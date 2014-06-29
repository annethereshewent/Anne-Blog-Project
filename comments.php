<?
include "common.php";


if (isset($_GET["pid"]) && $_GET["pid"] != "") {
	$postID = $_GET["pid"];
	$post = $conn->fetch_post($postID);
	

	$commentTree = $conn->fetch_post_comments($postID);


}
else
	Common::redirect("main.php");
?>
<html>
<head>	
	<style>
	.content.comment-container {
		width: 600px;
		height:150px;
		margin-left:-60px;
	}
	.comment-container {
		display:none;
	}
	.comment-text {
		width:90%;
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
		$(".comment-submit").attr("disabled","true");
		jQuery('.comment-text').on('input propertychange paste', function()  {
			if ($(this).val() != "")
				$(".comment-submit").removeAttr("disabled");
			else
				$(".comment-submit").attr("disabled","true");
		});
	});
	</script>
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
	<div class="main">
		<div class="tab-container">
			<span class="tab"><a class="tlink" href="main.php">Main</a></span>
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
				<a href="#" onClick="$('#new-textbox-container').show()">New Comment</a>&nbsp;&nbsp;<a href="main.php">Back</a>
			</div>
		</div>
		<div class="content-divider"></div>
		<div class="content comment-container" id="new-textbox-container">
			<form name="commentsubm" id="commentsubm" method="post" action="new_comment.php">
				<textarea name="comment" class="comment-text" id="comment-new" placeholder="Enter comment here..."></textarea>
				<input type="hidden" name="pid" value="<?= $postID ?>">
				<div class="buttonarea" style="margin-top:10px;margin-left:10px">
					<button type="submit" class="comment-submit">Post</button>&nbsp;&nbsp;<button type="button" onClick="$('#new-textbox-container').hide()">Cancel</button>
				</div>
			</form>
		</div>
		<div class="content-divider"></div>
		<? if (sizeof($commentTree[0]) != 0) { ?>
			<div class="content">
				<?= Comment::printCommentTree($commentTree,0) ?>
			</div>
		<? } ?>
</body>
</html>