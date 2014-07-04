<?php 
include "common.php";

echo "Checking log in.. Please wait.";

if (isset($_POST)) {	
	$sql = "select id,username from users where username='".$conn->remqt($_POST["username"])."' and binary password='".$conn->remqt($_POST["pass"])."'";
	//echo $sql."<br>";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_array();

		//start a new session and store the username in it
		echo $row["id"]." ".$row["username"];
		$_SESSION["userid"] = $row["id"];
		$_SESSION["username"] = $row["username"];
		$sql = "";
		$result = null;	
		Common::redirect("main.php");
	}	
	else {
		echo "Waht the fuck: ".$conn->error();
		exit;
		//Common::redirect("login.php?error=Y");
	}


	if (!empty($_GET))
		if ($_GET["success"] == "Y") 
			$messages += "Post successful! You must be super excited to have a working thingie";
		else
			$messages += "An error has occurred.";
		
	
}