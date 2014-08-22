<?php
require "common.php";

if (isset($_GET["user"])) {
	$display = isset($_GET["display"]) ? $_GET["display"] : "";

	echo $conn->check_register(
		array(
			"user"    => $_GET["user"],
			"display" => $display
		));
}
?>


