<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');

class User_Management extends MY_Controller {
 public $say;
	function __construct() {
		parent::__construct();

		$this -> load -> helper(array('form', 'url'));
		$this -> load -> library('form_validation');
	}

	public function index() {
		$this -> login();
	}
public function session_timeout(){

	$id = $this -> session -> userdata('user_id');
		$time = date("Y-m-d G:i:s", time());
		$status = "Inactive";
		$q = Doctrine_Query::create() -> update('logi') -> set('status', '?', "$status")->set('t_logout', '?', "$time") -> where("user_id='$id' AND status='Active'");
		$q -> execute();

		$data = array();
		$session_activity=array('active'=>1);
	$this -> db -> where('session_id', $this->session->userdata('session_id'),'user_id',$this->session->userdata('user_id'),'active',0);
	$this -> db -> update('session_activity', $session_activity);
		
		$this -> session -> sess_destroy("mSOS_session");
	    redirect("home_controller/session_timeout");
	}
	public function login() {
	
	if($this->session->userdata("user_id")){
	redirect("home_controller");
	}
		$data = array();
		$data['title'] = "System Login";
		if(@$say != null){
		$this -> load -> view("login_v", $data, $say);
		}
		else{
		$this -> load -> view("login_v", $data);
		}
	}

	public function logout() {
		$id = $this -> session -> userdata('user_id');
		$time = date("Y-m-d G:i:s", time());
		$status = "Inactive";
		if($this->session->userdata("user_id")){
		$q = Doctrine_Query::create() -> update('logi') -> set('status', '?', "$status")->set('t_logout', '?', "$time") -> where("user_id='$id' AND status='Active'");
		$q -> execute();
		$data = array();
		$this -> session -> sess_destroy("mSOS_session");
		}
		redirect("home_controller");
	}

