<?php
require "common.php";

if (isset($_GET["user"])) {
	echo $conn->check_username($_GET["user"]);
}
?>


