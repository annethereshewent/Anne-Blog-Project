<? 
session_start();

include "common-js.php";
$msg = "";

if (!empty($_GET)) {
	if (isset($_GET["error"])) 	
		$msg = "<p class=\"error\">Imposter detected! Red alert! weeooowweeeeowoeeooo</p>";
} 
if (isset($_SESSION["username"])) { 
	jsRedirect("main.php");
	
}
?>

<head>
	<title>The best blog in the whole wide world!</title>
	<link href="default.css" rel="stylesheet" type="text/css">
	<style>
	ul {
		list-style-type: none;
		font-family: Calibri;
	}
	h2 {
		font-size:20px;
		font-family:Calibri;
		background-color:blue;
		color:white;
		border-top: 1px solid #000000;
	}
	.error {
		color:red;
	}
	p {
		font-family:Calibri;
	}
	.logonpanel {
		width:30%;
		background: #F2F2FA;
		border-left: 1px solid #000000;
		border-right: 1px solid #000000;
		border-bottom: 1px solid #000000;
		margin: 25% 25% 25% 25%;
	}
	#validateErrors {
		color:red;
	}
	table {
		border: none;
		margin-left:20px;
	}

	</style>
	
</head>
<body>
<div class="logonpanel">
	<h2 style="padding-left:10px">Welcome!</h2>
	<form name="login" id="login" method="post" action="checkLogIn.php">
		<table>
			<tr>
				<td><label>Please Enter a Username:</label></td>
				<td><input type="text" name="username" id="username"></td>
			</tr>
			<tr>
				<td class="formElement"><label>Please Enter a Password:</label></td>
				<td><input type="password" name="pass" id="pass"></td>
			</tr>
			<tr>
				<td><button type="submit" value="Ok">Submit</button>&nbsp;&nbsp;<a style="font-size: 10px" href="register.php">New Member?</a></td>
	
			</tr>
		</table>
		<div id="validate Errors"><?= $msg ?></div>
	</form>
</div>
</body>

	





