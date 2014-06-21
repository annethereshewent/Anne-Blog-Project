<?
include "common-mysql.php";
include "common-js.php";


$row = null;
$messages = "";
$result = null;


if (isset($_SESSION["userid"])) {
	//get posts
	$sql = "select id, post, created_on, edited_on, edited from posts where userID='".$_SESSION["userid"]."' order by id desc";
	$result = $conn->query($sql);
}
else
	jsRedirect("login.php?error=Y");


?>

<head>
	<script src="jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
	
	<script src="main.js" type="text/javascript"></script>
	
	<title>Welcome!</title>
	<link href="default.css" rel="stylesheet" type="text/css">
	<style>
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
<body>
	<h1 class="logo">not tumblr.</logo>
	<h2 style="text-align:center">Welcome <?= $_SESSION["username"]?>!</h2>
	<div style="margin-left: 30%">
		<div style="margin-left:20px">
			<span class="tab"><a class="tlink" href="main.php">Posts</a></span>
			<span class="tab"><a class="tlink" href="#" onClick="openNewModal()">New</a></span>
			<span class="tab">Profile</span>
			<span class="tab"><a class="tlink" href="logout.php">Log Out</a></span>
		</div>

			<? if ($result != null) {
				while ($row = mysqli_fetch_array($result)) { ?>
					<div class="content">
						<p style="font-size:small;"><i>Creation Date: <?= $row["created_on"] ?></i></p>
						<div class="post"> 
							<p><?= $row["post"]?></p>
						</div>
						<? if ($row["edited"] == 1) { ?>
							<p style="font-size:small;"><i>(Edited on: <?= $row["edited_on"] ?>)</i></p>
						<? }?>
						<div class="post-buttons" style="font-size:12px">
							<a href="comments.php?pid=<?= $row["id"] ?>">Make a Comment</a>&nbsp;&nbsp;<a href="#" onClick="openEditModal(<?= $row["id"] ?>)">Edit Post</a>
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
<div id="postModal" style="display:none;clear:both">
	<div class="content">
		<p style="color:#7A7ACC">Create a New Post</p>
		<form name="newPost" id="newPost" method="post">
			<textarea name="blogpost" id="editContents" placeholder="Start writing here..." rows="15" cols="50"></textarea>
			<div class="buttonarea">
			 	<button type="submit" id="blogSubmit">Post</button> <button type="button" class="simplemodal-close">Cancel</button>
			</div>
		</form>
	</div>
</div>
<?  
$conn->close();
?>