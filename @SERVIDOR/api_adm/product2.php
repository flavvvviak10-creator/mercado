<?php 
$codigo = $_POST["idproduto"]; 
mkdir("../../arquivos/produtos/$codigo/descricao", 0777, true);
move_uploaded_file( $_FILES['pic2']['tmp_name'], '../../arquivos/produtos/'.$codigo.'/descricao/'.$codigo.'.png' );
?>