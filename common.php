<?php 
include "../config.php";
function __autoload($class_name) {
    include $class_name . '.php';
}

session_start();
	
$conn = new MyDB($config["HOST"], $config["USERNAME"],$config["PASSWORD"],$config["DB"]) or die("Error connecting: ".$conn->error());


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
	public static function getPageFooter($page,$num_posts) {

		if ($num_posts > 15) {			 
			if ($page == 1) {
				$returnStr = '<span class="navi">
								<a class="pagi-link" href="main.php?page='.($page+1).'">Next Page</a>
							  </span>';
				return $returnStr;
			}

			$returnStr = '<span class="navi">
							<a class="pagi-link" href="main.php?page='.($page-1).'">Previous Page</a>
						  </span>
						  <span class="navi" style="margin-left:60px">
						  	<a class="pagi-link" href="main.php?page='.($page+1).'">Next Page</a>
						  </span>
						  <div style="margin-left:60px">Page '.$page.'</div>';
			return $returnStr;
		}

		if ($page != 1) {
			$returnStr = '<span class="navi">
							<a class="pagi-link" href="main.php?page='.($page-1).'">Previous Page</a>
						  </span>
						  <div style="margin-left:60px">Page '.$page.'</div';
			return $returnStr;
		}
		$returnStr = '<div style="margin-left:60px">Page 1</div>';
		return $returnStr;
	}
}
?>
