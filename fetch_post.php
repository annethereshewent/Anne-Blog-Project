<?php
include "common.php";

$postID = (isset($_GET["pID"])) ? $_GET["pID"] : "";
if ($postID == "") {
	echo json_encode(array("success" => false));
	return;
}
else $conn->fetch_contents($postID);
?>