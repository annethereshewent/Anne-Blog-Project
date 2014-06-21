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
		width:20%;
		background: #F2F2FA;
		border-left: 1px solid #000000;
		border-right: 1px solid #000000;
		border-bottom: 1px solid #000000;
		margin: 10% 25% 25% 25%;
	}
	#validateErrors {
		color:red;
	}
	.inputs {
		margin-left:60px;
	}
	</style>
	
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
<div class="logonpanel">
	<h2 style="padding-left:10px">Welcome!</h2>
	<form name="login" id="login" method="post" action="checkLogIn.php">
		<!-- <table>
			<tr>
				<td><label>E-mail:</label></td>
				<td><input type="text" class="control-text" name="username" id="username"></td>
			</tr>
			<tr>
				<td><label>Password:</label></td>
				<td><input type="password" class="control-text" name="pass" id="pass"></td>
			</tr>
			<tr>
				<td><button type="submit" value="Ok">Submit</button>&nbsp;&nbsp;<a style="font-size: 10px" href="register.php">New Member?</a></td>
	
			</tr>
		</table> -->
		<div class="inputs">
			<label class="control-label">E-mail:</label>
			<input type="text" name="username" class="control-text">
		</div>
		<div class="inputs">
			<label class="control-label">Password:</label>
			<input type="password" name="pass" class="control-text">
		</div>
		<div class="inputs">
			<button type="submit">Submit</button>&nbsp;&nbsp;<a style="font-size: 10px" href="register.php" >New Member?</a>
		</div>
		<div id="validate Errors"><?= $msg ?></div>
	</form>
</div>
</body>

	





