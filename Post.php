<?php 
include "common.php";

public class Post extends MyDB {
	public $post, $userID, $created_on, $edited_on, $edited, $num_comments;
	public function __construct($row) {
		$this->post       =   $row["post"];
		$this->userID     =   $row["userID"];
		$this->created_on =   $row["created_on"];
		$this->edited_on  =   $row["edited_on"];
		$this->num_comments = $row["num_comments"];
	}
	
}