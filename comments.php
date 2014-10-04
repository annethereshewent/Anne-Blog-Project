<?php
require "common.php";


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
	.comment-col {
		display:table-cell;
	}
	.comment-row {
		display:table-row;
	}
	.comment-header {
		margin-right:10px;
		font-size:small;

	}
	#comments-box {
		word-wrap:break-word;
		width:500px;
		margin-left:-20px;
	}

	</style>
	<link href="/css/default.css" rel="stylesheet" type="text/css">
</head>
<body>
<aside class="sidebar">
    <div class="sidebar-main">
        <div class="title">
            <?= $_SESSION["title"] ?>.
        </div>
		<?php if (isset($_SESSION["userpic"])) { ?>
	        <div class="img-container">
	            <img class="sidebar-image" src="<?= $_SESSION["userpic"] ?>">
	        </div>
        <?php } ?>

            <div class="description">
               <?= $_SESSION["description"] ?>
            </div>

        <nav class="links">
            <ul>
                <li><a href="/blog/<?= $_SESSION["displayname"] ?>">home</a></li>
                
                <?php if (isset($_SESSION["login"])) {  ?> 
                	<li><a href="#" onClick="openNewModal();return false;">new</a></li>
                <?php } ?>            
                
                <li><a href="/login.php">control panel</a></li>
                <li><a href="/contact.php">contact</a></li>
                
                <?php if (isset($_SESSION["login"])) { ?>
                	<li><a href="/logout.php">logout</a></li>
                <?php } ?> 
            </ul>
        </nav>
    </div>
</aside>
	<div class="main">
		<div class="content">
			<p style="font-size:small;"><i>Creation Date: <?= date("m/d/y h:i A",strtotime($post["created_on"])) ?></i></p>
			<div class="post"> 
				<p><?= $post["post"]?></p>
			</div>
			<div class="post-buttons" style="font-size:12px">
				<?php if (isset($_SESSION["login"])) { ?>
					<a href="#" onClick="$('#new-textbox-container').show()">New Comment</a>
				<?php } ?>
				&nbsp;&nbsp;
				<a href="/blog/<?= $_SESSION["displayname"] ?>">Back</a>
			</div>
		</div>
		<div class="content-divider"></div>
		<div class="content comment-container" id="new-textbox-container">
			<form name="commentsubm" id="commentsubm" method="post" action="new_comment.php">
				<textarea name="comment" class="comment-text" id="comment-new" placeholder="Enter comment here..."></textarea>
				<input type="hidden" name="pid" value="<?= $postID ?>">
				<div class="buttonarea" style="margin-top:10px;margin-left:10px">
					<button type="submit" class="comment-submit btn primary">Post</button>&nbsp;&nbsp;<button type="button" onClick="$('#new-textbox-container').hide()" class="btn cancel">Cancel</button>
				</div>
			</form>
		</div>
		<div class="content-divider"></div>
		<? if (sizeof($commentTree[0]) != 0) { ?>
			<div class="content" id="comments-box">
				<?= Comment::printCommentTree($commentTree,0) ?>
			</div>
		<? } ?>
		<script src="/js/jquery-2.1.1.min.js" type="text/javascript"></script>	
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
</body>
</html>