$(function(){
	initEditor();
	$("#newPost").submit(function(e) {
		var postData = $(this).serialize();
		var postContent = $("#htmlContent").val();		

		e.preventDefault();
		$(e).unbind();
		
		$("#loading-post").show();
		$("#blogSubmit").prop('disabled', true);

		$.post(
			"/newpost.php",
			postData,
			function(data) {
				//console.log("hello?");
				if (data) {
					//console.log("great success");
					$("#postModal").dialog("close");
					$(".main").prepend(data).fadeIn(1000);
					$("#blogSubmit").prop('disabled', false);
					$("#loading-post").hide();
				}
			} 
		)
	}); 

	$("#post-cancel-btn").click(function() {
		$("#postModal").dialog("close");
	});
});

function initEditor() {
	$('#editContents').editable({
		inlineMode: false,
		paragraphy: true,
		placeholder:"",
		width: "350px",
		height: "250px",
		buttons: ["indent", "outdent", "strikeThrough", "bold", "italic", "underline", "insertUnorderedList", "insertOrderedList"],
		inverseSkin: true,
	});
}

function submitContents() {
	var content = $("#editContents").editable("getHTML").toString();

	if (isEmpty(content)) {
		alert("Your post is empty!");
		return false;
	}

	//need to get youtube url and convert into an iframe object. This is for embedding youtube videos in posts
	var youtube_match = parseYoutubeURL(content);
	if (youtube_match != null) {
		content = embedYoutube(youtube_match, content);
	}
	$("#htmlContent").val(content);
	$("#newPost").submit();
}

//checks whether content is empty, after stripping HTML tags
function isEmpty(content) {
	//cheap hack to get text content (without html tags)
	var sanitized_content = $("<div>").html(content).text();
	//console.log("sanitized content = '" + sanitized_content + "'");
	if (sanitized_content == '')
		return true;
	return false;
}	
function openModal() {
	/*$("#postModal").fadeIn(500).modal({
		opacity:70, 
		overlayClose:true,
		position: ["25%", "25%"]
	});*/

	$("#postModal").fadeIn(500).dialog({
		autoOpen:true,
		closeOnEscape:true,
		modal:true,
		resizable:false,
		width:410,
		height:480,
		position: {at:"top"},
		close: function() {
			$("#editContents").editable("setHTML", "");
		}
	});
}

function openQuoteModal(pid, username) {
	getPostContents(pid, function(data) {
		//alert($("<div>").html(data).find("<iframe>"));
		data = "<div class='block-quote-outer'><a href='/blog/" + username + "'>" + username + "</a><div class='block-quote'>" + data + "</div></div>";

		openModal();
		initEditor();
		$("#editContents").editable("focus");
		$("#editContents").editable("insertHTML",data, true);
		$("#blog-textarea").html(data);
		$("#newPost").attr("action", "/newpost.php");
	});
	
}

function getPostContents(pid, callback) {
	$.ajax({
		type: "GET",
		url: "/fetch_post.php?pID=" + pid,
		dataType: "json",
		success: function(data) {
			if (data.status != false) {
				callback(data.content);
			} 
		}
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

	//only going to work with youtube.com and youtu.be urls for now
	return content.replace(/http(s){0,1}:\/\/.*youtu(\.be|be\.com)\/.*/, youtube_vid);
}
function openNewModal() {
	openModal();
	$("#newPost").attr("action", "/newpost.php");
}
function openEditModal(pid) {
	//need ajax to get contents
	getPostContents(pid, function(data) {
		openModal();
		initEditor();
		$("#editContents").editable("focus");
		$("#editContents").editable("setHTML",data);
		$("#newPost").attr("action", "/edit.php?pID=" + pid);
		$("#blogSubmit").text("Edit");

		$("#postModal").next().html("Edit Post");
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
					$("#post_" + pID).fadeOut(1000).slideUp(1000, function() {
						//this is setting the deleted post's content divider height to 0. otherwise it looks bad
						$("#post_"+ pID).next().css("height", "0px");
					});
				}
				else {
					alert("an error has occurred");
				}
			}
		});
	}
}

