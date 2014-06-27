<?php 
include "common.php";

if (isset($_POST)) {	
	$sql = "select id,username from users where username='".$conn->remqt($_POST["username"])."' and binary password='".$conn->remqt($_POST["pass"])."'";
	$result = $conn->query($sql);

	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		//start a new session and store the username in it

		$_SESSION["userid"] = $row["id"];
		$_SESSION["username"] = $row["username"];
		$sql = "";
		$result = null;	
		Common::redirect("main.php");
	}	
	else {
		echo "ok wtf";
		exit;
		Common::redirect("login.php?error=Y");
	}


	if (!empty($_GET))
		if ($_GET["success"] == "Y") 
			$messages += "Post successful! You must be super excited to have a working thingie";
		else
			$messages += "An error has occurred.";
		
	
}