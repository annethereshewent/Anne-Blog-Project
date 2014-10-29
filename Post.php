<?php 
include "common.php";

public class Post extends MyDB {
	public $id, $post, $userID, $created_on, $edited_on, $edited, $num_comments;
	public function __construct($row) {
		$this->id           = $row["id"];
		$this->post         = $row["post"];
		$this->userID       = $row["userID"];
		$this->created_on   = $row["created_on"];
		$this->edited_on    = $row["edited_on"];
		$this->num_comments = $row["num_comments"];
	}
	/*
	mostly for ajax calls
	*/
	public function fetch_contents() {

		if ($pID == "")
			echo "false";
		$sql = "select post 
				from posts 
				where id=:id";
		
		$stmt = $this->prepare($sql,array(
			"id" => $this->id
		));


		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch();
			echo $row["post"];
		}
		$statement = null;

	}
	public function edit() {
			$sql = "update posts 
					set post = :content,
					edited_on = CURRENT_TIMESTAMP,
					edited = 1
					where id= :pID";

			return $this->command($sql,array(
				"content" => $this->post,
				"pID"     => $this->id
			));
	}
	public function insert() {
		$sql = "insert into posts (post,userID) 
				values (:content, :userID)";
		
		return $this->command($sql, array(
			"content" => $this->post,
			"userID"  => $this->userID
		));
	}
	public function delete() {
		$sql = "delete from posts "
				."where id = :id";
		if ($this->command($sql, array("id" => $this->id))) {
			echo "success";
		}
		else
			echo "failure";
	}

	public function fetch_user_posts_by_page($page) {


		//gets username from the uri
		$temp = explode("/",$_SERVER["REQUEST_URI"]);
		$username = $temp[2];
		$page = isset($temp[3]) ? $temp[3] : 1;

		//to prevent with tampering
		if (!is_numeric($page))
			$page = 1;

		$sql = "select displayname".
				" from users".
				" where displayname = :displayname";
		$stmt = $this->prepare($sql, array(
			"displayname" => $username	
		));

		if ($stmt->rowCount() == 0) 
			Common::redirect("/error.php");
		//else keep going


		$start = ($page == 1) ? 0 : 15*($page-1);

		$sql = "select p.id, post, created_on, edited_on, edited, num_comments 
				from posts p,users u 
				where displayname = :displayname and u.id = p.userID
				order by id desc limit :start, :fin";
		
		$stmt = $this->prepare($sql,array(
				"displayname" => $username,
				"start"       => $start,
				"fin"         => 15
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);

		return $stmt;
	}
	public function get_number_of_posts($page) {
		$username = explode("/",$_SERVER["REQUEST_URI"])[2];
		$start = ($page == 1) ? 0 : 15*($page-1);
		$sql = "select count(userID) as total
				from 
			    	(select userID
			     	 from posts p, users u
			     	 where displayname = :display and p.userID = u.id
			     	 order by p.id desc limit :start, :fin) tot";
		$stmt = $this->prepare($sql, array(
			"display" => $username,
			"start"   => $start,
			"fin"     => 20
		));
		$row = $stmt->fetch();
		return $row["total"];
	}
}