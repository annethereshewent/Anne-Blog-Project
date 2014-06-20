<?
include "common-mysql.php";
include "common-js.php";

if (!isset($_SESSION))
	jsRedirect("login.php?error=Y");
if (!empty($_POST)) {

	$sql = "insert into posts (post,userID) values ('".
		remqt($_POST["blogpost"])."',"
		.$_SESSION["userid"].")";

	if ($conn->query($sql)) 
		jsRedirect("main.php?success=Y");
	else {
		echo("<p style=\"color:red\">Error: ".$conn->error);
		echo $sql;
		exit;
	}
	
	//perhaps this could even be a modal. just like tumblr
}
/*$conn = mysqli_connect("localhost", "root", "root", "test") or die("Error: ".mysqli_error($conn));

$sql = "select posts, created_on from posts where userid='".$_SESSION["userID"]."'";
$result = mysqli_query($conn,$sql);*/

?>
