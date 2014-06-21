	function openModal() {
		$("#postModal").fadeIn(500).modal({
			opacity:60, 
			overlayClose:true,
			position: ["25%", "25%"]
		});
	}
	function openNewModal() {
		openModal();
		$("#newPost").attr("action", "newPost.php");
	}
	function openEditModal(pid) {
		openModal();
		//need ajax to get contents
		$.ajax({
			type: "GET",
			url: "fetch_post.php?pID=" + pid,
			dataType: "html",
			success: function(data) {
				if (data == "ERROR")
					return false;
				$("#editContents").val(data);
				return true;
			}
		});
		$("#newPost").attr("action", "edit.php?pID=" + pid);
		$("#blogSubmit").text("Edit"); 
		
	}