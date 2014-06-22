<? 
session_start();
$conn = new mysqli("localhost", "webaccess", "n0t-tUmblr34!", "blog") or die ("Error: ".mysqli_connect_error());



function remqt($str) {
	global $conn;
	
	$str = str_replace("\n","<br>", $str);
	return $conn->real_escape_string($str);
}

function fetch_post($pID) {
	global $conn;

	if ($pID == "")
		return false;
	$sql = "select post from posts where id=".$pID;
	$result = $conn->query($sql);
	if ($result->num_rows > 0) {
		$row = $result->fetch_array();
		return $row["post"];
	}
	$result->close();
	$result = null;
}
?>
