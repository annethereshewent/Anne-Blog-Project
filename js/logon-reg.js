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
	var check = true;
	if ($("#email").val() == "") {
		$("#email").next().show();
		check = false;
	}
	if ($("#pass1").val().length < 8) {
		$("#pass1").next().show();
		check = false;
	}
	if ($("#pass2").val() < 8) {
		$("#pass2").next().show();
		check  = false;
	}
	if (check) {
		if ($("#pass1").val() == $("#pass2").val()) {
			//call ajax to see if email exists
			if (usernameExists($("#email").val())) {
				var user_warning = $("#email").next();
				$(user_warning).html("<i>e-mail is already in use.</i>");
				$(user_warning).show();
				return false;
			}
			$("#register").submit();
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
	return true;
	$.ajax({
		type: "GET",
		url: "check_username.php?user=" + username,
		dataType: "html",
		success: function(data) {
			alert ("we made it all the way here! data = " + data);
			return true;
			if (data == "true")
				return true;
			return false;
		}
	});

}