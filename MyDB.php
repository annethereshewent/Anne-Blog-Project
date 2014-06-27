<?php

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
		$sql = "select id, post, created_on, edited_on, edited 
				from posts 
				where id = ".$this->remqt($pID);

		$result = $this->mysqli->query($sql);
		if ($result->num_rows == 1) {
			//success
			return $result->fetch_array();
		} 
		return null;
	}
	public function fetch_all_user_posts($userID) {
		$sql = "select id, post, created_on, edited_on, edited 
				from posts 
				where userID='".$userID."' order by id desc";

		return $this->mysqli->query($sql);
	}
	public static function getDisplayName($id) {
		$sql = "select displayname 
				from users 
				where id=".$id;
		$result = self::$mysqli->query($sql);
		if ($result->num_row == 1)
			return $result->fetch_array()["displayname"];
		return "<b>Error</b>: ".$mysqli->error;
	}
	public function fetch_user_posts_by_page($userID,$page) {
		$limit = "";

		if ($page == 1) 
			$limit = "limit 15";
		else 
			$limit = "limit ".(15*($page-1)).",15";


		$sql = 
		"select id, post, created_on, edited_on, edited 
		from posts 
		where userID='".$userID."'
		order by id desc ".$limit;
		return $this->mysqli->query($sql);
	}
	public function error() {
		return $this->mysqli->error;
	}
	public function fetch_post_comments($postID) {
		$sql = "select id, comment, parent, created_on 
				from comments 
				where postID=".$this->remqt($postID).
				" order by parent, id";
		$result = $this->mysqli->query($sql);
		if (!$result) {
			echo "<b>Runtime error: </b>".$this->error();
			exit;
		}
		$comments = array(array());
		while ($row = $result->fetch_assoc())
			$comments[ $row["parent"] ][ $row["id"] ] = new Comment($row);
		return $comments;

	}
}
?>