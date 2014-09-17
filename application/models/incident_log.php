<?php
class Incident_Log extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('incident_id', 'int', 11,array('unique' => 'true'));
		$this -> hasColumn('reported', 'int', 11);
		$this -> hasColumn('national_incident', 'text');
		$this -> hasColumn('county_incident', 'text');
		$this -> hasColumn('district_incident', 'text');

	}

	public function setUp() {
		$this -> setTableName('incident_log');
		$this -> hasOne('incidence as logs', array('local' => 'incident_id', 'foreign' => 'id'));
	}

	public function get_count($id) {
		$query = Doctrine_query::create() -> select("*") -> from("incident_log") -> where("incident_id=$id");
		$disease = $query -> count();
		return $disease;
	}

	public function national_get_count($id) {
		$query = Doctrine_query::create() -> select("*") -> from("incident_log") -> where("incident_id=$id and national_incident IS NULL");
		$count = $query -> count();
		return $count;
	}

	public function county_get_count($id) {
		$query = Doctrine_query::create() -> select("*") -> from("incident_log") -> where("incident_id=$id and county_incident IS NULL");
		$count = $query -> count();
		return $count;
	}

	public function district_get_count($id) {
		$query = Doctrine_query::create() -> select("*") -> from("incident_log") -> where("incident_id=$id and district_incident IS NULL");
		$count = $query -> count();
		return $count;
	}

}
