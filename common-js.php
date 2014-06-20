<?

function jsRedirect($url) {
	echo "<script type=\"text/javascript\">\n"
		."location.href='".$url."'</script>";
}

function jsAlert($str) {
	echo "<script type=\"text/javascript\">\n"
		."alert(".$str.")";
}

?>