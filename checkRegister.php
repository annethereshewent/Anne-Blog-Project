<?php
include "common.php";


if (isset($_POST)) {
	$conn->register_user(array(
		"email"       => $_POST["email"]), 
		"password"    => $_POST["pass1"],
		"displayname" => $_POST["displayname"],
		"blog_title"  => $_POST["btitle"]
	));	
}
else {
	Common::redirect("login.php?regError=Y");
}
?>