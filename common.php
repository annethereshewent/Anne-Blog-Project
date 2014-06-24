<?php 
include "config.php";
function __autoload($class_name) {
    include $class_name . '.php';
}

session_start();
$conn = new MyDB($config["HOST"], $config["USERNAME"],$config["PASSWORD"],$config["DB"]);

class Common {
	//parsing, useful javascript functions, general utility
	public static function redirect($url) {
		echo "<script type=\"text/javascript\">\n"
			."location.href='".$url."'</script>";
	}
	public static function alert($str) {
		echo "<script type=\"text/javascript\">\n"
			."alert(".$str.")</script>";
	}
}
?>
