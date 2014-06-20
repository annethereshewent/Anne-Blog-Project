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
<html>
	<head>
		<title>Make New Blog Post</title>
		<style>
		.post {
			font-size:16px;
		}
		h2 {
			font-family:"Calibri";
			color:#9999FF;
			font-size:25px;
		
		}
		.content {
			font-family:"Calibri";
			background:#ffffff;
			background: #F2F2FA;
			border:1px solid #000000;
			padding:30px 30px 30px 60px;
			width:40%;
			margin-left:10px;	
		}
		.header {
			background:#CC3399;
			width:40px;
			border:1px solid #7A1F5C;
			color:#ffffff;
		}
		
		</style>
	</head>
	<body style="background:#7A7ACC">
		<h2>Create a new post - <?= $_SESSION["username"]?></h2>
		<div class="content">
			<form name="newPost" method="post" action="newpost.php">
				<textarea name="blogpost" rows="20" cols="50">Start writing here...</textarea>
				<div class="buttonarea">
				 	<input type="submit" value="Post"> <input type="button" value="Cancel" onClick="location.href='main.php'">
				</div>
			</form>
		</div>
	</body>
</html>
