<? 
class Comment extends MyDB {
	
	public $id,$comment,$created_on,$parent;
	private $comments=array();
	//constructor
	public function __construct($row) {
		$this->id         = $row["id"];
		$this->comment    = $row["comment"];
		$this->created_on = $row["created_on"];
		$this->parent     = $row["parent"];
	}
	public function __toString() {
		//maybe implement user pictures at some point

		//MyDB::getUsernameByID($this->userID);
		return
		'<div class="comment">
			<p style="font-size:small;"><i>Creation Date:</i>: '.$this->created_on.'
			<div class="post">
				<p>'.$this->comment.'</p>
			</div>
			<p><a href="newChildComment.php?parent='.$this->id.'">Make a Reply</a>
		</div>
		<div class="content-divider"></div>';
	}

	/*recursive function*/
	public static function buildCommentTree($commentArray,$root) {
		if (!isset($commentArray[$root])) {
			return;	
		}
		foreach ($commentArray[$root] as $comment) {
			$temp = __CLASS__;
			echo '<p>'.$comment.'</p>'.
				 '<div style="margin-left:10px;">';
			echo Comment::buildCommentTree($commentArray,$comment->id);
			echo '</div>';

		}	
	}

}





?>