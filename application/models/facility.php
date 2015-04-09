<?php
class Facility extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('Facility_code', 'int', 15);
		$this -> hasColumn('Facility_name', 'varchar', '43');
		$this -> hasColumn('province', 'int');
		$this -> hasColumn('county', 'varchar', 255);
		$this -> hasColumn('district', 'varchar', '255');
		$this -> hasColumn('division', 'varchar', '255');
		$this -> hasColumn('type', 'varchar', '255');
		$this -> hasColumn('owner', 'varchar', '255');
		$this -> hasColumn('phone_number', 'varchar', '255');
		$this -> hasColumn('alternate', 'varchar', '255');
		$this -> hasColumn('contact', 'varchar', '255');
		$this -> hasColumn('status', 'int', 4);
		$this -> hasColumn('latitude', 'varchar', '255');
		$this -> hasColumn('longitude', 'varchar', '255');
		$this -> hasColumn('ebola_status', 'int', 1);
	}

	public function setUp() {
		$this -> setTableName('facility');
		$this -> hasOne('Incidence as incident', array('local' => 'Facility_code', 'foreign' => 'Mfl_Code'));

	}

	public function get_all() {
		$query = Doctrine_query::create() -> select("*") -> from("facility");
		$all = $query -> execute();
		return $all;
	}

	public function admin($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("facility") -> where("id = '$id'");
		$user = $query -> execute();
		return $user[0];
	}

	public function county() {
		$query = Doctrine_Query::create() -> select("county") -> from("facility") -> groupby("county");
		$user = $query -> execute();
		return $user;
	}

	public function getcounty($county) {
		$query = Doctrine_Query::create() -> select("*") -> from("facility") -> where("county='$county'");
		$user = $query -> execute();
		return $user;
	}

	public function district() {
		$query = Doctrine_Query::create() -> select("district") -> from("facility") -> groupby("district");
		$user = $query -> execute();
		return $user;
	}

	public function get_facility($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("facility") -> where("id = '$id'");
		$user = $query -> execute();
		return $user[0];
	}

	public function getby_district($district) {
		$query = Doctrine_Query::create() -> select("*") -> from("facility") -> where("district='$district'");
		$user = $query -> execute();
		return $user;
	}

	public function count_registered_facilities() {
		$query = Doctrine_Query::create() -> select("*") -> from("facility") -> where("(phone_number!=NULL || phone_number>=0 || phone_number!='')");
		$user = $query -> execute();
		return $user->count();
	}

}
