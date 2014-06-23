<?
include "common.php";

if (isset($_GET["pID"]) && isset($_POST["htmlContent"])) {
	$sql = "update posts set post = '".
			$conn->remqt($_POST["htmlContent"])."',".
				"edited_on = CURRENT_TIMESTAMP,".
				"edited = 1".
				" where id= ".$conn->remqt($_GET["pID"]);

	if ($result = $conn->query($sql)) {
		Common::redirect("main.php?success=Y");
	}
	else {
		printf("Errormessage: %s\n", MyDB::error);
		exit;
	}
	
}
else {
	echo "soemthing's wrong";
	exit;
}
?>