<?php
class rrt_diseases extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',11);
		$this -> hasColumn('disease_name', 'text');
		$this -> hasColumn('disease_acronym', 'text');
	}

	public function setUp() {
		$this -> setTableName('rrt_diseases');
		$this -> hasOne('incidence_ebola as disease_name', array('local' => 'id', 'foreign' => 'Disease_id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("rrt_diseases")->OrderBy("disease_name asc");
		$categories = $query -> execute();
		return $categories;
	}
	public static function getDisease($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("rrt_diseases")->where("id='$id'");
		$categories = $query -> execute();
		return $categories;
	}
	
	public function get_ebola(){
		$query = Doctrine_Query::create() -> select("*") -> from("rrt_diseases")->where("disease_acronym ='EBL'")->OrderBy("disease_name asc");
		$categories = $query -> execute();
		return $categories;
	}

}
