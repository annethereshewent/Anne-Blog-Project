<?php
include "common.php";

if (isset($_POST)) {
	$sql = "insert into comments (comment, postID, userID,parent) values (".
		"'".$conn->remqt($_POST["comment"])."',".
		"'".$conn->remqt($_POST["pid"])."',".
		"'".$conn->remqt($_SESSION["userid"])."',"
			"0)";
	if ($conn->query($sql))
		Common::redirect("comments.php?pid=".$_POST["pid"]);
	else 
		echo "<b>An Error has occured:</b>".$conn->error();
	
}
else
	Common::redirect("main.php");

?>