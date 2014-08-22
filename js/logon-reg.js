function displayRegPanel() {
	$("#logonpanel").hide();
	
	$(".error").each(function() {
		$(this).hide();
	});

	$("#registerpanel").fadeIn(500).show();
}
function displayLogonPanel() {
	$("#registerpanel").hide();
	$("#logonpanel").fadeIn(500).show();
}
function validate() {
	$(".error").each(function() {
		$(this).hide();
	});
	$("pass-alert").hide();
	var check = true;
	if ($("#email").val() == "") {
		$("#email").next().show();
		check = false;
	}
	if ($("#pass1").val().length < 8) {
		$("#pass2").next().show();
		check = false;
	}
	//only letters, dashes and underscores allowed
	var dispnameRE = /^[A-Za-z_\-]+$/;

	if ($("#displayname").val() != "" && 	!dispnameRE.test($("#displayname").val())) {
		var dispErr = $("#displayname").next();
		$(dispErr).html("<i>only letters, underscores, and dashes allowed</i>");
		$(dispErr).show();
		check = false;
	}
	if (check) {
		if ($("#pass1").val() == $("#pass2").val()) {
			//call ajax to see if email exists. this will submit form if it does
			$("#loading-reg").show();
			checkFieldsAjax($("#email").val(), $("#displayname").val());
		}
		else {
			var errormsg = $("#pass2").next();
			$(errormsg).html("<i>Passwords do not match.</i>");
			$(errormsg).show();
		}
	}
}

function checkFieldsAjax(username, displayname) {
	//need ajax to get contents
	var temp = "";
	var check = true;
	$.ajax({
		type: "GET",
		url: "check_fields.php",
		data: {
			user: username, 
			display: displayname
		},
		success: function(data) {
			$("#loading-reg").hide();
			if (data != "") {
				var params = data.split(" ");
				for (var i = 0; i < params.length; i++) {
					if (params[i].trim() == "user") {
						var user_warning = $("#email").next();
						$(user_warning).html("<i>e-mail is already in use.</i>");
						$(user_warning).show();
						$("#pass-alert").html("<a href=\"forgotpassword.php\"><i>Forgot Password?</i></a>")
						$("#pass-alert").fadeIn(300).show();
						check = false;
					}
					else if (params[i].trim() == "display") {
						var disp_warn = $("#displayname").next();
						$(disp_warn).html("<i>username is already in use.</i>");
						$(disp_warn).show();
						check = false;
					}
				}
			}
			if (check)
				$("#register").submit();
		}
	});
}