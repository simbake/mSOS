<?php
class Blog_Comment extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('blog_id', 'int',15);
		$this -> hasColumn('comment', 'text');	
		$this -> hasColumn('date_b', 'datetime');		
	}

	public function setUp() {
		$this -> setTableName('blog_comment');
		$this -> hasMany('blog as blo', array('local' => 'blog_id', 'foreign' => 'id'));
	}

	public static function getAll($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("blog_comment")->where("blog_id='$id'");
		$level = $query -> execute();
		return $level;
	}
	
	

}