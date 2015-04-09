<?php

class System_Visits extends Doctrine_Record{
	
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int', 11);
		$this -> hasColumn('ip_address', 'text');
	}
	public function setUp() {
		$this -> setTableName('system_visits');
	}
	public function load_unique_ips(){
		$query = Doctrine_query::create() -> select("DISTINCT ip_address as ip")-> from("system_visits")->orderBy("ip_address");
		$incident = $query->execute();
		return $incident;
	}
	function check_ip($ip){
		$query = Doctrine_query::create() -> select(" DISTINCT ip_address as ip ") -> from("system_visits")->where("ip_address='$ip'");
		$incident = $query -> execute(array(), Doctrine::HYDRATE_SINGLE_SCALAR);
		return $incident;
	}
}
