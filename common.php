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

		//flush the old header and send a redirect.	
		//header("location: ".$url);
	}
	public static function alert($str) {
		echo "<script type=\"text/javascript\">\n"
			."alert(".$str.")</script>";
	}
	public static function getPageNum() {
		//get page number from the URI, the third element in temp
		$temp = explode("/",$_SERVER["REQUEST_URI"]);
		$page = isset($temp[3]) ? $temp[3] : 1;
		
		return is_numeric($page) ? $page : 1; 
	}
	public static function getPageFooter($page,$num_posts) {

		if ($num_posts > 15) {			 
			if ($page == 1) {
				$returnStr = '<span class="navi">
								<a class="pagi-link" href="/blog/'.$_SESSION["displayname"].'/'.($page+1).'">Next Page</a>
							  </span>
							  <div style="margin-left:60px">Page '.$page.'</div>';
				return $returnStr;
			}

			$returnStr = '<span class="navi">
							<a class="pagi-link" href="/blog/'.$_SESSION["displayname"].'/'.($page-1).'">Previous Page</a>
						  </span>
						  <span class="navi" style="margin-left:60px">
						  	<a class="pagi-link" href="/blog/'.$_SESSION["displayname"].'/'.($page+1).'">Next Page</a>
						  </span>
						  <div style="margin-left:60px">Page '.$page.'</div>';
			return $returnStr;
		}

		if ($page != 1) {
			$returnStr = '<span class="navi">
							<a class="pagi-link" href="/blog/'.$_SESSION["displayname"].'/'.($page-1).'">Previous Page</a>
						  </span>
						  <div style="margin-left:60px">Page '.$page.'</div';
			return $returnStr;
		}
		$returnStr = '<div style="margin-left:60px">Page 1</div>';
		return $returnStr;
	}
}
?>
