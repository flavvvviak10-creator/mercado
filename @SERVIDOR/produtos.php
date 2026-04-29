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
  <title>
  Produtos
  </title>
  <!--     Fonts and icons     -->
  <link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700,900|Roboto+Slab:400,700" />
  <!-- Nucleo Icons -->
  <link href="./assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="./assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script>
  <!-- Material Icons -->
  <link href="https://fonts.googleapis.com/icon?family=Material+Icons+Round" rel="stylesheet">
  <!-- CSS Files -->
  <link id="pagestyle" href="./assets/css/material-dashboard.css?v=3.0.4" rel="stylesheet" />
</head>

<body class="g-sidenav-show  bg-gray-200">




  <aside class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3  bg-gradient-dark" id="sidenav-main">
    <div class="sidenav-header">
      <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none" aria-hidden="true" id="iconSidenav"></i>
      <a class="navbar-brand m-0" href="dashboard.php">
        
        <span class="ms-1 font-weight-bold text-white">Loja - THE-FAKE</span>
      </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link text-white" href="dashboard.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">dashboard</i>
            </div>
            <span class="nav-link-text ms-1">Dashboard</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link text-white" href="cadastros.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">assignment_ind</i>
            </div>
            <span class="nav-link-text ms-1">Cadastros</span>
          </a>
        </li>
        <li class="nav-item">
          <a class="nav-link active text-white bg-gradient-primary" href="produtos.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">local_grocery_store</i>
            </div>
            <span class="nav-link-text ms-1">Produtos</span>
          </a>
        </li>
      
        <li class="nav-item">
          <a class="nav-link text-white " href="add_produto.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">add_circle</i>
            </div>
            <span class="nav-link-text ms-1">Adicionar Produto</span>
          </a>
        </li>
	  
        <li class="nav-item">
          <a class="nav-link text-white " href="estatisticas.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">insert_chart</i>
            </div>
            <span class="nav-link-text ms-1">Estatisticas</span>
          </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link text-white" href="bloqueados.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">key</i>
            </div>
            <span class="nav-link-text ms-1">Bloqueados</span>
          </a>
        </li>	
       
        <li class="nav-item">
          <a class="nav-link text-white " href="administrador.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">person</i>
            </div>
            <span class="nav-link-text ms-1">Administrador</span>
          </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link text-white" href="pix.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">paid</i>
            </div>
            <span class="nav-link-text ms-1">Config Pix</span>
          </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link text-white" href="config.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">storefront</i>
            </div>
            <span class="nav-link-text ms-1">Config Loja</span>
          </a>
        </li>
		
		<li class="nav-item">
          <a class="nav-link text-white" href="apis.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">notification_important</i>
            </div>
            <span class="nav-link-text ms-1">Config Apis</span>
          </a>
        </li>
       
		 <li class="nav-item">
          <a class="nav-link text-white " href="said.php">
            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
              <i class="material-icons opacity-10">login</i>
            </div>
            <span class="nav-link-text ms-1">Sair</span>
          </a>
        </li>
		
      </ul>
    </div>
    <div class="sidenav-footer position-absolute w-100 bottom-0 ">
      <div class="mx-3">
        <a class="btn bg-gradient-primary mt-4 w-100" href="https://api.whatsapp.com/send?phone=5513996514973&text=Oi%20THE-FAKE" target="_blank" type="button">Falar com the-fake</a>
      </div>
    </div>
  </aside>
  <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg ">
    <!-- Navbar -->
      <nav class="navbar navbar-main navbar-expand-lg px-0 mx-4 shadow-none border-radius-xl " id="navbarBlur" data-scroll="true">
      <div class="container-fluid py-1 px-3">
        <nav aria-label="breadcrumb">
          <ol class="breadcrumb bg-transparent mb-0 pb-0 pt-1 px-0 me-sm-6 me-5">
            <li class="breadcrumb-item text-sm"><a class="opacity-5 text-dark" href="javascript:;">Página</a></li>
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Produtos</li>
          </ol>
          <h6 class="font-weight-bolder mb-0">Loja V1.0</h6>
        </nav>
        <div class="collapse navbar-collapse mt-sm-0 mt-2 me-md-0 me-sm-4" id="navbar">
          <div style="visibility:hidden;" class="ms-md-auto pe-md-3 d-flex align-items-center">
            <div class="input-group input-group-outline">
              <label class="form-label">Type here...</label>
              <input type="text" class="form-control">
            </div>
          </div>
          <ul class="navbar-nav  justify-content-end">
            <li class="nav-item d-flex align-items-center">
			
			<div class="avatar me-3">
             <img src="./assets/img/the.png" alt="kal" class="border-radius-lg shadow">
            </div>
			
              <a href="sair.php" class="nav-link text-body font-weight-bold px-0">
                <i class="fa fa-user me-sm-1"></i>
                <span class="d-sm-inline d-none">Sair</span>
              </a>
            </li>
           
		   <li class="nav-item d-xl-none ps-3 d-flex align-items-center">
              <a href="javascript:;" class="nav-link text-body p-0" id="iconNavbarSidenav">
                <div class="sidenav-toggler-inner">
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                  <i class="sidenav-toggler-line"></i>
                </div>
              </a>
            </li>
			
			
         
          </ul>
        </div>
      </div>
    </nav>
    <!-- End Navbar -->
    <div class="container-fluid py-4" style="padding-top: inherit !important;">
	
	
	<div class="row">
	   <div class="col-12 mt-4">
              <div class="mb-5 ps-3">  

              </div>
			 <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
              <div class="bg-gradient-primary shadow-primary border-radius-lg pt-4 pb-3">
                <h6 class="text-white text-capitalize ps-3">Total (<b id="total"></b> )</h6>
              </div>
			</div>
			<br><br>
              <div class="row">
			  
			  
			    <?php 
				
				$sql = mysqli_query($conn, "SELECT * from produto");
				if(mysqli_num_rows($sql) > 0){ 
			     
				 while($row = mysqli_fetch_array($sql)){
				 
				       $id = $row["id"];
				       $codigo = $row["codigo"];
					   
					   $nome = $row["nome"];
					   $valor = $row["valor"];
					   
					   $img = $row["img"];
					   $oferta = $row["oferta"];
					   
					   $desconto = $row["desconto"];
					   $venda = $row["venda"];
					   
					   $cliques = $row["cliques"];
					   
				 
				 if($oferta==1){
				 $promo = 'checked=""';
				 }else if($oferta==0){
				 $promo = '';
				 }
				 ?>
				  <div class="col-xl-3 col-md-6 mb-xl-0 mb-4">
                  <div class="card card-blog card-plain">
				  <div class="card-header p-0 position-relative mt-n4 mx-3 z-index-2">
				  <div class="bg-gradient-dark shadow-dark border-radius-lg pt-4 pb-3">
				  <h6 style="font-size:12px !important;" class="text-white text-capitalize ps-3"><?php echo $nome;?></h6>
				  </div>
				  </div>
                    <div class="card-header p-0 mt-n4 mx-3">
                      <a class="d-block shadow-xl border-radius-xl">
                        <?php 
                        // Verifica se a imagem é uma URL (começa com http) ou um arquivo local
                        $img_src = (strpos($img, 'http') === 0) ? $img : "../arquivos/produtos/$codigo/$img";
                        ?>
                        <img src="<?php echo $img_src; ?>" alt="img-blur-shadow" class="img-fluid shadow border-radius-xl" style="max-height: 200px; width: 100%; object-fit: cover;">
                      </a>
                    </div>
                    <div class="card-body p-3">
                 
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Código do produto:</strong> <?php echo $codigo;?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Cliques:</strong>  <?php echo $cliques;?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Vendidos:</strong>  <?php echo $venda;?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Valor:</strong> R$<?php echo $valor;?></li>
                    <li class="list-group-item border-0 ps-0 pt-0 text-sm"><strong class="text-dark">Desconto:</strong>  <?php echo $desconto;?>%</li>
                    <li class="list-group-item border-0 ps-0 text-sm">
					<div class="form-check form-switch ps-0">
					<input style="color:black !important; background-color:black !important;" class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" <?php echo $promo; ?> disabled></div>&nbsp; &nbsp; 
					  <strong class="text-dark">Oferta relampago</strong> &nbsp;  
					</li>
					<li class="list-group-item border-0 ps-0 text-sm">
					<div class="form-check form-switch ps-0">
					<input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" checked="" disabled></div>&nbsp; &nbsp; 
					  <strong class="text-dark">Pix</strong> &nbsp;  
					</li>
					<li class="list-group-item border-0 ps-0 text-sm">
					<div class="form-check form-switch ps-0">
					<input class="form-check-input ms-auto" type="checkbox" id="flexSwitchCheckDefault" disabled></div>&nbsp; &nbsp; 
					  <strong class="text-dark">Cartão ( Em Breve )</strong> &nbsp;  
					</li>
					
				
				
                    <br>
                      <div class="dropdown">
					  <button style="width: 100%;" class="btn bg-gradient-info dropdown-toggle" type="button" id="dropdownMenuButton" data-bs-toggle="dropdown" aria-expanded="false">
						Opções
					  </button>
					    <ul style="width: 100%; text-align: center;" class="dropdown-menu" aria-labelledby="dropdownMenuButton">
						<!--<li><a class="dropdown-item " href="#" onclick="abrireditor();">Editar</a></li>-->
							<li><a class="dropdown-item" href="#" id="<?php echo $id;?>" onclick="excluirProduto(this.id)">Excluir</a></li>
							<li><a class="dropdown-item" href="https://<?php echo $_SERVER['SERVER_NAME'];?>/?id=<?php echo $codigo;?>" target="_blank">Ver produto</a></li>
							<li><a class="dropdown-item" href="#" onclick="copiarLink('<?php echo $codigo;?>')">Copiar link</a></li>
						  </ul>
					</div>
                    </div>
                  </div>
				  </div>
				 <?php 
				   }
				  }
				 ?>
				
              </div>
            </div>
	     </div>
	
	<div class="position-fixed bottom-1 end-1 z-index-2" style="z-index: 9999999 !important;">
        <div class="toast fade hide p-2 mt-2 bg-gradient-info" role="alert" aria-live="assertive" id="infoToast" aria-atomic="true">
          <div class="toast-header bg-transparent border-0">
            <i class="material-icons text-white me-2">check</i>
            <span class="me-auto text-white font-weight-bold">O produto foi editado!</span>
            <i class="fas fa-times text-md text-white ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
          </div>
        </div>
      </div>
	
	
	
      <footer class="footer py-4  ">
	  	  
        <div class="container-fluid">
          <div class="row align-items-center justify-content-lg-between">
            <div class="col-lg-6 mb-lg-0 mb-4">
              <div class="copyright text-center text-sm text-muted text-lg-start">
                © <script>
                  document.write(new Date().getFullYear())
                </script>,
                made with <i class="fa fa-heart"></i> by
                <a href="#" class="font-weight-bold" target="_blank">THE-FAKE</a>
              </div>
            </div>
           
          </div>
        </div>
      </footer>
    </div>
  </main>
  
  
   <div id="editor1" class="fixed-plugin">
   <div style="display:none;" id="editor2" class="fixed-plugin show">
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Editar produto</h5>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
		
        <!-- End Toggle Button -->
      </div>
      <hr class="horizontal dark my-1">
	   <h6 class="mt-3 mb-0">Fridadeira eletrica smart rolor thefake 2022 com fogão embutido e todos os acesso acompanha garota de programa pra fazer a comida logo kk</h6>
 <hr class="horizontal dark my-1">     
	 <div class="card-body pt-sm-3 pt-0">
         
        <form>
				
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">Valor do produto</label>
		  <input type="text" class="form-control">
		</div>
		
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">Total vendas normal</label>
		  <input type="text" class="form-control">
		</div>
		
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">Total vendas relampago</label>
		  <input type="text" class="form-control">
		</div>
		
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">Desconto</label>
		  <input type="text" class="form-control">
		</div>
		</form>
		
        <!-- Navbar Fixed -->
        <div class="mt-3 d-flex">
          <h6 class="mb-0">Oferta relampago</h6>
          <div class="form-check form-switch ps-0 ms-auto my-auto">
            <input class="form-check-input mt-1 ms-auto" type="checkbox" id="navbarFixed">
          </div>
        </div>
		
		<hr class="horizontal dark my-3">
		   <div class="mt-3 d-flex">

       <a class="btn bg-gradient-dark w-100 toast-btn" data-target="infoToast" href="#" >Salvar</a> 
	   </div>
      </div>
    </div>
  </div>

  <!--   Core JS Files   -->
  <script src="./assets/js/core/popper.min.js"></script>
  <script src="./assets/js/core/bootstrap.min.js"></script>
  <script src="./assets/js/plugins/perfect-scrollbar.min.js"></script>
  <script src="./assets/js/plugins/smooth-scrollbar.min.js"></script>
  <script src="./assets/js/jquery.js"></script>
  <script>
    var win = navigator.platform.indexOf('Win') > -1;
    if (win && document.querySelector('#sidenav-scrollbar')) {
      var options = {
        damping: '0.5'
      }
      Scrollbar.init(document.querySelector('#sidenav-scrollbar'), options);
    }
  </script>

    <script>
  setTimeout(()=>{
  $.post("api_adm/", {painel:"totalprodutos"},function(resumo){
  document.getElementById("total").innerHTML=resumo;
  });
  }, 500);
  </script>
  
  <script>
  function excluirProduto(idx){
   $.post("api_adm/", {painel:"excluirProduto", id:idx},function(resumo){
   window.location.reload();
   });
  }
  
	  function abrireditor(){
	  document.getElementById("editor").setAttribute("class", "fixed-plugin ps show");
	  }

	  function copiarLink(codigo) {
	    var urlBase = window.location.href.split('/@SERVIDOR/')[0];
	    var link = urlBase + "/index.php?id=" + codigo;
	    navigator.clipboard.writeText(link).then(function() {
	      alert("Link copiado com sucesso!");
	    }, function() {
	      alert("Erro ao copiar link: " + link);
	    });
	  }
	  </script>
  <!-- Control Center for Material Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="./assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>