<?
include "common.php";


if (isset($_GET["pid"]) && $_GET["pid"] != "") {
	$postID = $_GET["pid"];
	$post = $conn->fetch_post($postID);
	

	$commentArray = $conn->fetch_post_comments($postID);

	//$commentTreeStr = Comment::buildCommentTree($commentArray,0);

}
else
	Common::redirect("main.php");
?>
<html>
<head>	
	<style>
	.content.comment-container {
		width: 800px;
		height:160px;
		margin-left:-60px;
		display:none;
	}
	#comment-text {
		width:740px;
		height:100px;
		-webkit-border-radius: 10px;
		-moz-border-radius: 10px;
		border-radius: 10px;
		margin-top:30px;
		margin-left:10px;
		outline:none;
		resize:none;
	}
	</style>
	<link href="css/default.css" rel="stylesheet" type="text/css">
	<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>	
	<script type="text/javascript">
	$(document).ready(function() {
		$("#comment-submit").attr("disabled","true");
		$("#comment-text").blur(function() {
			if ($(this).val() != "")
				$("#comment-submit").removeAttr("disabled");
			else
				$("#comment-submit").attr("disabled","true");
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
				<a href="#" onClick="$('#textbox-container').fadeIn(300).show()">New Comment</a>&nbsp;&nbsp;<a href="main.php">Back</a>
			</div>
		</div>
		<div class="content-divider"></div>
		<div class="content comment-container" id="textbox-container">
			<form name="commentsubm" id="commentsubm" method="post" action="new_comment.php">
				<textarea name="comment" id="comment-text" placeholder="Enter comment here..."></textarea>
				<input type="hidden" name="pid" value="<?= $postID ?>">
				<div class="buttonarea" style="margin-top:10px;margin-left:10px">
					<button type="submit" id="comment-submit">Post</button>&nbsp;&nbsp;<button type="button" onClick="$('#textbox-container').fadeOut(300).hide()">Cancel</button>
				</div>
			</form>
		</div>
		<div class="content-divider"></div>
		<div class="content">
			<?= Comment::buildCommentTree($commentArray,0) ?>
		</div>
</body>
</html>