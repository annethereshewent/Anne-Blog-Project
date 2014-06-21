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
	<script src="js/logon-reg.js" type="text/javascript"></script>
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
		color:red;;
		display:none;
		font-size:10px;
	}
	p {
		font-family:Calibri;
	}
	.panel {
		width:250px;
		background: #F2F2FA;
		border-left: 1px solid #000000;
		border-right: 1px solid #000000;
		border-bottom: 1px solid #000000;
		margin: 10% 25% 25% 25%;
		font-family: Calibri;
		font-size: 12px;
	}
	#validate {
		font-weight:bold;
		margin-top: 250px;
		text-align:center;
		color: #B20000;
	}
	.inputs {
		margin-left:60px;
	}
	h3 {
		padding: 0;
		margin:0;
		color:#7A7ACC;
		text-align:center;
	}
	#registerpanel {
		margin: 10% 25% 25% 25%;
		font-size: 12px;
	}
	</style>
	
</head>
<body>
	<h1 class="logo">not tumblr.</h1>
<div class="panel" id="logonpanel">
	<h2 style="padding-left:10px">Welcome!</h2>
	<form name="login" id="login" method="post" action="checkLogIn.php">
		<div class="inputs">
			<label class="control-label">E-mail:</label>
			<input type="text" name="username" class="control-text">
		</div>
		<div class="inputs" style="margin-bottom:10px">
			<label class="control-label">Password:</label>
			<input type="password" name="pass" class="control-text">
		</div>
		<div class="inputs">
			<button type="submit">Log In</button>&nbsp;&nbsp;<a style="font-size: 10px" href="#" onClick="displayRegPanel()" >New Member?</a>
		</div>

	</form>
</div>
<div id="validate"><?= $msg ?></div>
<div class="content" id="registerpanel" style="display:none;clear:both;width:20%">
	<p><i>Please fill in the required fields.</i></p>
	<div>
		<form name="register" id="register" method="post" action="register.php">
			<div class="inputs">
				<label class="control-label">Please Enter E-mail:</label>
				<input type="text" name="email" class="control-text" id="email"><span class="error"><i>(Required)</i></span>
			</div>
			<div class="inputs" style="padding-bottom:10px">
				<label class="control-label"><i>(This will be used as your log in.)</i></label>
			</div>
			<div class="inputs">
				<label class="control-label">Please Enter Password:</label>
				<input class="control-text" type="password" name="pass1" id="pass1"><span class="error"><i>(Required, must be at least 8 characters)</i></span>
			</div>
			<div class="inputs" style="margin-bottom:20px">
				<label class="control-label">Please Re-enter Password:</label>
				<input class="control-text" type="password" name="pass2" id="pass2"><span class="error"><i>(Required, must be at least 8 characters)</i></span>
			</div>
			<div class="inputs">
				<button type="button" onClick="validate()">Register</button>
				<button type="button" onClick="displayLogonPanel()">Back</button>
			</div>
		</form>
	</div>
</div>
</body>

	





