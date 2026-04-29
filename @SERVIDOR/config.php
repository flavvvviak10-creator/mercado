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
    Configuração
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
        <?php 
		$sql = mysqli_query($conn, "SELECT * FROM config");
						 while($rowx = mysqli_fetch_array($sql)){ 
						 						 
						 $lojinha = $rowx["nome"];
						 
						 }
						 
						 echo '<span class="ms-1 font-weight-bold text-white">Loja - '.$lojinha.'</span>';
		?>
        	
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
          <a class="nav-link text-white " href="produtos.php">
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
          <a class="nav-link text-white" href="administrador.php">
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
          <a class="nav-link active text-white bg-gradient-primary" href="config.php">
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
          <a class="nav-link text-white " href="sair.php">
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
            <li class="breadcrumb-item text-sm text-dark active" aria-current="page">Configuração</li>
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
    <div class="container-fluid py-4">
	<br><br><br>
	<div class="card card-body mx-3 mx-md-4 mt-n6">
      
        <div class="row">
          <div class="row">
           
           
            <div class="col-12 col-xl-4">
              <div class="card card-plain h-100">
                <div class="card-header pb-0 p-3">
                  <h6 class="mb-0">Configuração da loja</h6>
                </div>
                <div class="card-body p-3">
                  <ul class="list-group" id="lista">
                   <?php 
				   
				  	 		
				   $sql = mysqli_query($conn, "SELECT * from config");
				   
				   
					 if(mysqli_num_rows($sql) > 0){
						
					 $f = "../arquivos/logo/"; 
					 $i = glob($f . "*.png");
					
					 foreach($i as $im){
					 $imgFile = str_replace("../arquivos/logo/","",$im); //remove o caminho deixando sรณ nome
					 $thefile = $imgFile;
					 }
						
						
						$sql = mysqli_query($conn, "SELECT * FROM config");
						 while($rowx = mysqli_fetch_array($sql)){ 
						 
						 $id = $rowx["id"];
						 $nome = $rowx["nome"];
						 $cor = $rowx["cor"];
						 $img = $rowx["img"];
						 $numero = $rowx["numero"];
						 $texto = $rowx["texto"];
						
					    if($cor=="#1165ce"){
						$color = "Azul";
						}
						if($cor=="#1191ce"){
						$color = "Azul Escuro";
						}
						if($cor=="#ce1111"){
						$color = "Vermelho";
						}
						if($cor=="#c211ce"){
						$color = "Roxo";
						}
						if($cor=="#11ce17"){
						$color = "Verde";
						}
						if($cor=="#ff4f00"){
						$color = "Laranja";
						}
						if($cor=="#ffe600"){
						$color = "Amarelo";
						}				
						echo '<li class="list-group-item border-0 d-flex align-items-center px-0 mb-2 pt-0">
							  <div class="avatar me-3">
								<img style="width:70px;" src="../arquivos/logo/'.$thefile.'" class="border-radius-lg shadow">
							  </div>
							  <div class="d-flex align-items-start flex-column justify-content-center">
								<h6 class="mb-0 text-sm">Nome: '.$nome.'</h6>
								<h6 class="mb-0 text-sm">Cor: <b style="color:'.$cor.';">'.$color.'</b></h6>
								<h6 class="mb-0 text-sm">WhatsApp: '.$numero.'</b></h6>
								<h6 class="mb-0 text-sm">Texto: '.$texto.'</b></h6>
								
							  </div>
							  <a class="btn btn-link pe-3 ps-0 mb-0 ms-auto w-25 w-md-auto" href="javascript:;"><span style="cursor:pointer;" class="badge badge-sm bg-gradient-dark fixed-plugin-button">Editar</span></a>
							</li>  ';
						}
						
					}else{
					 echo "";
					}
				   ?>   
                  </ul>
                </div>
              </div>
            </div>
          </div> 
		 
        </div>
      </div>
	  
	  <div class="position-fixed bottom-1 end-1 z-index-2" style="z-index:9999999 !important;">
        <div class="toast fade hide p-2 mt-2 bg-gradient-danger" role="alert" aria-live="assertive" id="infoToast" aria-atomic="true">
          <div class="toast-header bg-transparent border-0">
            <i class="material-icons text-white me-2">notifications</i>
            <span class="me-auto text-white font-weight-bold">Oops! Senha invalida.</span>
            <i class="fas fa-times text-md text-white ms-3 cursor-pointer" data-bs-dismiss="toast" aria-label="Close"></i>
          </div>
        </div>
		
		<div class="toast fade hide p-2 mt-2 bg-gradient-danger" role="alert" aria-live="assertive" id="infoToast1" aria-atomic="true">
          <div class="toast-header bg-transparent border-0">
            <i class="material-icons text-white me-2">notifications</i>
            <span class="me-auto text-white font-weight-bold">Oops! Preencha todos os campos!</span>
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
                <a href="" class="font-weight-bold" target="_blank">THE-FAKE</a>
              </div>
            </div>
           
          </div>
        </div>
      </footer>
    </div>
  </main>
    <div class="fixed-plugin">
    <div class="card shadow-lg">
      <div class="card-header pb-0 pt-3">
        <div class="float-start">
          <h5 class="mt-3 mb-0">Editar Loja</h5>
        </div>
        <div class="float-end mt-4">
          <button class="btn btn-link text-dark p-0 fixed-plugin-close-button">
            <i class="material-icons">clear</i>
          </button>
        </div>
		
       
      </div>
      <hr class="horizontal dark my-1">
      <div class="card-body pt-sm-3 pt-0">

        <form id="formqr" onsubmit="return false" >
		<div class="input-group input-group-outline my-3">
		 <!-- <label class="form-label">Logo da loja</label>
		  <input id="logoloja" name="logoloja" type="text" class="form-control">-->
		   
		 <!--<p>Logo da loja</p>-->
		   <label for='pic' style="text-align:center;background-color: transparent; border: 1px solid #344767; cursor:pointer;justify-content: center;width: 100%;background-image: none; color: #344767; padding: 4px 12px;font-size: 15px;font-weight: 400;border-radius: 4px;text-decoration: none;transition: all 0.3s ease;">Buscar logo (click aqui)</label>
		  		 
		  <input style="display:none; width:100%;text-align:center;color:transparent;" accept="image/*" type="file" id="pic" name="pic">
		  
		</div>
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">Nome da loja</label>
		  <input id="nomeloja" name="nomeloja" type="text" class="form-control">
		</div>
		
		<div class="input-group input-group-outline my-3">
		  <label class="form-label">WhatsApp da loja</label>
		  <input id="numerozap" name="numerozap" type="text" class="form-control">
		</div><div class="input-group input-group-outline my-3">
		  <label class="form-label">Texto do WhatsApp</label>
		  <input id="textozap" name="textozap" type="text" class="form-control">
		</div>
		<div class="input-group input-group-outline my-3">
		  
		  <!--<input id="oldsenha" name="oldsenha" type="text" class="form-control">-->
		  <select id="corloja" name="corloja" class="form-control">
		  <option>Selecione a cor da loja</option>
		  <option value="#1165ce" style="font-weight:bold;color:white;background:#1165ce;">Azul</option>
		  <option value="#1191ce" style="font-weight:bold;color:white;background:#1191ce;">Azul escuro</option>
		  <option value="#ce1111" style="font-weight:bold;color:white;background:#ce1111;">Vermelho</option>
		  <option value="#c211ce" style="font-weight:bold;color:white;background:#c211ce;">Roxa</option>
		  <option value="#11ce17" style="font-weight:bold;color:white;background:#11ce17;">Verde</option>
  <option value="#ff4f00" style="font-weight:bold;color:white;background:#ff4f00;">Laranja</option>
  <option value="#ffe600" style="font-weight:bold;color:#333;background:#ffe600;">Amarelo</option>
  </select>
		</div>
		</form>
		
		<hr class="horizontal dark my-3">
		   <div class="mt-3 d-flex">

       <a class="btn bg-gradient-dark w-100" href="#" onclick="atualizar()">Salvar</a> 
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

  function atualizar(){
      var selectColor = document.getElementById("corloja");
 	 var cordaloja = selectColor.options[selectColor.selectedIndex].value;
     var nomedaloja = document.getElementById("nomeloja").value;
     
	 var numerozap = document.getElementById("numerozap").value;
     var textozap = document.getElementById("textozap").value;
     var picpic = document.getElementById("pic").value;
	 
	 if(!cordaloja || !nomedaloja || !numerozap || !textozap || !picpic){
	  document.getElementById("infoToast1").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger show");
	
	  setTimeout(()=>{
	  document.getElementById("infoToast1").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger hide");
	  }, 3000);
	  
	 }else{
	  var form_data = new FormData(document.getElementById("formqr"));
	 
     fetch("api_adm/img.php",{
     method: "POST",
     body: form_data
     });
    
	setTimeout(()=>{
	newnew();
	}, 2000);
	 }
	 
    
	
	
  }  
  
  function newnew(){
     var selectColor = document.getElementById("corloja");
 	 var cordaloja = selectColor.options[selectColor.selectedIndex].value;
     var nomedaloja = document.getElementById("nomeloja").value;
     
	 var numerozap = document.getElementById("numerozap").value;
     var textozap = document.getElementById("textozap").value;
	 
	 if(!cordaloja || !nomedaloja || !numerozap || !textozap){
	 
	  document.getElementById("infoToast1").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger show");
	
	  setTimeout(()=>{
	  document.getElementById("infoToast1").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger hide");
	  }, 3000);
	  
	 }else{
	 
	 $.post("api_adm/", {painel:"atualizarLoja", cor:cordaloja, nome:nomedaloja, zap:numerozap, texto:textozap},function(zeragem){
     if(zeragem.trim()=="erro"){
     document.getElementById("infoToast").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger show");
	
	  setTimeout(()=>{
	  document.getElementById("infoToast").setAttribute("class","toast fade hide p-2 mt-2 bg-gradient-danger hide");
	  }, 3000);
	  
    }else{
     window.location.reload();
     }  
   });
	 }
    
  }
</script>
  
  <script src="./assets/js/material-dashboard.min.js?v=3.0.4"></script>
</body>

</html>