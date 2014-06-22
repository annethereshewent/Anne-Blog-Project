<?
include "common-mysql.php";
include "common-js.php";

if (isset($_GET["pID"]) && isset($_POST["htmlContent"])) {
	$sql = "update posts set post = '".
			remqt($_POST["htmlContent"])."',".
				"edited_on = CURRENT_TIMESTAMP,".
				"edited = 1".
				" where id= ".remqt($_GET["pID"]);

	if ($result = $conn->query($sql)) {
		jsRedirect("main.php?success=Y");
	}
	else {
		printf("Errormessage: %s\n", $conn->error);
		exit;
	}
	
}
else {
	echo "soemthing's wrong";
	exit;
}
?>