	public function login_user() {
		$username = $_POST['username'];
		$password = $_POST['password'];
		if ($this -> _submit_validate1() == FALSE) {
			 echo "<script>alert(wrong username or/and password);</script>";
			//$this -> index();
			return;
		}
		$reply = User::login($username, $password);
		$n = $reply -> toArray();
		//echo($n['username']);
        //$password=$n['password'];
		
		$myvalue = $n['usertype_id'];
		$namer = $n['fname'];
		$user_id = $n['id'];
		$district = $n['district'];
		$county= $n['county'];
		$status=$n['status'];
		$ebola_login=$n['ebola_login'];
		$password=$n['password'];
		$time = date("Y-m-d G:i:s", time());
		if($status==0){$myvalue=null;}

		$lg = new logi();
		$lg -> user_id = $user_id;
		$lg -> t_login = $time;
		$lg -> save();
          $session_data="";
		if ($myvalue == 1) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Administrator");
		} else if ($myvalue == 2) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "MOH",'ebola_login' => $ebola_login);
		} else if ($myvalue == 5) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "KEMRI", 'ebola_login' => $ebola_login);
		} else if ($myvalue == 4) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "District Administrator", 'district' => $district);
		}else if ($myvalue == 3) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "County Administrator", 'county' => $county);
		}
		else if ($myvalue == 7) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Ebola Response", 'ebola_login' => $ebola_login);
		}
         if($session_data=="" || $session_data==null){
		 //header('Location: ' . $_SERVER['HTTP_REFERER']);
		// echo "Wrong Username or/and Password";
		//global $say;
		$this->session->set_flashdata("login_check",1);
		 redirect("user_management/login");
		 //header('application/controllers/home_controller');
		 
		 }
		 else{
		$this -> session -> set_userdata($session_data);
		
         }
		 
		 $salt = '#*seCrEt!@-*%';
        $pass1="msos123";
        $old_pass=( md5($salt . $pass1));
		if($password==$old_pass){
		  redirect("user_management/change_pass_login/");
		 
		}
		else{
			if($ebola_login==1){
				
			redirect("ebola_controller");
				
			}else {
		redirect("home_controller");
			}
		}
		
		
	}
	
	public function change_pass_login() {
		$data = array();
		$data['title'] = "Change Password";
		$data['banner_text'] = "Dashboards";
		$this -> load -> view("change_pass_view", $data);
	}

	public function submit() {
		if ($this -> _submit_validate() === FALSE) {
			$this -> index();
			return;
		}

		$email = $this -> input -> post('email');
		$name1 = $this -> input -> post('fname');
		$name2 = $this -> input -> post('lname');
		$password = $this -> input -> post('password');
		$username = $this -> input -> post('username');
		$id = $this -> input -> post('facility');

		$u = new User();
		$u -> fname = $this -> input -> post('fname');
		$u -> email = $this -> input -> post('email');
		$u -> username = $this -> input -> post('username');
		$u -> password = $this -> input -> post('password');
		$u -> usertype_id = $this -> input -> post('type');
		$u -> telephone = $this -> input -> post('tell');
		$u -> province = $this -> input -> post('province');
		$u -> district = $this -> input -> post('district');
		$u -> facility = $this -> input -> post('facility');
		$u -> save();

		$data['title'] = "Facilities";
		$data['content_view'] = "all_facilities";
		$data['banner_text'] = "Facilities";
		$data['link'] = "all_facilities";
		$data['all'] = Facility::get_all();
		$data['quick_link'] = "all_facilities";
		$this -> load -> view("template", $data);

	}

	public function admin_submit() {
		/*if ($this->_submit_validate() === FALSE) {
		 $this->index();
		 return;
		 }*/

		$email = $this -> input -> post('email');
		$name1 = $this -> input -> post('fname');
		$name2 = $this -> input -> post('lname');
		//$password="msos123";
		$password = $this -> input -> post('password');
		$username = $this -> input -> post('username');
		$id = $this -> input -> post('facility');
		$province = $this -> input -> post('province');
		$district = $this -> input -> post('district');
		if ($province == '-- Select District --') {
			$province = 'NULL';
		}
		if ($district == '-- Select District --') {
			$district = 'NULL';
		}

		$u = new User();
		$u -> fname = $this -> input -> post('fname');
		$u -> email = $this -> input -> post('email');
		$u -> username = $this -> input -> post('username');
		$u -> password = $this -> input -> post('password');
		$u -> usertype_id = $this -> input -> post('type');
		$u -> telephone = $this -> input -> post('tell');
		$u -> county = $province;
		$u -> district = $district;
		$u -> facility = $this -> input -> post('facility');
		$u -> save();
        
		 $data['title'] = "Administrators";
		$data['content_view'] = "add_moh_view";
		$data['banner_text'] = "Add Administrator";
		$data['link'] = "add_moh_view";
		$data['level_l'] = Access_level::getAll();
		$data['province'] = Facility::county();
		$data['district'] = Facility::district();
		$data['quick_link'] = "add_moh_view";
		$this -> load -> view("template", $data);
	}

	private function _submit_validate1() {

		$this -> form_validation -> set_rules('username', 'Username', 'trim|required');

		$this -> form_validation -> set_rules('password', 'Password', 'trim|required');

		$this -> form_validation -> set_message('authenticate', 'Invalid login. Please try again.');

		return $this -> form_validation -> run();

	}

	private function _submit_validate() {

		// validation rules
		$this -> form_validation -> set_rules('fname', 'First Name', 'trim|required|alpha_numeric|min_length[3]');

		$this -> form_validation -> set_rules('email', 'E-mail', 'trim|required|valid_email|unique[User.email]');

		$this -> form_validation -> set_rules('username', 'Username', 'trim|required|alpha_numeric|min_length[3]|max_length[12]|unique[User.username]');

		$this -> form_validation -> set_rules('password', 'Password', 'trim|required|min_length[3]|max_length[12]');

		$this -> form_validation -> set_rules('passconf', 'Confirm Password', 'trim|required|matches[password]');

		$this -> form_validation -> set_rules('tell', 'Mobile Number', 'trim|required|numeric|min_length[10]');

		return $this -> form_validation -> run();

	}

	public function authenticate() {

		return Current_User::login($this -> input -> post('username'), $this -> input -> post('password'));

	}

	public function go_home($data) {
		$data['title'] = "System Home";
		$data['content_view'] = "home_v";
		$data['banner_text'] = "Dashboards";
		$data['link'] = "home";
		$this -> load -> view("template", $data);
	}

	public function sign_up() {
		$data['title'] = "Facilities";
		$data['content_view'] = "all_facilities";
		$data['banner_text'] = "Facilities";
		$data['link'] = "all_facilities";
		$data['all'] = Facility::get_all();
		$data['quick_link'] = "all_facilities";
		$this -> load -> view("template", $data);
	}

	public function moh() {
		$data['title'] = "Administrators";
		$data['content_view'] = "add_moh_view";
		$data['banner_text'] = "Add Administrator";
		$data['link'] = "add_moh_view";
		$data['level_l'] = Access_level::getAll();
		$data['province'] = Facility::county();
		$data['district'] = Facility::district();
		$data['quick_link'] = "add_moh_view";
		$data['left_content']="true";
		
		$data['list'] = Diseases::getAll();
		$this -> load -> view("template", $data);
	}

	//users list
	public function users_facility() {

		$data['title'] = "View Users";
		$data['content_view'] = "users_facility_v";
		$data['banner_text'] = "Facility Users";
		$data['result'] = User::getAll();
		$data['quick_link'] = "users_facility_v";
		$this -> load -> view("template", $data);

	}

	// views users
	public function users_manage() {
		$data['title'] = "Manage Users";
		$data['content_view'] = "user_manage_v";
		$data['banner_text'] = "User Management";
		$this -> load -> view("template", $data);
	}

	public function base_params($data) {
		$this -> load -> view("template", $data);
	}
	public function active(){
		$status=1;		
		$id=$this->uri->segment(3);
		$state=Doctrine::getTable('user')->findOneById($id);
		$state->status=$status;
		$state->save();
		

		$data['title'] = "View Users";
		$data['content_view'] = "users_facility_v";
		$data['banner_text'] = "Facility Users";
		$data['result'] = User::getAll();
		$this -> load -> view("template", $data);
	}
	public function user_reset(){
		$id=$this->uri->segment(3);
		$password='msos123';
		
		$pass1=Doctrine::getTable('user')->findOneById($id);
		$name=$pass1->fname;
		$email=$pass1->email;
		$pass=Doctrine::getTable('user')->findOneById($id);
		//echo $pass->password
		$pass->password=$password;
		$pass->save();
		if($email){
		$fromm='hcmpkenya@gmail.com';
		$datetime = date_create()->format('Y-m-d H:i:s');
		$dates = new DateTime($datetime);
		$messages='Hallo '.$name .', Your password has been reset on '.$dates->format('jS F Y H:i:s').'. Please use the default password to login and change. 
		
		Thank you';
	
  		$config = Array(
  'protocol' => 'smtp',
  'smtp_host' => 'ssl://smtp.googlemail.com',
  'smtp_port' => 465,
  'smtp_user' => 'ddsrmsos@gmail.com', // change it to yours
  'smtp_pass' => 'y3ll0w@#1', // change it to yours
  'mailtype' => 'html',
  'charset' => 'iso-8859-1',
  'wordwrap' => TRUE
); 
		
        //$this->email->initialize($config);
		$this->load->library('email', $config);
 
  		$this->email->set_newline("\r\n");
  		$this->email->from($fromm,'DDSR mSOS'); // change it to yours
  		$this->email->to($email); // change it to yours
  		
  		$this->email->subject('Password Reset:'.$name);
 		$this->email->message($messages);
 
  if($this->email->send())
 {

 }
 else
{
 show_error($this->email->print_debugger());
}
}
		
		//$this->session->sess_destroy();
		/*$session_data=array('pass_check'=>'Password change succesful');
		$this -> session -> set_userdata($session_data);*/
		//session_start();
		//$_SESSION['pass_check']="Password change succesful";
		// Take causion of being hijacked while you redirect with the below code.
		header('Location: ' . $_SERVER['HTTP_REFERER']);
		
		//$data = array();
		//$data['title'] = "System Login";
		
		//$this -> load -> view("template", $data);
	}

	public function deactive(){
	$id=$this->uri->segment(3);
		//$password='msos123';
		
		$pass1=Doctrine::getTable('user')->findOneById($id);
		$name=$pass1->fname;
		$email=$pass1->email;
		$pass=Doctrine::getTable('user')->findOneById($id);
		//echo $pass->password
		$pass->status=0;
		$pass->save();
		$this->users_facility();
	}
	
	public function Change_pass() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Password Change";
		$data['content_view'] = "changefcpass";
		$data['banner_text'] = "Password Change";
		$data['link'] = "changefcpass";
		//$data['all'] = Incidence::get_confirmation($id);
		$data['quick_link'] = "changefcpass";
		$this -> load -> view("template", $data);
	}
}
