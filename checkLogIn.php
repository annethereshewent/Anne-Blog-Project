<?php 
include "common.php";

echo "Checking log in.. Please wait.<br>";

if (isset($_POST)) {
	echo "POST variables are set..";
	$conn->authenticate($_POST["username"],$_POST["pass"]);	
}
