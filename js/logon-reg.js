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

			$("#register").submit();
		}
		else {
			var errormsg = $("#pass2").next();
			$(errormsg).html("<i>Passwords do not match.</i>");
			$(errormsg).show();
		}
	}
}