<?php
include "common.php";

if (isset($_GET["pID"]) && isset($_POST["htmlContent"])) {
	if ($conn->edit_post($_POST["htmlContent"], $_GET["pID"]))
		Common::redirect("/blog/".$_SESSION["displayname"]);
	else 
		Common::redirect("/blog/".$_SESSION["displayname"]);	
}
else {
	echo "soemthing's wrong";
	exit;
}
?>