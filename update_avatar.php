<?php 
include "common.php";

$allowedExts = array("image/gif", "image/jpeg", "image/jpg", "image/png", "image/x-png", "image/pjpeg");
$temp = explode(".", $_FILES["upload-pic"]["name"]);
$ext = end($temp);
$temp = null;
echo $_FILES["upload-pic"]["type"]."<br>";
echo $_FILES["upload-pic"]["size"]."<br>";
if ($_FILES["upload-pic"]["error"] > 0) 
	echo "An error has occurred: ".$_FILES["upload-pic"]["error"]."<br>";
	//Common::redirect("account.php?error");
if (in_array($_FILES["upload-pic"]["type"], $allowedExts) && $_FILES["upload-pic"]["size"] < (20*1024*1024)) {
	
	$directory = "/user_pics/";
	$filename = uniqid("userpic-",true).".".$ext;

	move_uploaded_file($_FILES["upload-pic"]["tmp_name"], $directory.$filename);
	$conn->update_profile_pic($directory.$filename);

	echo "File uploaded successfully!";
	//Common::redirect("account.php?success");
}
else {
	echo "An error has occurred. Please contact your administrator";
	//Common::redirect("account.php?error");
}



?>