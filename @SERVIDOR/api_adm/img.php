<?php 
$novoFile = uniqid() . time();
$f = "../../arquivos/logo/"; // caminho da img
$i = glob($f . "*.png"); // img com final png	
foreach($i as $im){ // busca todas
$imgFile = str_replace("../../arquivos/logo/","",$im); //remove o caminho deixando só nome
if(unlink("../../arquivos/logo/".$imgFile."")){ //apaga a imagem atual
move_uploaded_file( $_FILES['pic']['tmp_name'], "../../arquivos/logo/".$novoFile.".png" ); //cria uma nova imagem
}
else{
echo "Unlink nao encontrado"; 
}  
}
?>