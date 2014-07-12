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
	if (check) {
		if ($("#pass1").val() == $("#pass2").val()) {
			//call ajax to see if email exists. this will submit form if it does
			usernameExists($("#email").val());
		}
		else {
			var errormsg = $("#pass2").next();
			$(errormsg).html("<i>Passwords do not match.</i>");
			$(errormsg).show();
		}
	}
}

function usernameExists(username) {
	//need ajax to get contents
	var temp = "";
	$.ajax({
		type: "GET",
		url: "check_username.php?user=" + username,
		success: function(data) {
			if (data == 1) {
				var user_warning = $("#email").next();
				$(user_warning).html("<i>e-mail is already in use.</i>");
				$(user_warning).show();
				$("#pass-alert").html("<a href=\"forgotpassword.php\"><i>Forgot Password?</i></a>")
				$("#pass-alert").fadeIn(300).show();
				return false;
			}
			$("#register").submit();
		}
	});
}