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
		return "<p><b>************</b></p>
				<p>parent = ".$this->parent." id = ".$this->id."</p>
				<p>comment: ".$this->comment."</p>".
				"<p><b>************</b></p>";
	}
	public function addComment($comment) {
		
	}

}





?>