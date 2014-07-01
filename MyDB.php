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
		$sql = "select post from posts where id=".$this->remqt($pID);
		$result = $this->mysqli->query($sql);
		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			echo $row["post"];
		}
		$result->close();
		$result = null;
	}
	public function insert_comment($parentID,$pID,$comment) {
		$sql = "start transaction;

				insert into comments 
				(comment, postID, userID, parent) 
				values (".
				"'".$this->remqt($comment)."',".
				$this->remqt($pID).",".
				$this->remqt($_SESSION["userid"]).",".
				$this->remqt($parentID).");
				
				update posts  
				set num_comments = num_comments+1
				where id=".$pID.";

				commit;";
				

		return $this->mysqli->multi_query($sql);
	}
	/*
	when you must call mysqli_query
	*/
	public function query($sql) {
		return $this->mysqli->query($sql);
	}
	/* 
	fetches a post record from database and returns it. good for formatting
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
		$sql = "select id, post, created_on, edited_on, edited, num_comments 
				from posts 
				where userID='".$this->remqt($userID)."' order by id desc";

		return $this->mysqli->query($sql);
	}
	public function fetch_user_posts_by_page($userID,$page) {
		$limit = $page == 1 ? "limit 15" : "limit ".(15*($page-1)).",15";

		$sql = 
		"select id, post, created_on, edited_on, edited, num_comments 
		from posts 
		where userID='".$userID."'
		order by id desc ".$limit;
		return $this->mysqli->query($sql);
	}
	public function error() {
		return $this->mysqli->error;
	}
	public function fetch_post_comments($postID) {
		$sql = "select c.id, comment, parent, created_on, postID, displayname 
				from  comments c, users u
				where postID=".$this->remqt($postID).
				" and u.id = c.userID".
				" order by parent, id";
		$result = $this->mysqli->query($sql);
		if (!$result) {
			echo "<b>Runtime error: </b>".$this->error();
			exit;
		}
		$comments = array(array());
		while ($row = $result->fetch_assoc())
			$comments[ $row["parent"] ][] = new Comment($row);
		return $comments;

	}
}
?>