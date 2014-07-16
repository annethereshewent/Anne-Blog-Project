<?php
include "common.php";

if (isset($_GET["pID"]) && isset($_POST["htmlContent"])) {
	if ($conn->edit_post($_POST["htmlContent"], $_GET["pID"]))
		Common::redirect("main.php?success=Y");
	else 
		Common::redirect("main.php?success=N");	
}
else {
	echo "soemthing's wrong";
	exit;
}
?>