<?php

class MyDB {

	private $DB; 


	public function __construct($host, $user, $pass,$db) {
		try {
			$this->DB = new PDO("mysql:host=".$host.";dbname=".$db, $user, $pass);
			$this->DB->setAttribute(PDO::ATTR_EMULATE_PREPARES, FALSE);
			$this->DB->etAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
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
				where id=?";
		
		$stmt = $this->prepare($sql,array("i",intval($pID)));


		if ($result->num_rows > 0) {
			$row = $result->fetch_array();
			echo $row["post"];
		}
		$result->close();
		$statement->close();
		$result = null;
		$statement = null;

	}

	public function register_user($record) {
		$sql = "insert into users (username, password) 
				values (:user, :pass)";

		$stmt = $this->prepare($sql, array(
			"user" => $record["email"],
			"pass" => $record["pass1"]
		));
		if ($conn->query($sql)) {
			$sql = "select id from users where username = '".$conn->remqt($_POST["email"])."'";
			echo ($sql);
			$result = $conn->query($sql);
			$row = $result->fetch_array();
			$_SESSION["username"] = $conn->remqt($_POST["email"]);
			$_SESSION["userid"] = $row["id"];
			Common::redirect("main.php");
		}
		else {
			echo "<b>MySQL error:</b> ".$conn->error();
		}
	}

	public function authenticate($username,$password) {
			
		$sql = "select id,username 
				from users 
				where username=:user and binary password=:pass limit 1";
		//echo $sql.", username = ".$username." and password=".$password;
		
		$stmt = $this->prepare($sql,array(
			"user" => $username,
			"pass" => $password
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		if ($row = $stmt->fetch()) {
			//if it got here authentication is successful
			echo "authentication successful, logging in...<br>";
			$_SESSION["userid"] = $row["id"];
			$_SESSION["username"] = $row["username"];
			$stmt = null;
			Common::redirect("main.php");
		}
		echo "Authentication failed..";
		Common::redirect("login.php?error=Y");

	}





	public function prepare($sql, $data) {
		try {
			$stmt = $this->DB->prepare($sql);
			$stmt->execute($data);
			return $stmt;
		} catch (Exception $e) {
			var_dump($e->getMessage();
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
	when you *must* call mysqli_query
	may phase this one out eventually.
	uses prepared statements
	*/
	public function query($sql,$params) {
		$statement = $this->prepare($sql,$params);
		$result = $statement->get_result();

		return $result;
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
	/*
	used to get all user posts at once, not really used
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