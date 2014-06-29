<?php
include "common.php";

if (isset($_POST)) {

	if ($conn->insert_comment($_GET["parent"],$_GET["pid"],$_POST["comment"])) {
		Common::Redirect("comments.php?pid=".$_GET["pid"]);
	}
	else {
		echo "<b>An error has occurred:</b>";
		exit;
	}
}


?>