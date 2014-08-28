<?php
require "common.php";

$email = isset($_GET["email"]) ? $_GET["email"] : "";
$password = isset($_GET["pass1"]) ? $_GET["pass1"] : "";

if ($email != "") {
	if (!$conn->changeEmail($email))
		Common::redirect("account.php?error");
}
if ($password != "") {
	if (!$conn->changePassword($password))
		Common::redirect("account.php?error");

}
Common::redirect("account.php")

?>