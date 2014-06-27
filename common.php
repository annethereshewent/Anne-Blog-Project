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
	public static function getPageFooter($page) {
		$returnStr = '<p class="pageFooter">';
		echo $returnStr;
		if ($page == 1) {

			$returnStr .= '<a href="main.php?page='.($page+1).'">Next Page</a></p>';
			return $returnStr;
		}
		$returnStr .= '<a href="main.php?page='.($page-1).'">Previous Page</a>&nbsp;&nbsp;<a href="main.php?page='.($page+1).'">Next Page</p>';
		return $returnStr;

	}
}
?>
