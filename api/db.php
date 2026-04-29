<?php 

/*=====================================
▀▀█▀▀ █  █ █▀▀▀    █▀▀▀ █▀▀█ █ ▄▀ █▀▀▀ 
  █   █▀▀█ █▀▀▀ ▀▀ █▀▀▀ █▄▄█ █▀▄  █▀▀▀ 
  █   █  █ █▄▄▄    █    █  █ █  █ █▄▄▄
=====================================*/

class db {
public static $db_server = "localhost";
public static $db_db = "railway";
public static $db_user = "root";
public static $db_pass = "RhTNMVFzagwXunmRcCgbOAZdlymxLNCY";
}
$conn = mysqli_connect(db::$db_server, db::$db_user, db::$db_pass, db::$db_db);
if (!$conn) { die("Conexao falhou: " . mysqli_connect_error()); }

?>
