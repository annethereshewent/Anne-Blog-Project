<?
include "common-mysql.php";

if (isset($_GET["user"])) {
	$sql = "select username from users where username = '".$_POST["user"];
	$result = $conn->query($sql);
	if ($result->num_row > 0) 
		echo "true";
	else
		echo "false";
}


?>