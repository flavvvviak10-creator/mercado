<?php 

$codigo = $_POST["idproduto"]; 

mkdir("../../arquivos/produtos/$codigo", 0777, true);
move_uploaded_file( $_FILES['pic1']['tmp_name'], '../../arquivos/produtos/'.$codigo.'/'.$codigo.'.png' );


?>