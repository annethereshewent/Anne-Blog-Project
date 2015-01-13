<?php 
class Post extends MyDB {
	public $id, $post, $userID, $created_on, $edited_on, $edited, $num_comments;
	public function __construct($row) {
		$this->id           = $row["id"];
		$this->post         = $row["post"];
		$this->userID       = $row["userID"];
		$this->created_on   = $row["created_on"];
		$this->edited_on    = $row["edited_on"];
		$this->num_comments = $row["num_comments"];
	}
	public function __toString() {
		$returnStr = '<div class="content" id="post_'.$this->id.'">
						<p style="font-size:small;"><i>Creation Date: '.date("m/d/y h:i A",strtotime($this->created_on)).'</i></p>
						<div class="post"> 
							<p>'.$this->post.'</p>
						</div>
						<div class="post-buttons" style="font-size:12px">
							<a href="/comments/'.$_SESSION['displayname'].'/'.$this->id .'">'.Common::getCommentText($this->num_comments).'</a>
							&nbsp;&nbsp;
							<a href="#" onClick="openEditModal('.$this->id.')">Edit Post</a>
				  			<a href="#" onClick="openQuoteModal('.$this->id .','.'\''.$_SESSION['displayname'].'\')" style="margin-left:5px">Quote</a>
					    	<a class="delete" href="#" onclick="deletePost('.$this->id.');return false"><li class="fa fa-trash"></li></a>
				     	</div>
				     </div>
				     <div class="content-divider"></div>';
							
    	return $returnStr;
	}

}