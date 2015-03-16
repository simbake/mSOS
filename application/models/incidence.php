<?php
class Incidence extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('Mfl_Code', 'int');
		$this -> hasColumn('district', 'varchar', 255);
		$this -> hasColumn('county', 'varchar', '255');
		$this -> hasColumn('Type', 'varchar', '255');
		$this -> hasColumn('Disease_id', 'int', '11');
		$this -> hasColumn('Age', 'int', 11);
		$this -> hasColumn('Sex', 'varchar', 5);
		$this -> hasColumn('Status', 'varchar', '5');
		$this -> hasColumn('New_Age', 'int', 11);
		$this -> hasColumn('New_Sex', 'varchar', 5);
		$this -> hasColumn('New_Status', 'varchar', '5');
		$this -> hasColumn('time_changed', 'datetime');
		$this -> hasColumn('p_id', 'varchar', '255');
		$this -> hasColumn('Time', 'datetime');
		$this -> hasColumn('confirmation', 'varchar', '255');
		$this -> hasColumn('lab_time', 'datetime');

	}

	public function setUp() {
		$this -> setTableName('incidence');
		$this -> hasMany('Facility as incident', array('local' => 'Mfl_Code', 'foreign' => 'Facility_code'));
		$this -> hasMany('diseases as disease_name', array('local' => 'Disease_id', 'foreign' => 'id'));
		$this -> hasMany('incident_log as logs', array('local' => 'id', 'foreign' => 'incident_id'));

	}

	public function get_incidence_count() {
		$query = Doctrine_query::create() -> select("count(id) as total") -> from("incidence") -> where('confirmation="Suspected"');
		$incident = $query -> execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
		return $incident;
	}
public function get_incidence_ebola_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Suspected' AND disease_id='16'");
		$incident = $query -> count();
		return $incident;
	}

	public function get_incidence() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> groupby("Disease_id");
		$dlist = $query -> execute();
		return $dlist;
	}

	public function get_all() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence")->orderBy("id desc");
		$all = $query -> execute();
		return $all;
	}
	public function get_all_ebola() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence")->where("disease_id='16'")->orderBy("id desc");
		$all = $query -> execute();
		return $all;
	}
	public function lab_results() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence")->where("disease_id='16'")->orderBy("id desc");
		$all = $query -> execute();
		return $all;
	}

	public function get_facility_count() {
		$query = Doctrine_query::create() -> select("COUNT(id) as total,id,mfl_code,disease_id,p_id") -> from("incidence")-> groupby("mfl_code");
		$incident = $query -> execute();
		return $incident;
	}
	public function get_facility_count_by_disease($diseases) {
		$query = Doctrine_query::create() -> select("COUNT(id) as total,id,mfl_code,disease_id,p_id") -> from("incidence")->where("disease_id='$diseases'")-> groupby("mfl_code");
		$incident = $query -> execute();
		//$incident = $query -> execute();
		return $incident->toArray();
	}
	public function get_ebola_count() {
		$query = Doctrine_query::create() -> select("COUNT(id) as total,id,mfl_code,disease_id,p_id") -> from("incidence")->Where(" disease_id='16'")-> groupby("mfl_code");
		$incident = $query -> execute();
		return $incident;
	}

	public function get_confirmation($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence") -> where("id = '$id'");
		$user = $query -> execute();
		return $user[0];
	}

	public function get_filter($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence") -> where("disease_id = $id");
		$user = $query -> execute();
		return $user;
	}

	public function get_suspected() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where('confirmation="Suspected"');
		$all = $query -> execute();
		return $all;
	}

	public function get_disease($disease) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("Disease_id='$disease'");
		$ddetails = $query -> execute();
		return $ddetails;
	}

	public function get_disease_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> groupby("Disease_id");
		$disease = $query -> count();
		return $disease;
	}

	public function get_male_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("sex='M'") -> groupby("sex");
		$male = $query -> count();
		return $male;
	}

	public function get_female_count() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("sex='F'") -> groupby("sex");
		$female = $query -> count();
		return $female;
	}

	public function incidence_r() {
		$query = Doctrine_Query::create() -> select("COUNT(`id`) as total,Disease_id,time") -> from("incidence") -> groupby("Disease_id ASC");

		$bubu = $query -> execute();
		return $bubu -> toArray();
	}

	public function danalyse($y, $m) {
		$query = Doctrine_Query::create() -> select("COUNT(`id`) as total,DATE(time) as dater,Disease_id") -> from("incidence") -> where("Disease_id=3 AND YEAR(time)='$y' AND MONTH(time)='$m'") -> groupby("DATE(time)");
		$dayan = $query -> execute();
		return $dayan -> toArray();
	}

	public function conf() {
		$query = Doctrine_Query::create() -> select("COUNT(`id`) as total,confirmation") -> from("incidence") -> groupby("confirmation");

		$bubu = $query -> execute();
		return $bubu -> toArray();
	}

	public function confirm() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Positive'") -> groupby("confirmation");
		$confirm = $query -> count();
		return $confirm;
	}
	public function confirm_ebola() {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Positive' AND disease_id='16'") -> groupby("confirmation");
		$confirm = $query -> count();
		return $confirm;
	}

	public static function get_district_incidents($d) {

		$query = Doctrine_Query::create() -> select("Type, incidence.id, Mfl_code, Disease_id, Age, Sex, Status,P_id, Time, Confirmation ") -> from("incidence,facility") -> where("incidence.Mfl_code=facility.facility_code") -> andWhere("incidence.district='$d'");
		$order = $query -> execute();
		return $order;
	}

	public static function get_county_incidents($d) {

		$query = Doctrine_Query::create() -> select("Type, incidence.id, Mfl_code, Disease_id, Age, Sex, Status,P_id, Time, Confirmation ") -> from("incidence,facility") -> where("incidence.Mfl_code=facility.facility_code") -> andWhere("facility.county='$d'");
		$order = $query -> execute();
		return $order;
	}

	public function facility_incidents($id) {
		$query = Doctrine_Query::create() -> select("*") -> from("incidence") -> where("mfl_code = '$id'");
		$user = $query -> execute();
		return $user;
	}

	//county
	public function get_incidence_count_county($county) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Suspected' AND county='$county'");
		$incident = $query -> count();
		return $incident;
	}

	public function get_disease_count_county($county) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("county='$county'") -> groupby("Disease_id");
		$disease = $query -> count();
		return $disease;
	}

	public function confirm_county($county) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Positive' AND county='$county'") -> groupby("confirmation");
		$confirm = $query -> count();
		return $confirm;
	}

	public function get_county($county) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("county='$county'");
		$all = $query -> execute();
		return $all;
	}
	//district
	
	//county
	public function get_incidence_count_district($district) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Suspected' AND district='$district'");
		$incident = $query -> count();
		return $incident;
	}

	public function get_disease_count_district($district) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("district='$district'") -> groupby("Disease_id");
		$disease = $query -> count();
		return $disease;
	}

	public function confirm_district($district) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("confirmation='Positive' AND district='$district'") -> groupby("confirmation");
		$confirm = $query -> count();
		return $confirm;
	}

	public function get_district($district) {
		$query = Doctrine_query::create() -> select("*") -> from("incidence") -> where("district='$district'");
		$all = $query -> execute();
		return $all;
	}
	public function report_rate($year,$county){
		$query = Doctrine_query::create() -> select("monthname(Time) as Month, 
  year(Time) as Year, count(id) as total") -> from("incidence") -> where("year(Time)='$year' AND county='$county'")->groupby("monthname(Time), year(Time)");
		$all = $query -> execute();
		return $all->toArray();
	}

}
