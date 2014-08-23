<?php
include "common.php";

$params = [];
if (isset($_POST["blog_title"]) && $_POST["blog_title"] != "") 
	$params["blog_title"] = $_POST["blog_title"];
if (isset($_POST["username"]) && $_POST["username"] != "") 
	$params["displayname"] = $_POST["username"];
if (isset($_POST["description"]) && $_POST["description"] != "") 
	$params["description"] = $_POST["description"];

if ($conn->update_user_info($params))
	Common::redirect("account.php?success");
else 
	echo "An error has occurred";
?>