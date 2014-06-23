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
	/*recursive function*/
	public static function buildCommentTree($commentArray,$root) {
		$tree = array();
		if (!isset($commentArray[$root])) {
			return;	
		}
		foreach ($commentArray[$root] as $comment) {
			echo '<p>'.$comment.'</p>'.
				 '<div style="margin-left:10px;">';
			echo Common::buildCommentTree($commentArray,$comment->id);
			echo '</div>';
		}	
	}
}


?>
<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>