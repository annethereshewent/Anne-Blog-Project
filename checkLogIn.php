<?php 
include "common.php";

echo "Checking log in.. Please wait.<br>";

if (isset($_POST)) {
	echo "POST variables are set<br>";
	$conn->authenticate($_POST["username"],$_POST["pass"]);	
}
else
	Common::Redirect("login.php");
