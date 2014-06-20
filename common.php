<? 
session_start();
$conn = new mysqli("localhost", "root", "root", "blog") or die ("Error: ".mysqli_connect_error());

function jsRedirect($url) {
	echo "<script type=\"text/javascript\">\n"
		."location.href='".$url."'</script>";
}

function remqt($str) {
	global $conn;
	
	$str = str_replace("\n","<br>", $str);
	return $conn->real_escape_string($str);
}
?>
<script src="jquery-2.1.1.min.js" type="text/javascript"></script>