<?php
class Access_level extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('level', 'varchar',255);		
	}

	public function setUp() {
		$this -> setTableName('access_level');
	
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("access_level");
		$level = $query -> execute();
		return $level;
	}
	
	

}