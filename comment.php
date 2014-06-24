<? 

class Comment {
	
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
		return
		'<div class="content comment-container">
		<p style="font-size:small;"><i>Creation Date:</i>: '.$this->created_on.
		'<div class="post"><p>'.
		$this->comment.'</p<</div>
		</div>';
	}
	public function addComment($comment) {
		
	}
		/*recursive function*/
	public static function buildCommentTree($commentArray,$root) {
		if (!isset($commentArray[$root])) {
			return;	
		}
		foreach ($commentArray[$root] as $comment) {
			$temp = __CLASS__;
			echo '<p>'.$comment->comment.'</p>'.
				 '<div style="margin-left:10px;">';
			echo Comment::buildCommentTree($commentArray,$comment->id);
			echo '</div>';
		}	
	}

}





?>