<?php 
include "common-mysql.php";
include "common-js.php";

if (isset($_POST)) {
	
	
	$sql = "select id,username,fname,lname from users where username='".remqt($_POST["username"])."' and binary password='".remqt($_POST["pass"])."'";
	
	$result = $conn->query($sql);
	unset($_POST);
	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		//start a new session and store the username in it

		$_SESSION["userid"] = $row["id"];
		$_SESSION["username"] = $row["username"];
		$sql = "";
		$result = null;	
		jsRedirect("main.php");
	}	
	else 
		jsRedirect("login.php?error=Y");

	if (!empty($_GET))
		if ($_GET["success"] == "Y") 
			$messages += "Post successful! You must be super excited to have a working thingie";
		else
			$messages += "An error has occurred.";
		
	
}