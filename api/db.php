<?php 

class db {
    public static $db_server = "mysql.railway.interna";
    public static $db_db = "railway";
    public static $db_user = "root";
    public static $db_pass = "eVEFVwHlbgXyYJdYjKYjpveWscIsilIC";
    public static $db_port = "29780";

    public static function init() {
        self::$db_server = getenv("MYSQLHOST") ?: "mysql.railway.internal";
        self::$db_db = getenv("MYSQLDATABASE") ?: "railway";
        self::$db_user = getenv("MYSQLUSER") ?: "root";
        self::$db_pass = getenv("MYSQLPASSWORD") ?: "eVEFVwHlbgXyYJdYjKYjpveWscIsilIC";
        self::$db_port = getenv("MYSQLPORT") ?: "29780";
    }
}

db::init();

$conn = mysqli_connect(db::$db_server, db::$db_user, db::$db_pass, db::$db_db, db::$db_port);

if (!$conn) { 
    die("Conexao falhou: " . mysqli_connect_error()); 
}

?>
