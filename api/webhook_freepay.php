<?php
/**
 * FreePay Brasil - Webhook de Notificações
 * Documentação: https://freepaybrasil.readme.io/reference/formato-dos-webhooks
 *
 * Este endpoint recebe atualizações de status das transações PIX.
 *
 * Formato do payload recebido (POST JSON):
 * {
 *   "Id": "a24207e615224923bf4a68265d519fc6",
 *   "CreatedAt": "05/11/2025 21:19:42",
 *   "UpdatedAt": "2025-11-05T21:19:42.3648396",
 *   "ExternalId": "27615041",
 *   "PaidAt": "0001-01-01T00:00:00",
 *   "Amount": 100,        // Em REAIS
 *   "Installments": 0,
 *   "PaymentMethod": "pix",
 *   "Status": "PAID",
 *   "PostbackUrl": "https://..."
 * }
 *
 * Status possíveis:
 *   PENDING       → Aguardando pagamento
 *   PAID          → Pagamento realizado
 *   REFUNDED      → Transação estornada
 *   REFUSED       → Transação recusada
 *   CHARGEBACK    → Chargeback
 *   PRECHARGEBACK → Pré-Chargeback
 *   EXPIRED       → Expirado
 *   ERROR         → Erro na transação
 */

require_once("db.php");

// Registrar log de entrada
error_log("[FreePay Webhook] Recebido em " . date('Y-m-d H:i:s'));

// Ler o corpo da requisição (JSON)
$raw_body = file_get_contents('php://input');
error_log("[FreePay Webhook] Payload: " . $raw_body);

if (empty($raw_body)) {
    http_response_code(400);
    echo json_encode(['error' => 'Payload vazio']);
    exit;
}

$payload = json_decode($raw_body, true);

if (!$payload || !isset($payload['Id'])) {
    // Tentar também via POST form-encoded
    $payload = $_POST;
    if (empty($payload['Id'])) {
        http_response_code(400);
        echo json_encode(['error' => 'Payload inválido ou campo Id ausente']);
        exit;
    }
}

// Extrair campos do webhook
$transaction_id  = $payload['Id']            ?? '';
$status          = strtoupper($payload['Status'] ?? '');
$amount          = $payload['Amount']        ?? 0;   // Em reais
$payment_method  = $payload['PaymentMethod'] ?? '';
$external_id     = $payload['ExternalId']    ?? '';
$paid_at         = $payload['PaidAt']        ?? '';

error_log("[FreePay Webhook] Transaction ID: $transaction_id | Status: $status | Valor: $amount");

// -------------------------------------------------------
// Verificar se a tabela pixgerado possui a coluna freepay_transaction_id
// Se não existir, criar via ALTER TABLE
// -------------------------------------------------------
$check_col = mysqli_query($conn, "SHOW COLUMNS FROM pixgerado LIKE 'freepay_transaction_id'");
if (mysqli_num_rows($check_col) === 0) {
    mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_transaction_id TEXT NOT NULL DEFAULT ''");
    mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_status TEXT NOT NULL DEFAULT 'PENDING'");
    error_log("[FreePay Webhook] Colunas freepay_transaction_id e freepay_status adicionadas à tabela pixgerado.");
}

// -------------------------------------------------------
// Atualizar o status da transação no banco de dados
// -------------------------------------------------------
if (!empty($transaction_id)) {
    $tid_safe = mysqli_real_escape_string($conn, $transaction_id);
    $status_safe = mysqli_real_escape_string($conn, $status);

    // Verificar se existe registro com esse transaction_id
    $check = mysqli_query($conn, "SELECT id FROM pixgerado WHERE freepay_transaction_id='$tid_safe' LIMIT 1");

    if (mysqli_num_rows($check) > 0) {
        $update = mysqli_query($conn, "UPDATE pixgerado SET freepay_status='$status_safe' WHERE freepay_transaction_id='$tid_safe'");
        error_log("[FreePay Webhook] Status atualizado para '$status' na transação '$transaction_id'");
    } else {
        error_log("[FreePay Webhook] Transação '$transaction_id' não encontrada no banco local.");
    }
}

// -------------------------------------------------------
// Responder com 200 OK para confirmar recebimento
// -------------------------------------------------------
http_response_code(200);
echo json_encode(['received' => true, 'transaction_id' => $transaction_id, 'status' => $status]);
exit;
