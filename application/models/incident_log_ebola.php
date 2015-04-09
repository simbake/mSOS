<?php
class incident_Log_ebola extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('incident_id', 'varchar', 255,array('unique' => 'true'));
		$this -> hasColumn('reported', 'int', 11);
		$this -> hasColumn('Admin_Response', 'text');
		$this -> hasColumn('RRT_Response', 'text');

	}

	public function setUp() {
		
		$this -> setTableName('Incident_Log_ebola');
		$this -> hasOne('incidence_ebola as logs', array('local' => 'incident_id', 'foreign' => 'incidence_code'));
		
	}

	public function get_count($id) {
		$query = Doctrine_query::create() -> select("*") -> from("Incident_Log_ebola") -> where("incident_id=$id");
		$disease = $query -> count();
		return $disease;
	}

	public function national_get_count($id) {
		
		$query = Doctrine_query::create() -> select("*") -> from("Incident_Log_ebola") -> where("incident_id=$id and Admin_Response IS NULL");
		$count = $query -> count();
		return $count;
		
	}
	
	public function get_rrt_response($id){
		$query = Doctrine_query::create() -> select("*") -> from("Incident_Log_ebola") -> where("incident_id=$id and RRT_Response IS NULL");
		$count = $query -> count();
		return $count;
	}


}
