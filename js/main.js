$(function(){
	initEditor();
});
function initEditor() {
	$('#editContents').editable({
		inlineMode: false,
		paragraphy: true,
		width: "350px",
		height: "250px",
		buttons: ["indent", "outdent", "strikeThrough", "bold", "italic", "underline", "insertUnorderedList", "insertOrderedList"],
		inverseSkin: true,
	});
}
function submitContents() {
	var content = $("#editContents").editable("getHTML");
	$("#htmlContent").val(content);
	$("#newPost").submit();
}
function openModal() {
	$("#postModal").fadeIn(500).modal({
		opacity:70, 
		overlayClose:true,
		position: ["25%", "25%"]
	});
}
function openNewModal() {
	openModal();
	$("#newPost").attr("action", "newpost.php");
}
function openEditModal(pid) {
	//need ajax to get contents
	$.ajax({
		type: "GET",
		url: "fetch_post.php?pID=" + pid,
		dataType: "html",
		success: function(data) {
			if (data == "false")
				return false;
			openModal();
			initEditor();
			$("#editContents").editable("focus");
			$("#editContents").editable("setHTML",data);
			$("#newPost").attr("action", "edit.php?pID=" + pid);
			$("#blogSubmit").text("Edit"); 
		}
	});
}

