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
		else
			echo "something went wrong";
		$statement = null;

	}

	public function edit_post($content, $pID) {
			$sql = "update posts 
					set post = :content,
					edited_on = CURRENT_TIMESTAMP,
					edited = 1
					where id= :pID";

			return $this->command($sql,array(
				"content" => $content,
				"pID"     => $pID
			));
	}

	public function register_user($record) {
		

		$sql = "insert into users (username, password, displayname, blog_title) 
				values (:user, :pass, :display, :title)";
		
		//generate random salt, cost of 7
		//$salt = '$2a$07$'.base64_encode(mcrypt_create_iv(16, MCRYPT_DEV_URANDOM)); 
		//$hash = crypt($record["password"], $salt);

		$hash = password_hash($record["password"], PASSWORD_DEFAULT);
		//echo $hash;
		
		$params = array(
			"user"    => $record["email"],
			"pass"    => $hash,
			"display" => $record['displayname'],
			"title"   => $record['blog_title']
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
				
				$_SESSION["userid"]      = $row["id"];
				$_SESSION["title"]       = $record["blog_title"];
				$_SESSION["displayname"] = $record["displayname"];
				$_SESSION["login"]       = true;
 				
 				Common::redirect("/blog/".$_SESSION["displayname"]);
			}
		}
	}

	public function authenticate($username,$password) {
		$sql = "select id,password,displayname,blog_title,description,profile_pic
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
				
				$_SESSION["userid"]      = $row["id"];
				$_SESSION["title"]       = $row["blog_title"];
				$_SESSION["displayname"] = $row["displayname"];
				$_SESSION["login"]       = true;
				$_SESSION["userpic"]     = $row["profile_pic"];
				$_SESSION["description"] = $row["description"];
				
				$stmt = null;
				
				$url = "/blog/".$_SESSION["displayname"];
				Common::redirect("/blog/".$_SESSION["displayname"]);
			}
		}

		echo "Authentication failed..";
		Common::redirect("login.php?error=Y");

	}
	//similar to authenticate, returns true or false
	public function verify($password) {
		$sql = "select password
				from users 
				where id=:id limit 1";
		//echo $sql.", username = ".$username." and password=".$password;		
		$stmt = $this->prepare($sql,array(
			"id" => $_SESSION["userid"]
		));
		if ($row = $stmt->fetch()) {
			//need to check hashed password
			if (password_verify($password,$row["password"])) 
				return true;
		}
		return false;

	}


	/*
	same as prepare, but returns true or false.
	used for inserts and updates.
	*/
	public function command($sql, $params) {
		try {
			$stmt = $this->DB->prepare($sql);
			return $stmt->execute($params);
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

	public function check_register($fields) {
		$returnStr = "";
		$sql = "select username 
				from users 
				where username = :username";

		$stmt = $this->prepare($sql, array(
			"username" => $fields["user"]
		));

		if ($stmt->rowCount() > 0) {
			$stmt = null;
			$returnStr .= "user";
		}
		if ($fields["display"] != "") {
			$sql = "select displayname
					from users
					where displayname = :display";
			$stmt = $this->prepare($sql, array(
				"display" => $fields["display"] 
			));

			if ($stmt->rowCount() > 0) {
				$stmt = null;
				$returnStr .= " display";
			}
		}
		return $returnStr;
	}

	public function insert_post($content,$userID) {
		$sql = "insert into posts (post,userID) 
				values (:content, :userID)";
		
		return $this->command($sql, array(
			"content" => $content,
			"userID"  => $userID
		));
	}
	//public abstract function insert() { }

	public function insert_comment($parentID,$pID,$comment) {
		$comment = str_replace("\n", "<br>", $comment);
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
				"pID" => $pID
			));

			$this->DB->commit();
		} catch (Exception $e) {
			$this->DB->rollback();
			var_dump($e->getMessage());
			return false;
		}	
		return true;
	}
	//make this protected
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
	fetches a post from database and returns it. good for formatting
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
	public function get_page_info() {
		$temp = explode("/", $_SERVER["REQUEST_URI"]);
		$info = array();

		$info["action"] = isset($temp[1]) ? $temp[1] : "";
		$info["blog"] = isset($temp[2]) ? $temp[2] : "";
		switch ($info['action']) {
			case 'blog':
				$info["page"] = (isset($temp[3]) && is_numeric($temp[3])) ? $temp[3] : 1; //third parameter is the page number
				break;
			case 'comments':
				if (isset($temp[3]) && $temp[3] != '')
					$info['pid'] = $temp[3]; //the third parameter will be the pid
				else
					Common::redirect("/error.php");
				break;
		}


		//get page's user picture, title, description, etc

		$sql = "select blog_title, profile_pic, description"
				." from users"
				." where displayname = :displayname limit 1";

		$stmt = $this->prepare($sql, array(
			"displayname" => $info["blog"]
		));
		$stmt->setFetchMode(PDO::FETCH_ASSOC);
		$row = $stmt->fetch();
		$info = array_merge($info, $row);

		//var_dump($info);
		//exit;

		return $info;
	}
	public function deletePost($pID) {
		$sql = "delete from posts "
				."where id = :id";
		if ($this->command($sql, array("id" => $pID))) {
			echo "success";
		}
		else
			echo "failure";
	}
	public function fetch_post_comments($postID) {

		$sql = "select c.id, comment, parent, created_on, postID, displayname 
				from comments c, users u
				where postID=:postID    
				order by parent, id";
		$stmt = $this->prepare($sql,array(
			"postID" => $postID
		));
		$comments = array(array());
		while ($row = $stmt->fetch())
			$comments[ $row["parent"] ][] = new Comment($row);
		return $comments;
	}

	public function update_profile_pic($path) {
		$sql = "update users".
				" set profile_pic = :path".
				" where id = :userid";
		$_SESSION["userpic"] = $path;
		return $this->command($sql, array(
			"path"   => $path,
			"userid" => $_SESSION["userid"]
		));
	}
	/*
				$_SESSION["userid"]      = $row["id"];
				$_SESSION["displayname"] = $row["displayname"];
				$_SESSION["title"]       = $row["blog_title"];
				$_SESSION["description"] = $row["description"];
				$_SESSION["userpic"]     = $row["profile_pic"];
	*/
	public function update_user_info($params) {
		$sql = "update users
				set ";
		foreach ($params as $column => $value) {
			$sql .= $column." = :".$column.",";
		    if ($column == "blog_title")
		    	$_SESSION["title"] = $value;
		    else if ($column == "profile_pic")
		    	$_SESSION["userpic"] = $value;
		    else 
		    	$_SESSION[$column] = $value;

		}
		
		//remove trailing comma and add where clause 
		$sql = trim($sql, ",")." 
		where id=:userid";
		
		$params["userid"] = $_SESSION["userid"];
                return $this->command($sql,$params); //returns true or false for update command
                
                
	}
	public function savePassword($password) {
		if ($password != "") {
			$hash = password_hash($password, PASSWORD_DEFAULT);
			$sql = "update users".
					" set password = :password".
					" where id = :id";
			return $this->command($sql, array(
				"password" => $hash,
				"id"       => $_SESSION["userid"]
			));
		}

	}
	public function saveEmail($email) {
		if ($email != "") {
			$sql = "update users".
					" set username = :user".
					" where id = :id";

			return $this->command($sql, array(
				"user" => $email,
				"id"   => $_SESSION["userid"]
			));
		}
	}
}
?>