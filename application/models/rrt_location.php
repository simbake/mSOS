<?php
class rrt_location extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('location_name', 'varchar',255);
		$this -> hasColumn('lat', 'varchar',255);
		$this -> hasColumn('long', 'varchar',255);		
	}
	
	public function setUp() {
		$this -> setTableName('rrt_location');
		$this->hasMany('incidence_ebola as incidence', array('local' => 'location_name', 'foreign' => 'incidence_location'));
	}
	
	public function get_all(){
	    $query = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT l.*, count(i.id) as total FROM rrt_location l, incidence_ebola i WHERE l.location_name=i.incidence_location GROUP BY l.location_name");
		return $query;
	}
	
}