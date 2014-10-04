<?php
include "common.php";

if (!isset($_SESSION))
	Common::redirect("login.php?error=Y");
if (isset($_POST["htmlContent"])) {

	if ($conn->insert_post($_POST["htmlContent"], $_SESSION["userid"])) 
		Common::redirect("/blog/".$_SESSION["displayname"]);
	else 
		Common::redirect("/blog/".$_SESSION["displayname"]);	
}
else {
	echo "something went wrong";
	Common::redirect("/blog/".$_SESSION["displayname"]."?error");
}
?>
