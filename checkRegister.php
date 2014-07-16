<?php
include "common.php";


if (isset($_POST)) {
	$conn->register_user(array(
		"email" => $_POST["email"], 
		"password" => $_POST["pass1"]
	));	
}
else {
	Common::redirect("login.php?regError=Y");
}
?>