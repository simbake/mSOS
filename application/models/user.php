<?php
class User extends Doctrine_Record {

	public function setTableDefinition() {
		$this->hasColumn('id', 'int', 11);
		$this->hasColumn('fname', 'varchar', 255);
		$this->hasColumn('email', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('username', 'string', 255, array('unique' => 'true'));
		$this->hasColumn('password', 'string', 255);
		$this->hasColumn('usertype_id', 'integer', 11);
		$this->hasColumn('telephone', 'varchar', 255);
		$this->hasColumn('county', 'varchar', 255);
		$this->hasColumn('district', 'varchar', 255);
		$this->hasColumn('facility', 'varchar', 255);
		$this->hasColumn('status', 'int', 1);
		$this->hasColumn('ebola_login', 'int', 1);
		
	}
	
	public function setUp() {
		$this->setTableName('user');
		$this->actAs('Timestampable');
		$this->hasMutator('password', '_encrypt_password');
		$this -> hasOne('logi as logss', array('local' => 'id', 'foreign' => 'user_id'));
		$this -> hasOne('blog as bloger', array('local' => 'id', 'foreign' => 'user_id'));
			
	}

	protected function _encrypt_password($value) {
		$salt = '#*seCrEt!@-*%';
		$this->_set('password', md5($salt . $value));
		
	}
	
	public function login($username, $password) {
		
		$salt = '#*seCrEt!@-*%';
		$value=( md5($salt . $password));
		$query = Doctrine_Query::create() -> select("*") -> from("User") -> where("username = '" . $username . "' and password='". $value ."'");

		$x = $query -> execute();
		//echo $x['username'];
		/*if($x['username']!="" || $x['username']==null){
		echo "<script>alert('Wrong Username or/and Password');</script>";
		
		}
		else{*/
		return $x[0];
		//}
		//
	}
	public static function getsome($id) {
		$query = Doctrine_Query::create() -> select("fname") -> from("user")->where("id='$id' ");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll2($facility,$id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 or usertype_id=5 ")->andWhere("id <> $id and facility='$facility'");
		$level = $query -> execute();
		return $level;
	}
	public static function getAll3($use_id) {
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id=2 and id=$use_id");
		$level = $query -> execute();
		return $level;
		
	}
	public static function getAll4($use_id) {
		$myobj = Doctrine::getTable('user')->findOneById($use_id);
        $id=$myobj->id ;
		$my_array =array('0'=>$id);
		return $my_array;
	}
	public static function getAll(){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->orderBy('usertype_id');;
		$level = $query -> execute();
		return $level;
	}
	public static function getAll5($district, $id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("district=$district") ->andWhere("id <> $id");
		$level = $query -> execute();
		return $level;
	}
	public static function getUsers($facility_c){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("facility=$facility_c");
		$level = $query -> execute();
		return $level;
	}
	public static function getAllUser($use_id){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("id=$use_id");
		$level = $query -> execute();
		return $level;
	}
	public function admin(){
		$query = Doctrine_Query::create() -> select("*") -> from("user")->where("usertype_id =1 OR usertype_id =2");
		$admin = $query -> execute();
		return $admin;
	}
	public function get_usertype($user_id){
	    $query = Doctrine_Query::create() -> select("*") -> from("access_level")->where("id=$user_id");
		$user_type= $query -> execute();
		return $user_type;
	}
}
