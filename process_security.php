<?php
require "common.php";

$email = isset($_POST["email"]) ? $_POST["email"] : "";
$password = isset($_POST["pass1"]) ? $_POST["pass1"] : "";

if ($email != "") {
	if (!$conn->saveEmail($email)) {
		Common::redirect("account.php?error");
	}
		
}
if ($password != "") {
	if (!$conn->savePassword($password)) {
		Common::redirect("account.php?error");
	}
		

}
Common::redirect("account.php")

?>