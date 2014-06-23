<?
include "common.php";

if (isset($_GET["user"])) {
	$sql = "select username from users where username = '".$_GET["user"]."'";
	$result = $conn->query($sql);
	if ($result->num_rows > 0) 
		echo "true";
	else
		echo "false";
}
?>