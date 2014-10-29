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
        <div class="description"><?= isset($info["description"]) ? $info["description"] : "" ?></div>
        <nav class="links">
            <ul>
                <li><a href="/blog/<?= $info["blog"] ?>">home</a></li>                         
                <li><a href="/account.php">control panel</a></li>
                <li><a href="/contact.php">contact</a></li> 
                <?php if (isset($_SESSION["login"])) { ?>
                    <li><a href="#" onClick="openNewModal();return false;">new</a></li>
                    <li><a href="/logout.php">logout</a></li>
                <?php } ?> 
            </ul>
        </nav>
        <div class="pagination"><?= isset($info['page']) ? Common::getPageFooter($info["page"], $post_count) : '' ?></div>
    </div>
</aside>