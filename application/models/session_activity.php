<?php
class session_activity extends Doctrine_Record{
	public function setTableDefinition(){	
		$this->hasColumn('id','int', 11);
		$this->hasColumn('session_id','text');
		$this->hasColumn('logi_id','int', 11);
		$this->hasColumn('user_id','int', 11);
		$this->hasColumn('last_activity','datetime');
		$this->hasColumn('active','int',2);
	}
	
	
	public function setUp(){
		
		$this->setTableName('session_activity');	
	}
	
	
	}
