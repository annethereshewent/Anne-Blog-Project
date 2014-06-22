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
<script src="js/jquery-2.1.1.min.js" type="text/javascript"></script>
