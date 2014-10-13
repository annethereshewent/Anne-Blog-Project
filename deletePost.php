<?php
require "common.php";
$pID = 0;
if (isset($_POST["pID"])) 
	$pID = $_POST["pID"];
else {
	echo "failure, pID not set";
	exit;
}

$conn->deletePost($pID);

?>