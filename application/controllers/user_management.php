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

	public function session_timeout() {

		$id = $this -> session -> userdata('user_id');
		$time = date("Y-m-d G:i:s", time());
		$status = "Inactive";
		$q = Doctrine_Query::create() -> update('logi') -> set('status', '?', "$status") -> set('t_logout', '?', "$time") -> where("user_id='$id' AND status='Active'");
		$q -> execute();

		$data = array();
		$session_activity = array('active' => 1);
		$this -> db -> where('session_id', $this -> session -> userdata('session_id'), 'user_id', $this -> session -> userdata('user_id'), 'active', 0);
		$this -> db -> update('session_activity', $session_activity);

		$this -> session -> sess_destroy("mSOS_session");
		redirect("home_controller/session_timeout");
		exit ;
	}

	public function login() {

		if ($this -> session -> userdata("user_id")) {
			redirect("home_controller");
			exit;
		}
		$data = array();
		$data['title'] = "System Login";
		$this -> load -> view("login_v", $data);
	}

	public function logout() {
		$id = $this -> session -> userdata('user_id');
		$time = date("Y-m-d G:i:s", time());
		$status = "Inactive";
		if ($this -> session -> userdata("user_id") > 0) {
			$q = Doctrine_Query::create() -> update('logi') -> set('status', '?', "$status") -> set('t_logout', '?', "$time") -> where("user_id='$id' AND status='Active'");
			$q -> execute();
			$data = array();
			$this -> session -> sess_destroy("mSOS_session");
		}
		redirect("home_controller");
		exit;
	}

	public function login_user() {
		//Post data
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$user_ip = $this -> input -> ip_address();
		$user_agent = $this -> input -> user_agent();

		//Check db for validity of the credentials
		$reply = User::login($username, $password);
		$n = $reply -> toArray();
		$myvalue = $n['usertype_id'];
		$namer = $n['fname'];
		$user_id = $n['id'];
		$district = $n['district'];
		$county = $n['county'];
		$status = $n['status'];
		$ebola_login = $n['ebola_login'];
		$password = $n['password'];

		if ($status == 0) {
			$myvalue = null;
		}

		$session_data = "";
		if ($myvalue == 1) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Administrator");
		} else if ($myvalue == 2) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "MOH", 'ebola_login' => $ebola_login);
		} else if ($myvalue == 5) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "KEMRI", 'ebola_login' => $ebola_login);
		} else if ($myvalue == 4) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "District Administrator", 'district' => $district);
		} else if ($myvalue == 3) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "County Administrator", 'county' => $county);
		} else if ($myvalue == 7) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Ebola Response", 'ebola_login' => $ebola_login);
		}
		if ($session_data == "" || $session_data == null) {

			$this -> session -> set_flashdata("login_check", 1);
			redirect("user_management/login");
			exit ;

		} else {

			$this -> session -> set_userdata($session_data);
			$lg = new logi();
			$lg -> user_id = $user_id;
			$lg -> ip_address = $user_ip;
			$lg -> user_agent = $user_agent;
			$time = date("Y-m-d G:i:s", time());
			$lg -> t_login = $time;
			$lg -> save();

		}

		$salt = '#*seCrEt!@-*%';
		$pass1 = "msos123";
		$old_pass = ( md5($salt . $pass1));
		if ($password == $old_pass) {

			redirect("user_management/change_pass_login/");
			exit ;
		} else {

			if ($ebola_login == 1) {

				redirect("ebola_controller");
				exit;

			} else {
				redirect("home_controller");
				exit;
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
		$username = trim($this -> input -> post('username'));
		// strip ay whitespaces
		$username_check = $this -> check_username($username);

		$email = $this -> input -> post('email');
		$name1 = $this -> input -> post('fname');
		$name2 = $this -> input -> post('lname');
		//$password="msos123";
		$password = $this -> input -> post('password');
		//$id = $this -> input -> post('facility');
		$province = $this -> input -> post('county');
		$district = $this -> input -> post('subcounty');
		$user_access = $this -> input -> post('type');

		if ($user_access == 1 || $user_access == 2 || $user_access == 5) {
			$province = "Null";
			$district = "Null";
		} else if ($user_access == 3) {
			$district = "Null";
		} else if ($user_access == 4) {
			$province = "Null";
		}
		$u = new User();
		$u -> fname = $this -> input -> post('fname');
		$u -> email = $this -> input -> post('email');
		$u -> username = $this -> input -> post('username');
		$u -> password = $this -> input -> post('password');
		$u -> usertype_id = $user_access;
		$u -> telephone = $this -> input -> post('tell');
		$u -> county = $province;
		$u -> district = $district;
		$u -> facility = $this -> input -> post('facility');
		$u -> save();

		redirect("user_management/moh");

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
		$data['counties'] = Facility::county();
		$data['sub_counties'] = Facility::district();
		$data['quick_link'] = "add_moh_view";
		$data['left_content'] = "true";

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

	public function active() {
		$status = 1;
		$id = $this -> uri -> segment(3);
		$state = Doctrine::getTable('user') -> findOneById($id);
		$state -> status = $status;
		$state -> save();
		redirect("user_management/users_facility");

		/*$data['title'] = "View Users";
		 $data['content_view'] = "users_facility_v";
		 $data['banner_text'] = "Facility Users";
		 $data['result'] = User::getAll();
		 $this -> load -> view("template", $data);*/
	}

	public function user_reset() {
		$id = $this -> uri -> segment(3);
		$password = 'msos123';

		$pass1 = Doctrine::getTable('user') -> findOneById($id);
		$name = $pass1 -> fname;
		$email = $pass1 -> email;
		$pass = Doctrine::getTable('user') -> findOneById($id);
		//echo $pass->password
		$pass -> password = $password;
		$pass -> save();
		if ($email) {
			$fromm = 'hcmpkenya@gmail.com';
			$datetime = date_create() -> format('Y-m-d H:i:s');
			$dates = new DateTime($datetime);
			$messages = 'Hallo ' . $name . ', Your password has been reset on ' . $dates -> format('jS F Y H:i:s') . '. Please use the default password to login and change. 
		
		Thank you';

			$config = Array('protocol' => 'smtp', 'smtp_host' => 'ssl://smtp.googlemail.com', 'smtp_port' => 465, 'smtp_user' => 'ddsrmsos@gmail.com', // change it to yours
			'smtp_pass' => 'y3ll0w@#1', // change it to yours
			'mailtype' => 'html', 'charset' => 'iso-8859-1', 'wordwrap' => TRUE);

			//$this->email->initialize($config);
			$this -> load -> library('email', $config);

			$this -> email -> set_newline("\r\n");
			$this -> email -> from($fromm, 'DDSR mSOS');
			// change it to yours
			$this -> email -> to($email);
			// change it to yours

			$this -> email -> subject('Password Reset:' . $name);
			$this -> email -> message($messages);

			if ($this -> email -> send()) {

			} else {
				show_error($this -> email -> print_debugger());
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

	public function deactive() {
		$id = $this -> uri -> segment(3);
		//$password='msos123';

		$pass1 = Doctrine::getTable('user') -> findOneById($id);
		$name = $pass1 -> fname;
		$email = $pass1 -> email;
		$pass = Doctrine::getTable('user') -> findOneById($id);
		//echo $pass->password
		$pass -> status = 0;
		$pass -> save();
		redirect("user_management/users_facility");
	}

	public function Change_pass() {
		$id = $this -> uri -> segment(3);
		$data['title'] = "Password Change";
		$data['content_view'] = "changefcpass";
		$data['banner_text'] = "Password Change";
		$data['link'] = "changefcpass";
		//$data['all'] = Incidence::get_confirmation($id);
		$data['quick_link'] = "changefcpass";
		//redirect("home_controller");
		$this -> load -> view("template", $data);
	}

	public function forgot_password() {
		$data = array();
		$data['title'] = "Forgot Password";
		$this -> load -> view("pass_forgot", $data);
	}

	public function forgot_pass_submit() {
		$user_email = $this -> input -> post("email_address");
		$user_search = User::get_userbyEmail($user_email);

		$checker = 0;
		foreach ($user_search as $fname) {
			if ($fname -> fname) {
				$checker = 1;
				echo "User with email address: $user_email, found. Names:$fname->fname.<br/>";
			} else {
				echo "User with email address, $user_email, was not found. Please try again!";
				break;
			}
		}
		if ($checker == 0) {
			echo "User with email address, $user_email, was not found. Please try again!";
		}
	}

	public function users_online() {
		$data["online_users"] = Logi::online_users();
		$data["banner_text"] = "Online Users";
		$data["content_view"] = "users_online";
		$this -> load -> view("template", $data);
	}

	public function check_username($username) {
		$username = trim($username);
		$response = array();
		$usedetail = User::getByUsername($username);
		$username_check = false;
		foreach ($usedetail as $details) {
			$username_check = true;
		}
		// if the username is blank
		if (!$username) {
			$response = array('ok' => false, 'msg' => "Please specify a username");

			// if the username does not match a-z or '.', '-', '_' then it's not valid
		} else if (!preg_match('/^[a-z0-9.-_]+$/', $username)) {
			$response = array('ok' => false, 'msg' => "Your username can only contain alphanumerics and period, dash and underscore (.-_)");

			// this would live in an external library just to check if the username is taken
		} else if ($username_check) {
			$response = array('ok' => false, 'msg' => "The selected username is not available");

			// it's all good
		} else {
			$response = array('ok' => true, 'msg' => "This username is free");
		}

		//return $response;
		return $response;
	}

	function json_response($username, $action) {
		//if (@$_REQUEST['action'] == 'check_username' && isset($_SERVER['HTTP_X_REQUESTED_WITH'])) {
		if (!isset($username) || $username == '') {
			$response = array('ok' => false, 'msg' => "Please specify a username");
			echo json_encode($response);
			exit ;
			// only print out the json version of the response
		}
		if ($action == "check_username") {
			echo json_encode($this -> check_username($username));
			exit ;
			// only print out the json version of the response
		}

	}

}// End of class
