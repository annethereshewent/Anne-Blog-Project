<?php
include "common-mysql.php";

$postID = (isset($_GET["pID"])) ? $_GET["pID"] : "";
if ($postID == "")
	echo "ERROR";
$sql = "select post from posts where id=".$postID;
$result = $conn->query($sql);
if ($result->num_rows > 0) {
	$row = $result->fetch_array();
	echo str_replace("<br>","\n",$row["post"]);
}
?>