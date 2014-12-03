<?php
class ebola_numbers extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',11);
		$this -> hasColumn('names', 'text');
		$this -> hasColumn('phone_numbers', 'text');
		$this -> hasColumn('facility_code', 'text');
		$this -> hasColumn('isActive', 'tinyint',1);
	}

	public function setUp() {
		$this -> setTableName('ebola_numbers');
		$this -> hasMany('Facility as facility_info', array('local' => 'Mfl_Code', 'facility_code' => 'Mfl_Code'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("ebola_numbers");
		$categories = $query -> execute();
		return $categories;
	}

}
