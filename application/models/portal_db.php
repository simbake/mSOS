<?php
class portal_db extends Doctrine_Record{
	public function setTableDefinition(){	
		$this->hasColumn('id','int', 11);
		$this->hasColumn('incident_id', 'varchar', '255');
	}
	
	
	public function setUp(){
		
		$this->setTableName('portal');
		$this -> hasOne('portal_db as Incidence', array('local' => 'incident_id', 'foreign' => 'p_id'));
		
	}
	
	/*public function get_all_portal() {
	   // $query = Doctrine_Query::create()->select('I.*,P.*')->from('incidence I')->leftJoin('I.portal_db P')->groupBy('I.id desc');
		//$query = Doctrine_query::create() -> select("*") -> from("incidence")->orderBy('id desc');
		$query = Doctrine_Query::create()
    ->select('I.*, P.*')
    ->from('incidence I')
    ->leftJoin('I.portal_db P')
    ->groupBy('I.id desc');
		
		$all = $query -> execute();
		return $all;
	}*/
	
	public static function get_supply_plan($say) {

		$supplyplan = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT * FROM portal WHERE incident_id='$say'");
		return $supplyplan;
	}
	
}
