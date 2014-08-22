<?php
include "common.php";

$password = isset($_GET["password"]) ? $_GET["password"] : "";
echo $conn->verify($password);

?>