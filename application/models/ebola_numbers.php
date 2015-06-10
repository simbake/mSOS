<?php
class ebola_numbers extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',11);
		$this -> hasColumn('Acronym', 'text');
		$this -> hasColumn('Full_Name', 'text');
		$this -> hasColumn('definition', 'text');
		$this -> hasColumn('sample', 'text');
	}

	public function setUp() {
		$this -> setTableName('ebola_numbers');
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("ebola_numbers");
		$categories = $query -> execute();
		return $categories;
	}

}
