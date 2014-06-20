<?php

require "config.php";

echo "This isn't working";
echo "Wtf you piece of shit";

try {
	echo "Attempting to connect...";
	$conn = new PDO("mysql:host=localhost;dbname=test", $config["DB_USERNAME"], $config["DB_PASSWORD"]);
	//$conn->setAttribute(PDO:ATTR_ERRMODE, PDO:ERRMODE_EXCEPTION);
	echo "Connection successful";
	
}
catch(Exception $e) {
	echo "Unable to connect: ".$e->getMessage();
}
?>