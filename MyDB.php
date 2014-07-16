<?php

class MyDB {

	private $DB; 
	//note to self: if PDO::rowCount() doesn't work on the server, try select found_rows(); instead

	public function __construct($host, $user, $pass,$db) {
		try {
			$this->DB = new PDO("mysql:host=".$host.";dbname=".$db, $user, $pass);
			$this->DB->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
			$this->DB->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		} catch(PDOException $e) {
			echo $e->getMessage();
			exit;
		}
	}
	/* 
	Primarily for ajax calls
	*/
	public function fetch_contents($pID) {

		if ($pID == "")
			echo "false";
		$sql = "select post 
				from posts 
				where id=:id";
		
		$stmt = $this->prepare($sql,array(
			"id" => $pID
		));


		if ($stmt->rowCount() > 0) {
			$row = $stmt->fetch();
			echo $row["post"];
		}
		$statement = null;

	}

	public function edit_post($content, $pID) {
			$sql = "update posts set post = :content,
			edited_on = CURRENT_TIMESTAMP,
			edited = 1
			where id= :pID";

			return $this->command($sql,array(
				"content" => $content,
				"pID"     => $pID
			));
	}

	public function register_user($record) {
		$sql = "insert into users (username, password) 
				values (:user, :pass)";
		
		//generate random salt, cost of 7
		//$salt = '$2a$07$'.base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)); 
		//$hash = crypt($record["password"], $salt);

		$hash = password_hash($record["password"], PASSWORD_DEFAULT);
		//echo $hash;
		
		$params = array(
			"user" => $record["email"],
			"pass" => $hash
		);

		if ($this->command($sql, $params)) {
			$sql = "select id 
					from users 
					where username = :username";

			//echo ($sql);
			$statement = $this->prepare($sql, array(
				"username" => $record["email"]
			));
			if ($row = $statement->fetch(PDO::FETCH_ASSOC)) {
				$_SESSION["username"] = $record["email"];
				$_SESSION["userid"] = $row["id"];
				Common::redirect("main.php");
			}
		}
	}

	public function authenticate($username,$password) {
		if (!isset($_SESSION["attempts"]))
			$_SESSION["attempts"] = 0;	
		$sql = "select id,username,password 
				from users 
				where username=:user limit 1";
		//echo $sql.", username = ".$username." and password=".$password;
		
		$stmt = $this->prepare($sql,array(
			"user" => $username
		));

		if ($row = $stmt->fetch()) {
			//need to check hashed password
			if (password_verify($password,$row["password"])) { 
				echo "authentication successful, logging in...<br>";
				$_SESSION["userid"] = $row["id"];
				$_SESSION["username"] = $row["username"];
				$stmt = null;
				$_SESSION["attempts"] = null;
				unset($_SESSION["attempts"]);
				Common::redirect("main.php");
			}
		}

		echo "Authentication failed..";
		$_SESSION["attempts"]++;
		Common::redirect("login.php?error=Y");

	}

	/*
	same as prepare, but returns true or false.
	used for inserts and updates.
	*/
	public function command($sql, $params) {
		try {
			$stmt = $this->DB->prepare($sql);
			if ($stmt->execute($params))
				return true;
			return false;
		} catch (Exception $e) {
			var_dump($e->getMessage());
			return false;
		}
	}

	public function prepare($sql, $data) {	
		try {
			$stmt = $this->DB->prepare($sql);
			$stmt->execute($data);
			return $stmt;
		} catch (Exception $e) {
			var_dump($e->getMessage());
			return null;
		}

	}

	public function check_username($username) {
		$sql = "select username 
				from users 
				where username = :username";

		$stmt = $this->prepare($sql, array(
			"username" => $username
		));


		if ($stmt->rowCount() > 0) {
			$stmt = null;
			return true;
		}

		return false;
	}

	public function insert_post($content,$userID) {
		$sql = "insert into posts (post,userID) 
				values (:content, :userID)";
		
		return $this->command($sql, array(
			"content" => $content,
			"userID"  => $userID
		));
	}

	public function insert_comment($parentID,$pID,$comment) {
		$this->DB->beginTransaction();
		try {
			$sql = "insert into comments 
					(comment, postID, userID, parent) 
					values (:comment, :postID, :userID, :parent)";
			
			$stmt = $this->DB->prepare($sql);
			$stmt->execute(array(
				"comment" => $comment,
				"postID"  => $pID,
				"userID"  => $_SESSION["userid"],
				"parent"  => $parentID
			));		
					
			$sql = "update posts  
					set num_comments = num_comments+1
					where id=:pID";

			$stmt = $this->DB->prepare($sql);
			$stmt->execute(array(
				"pID" => $_SESSION["userid"]
			));

			$this->DB->commit();
		} catch (Exception $e) {
			echo "hey it made it here! yay.";
			$this->DB->rollback();
			var_dump($e->getMessage());
			return false;
		}	
		return true;
	}
	/*
	when you *must* call a query directly.
	uses prepared statements
	*/
	public function query($sql,$params) {
		$statement = $this->prepare($sql,$params);
		$statement->setFetchMode(PDO::FETCH_ASSOC);
		return $statement;
	}
	/* 
	fetches a post record from database and returns it. good for formatting
	*/
	public function fetch_post($pID) {

		if ($pID == "")
			return null;
		$sql = "select id, post, created_on, edited_on, edited 
				from posts 
				where id = :id";

		//$result = $this->mysqli->query($sql);
		$stmt = $this->prepare($sql,array(
			"id" => $pID
		));
		if ($stmt->rowCount() == 1) {
			//success
			return $stmt->fetch();
		} 
		return null;
	}
	/*
	gets all user posts at once, deprecated
	*/
	public function fetch_all_user_posts($userID) {
		$sql = "select id, post, created_on, edited_on, edited, num_comments 
				from posts 
				where userID='".$this->remqt($userID)."' order by id desc";

		return $this->mysqli->query($sql);
	}

	public function fetch_user_posts_by_page($userID,$page) {
		//to prevent with tampering
		if (!is_numeric($page))
			$page = 1;

		$start = ($page == 1) ? 0 : 15*($page-1);

		$sql = "select id, post, created_on, edited_on, edited, num_comments 
				from posts 
				where userID=:userID
				order by id desc limit :start, :fin";
		
		$stmt = $this->prepare($sql,array(
				"userID" => $userID,
				"start"  => $start,
				"fin"    => 15
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		return $stmt;
	}

	public function fetch_post_comments($postID) {
		$sql = "select c.id, comment, parent, created_on, postID, displayname 
				from  comments c, users u
				where postID=:postID
				and u.id = c.userID
				order by parent, id";
		$stmt = $this->prepare($sql,array(
			"postID" => $postID
		));
		$comments = array(array());
		while ($row = $stmt->fetch())
			$comments[ $row["parent"] ][] = new Comment($row);
		return $comments;
	}
}
?>