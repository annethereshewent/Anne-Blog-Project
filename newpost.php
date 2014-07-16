<?php
include "common.php";

if (!isset($_SESSION))
	jsRedirect("login.php?error=Y");
if (isset($_POST["htmlContent"])) {

	if ($conn->insert_post($_POST["htmlContent"], $_SESSION["userid"])) 
		Common::redirect("main.php?success=Y");
	else 
		Common::redirect("main.phpsuccess=N");	
}
else {
	echo "something went wrong";
	exit;
}
?>
