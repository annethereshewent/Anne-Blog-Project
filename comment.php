<? 
class Comment {
	
	public $id,$comment,$created_on,$parent,$postID;
	private $comments=array();
	//constructor
	public function __construct($row) {
		$this->id         = $row["id"];
		$this->comment    = $row["comment"];
		$this->created_on = $row["created_on"];
		$this->parent     = $row["parent"];
		$this->postID     = $row["postID"];
	}
	public function __toString() {
		//maybe implement user pictures at some point
		$replytextboxID = "reply-textbox-".$this->id;
		$replySelector = "'#".$replytextboxID."'";
		return
		'<div class="comment">
			<p style="font-size:small;"><i>Posted on:</i> '.$this->created_on.'</p>
			<div class="post">
				<p>'.$this->comment.'</p>
			</div>
			<p style="font-size:small"><a href="#" onClick="$('.$replySelector.').show();return false;">Make a Reply</a></p>
		</div> 
		<div class="comment-container" id="'.$replytextboxID.'">
			<hr>
			<form method="post" action="comment_reply.php?parent='.$this->id.'&pid='.$this->postID.'">
				<textarea class="comment-text" name="comment" id="comment_reply" placeholder="Enter comment here..."></textarea>
				<div class="buttonarea" style="margin-top:10px;margin-left:10px">
					<button type="submit" class="comment-submit">Reply</button>&nbsp;&nbsp;&nbsp;<button type="button" onClick="$('.$replySelector.').hide();return false;">Cancel</button>
				</div>
			</form>
			<hr>
		</div>
		<div class="content-divider"></div>
		';
	}

	/*recursive function*/
	public static function printCommentTree($commentTree,$root) {
		if (!isset($commentTree[$root])) {
			return;	
		}
		foreach ($commentTree[$root] as $comment) {
			echo '<p>'.$comment.'</p>'.
				 '<div style="margin-left:15px;">';
			echo Comment::printCommentTree($commentTree,$comment->id);
			echo '</div>';

		}	
	}

}





?>