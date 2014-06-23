<?php 
include "config.php";
session_start();
class Common {
	public static function redirect($url) {
		echo "<script type=\"text/javascript\">\n"
			."location.href='".$url."'</script>";
	}
	public static function alert($str) {
		echo "<script type=\"text/javascript\">\n"
			."alert(".$str.")</script>";
	}
}

class MyDB {
	private $mysqli; 
	public function remqt($str) {
		
		$str = str_replace("\n","<br>", $str);
		return $this->mysqli->real_escape_string($str);
	}
	public function __construct($host, $user, $pass,$db) {
		$this->mysqli = new mysqli($host, $user, $pass,$db) or die ("Error: ".mysqli_connect_error());
	}
	/* 
	Primarily for ajax calls
	*/
	public function fetch_contents($pID) {

		if ($pID == "")
			echo "false";
		$sql = "select post from posts where id=".$pID;
		$result = $this->mysqli->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			echo $row["post"];
		}
		$result->close();
		$result = null;
	}
	/*
	when you absolutely must call mysqli_query
	*/
	public function query($sql) {
		return $this->mysqli->query($sql);
	}
	/* 
	fetches a post record from database and returns it. good for formatting and what not
	*/
	public function fetch_post($pID) {

		if ($pID == "")
			return null;
		$sql = "select id, post, created_on, edited_on, edited from posts where id = ".$this->remqt($pID);
		$result = $this->mysqli->query($sql);
		if ($result->num_rows == 1) {
			//success
			return $result->fetch_array();
		} 
		return null;
	}
	public function fetch_all_user_posts($userID) {
		$sql = "select id, post, created_on, edited_on, edited from posts where userID='".$userID."' order by id desc";
		return $this->mysqli->query($sql);
	}
	public function error() {
		return $this->mysqli->error();
	}
}
$conn = new MyDB($config["HOST"], $config["USERNAME"],$config["PASSWORD"],$config["DB"]);
?>
<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>