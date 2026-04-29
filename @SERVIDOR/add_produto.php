<?php 

session_start();

require_once("../api/db.php");

				$sql = mysqli_query($conn, "SELECT * FROM acesso");
				 while($rowx = mysqli_fetch_array($sql)){ 
				 
				 $login = $rowx["login"];
				 $senha = $rowx["senha"];
				 
				 if($_SESSION['login']==$login && $_SESSION['senha']==$senha){ // se os dados nao bater.. direciona para area de login
                  if($_SESSION['tempo'] > time()){ //verifica se o tempo da sessão ainda está dentro do permitido
				  }else{
				  $tempo = time();
				  header("Location: ./?temp=expired&id=$tempo");
				  exit;
				  }				 
				 }else{
				 $tempo = time();
				 header("Location: ./?access=fail=id=$tempo");
				 exit;
				 }
				 }

?>
<!DOCTYPE html>
<html>

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="./assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="./assets/img/favicon.png">
  <title>Add produto - Moderno</title>
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
  <style>
    .img-preview { width: 100px; height: 100px; object-fit: cover; border-radius: 8px; margin-top: 5px; border: 1px solid #ddd; display: none; }
    .url-input-group { border: 1px solid #e0e0e0; padding: 15px; border-radius: 8px; margin-bottom: 20px; background: #f9f9f9; }
    .url-input-group h6 { margin-bottom: 15px; color: #344767; font-weight: 600; }
  </style>
</head>

<body class="g-sidenav-show bg-gray-200">
  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="dashboard.php">
        <?php 
		$sql = mysqli_query($conn, "SELECT * FROM config");
		while($rowx = mysqli_fetch_array($sql)){ $lojinha = $rowx["nome"]; }
		echo '<span class="ms-1 font-weight-bold text-white">Loja - '.$lojinha.'</span>';
		?>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse w-auto" id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item"><a class="nav-link text-white" href="dashboard.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">dashboard</i></div><span class="nav-link-text ms-1">Dashboard</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="cadastros.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">assignment_ind</i></div><span class="nav-link-text ms-1">Cadastros</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="produtos.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">local_grocery_store</i></div><span class="nav-link-text ms-1">Produtos</span></a></li>
        <li class="nav-item"><a class="nav-link text-white active bg-gradient-primary" href="add_produto.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">add_circle</i></div><span class="nav-link-text ms-1">Adicionar Produto</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="estatisticas.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">insert_chart</i></div><span class="nav-link-text ms-1">Estatisticas</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="bloqueados.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">key</i></div><span class="nav-link-text ms-1">Bloqueados</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="administrador.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">person</i></div><span class="nav-link-text ms-1">Administrador</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="pix.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">paid</i></div><span class="nav-link-text ms-1">Config Pix</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="config.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">storefront</i></div><span class="nav-link-text ms-1">Config Loja</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="apis.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">notification_important</i></div><span class="nav-link-text ms-1">Config Apis</span></a></li>
        <li class="nav-item"><a class="nav-link text-white" href="sair.php"><div class="text-white text-center me-2 d-flex align-items-center justify-content-center"><i class="material-icons opacity-10">login</i></div><span class="nav-link-text ms-1">Sair</span></a></li>
      </ul>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
    <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl" id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Página</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Adicionar produto</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Loja V2.0 - Novo Layout</h6>
        </nav>
      </div>
    </nav>
    <div class="container-fluid py-4">
      <div class="card card-body mx-3 mx-md-4 mt-n6">
        <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
          <h6 class="text-white text-capitalize ps-3">Novo produto (6 Fotos via URL)</h6>
        </div>
        <div class="row mt-4">
          <form id="formulario" onsubmit="return false">
            <div class="row">
              <div class="col-md-6">
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Nome do produto</label>
                  <input id="nomeproduto" name="nomeproduto" type="text" class="form-control">
                </div>
              </div>
	              <div class="col-md-3">
	                <div class="input-group input-group-outline my-3">
	                  <label class="form-label">Valor Original (Riscado)</label>
	                  <input onkeypress="mascara(this,reais)" id="valor_original" name="valor_original" type="text" class="form-control">
	                </div>
	              </div>
	              <div class="col-md-3">
	                <div class="input-group input-group-outline my-3">
	                  <label class="form-label">Valor com Desconto</label>
	                  <input onkeypress="mascara(this,reais)" id="valor" name="valor" type="text" class="form-control">
	                </div>
	              </div>
              <div class="col-md-3">
                <div class="input-group input-group-outline my-3">
                  <label class="form-label">Desconto %</label>
                  <input type="text" id="desconto" name="desconto" class="form-control">
                </div>
              </div>
            </div>

            <div class="url-input-group">
              <h6>Imagens do Carrossel (URLs)</h6>
              <div class="row">
                <?php for($i=1; $i<=6; $i++): ?>
                <div class="col-md-4 mb-3">
                  <div class="input-group input-group-outline">
                    <label class="form-label">URL Imagem <?php echo $i; ?></label>
                    <input type="text" id="img<?php echo $i; ?>" name="img<?php echo $i; ?>" class="form-control" onchange="previewImg(this, 'prev<?php echo $i; ?>')">
                  </div>
                  <img id="prev<?php echo $i; ?>" class="img-preview">
                </div>
                <?php endfor; ?>
              </div>
            </div>

            <div class="input-group input-group-outline my-3">
              <label class="form-label">Características do Produto (Um por linha)</label>
              <textarea id="caracteristicas" name="caracteristicas" class="form-control" rows="4"></textarea>
            </div>

            <div class="input-group input-group-outline my-3">
              <label class="form-label">Descrição do Produto</label>
              <textarea id="texto" name="texto" class="form-control" rows="4"></textarea>
            </div>

            <div class="url-input-group">
              <h6>&#9733; Avaliações do Produto (5 comentários com 3 fotos cada)</h6>
              <p class="text-xs text-secondary mb-3">Preencha os campos abaixo. Ao salvar, as avaliações serão convertidas automaticamente para JSON.</p>

              <div id="reviews-builder">
                <?php for($r=1; $r<=5; $r++): ?>
                <div style="border:1px solid #e0e0e0;border-radius:8px;padding:14px;margin-bottom:16px;background:#fff;">
                  <div style="font-weight:600;color:#344767;margin-bottom:10px;">Avaliação <?php echo $r; ?></div>
                  <div class="row">
                    <div class="col-md-4">
                      <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Nome do cliente</label>
                        <input type="text" class="form-control rev-nome" id="rev_nome_<?php echo $r; ?>" placeholder="Ex: Cláudia Martins">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Data (dd/mm/aaaa)</label>
                        <input type="text" class="form-control rev-data" id="rev_data_<?php echo $r; ?>" placeholder="Ex: 15/04/2025">
                      </div>
                    </div>
                    <div class="col-md-2">
                      <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Estrelas (1-5)</label>
                        <input type="number" class="form-control rev-estrelas" id="rev_estrelas_<?php echo $r; ?>" min="1" max="5" value="5">
                      </div>
                    </div>
                    <div class="col-md-3">
                      <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Título da avaliação</label>
                        <input type="text" class="form-control rev-titulo" id="rev_titulo_<?php echo $r; ?>" placeholder="Ex: Produto excelente!">
                      </div>
                    </div>
                    <div class="col-12">
                      <div class="input-group input-group-outline mb-3">
                        <label class="form-label">Texto do comentário</label>
                        <textarea class="form-control rev-texto" id="rev_texto_<?php echo $r; ?>" rows="2" style="border:1px solid #d2d6da;padding:8px;"></textarea>
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-outline mb-2">
                        <label class="form-label">URL Foto 1</label>
                        <input type="text" class="form-control rev-foto" id="rev_foto1_<?php echo $r; ?>" placeholder="https://...">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-outline mb-2">
                        <label class="form-label">URL Foto 2</label>
                        <input type="text" class="form-control rev-foto" id="rev_foto2_<?php echo $r; ?>" placeholder="https://...">
                      </div>
                    </div>
                    <div class="col-md-4">
                      <div class="input-group input-group-outline mb-2">
                        <label class="form-label">URL Foto 3</label>
                        <input type="text" class="form-control rev-foto" id="rev_foto3_<?php echo $r; ?>" placeholder="https://...">
                      </div>
                    </div>
                  </div>
                </div>
                <?php endfor; ?>
              </div>

              <!-- Campo oculto que recebe o JSON gerado -->
              <textarea id="reviews" name="reviews" class="form-control" rows="3" style="border:1px solid #d2d6da;padding:10px;font-size:11px;color:#888;" placeholder="JSON gerado automaticamente ao salvar..."></textarea>
              <small class="text-secondary">Você também pode colar um JSON diretamente no campo acima (substitui os campos acima).</small>
            </div>

            <div class="row">
              <div class="col-md-6">
                <div class="mt-3 d-flex align-items-center">
                  <h6 class="mb-0">Oferta relampago</h6>
                  <div class="form-check form-switch ps-0 ms-auto my-auto">
                    <input class="form-check-input mt-1 ms-auto" type="checkbox" id="oferta_check" onclick="verificarCheckBox();">
                  </div>
                </div>
              </div>
            </div>

            <input type="hidden" id="idproduto" name="idproduto">
            <button id="salvar" class="btn bg-gradient-success w-100 mt-4" onclick="addprox();">Adicionar Produto</button>
          </form>
        </div>
      </div>
    </div>
  </main>

  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/jquery.js"></script>
  <script src="./assets/js/material-dashboard.min.js?v=3.0.4"></script>

  <script>
    function previewImg(input, previewId) {
      var preview = document.getElementById(previewId);
      if (input.value) {
        preview.src = input.value;
        preview.style.display = 'block';
      } else {
        preview.style.display = 'none';
      }
    }

    var chk = 0;
    function verificarCheckBox() {
      chk = document.getElementById("oferta_check").checked ? 1 : 0;
    }

	    function buildReviewsJSON() {
	      var reviews = [];
	      for(var i=1; i<=5; i++) {
	        var nome = $("#rev_nome_"+i).val();
	        if(nome) {
	          var fotos = [];
	          if($("#rev_foto1_"+i).val()) fotos.push($("#rev_foto1_"+i).val());
	          if($("#rev_foto2_"+i).val()) fotos.push($("#rev_foto2_"+i).val());
	          if($("#rev_foto3_"+i).val()) fotos.push($("#rev_foto3_"+i).val());
	          
	          reviews.push({
	            nome: nome,
	            data: $("#rev_data_"+i).val(),
	            estrelas: parseInt($("#rev_estrelas_"+i).val()),
	            titulo: $("#rev_titulo_"+i).val(),
	            texto: $("#rev_texto_"+i).val(),
	            fotos: fotos
	          });
	        }
	      }
	      if(reviews.length > 0) {
	        $("#reviews").val(JSON.stringify(reviews));
	      }
	    }

	    function addprox() {
	      buildReviewsJSON();
	      var data = {
	        painel: "addproduto_v2",
	        nome: $("#nomeproduto").val(),
	        valor: $("#valor").val(),
	        valor_original: $("#valor_original").val(),
	        desconto: $("#desconto").val(),
	        textodescricao: $("#texto").val(),
	        caracteristicas: $("#caracteristicas").val(),
	        reviews: $("#reviews").val(),
	        oferta: chk,
	        img1: $("#img1").val(),
	        img2: $("#img2").val(),
	        img3: $("#img3").val(),
	        img4: $("#img4").val(),
	        img5: $("#img5").val(),
	        img6: $("#img6").val()
	      };

      if(!data.nome || !data.valor) {
        alert("Preencha o nome e o valor!");
        return;
      }

	      $.post("api_adm/", data, function(retorno) {
	        if (retorno.trim().includes("ok")) {
	          var partes = retorno.split("|");
	          var idGerado = partes[1];
	          var urlBase = window.location.href.split('/@SERVIDOR/')[0];
	          var linkProduto = urlBase + "/index.php?id=" + idGerado;
	          
	          // Criar um modal ou alerta com o link
	          var msg = "Produto adicionado com sucesso!\n\nLink para divulgação:\n" + linkProduto;
	          if(confirm(msg + "\n\nDeseja copiar o link agora?")) {
	            navigator.clipboard.writeText(linkProduto).then(function() {
	              alert("Link copiado para a área de transferência!");
	              window.location.href = "produtos.php";
	            }, function() {
	              window.location.href = "produtos.php";
	            });
	          } else {
	            window.location.href = "produtos.php";
	          }
	        } else {
	          alert("Erro: " + retorno);
	        }
	      });
    }

    function reais(v){
      v=v.replace(/\D/g,"");
      v=v/100;
      v=v.toFixed(2);
      return v;
    }
    function mascara(o,f){
      v_obj=o; v_fun=f;
      setTimeout("execmascara()",1);
    }
    function execmascara(){ v_obj.value=v_fun(v_obj.value); }
  </script>
</body>
</html>
