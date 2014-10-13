<?php
require "common.php";



$row = null;
$messages = "";
$result = null;
$num_rows = 0;

//get posts
//$pageNumber = Common::getPageNum();
$info = $conn->get_page_info();



if (isset($_GET["user"])) 
	$result = $conn->fetch_user_posts_by_page($info["page"]);
else 
	Common::redirect("/error.php");



//gets the number of posts starting from the specified page. Used to determine pagination
$post_count = $conn->get_number_of_posts($info["page"]);



?>

<head>
	
	<title><?= $info["blog_title"] ?></title>
	<link href="/css/default.css" rel="stylesheet" type="text/css">
	<link href="/css/font-awesome.min.css" rel="stylesheet">
	<link href="/css/froala_editor.min.css" rel="stylesheet" type="text/css">
	

	
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
<aside class="sidebar">
    <div class="sidebar-main">
        <div class="title">
            <?= isset($info["blog_title"]) ? $info["blog_title"] : "" ?>
        </div>
        <?php if (isset($info["profile_pic"])) { ?>
	        <div class="img-container">
	            <img class="sidebar-image" src="<?= $info["profile_pic"] ?>">
	        </div>
        <?php } ?>
        <div class="description">
           <?= isset($info["description"]) ? $info["description"] : "" ?>
        </div>
        <nav class="links">
            <ul>
                <li><a href="/blog/<?= $info["blog"] ?>">home</a></li>
                
                <?php if (isset($_SESSION["login"])) {  ?> 
                	<li><a href="#" onClick="openNewModal();return false;">new</a></li>
                <?php } ?>            
                
                <li><a href="/account.php">control panel</a></li>
                <li><a href="/contact.php">contact</a></li>
                
                <?php if (isset($_SESSION["login"])) { ?>
                	<li><a href="/logout.php">logout</a></li>
                <?php } ?> 
            </ul>
        </nav>

            <div class="pagination">
            	<?= Common::getPageFooter($info["page"], $post_count) ?>
            </div>
    </div>
</aside>
	<div class="main">
		<?php if ($result != null) {
			if (!$post_count) { ?>
				<div class="content" style="color:grey">
					<i><h3>Your blog is empty. :(</h3>
					<p>give your blog some loving and create your first post!</p></i>				
				</div>
			<?php } 
			else {
				while ($row = $result->fetch()) { ?>
					<div class="content" id="post_<?= $row["id"] ?>">
						<p style="font-size:small;"><i>Creation Date: <?= date("m/d/y h:i A",strtotime($row["created_on"])) ?></i></p>
						<div class="post"> 
							<p><?= $row["post"]?></p>
						</div>
						<?php if ($row["edited"] == 1) { ?>
							<p style="font-size:small;"><i>(Edited on: <?= $row["edited_on"] ?>)</i></p>
						<?php }?>
						<div class="post-buttons" style="font-size:12px">
							<a href="/comments.php?pid=<?= $row["id"] ?>"><?= Common::getCommentText($row["num_comments"]) ?></a>
							&nbsp;&nbsp;
							<?php if (isset($_SESSION["login"])) { ?>
								<a href="#" onClick="openEditModal(<?= $row["id"] ?>)">Edit Post</a>
								<a class="delete" href="#" onclick="deletePost(<?= $row["id"] ?>);return false"><li class="fa fa-trash"></li></a>
							<?php } ?>
						</div>
					</div>
					<div class="content-divider"></div>
	<?php
				}
			}
		}

	?>
	</div>

	<!-- jQuery, misc js -->
	<script src="/js/jquery-2.1.1.min.js" type="text/javascript"></script>
	<script src="/js/jquery.simplemodal-1.4.4.js" type="text/javascript"></script>
	<script src="/js/froala_editor.min.js"></script>
	
	<script src="/js/main.js" type="text/javascript"></script>
</body>

<div class="content" id="postModal" style="display:none">
	<p style="color:#7A7ACC;margin-left:10px">Create a New Post</p>
	<form name="newPost" id="newPost" method="post">
			<div name="blogpost" id="editContents"></div>
			<div  style="margin-left:15px;"class="buttonarea">
		 	   <button type="button" onClick="submitContents()" id="blogSubmit" class="btn confirm sm" style="margin-right:20px">Post</button><button type="button" class="simplemodal-close btn cancel sm">Cancel</button>
			</div>
			<input type="hidden" name="htmlContent" id="htmlContent">
	</form>
</div>