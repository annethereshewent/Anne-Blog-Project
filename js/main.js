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
	var content = $("#editContents").editable("getHTML").toString();
	var str = "blah blah blah blah";
	//need to get youtube url and convert into an iframe object. This is for embedding youtube videos in posts
	var youtube_match = parseYoutubeURL(content);
	var youtube_id = '';
	if (youtube_match != null) {
		content = embedYoutube(youtube_match, content);
	}
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

//returns array of matches from the regex. These can be used to embed the video or whatever
function parseYoutubeURL(content) {
	var regEx = /^.*((youtu.be\/)|(v\/)|(\/u\/\w\/)|(embed\/)|(watch\?))\??v?=?([^#\&\?]*).*/;
	var match = content.match(regEx);
	//the youtube id will be in match[4]. can verify with console.log
	//console.log(match);

	return match;
}
function embedYoutube(match, content) {
	//strips html from the youtube id. the div is there because otherwise it will think the text is a selector
	var youtube_id = $("<div/>").html(match[7]).text();
	//replace youtube url with iframe object
	var youtube_vid = '<iframe src="http://www.youtube.com/v/' + youtube_id + '" width="375" height="211" frameborder="0" allowfullscreen></iframe>';
	//console.log(youtube_match);	
	//only going to work with youtube.com and youtu.be urls
	return content.replace(/http(s){0,1}:\/\/.*youtu(\.be|be\.com)\/.*/, youtube_vid);
}
function openNewModal() {
	openModal();
	$("#newPost").attr("action", "/newpost.php");
}
function openEditModal(pid) {
	//need ajax to get contents
	$.ajax({
		type: "GET",
		url: "/fetch_post.php?pID=" + pid,
		dataType: "html",
		success: function(data) {
			if (data != "false") {
				openModal();
				initEditor();
				$("#editContents").editable("focus");
				$("#editContents").editable("setHTML",data);
				$("#newPost").attr("action", "/edit.php?pID=" + pid);
				$("#blogSubmit").text("Edit");

				$("#postModal").next().html("Edit Post");
			} 
		}
	});
}
function deletePost(pID) {
	var r = confirm("Are you sure you want to delete this post?");
	if (r) {
		$.ajax({
			url: "/deletePost.php",			
			type: "post",
			data: { pID: pID },
			success: function(data) {
				//console.log(data);
				if (data == "success") {
					$("#post_" + pID).fadeOut(500).slideUp(500);
				}
				else {

					alert("an error has occurred");
				}
			}
		});
	}
}

