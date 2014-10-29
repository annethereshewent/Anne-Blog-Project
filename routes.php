<?php 
$routes = array(
	'blog' 		=> 'main.php',
	'comments'	=> 'comments.php',
	'account'	=> 'account.php'
);
$route = explode("/", $_SERVER["REQUEST_URI"]);
if (isset($route[1])) {
	$location = $route[1];
	if (isset($routes[$location])) {
		include $routes[$location];
	} 
	else
		include 'error.php'; //the page was not found
}
else
	include 'login.php';


?> 