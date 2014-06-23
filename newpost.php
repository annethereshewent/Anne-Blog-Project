<?
include "common.php";

if (!isset($_SESSION))
	jsRedirect("login.php?error=Y");
if (isset($_POST["htmlContent"])) {

	$sql = "insert into posts (post,userID) values ('".
		$conn->remqt($_POST["htmlContent"])."',"
		.$_SESSION["userid"].")";

	if ($conn->query($sql)) 
		Common::redirect("main.php?success=Y");
	else {
		echo("<p style=\"color:red\">Error: ".$conn->error);
		echo $sql;
		exit;
	}
}
else {
	echo "something went wrong";
	exit;
}
?>
