<?php 
include "common.php";
$msg = "";
$conn->fetchUserInfo();
$title = isset($_SESSION["title"]) ? $_SESSION["title"] : "";


if (!empty($_GET)) {
	if (isset($_GET["error"])) 	
		$msg = "Incorrect username or password";
} 
if (isset($_SESSION["login"])) 
	Common::redirect("account.php");

?>

<head>
	<title><?= $title ?></title>
	<link href="css/default.css" rel="stylesheet" type="text/css">
	<script src="js/logon-reg.js" type="text/javascript"></script>
	<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
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
	p {
		font-family:Calibri;
	}
	#logonpanel {
		width:300px;
		//height:157px;
		background: #F2F2FA;
		border-left: 1px solid #000000;
		border-right: 1px solid #000000;
		border-bottom: 1px solid #000000;
		margin: 200px 0px 0px 350px;
		font-family: Calibri;
		font-size: 16px;
	}
	#validate {
		font-weight:bold;
		margin-top: 250px;
		text-align:center;
		color: #B20000;
	}
	.inputs {
		margin-left:80px;
	}
	h3 {
		padding: 0;
		margin:0;
		color:#7A7ACC;
		text-align:center;
	}
	#registerpanel {
		margin: 200px 0px 0px 350px;
		font-size: 12px;
		display:none;
		width:300px;
	}
	#pass-alert {
		display:none;
		font-size:10px;
		text-align:center;
	}

	</style>
	
</head>
<body>
<h1 class="logo"><span class="logo-bracket">[</span><?= $title ?><span class="logo-bracket">].</span></h1>
<p style="text-align:center;color:red"><?= $msg ?>
<div id="logonpanel">
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
			<button type="submit">Log In</button>&nbsp;&nbsp;<a style="font-size: 12px" href="#" onClick="displayRegPanel()" >New Member?</a>
		</div>
	</form>
</div>
<a style="margin-left:370px;" href="main.php">Back</a>
<div id="validate"><?= $msg ?></div>
<div class="content" id="registerpanel">
	<p style="color:#5200A3"><i>Please fill in the required fields.</i></p>
	<div>
		<form name="register" id="register" method="post" action="check$msg">
			<div class="inputs row">
				<label class="control-label"><i>
				<div class="col">
					<input type="text" name="btitle" id="btitle" class="control-text lg" placeholder="Blog Title (Optional)"><span class="error"></span>
				</div>
				<div class="col" style="margin-left:20px">
					<input type="text" placeholder="Display Name (Optional)" name="displayname" class="control-text lg" id="displayname"><span class="error"></span>
				</div>
			</div>
			<div style="margin-bottom:20px"></div>	
			<div class="inputs">			
					<input type="text" placeholder="E-mail" name="email" class="control-text" id="email"><span class="error"><i>(Required)</i></span>
					<label class="control-label"><i>(This will be used as your log-in.)</i></label>
			</div>

			<div style="margin-bottom:20px"></div>

			<div class="inputs row">
				<div class="col">
					<input class="control-text lg" type="password" placeholder="Password" name="pass1" id="pass1">
				</div>
				<div class="col">
					<input class="control-text lg" placeholder="Re-enter Password" type="password" name="pass2" id="pass2"><span class="error"><i>(Required, must be at least 8 characters)</i></span>
				</div>
			</div>
			<div style="margin-bottom:20px"></div>
			<div class="inputs">
				<button type="button" onClick="validate()">Register</button>
				<button type="button" onClick="displayLogonPanel()">Back</button>
			</div>
			<div class="inputs">
				<img src="images/loading.gif" style="display:none" id="loading-reg">
			</div>
			<p id="pass-alert"></p>
		</form>
	</div>
</div>
</body>

	





