<?php
include "common.php";

if (isset($_POST["htmlContent"])) {
	$conn->insert_post($_POST["htmlContent"], $_SESSION["userid"]); 
}
else 
	echo "false"


?>
