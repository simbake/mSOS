<?php
class Diseases extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',11);
		$this -> hasColumn('Acronym', 'text');
		$this -> hasColumn('Full_Name', 'text');
		$this -> hasColumn('definition', 'text');
		$this -> hasColumn('sample', 'text');
	}

	public function setUp() {
		$this -> setTableName('diseases');
		$this -> hasOne('Incidence as disease_name', array('local' => 'id', 'foreign' => 'Disease_id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("Diseases")->where("acronym !='EBL'")->OrderBy("Full_Name asc");
		$categories = $query -> execute();
		return $categories;
	}
	public static function getDisease($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("Diseases")->where("id='$id'");
		$categories = $query -> execute();
		return $categories;
	}

}
