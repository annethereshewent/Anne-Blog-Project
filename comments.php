<?
include "common.php";
require_once "comment.php";

if (!empty($_GET)) {
	$sql = "select id,comment,created_on from comments where postID = '".remqt($_GET["pID"])."' order by parent, id";
	$result = $conn->query($sql);
	while ($row = $conn->fetch_array($result) {
		
	}
}	
	

	
?>
<html>
<head>
	
	
	
</head>
<body>
	
	
	
	
</body>
</html>