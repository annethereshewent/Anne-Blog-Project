<?php 
$routes = array(
	'blog' 		=> 'main.php',
	'comments'	=> 'comments.php',
	'account'	=> 'account.php'
);
$url = explode("/", $_SERVER["REQUEST_URI"]);
if (isset($url[1])) {
	$location = $url[1];
	if (isset($routes[$location])) {
		include $routes[$location];
	} 
	else
		include 'error.php'; //the page was not found
}
else
	include 'login.php';


?> 