<?php
class weekly_summary_db extends Doctrine_Record{
	public function setTableDefinition(){	
		$this->hasColumn('id','int', 11);
		$this->hasColumn('facility_code','int', 11);
		$this->hasColumn('sys_number','int', 11);
		$this->hasColumn('facility_no','int', 11);
		$this->hasColumn('date_week','datetime');
	}
	
	
	public function setUp(){
		
		$this->setTableName('weekly');
		$this -> hasOne('Facility as Facility', array('local' => 'facility_code', 'foreign' => 'Facility_code'));
		
	}
	
	public function weekly_summary_view($db){	
		//$query=Doctrine_query::create()->select("*")->from("weekly_summary_db")->where(" date_format( date_week, '%Y-%m-%d' ) = '$db' and sys_number=facility_no")->orderBy('id desc');
		$query = Doctrine_Query::create()->select('w.*,f.*')->from('weekly_summary_db w')->leftJoin('w.Facility f')->where(" date_format( w.date_week, '%Y-%m-%d' ) = '$db' and w.sys_number=w.facility_no")->groupBy('w.id desc');
		$all=$query-> execute();
		return $all;
	}
	
	public function weekly_summary_views(){	
		$query=Doctrine_query::create()->select("*")->from("weekly_summary_db")->orderBy('id desc');
		//$query = Doctrine_Query::create()->select('w.*,f.*')->from('weekly_summary_db w')->leftJoin('w.Facility f')->where("w.sys_number=w.facility_no")->groupBy('w.id desc');
		$all=$query-> execute();
		return $all;
	}
	
	
	
	
	
	
	
}
