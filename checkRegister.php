<?php
include "common-mysql.php";
include "common-js.php";


//echo "is anybody out there?";
if (isset($_POST)) {
	//echo ("what the heck? ".$_POST["email"]." ".$_POST["pass1"]);

	$sql = "insert into users (username, password) values (".
		"'".remqt($_POST["email"])."',".
		"'".remqt($_POST["pass1"])."')";
	//echo ($sql);
	if ($conn->query($sql)) {
		echo "is it the lack of head? (lol)";
		$sql = "select id from users where username = '".remqt($_POST["email"])."'";
		echo ($sql);
		$result = $conn->query($sql);
		$row = $result->fetch_array();
		$_SESSION["username"] = $_POST["email"];
		$_SESSION["userid"] = $row["id"];
		echo "nope seems like it was a sql thing";
		jsRedirect("main.php");
	}
	else {
		//echo "Test? Not sure what's going on anymore :(";
		echo "<b>MySQL error:</b> ".$conn->error;
	}

}
else {
	jsRedirect("login.php?regError=Y");
}
basdfasdfsdafsd
?>