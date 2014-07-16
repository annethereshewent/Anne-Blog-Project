<?php
include "common.php";

if (isset($_POST)) {
	if ($conn->insert_comment(0,$_POST["pid"],$_POST["comment"])) 
		Common::redirect("comments.php?pid=".$_POST["pid"]);
}
else
	Common::redirect("main.php");

?>