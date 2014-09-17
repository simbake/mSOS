<?php
class kemri_response extends Doctrine_Record{
	public function setTableDefinition(){	
		$this->hasColumn('Id','int', 11);
		$this->hasColumn('incident_id', 'varchar', '250');
		$this->hasColumn('specimen_received', 'datetime');
		$this->hasColumn('lab_test_begun', 'datetime');
		$this->hasColumn('specimen_type', 'text');
		$this->hasColumn('other_specimen', 'text');
		$this->hasColumn('conditions', 'text');
		$this->hasColumn('other_condition', 'text');
		$this->hasColumn('comments', 'text');
		$this->hasColumn('notified','tinyint',1);
		$this->hasColumn('date_notified','datetime');
	}
	
	
	public function setUp(){
		
		$this->setTableName('kemri_response');
		//$this->actAs('Timestampable');
		$this -> hasOne('kemri_response as Incidence', array('local' => 'incident_id', 'foreign' => 'incident_id'));
		
	}
	
	public function get_kemri_response($incident_id){
	$query = Doctrine_Query::create()->select('*')->from('kemri_response')->where("incident_id='$incident_id'")->groupBy('id desc');
		$all=$query-> execute();
		return $all;
	}
	public function save_response($id,$test_time,$type,$other,$condition,$comments){

	$query = Doctrine_query::create() -> update("kemri_response")-> set(array("lab_test_begun=>$test_time, specimen_type=>$type, other_specimen=>$other, conditions=>$condition, comments=>$comments")) -> where("incident_id='$id'");
		$all=$query-> execute();
		return $all;
	}
	
	public function kemri_results_view(){
	$query = Doctrine_Query::create()->select('*')->from('kemri_response')->groupBy('id desc');
		$all=$query-> execute();
		return $all;
	}
	public function ebola_results_view(){
	//$query = Doctrine_Query::create()->select('k.*')->from('kemri_response k, incidence i')->where("i.p_id=k.incident_id AND i.disease_id='16'")->groupBy('id desc');
		//$all=$query-> execute();
	$all = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT k.* FROM kemri_response k, incidence i WHERE i.p_id=k.incident_id AND i.disease_id='16'");
		
		return $all;
	}
	public function kemri_response_report(){
	$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT i.*,k.* FROM kemri_response k,incidence i WHERE k.incident_id=i.p_id");
	return $fetch_incidence;
	}
	
}
