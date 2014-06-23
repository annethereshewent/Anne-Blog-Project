<?php
include "common.php";

$postID = (isset($_GET["pID"])) ? $_GET["pID"] : "";
if ($postID == "") {
	echo "false";
	return;
}
else $conn->fetch_contents($postID);
?>