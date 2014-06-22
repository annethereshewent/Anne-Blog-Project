<? 
session_start();
$conn = new mysqli("localhost", "webaccess", "n0t-tUmblr34!", "blog") or die ("Error: ".mysqli_connect_error());


function remqt($str) {
	global $conn;
	
	$str = str_replace("\n","<br>", $str);
	return $conn->real_escape_string($str);
}
?>
