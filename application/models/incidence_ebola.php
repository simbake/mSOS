<?php
class incidence_ebola extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('Type', 'varchar', 11);
		$this -> hasColumn('incidence_location', 'varchar',255);
		$this -> hasColumn('location_reported_by', 'varchar',255);
		$this -> hasColumn('location_report_date', 'datetime');
		$this -> hasColumn('Disease_id', 'varchar', '255');
		$this -> hasColumn('Age', 'int', 11);
		$this -> hasColumn('Sex', 'varchar', 5);
		$this -> hasColumn('Status', 'varchar', '5');
		$this -> hasColumn('msos_code', 'text');
		$this -> hasColumn('case_number', 'text');
		$this -> hasColumn('reported_by', 'int', '11');
		$this -> hasColumn('incidence_time', 'datetime');
		$this -> hasColumn('lab_results', 'varchar', '255');
		$this -> hasColumn('lab_time', 'datetime');
	}

	public function setUp() {
		$this -> setTableName('incidence_ebola');
		$this -> hasMany('rrt_diseases as disease_name', array('local' => 'Disease_id', 'foreign' => 'id'));
		$this -> hasMany('User as ebl_numbers', array('local' => 'reported_by', 'foreign' => 'telephone'));
		$this -> hasMany('rrt_location as coordinates', array('local' => 'incidence_location', 'foreign' => 'location_name'));
		$this -> hasMany('User as location_user', array('local' => 'location_reported_by', 'foreign' => 'telephone'));
		$this -> hasMany('incident_log_ebola as logs_ebola', array('local' => 'msos_code', 'foreign' => 'incident_id'));
		$this -> hasMany('kemri_response_ebola as kemri_response', array('local' => 'msos_code', 'foreign' => 'incident_id'));
	}
	
	public function getAll(){
		$query = Doctrine_query::create() -> select("*") -> from("incidence_ebola");
		$incident = $query -> execute();
		return $incident;
	}

	public static function get_Response() {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence_ebola i")->leftjoin("i.kemri_response k")->leftjoin("i.logs_ebola l")->orderBy("i.msos_code");
		$categories = $query -> execute(array(), Doctrine::HYDRATE_RECORD);
		return $categories;
	}
	public function get_ebola_count() {
		$query = Doctrine_query::create() -> select("COUNT(id) as total,id,disease_id,msos_code") -> from("incidence_ebola")-> groupby("incidence_time");
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
    public function get_confirmation($msos_code) {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence_ebola") -> where("msos_code = '$msos_code'");
		$user = $query -> execute();
		return $user[0];
	}
	public function get_disease_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence_ebola") -> groupby("Disease_id");
		$disease = $query -> count();
		return $disease;
	}
	public function get_null_locations(){
		$query = Doctrine_query::create() -> select("reported_by,incidence_time,GROUP_CONCAT(mSOS_code) as mSOS_id") -> from("incidence_ebola i") ->where("i.incidence_location='Null'")->groupBy("reported_by");
		$incidence = $query -> execute();
		return $incidence;
	}
	public function getAll_null_locations(){
		$query = Doctrine_query::create() -> select("reported_by,incidence_time") -> from("incidence_ebola i") ->where("i.incidence_location='Null'");
		$incidence = $query -> execute();
		return $incidence;
	}

}
