<?
include "common.php";

if (isset($_GET["pid"]) && $_GET["pid"] != "") {
	$postID = $_GET["pid"];
	$post = $conn->fetch_post($postID);
	

	$commentArray = $conn->fetch_post_comments($postID);

	//$commentTreeStr = Common::buildCommentTree($commentArray,0);

}
else
	Common::redirect("main.php");
?>
<html>
<head>	
	<style>
	#comment-textbox-container {
		width: 60%;
		height:20%;
		margin-left:-25px;
		display:none;
	}
	#comment {
		width:95%;
		height:65%;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		margin-top:30px;
		outline:none;
		resize:none;
	}
	</style>
	<link href="css/default.css" rel="stylesheet" type="text/css">	
	<script src="js/comment.js" type="text/javascript"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		$("#comment-submit").attr("disabled","true");
		$("#comment").blur(function() {
			if ($(this).val != "")
				$("#comment-submit").attr("enabled","true");
		});
	});
	</script>
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
	<div class="main">
		<div class="tab-container">
			<span class="tab"><a class="tlink" href="main.php">Posts</a></span>
			<span class="tab"><a class="tlink" href="#" onClick="openNewModal()">New</a></span>
			<span class="tab">Profile</span>
			<span class="tab"><a class="tlink" href="logout.php">Log Out</a></span>
		</div>

		<div class="content">
			<p style="font-size:small;"><i>Creation Date: <?= $post["created_on"] ?></i></p>
			<div class="post"> 
				<p><?= $post["post"]?></p>
			</div>
			<div class="post-buttons" style="font-size:12px">
				<a href="#" onClick="$('#comment-container').fadeIn(300).show()">New Comment</a>&nbsp;&nbsp;<a href="main.php">Back</a>
			</div>
		</div>
		<div class="content-divider"></div>
		<div class="content" id="comment-textbox-container">
			<form name="commentsubm" id="commentsubm" method="post" action="new_comment.php">
				<textarea name="comment" id="comment" required></textarea>
				<input type="hidden" name="pid" value="<?= $postID ?>">
				<div class="buttonarea" style="margin-top:10px;margin-left:10px">
					<button type="submit" id="comment-submit">Post</button>&nbsp;&nbsp;<button type="button" onClick="$('#comment-container').fadeOut(300).hide()">Cancel</button>
				</div>
			</form>
		</div>
		<div class="content-divider"></div>
		<div class="content" id="posted-comments">
			<? Common::buildCommentTree($commentArray,0); ?>
		</div>
</body>
</html>