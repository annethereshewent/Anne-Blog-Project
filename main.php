<?
include "common.php";


$row = null;
$messages = "";
$result = null;
$noRows = false;

if (isset($_SESSION["userid"])) {
	//get posts
	$pageNumber = 1;
	if (isset($_GET["page"])) 
		$pageNumber = $_GET["page"];
	

	$result = $conn->fetch_user_posts_by_page($_SESSION["userid"],$pageNumber);
	if ($result->num_rows == 0)
		$noRows= true;
}
else
	Common::redirect("login.php?error=Y");


?>

<head>
	<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script src="js/jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
	<script src="js/froala_editor.min.js"></script>
	
	<script src="js/main.js" type="text/javascript"></script>
	
	<title>Welcome!</title>
	<link href="css/default.css" rel="stylesheet" type="text/css">
	<link href="//maxcdn.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet">
	<link href="css/froala_editor.min.css" rel="stylesheet" type="text/css">
	

	
	<style>

	#postModal {
		width: 375px;
		height: 420px;
	}
	#editContents {
		-webkit-border-radius: 15px;
		-moz-border-radius: 15px;
		background: white;
		//border: 1px solid black;
		border-radius: 15px;
		font-size: 16px;
		font-family: "Calibri";
		margin-bottom:10px;
		margin-left:10px;
	}
	#simplemodal-overlay {
		background: #000;
	}
	
	</style>
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
	<h2 style="text-align:center">Welcome!</h2>
	<div class="main">
		<div class="tab-container">
			<span class="tab"><a class="tlink" href="main.php">Main</a></span>
			<span class="tab"><a class="tlink" href="#" onClick="openNewModal()">New</a></span>
			<span class="tab">Profile</span>
			<span class="tab"><a class="tlink" href="logout.php">Log Out</a></span>
		</div>

			<? if ($result != null) {
				if ($noRows) { ?>
					<div class="content" style="color:grey">
						<i><h3>Your blog is empty. :(</h3>
						<p>give your blog some loving and create your first post! We are so excited!</p></i>
					</div>
				<? } 
				else {
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
						<div class="content-divider"></div>
		<?
					}
				}
			}
		?>
		<footer>
		<?= Common::getPageFooter($pageNumber) ?>
		</footer>
	</div>
</body>

<div class="content" id="postModal" style="display:none">
	<p style="color:#7A7ACC;margin-left:10px">Create a New Post</p>
	<form name="newPost" id="newPost" method="post">
			<div name="blogpost" id="editContents"></div>
			<div  style="margin-left:15px;"class="buttonarea">
		 	   <button type="button" onClick="submitContents()" id="blogSubmit">Post</button> <button type="button" class="simplemodal-close">Cancel</button>
			</div>
			<input type="hidden" name="htmlContent" id="htmlContent">
	</form>
</div>