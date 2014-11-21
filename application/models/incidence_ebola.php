<?php
class incidence_ebola extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('Type', 'varchar', 11);
		$this -> hasColumn('Mfl_Code', 'int');
		$this -> hasColumn('Disease_id', 'varchar', '255');
		$this -> hasColumn('Age', 'int', 11);
		$this -> hasColumn('Sex', 'varchar', 5);
		$this -> hasColumn('Status', 'varchar', '5');
		$this -> hasColumn('New_Age', 'int', 11);
		$this -> hasColumn('New_Sex', 'varchar', 255);
		$this -> hasColumn('New_Status', 'varchar', 255);
		$this -> hasColumn('incidence_code', 'text');
		$this -> hasColumn('reported_by', 'int', '11');
		$this -> hasColumn('incidence_time', 'datetime');
		$this -> hasColumn('lab_results', 'varchar', '255');
		$this -> hasColumn('lab_time', 'datetime');
	}

	public function setUp() {
		$this -> setTableName('incidence_ebola');
		$this -> hasMany('Facility as facility_info', array('local' => 'Mfl_Code', 'foreign' => 'Facility_code'));
		$this -> hasMany('diseases as disease_name', array('local' => 'Disease_id', 'foreign' => 'id'));
		$this -> hasMany('incident_log_ebola as logs_ebola', array('local' => 'incidence_code', 'foreign' => 'incident_id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence_ebola");
		$categories = $query -> execute();
		return $categories;
	}
	public function get_ebola_count() {
		$query = Doctrine_query::create() -> select("COUNT(id) as total,id,mfl_code,disease_id,incidence_code") -> from("incidence_ebola")-> groupby("mfl_code");
		$incident = $query -> execute();
		return $incident;
	}
	public function get_incidence_ebola_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence_ebola") -> where("lab_results='Suspected'");
		$incident = $query -> count();
		return $incident;
	}
	public function confirm_ebola() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence_ebola") -> where("lab_results='Positive'");
		$confirm = $query -> count();
		return $confirm;
	}
    public function get_confirmation($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence_ebola") -> where("id = '$id'");
		$user = $query -> execute();
		return $user[0];
	}
	public function get_disease_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence_ebola") -> groupby("Disease_id");
		$disease = $query -> count();
		return $disease;
	}

}
