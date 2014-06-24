<?php
include "common.php";


if (isset($_POST)) {
	$sql = "insert into users (username, password) values (".
		"'".$conn->remqt($_POST["email"])."',".
		"'".$conn->remqt($_POST["pass1"])."')";
	//echo ($sql);
	if ($conn->query($sql)) {
		$sql = "select id from users where username = '".remqt($_POST["email"])."'";
		echo ($sql);
		$result = $conn->query($sql);
		$row = $result->fetch_array();
		$_SESSION["username"] = $conn->remqt($_POST["email"]);
		$_SESSION["userid"] = $row["id"];
		Common::redirect("main.php");
	}
	else {
		echo "<b>MySQL error:</b> ".$conn->error();
	}

}
else {
	Common::redirect("login.php?regError=Y");
}
?>