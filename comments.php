<?
require_once "comment.php";
include "common.php";

?>
<html>
<head>
<link href="css/default.css" rel="stylesheet" type="text/css">	
	
	
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
	<div class="main">
		<div class="tab-container">
			<span class="tab"><a class="tlink" href="main.php">Posts</a></span>
			<span class="tab"><a class="tlink" href="#" onClick="openNewModal()">New</a></span>
			<span class="tab">Profile</span>
			<span class="tab"><a class="tlink" href="logout.php">Log Out</a></span>
		</div>
		<div class="content">
			<?= (isset($_GET["pid"]) ? fetch_post($_GET["pid"]) : "") ?>
		</div>
</body>
</html>