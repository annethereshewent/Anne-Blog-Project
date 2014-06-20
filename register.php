<?php
include "common-js.php";
include "common-mysql.php";




?>
<html>
<head>
	<link href="default.css" rel="stylesheet" type="text/css">
	<script>
	
	
	</script>
	<style>
	.table{
	  display:table;         
	  width:auto;            
	  border:none;         
	 //border-spacing:5px;/*cellspacing:poor IE support for  this*/
	}
	.table-row{
	  display:table-row;
	  width:auto;
	  clear:both;
	}
	.table-col{
	  float:left;/*fix for  buggy browsers*/
	  display:table-column;         
	  width:200px;          
	}
	.control-input {
		
	}
	</style>
</head>
<body>
	<h2>Register a New Account</h2>
	<p>Please enter all relative details. Thanks! 
	<div class="content table">
		<div class="table-row">
			<div class="table-col">
				<label>First Name: </label><input class="ctrl-input" type="text" name="fname">
			</div>
			<div class="table-col">
				<label>Last Name: </label><input class="ctrl-input" type="text" name="lname">
			</div>
		</div>
	</div>
</body>
</html>