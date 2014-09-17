<?php
class Blog extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('title', 'varchar',255);
		$this -> hasColumn('post', 'text');
		$this -> hasColumn('user_id', 'int',15);
		$this -> hasColumn('time_p', 'datetime');
					
	}

	public function setUp() {
		$this -> setTableName('blog');
		$this -> hasMany('user as bloger', array('local' => 'user_id', 'foreign' => 'id'));
		$this -> hasOne('blog_comment as blo', array('local' => 'id', 'foreign' => 'blog_id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("blog");
		$level = $query -> execute();
		return $level;
	}
	public static function viewBlog($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("blog")->where("id='$id'");
		$level = $query -> execute();
		return $level[0];
	}
	
	

}