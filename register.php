<?
include "common-mysql.php";
include "common-js.php";

echo "hello?";
if (isset($_POST)) {
	//assuming all validation passes
	echo "test? can anyone hear me?: " $_POST["email"]." ".$_POST["pass1"];
	exit;
	$sql = "insert into users (username, password) values (".
		"'".$_POST["email"]."',".
		"'".$_POST["pass1"."')";
	echo $sql;
	if ($conn->query($sql)) {
		echo "test?";
		$_SESSION["username"] = $_POST["email"];
		//not sure if this is dumb
		$sql = "select id from users where username = '".$_SESSION["username"]."'";
		$row = $conn->query($sql).fetch_array();
		$_SESSION["userid"] = $row["id"];
		jsRedirect("main.php");
	}
	else {
		echo "an error has occured: ".$conn->error();
		exit;
	}	
}
else {
	echo "post variables not set?";
	exit;
}
