<?php
include "common.php";

if (isset($_GET)) {

	if ($conn->insert_comment($_GET["parent"],$_GET["pid"])) {
		Common::Redirect("comments.php?pid=".$_GET["pid"]);
	}
	else {
		echo "<b>An error has occurred:</b>";
		exit;
	}
}


?>