<?
include "common-mysql.php";
include "common-js.php";


$row = null;
$messages = "";
$result = null;


if (isset($_POST["username"])) {
	
	
	$sql = "select id,username,fname,lname from users where username='".remqt($_POST["username"])."' and password='".remqt($_POST["pass"])."'";
	
	$result = $conn->query($sql);
	unset($_POST);
	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		//start a new session and store the username in it

		$_SESSION["userid"] = $row["id"];
		$_SESSION["username"] = $row["username"];	

	}	
	else 
		jsRedirect("login.php?error=Y");

	if (!empty($_GET))
		if ($_GET["success"] == "Y") 
			$messages += "Post successful! You must be super excited to have a working thingie";
		else
			$messages += "An error has occurred.";
		
	
}
if (isset($_SESSION)) {
	//get posts
	$sql = "select id, post, created_on from posts where userID='".$_SESSION["userid"]."' order by id desc";
	$result = $conn->query($sql);
}
else
	jsRedirect("login.php?error=Y");
?>

<head>
	<script src="jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
	
	<script>
	function openModal() {
		$("#postModal").modal({
			opacity:60, 
			overlayClose:true,
			position: ["25%", "25%"]
		});
	}
	</script>
	
	<title>Main</title>
	
	<style>
	.post {
		font-size:16px;
	}
	h2 {
		font-family:"Calibri";
		color:#EBD6FF;
		font-size:25px;
		
	}
	.content {
		font-family:"Calibri";
		background: #F2F2FA;
		border:1px solid #000000;
		-webkit-border-radius: 20px;
		-moz-border-radius: 20px;
		border-radius: 20px;
		//margin: 30px 30px 30px 30px;
		padding-left: 20px;
		padding-bottom:20px;
		padding-right:20px;
		width: 40%;
	}
	.tab {
		background:#CC3399;
		width:120px;
		border:1px solid #7A1F5C;
		color:#ffffff;
	}
	a.tlink {
		text-decoration:none;
		color:#ffffff;
	}
	#postModal {
		padding-top:20px;
		padding-right:40px;
		width:85%;
		height:90 %;
	}
	textarea {
		-webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		border-radius: 15px;
		outline:none;
		resize:none;
		font-size: 16px;
		font-family: "Calibri";
	}
	#simplemodal-overlay {
		background: #000;
	}
	
	</style>
</head>
<body style="background:#7A7ACC">
	<h2 style="text-align:center">Welcome <?= $_SESSION["username"]?>!</h2>
	<div style="margin-left: 30%">
		<div style="margin-left:20px">
			<span class="tab"><a class="tlink" href="main.php">Posts</a></span>
			<span class="tab"><a class="tlink" href="#" onClick="openModal()">New</a></span>
			<span class="tab">Profile</span>
			<span class="tab"><a class="tlink" href="logout.php">Log Out</a></span>
		</div>

			<? if ($result != null) {
				while ($row = mysqli_fetch_array($result)) { ?>
					<div class="content">
						<p style="font-size:small;"><i>Creation Date: <?= $row["created_on"] ?></i></p>
						<div class="post"> 
							<?= $row["post"]?>
						</div>
						<div class="post-buttons" style="font-size:12px">
							<a href="comments.php?pid=<?= $row["id"] ?>">Make a Comment</a>&nbsp;&nbsp;<a href="edit.php?pid=<?= $row["id"] ?>">Edit Post</a>
						</div>
					</div>
					<div style="height:20px; width: 20px"></div>
		<?
				}
			}
		?>
	</div>
		<br>
	</div>
	
	<div class="messages" style="color:red"> 
		<?= $messages ?>
	</div>

</body>
<div id="postModal" style="display:none">
	<div class="content">
		<p style="color:#7A7ACC">Create a New Post</p>
		<form name="newPost" method="post" action="newpost.php">
			<textarea name="blogpost" placeholder="Start writing here..." rows="15" cols="50"></textarea>
			<div class="buttonarea">
			 	<button type="submit">Post</button> <button type="button" class="simplemodal-close">Cancel</button>
			</div>
		</form>
	</div>
</div>
<?  
$conn->close();
?>