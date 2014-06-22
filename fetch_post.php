<?php
include "common-mysql.php";

$postID = (isset($_GET["pID"])) ? $_GET["pID"] : "";
if ($postID == "") {
	echo "false";
	return;
}
else echo fetch_post($postID);
?>