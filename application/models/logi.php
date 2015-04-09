<?php
class Logi extends Doctrine_Record {
	public function setTableDefinition() {
		$this -> hasColumn('id', 'int',15);
		$this -> hasColumn('user_id', 'int',15);
		$this -> hasColumn('ip_address', 'text');
		$this -> hasColumn('user_agent', 'text');
		$this -> hasColumn('status', 'varchar',255);
		$this -> hasColumn('t_login', 'datetime');
		$this -> hasColumn('t_logout', 'datetime');			
	}

	public function setUp() {
		$this -> setTableName('logi');
		$this -> hasMany('user as logss', array('local' => 'user_id', 'foreign' => 'id'));
	}

	public static function getAll() {
		$query = Doctrine_Query::create() -> select("*") -> from("logi")->orderBy('id desc');
		$level = $query -> execute();
		return $level;
	}
	public static function getAccessLogs(){
		$query = Doctrine_Query::create() -> select("*") -> from("logi")->where("status='Inactive' AND t_logout!='NULL'")->orderBy('id desc');
		$level = $query -> execute();
		return $level;
	}
      
	  public static function online_users(){
		$query = Doctrine_Query::create() -> select("*") -> from("logi")->where("status='active'")->orderBy('id desc');
		$level = $query -> execute();
		return $level;
	}
	
	
	

}