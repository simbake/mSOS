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
			exit ;
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
		exit ;
	}

	public function login_user() {
		//Post data
		$username = $this -> input -> post('username');
		$password = $this -> input -> post('password');
		$user_ip = $this -> input -> ip_address();
		$user_agent = $this -> input -> user_agent();

		//Check db for validity of the credentials
		$reply = User::login($username, $password);
		$n = $reply->toArray();
		$myvalue = $n['usertype_id'];
		$namer = $n['fname'];
		$user_id = $n['id'];
		$district = $n['district'];
		$county = $n['county'];
		$status = $n['status'];
		$rrt_sms=$n['rrt_sms'];
		$ebola_login =0;
		$password = $n['password'];
		$token_key = $n['reset_token'];
		if ($status == 0) {
			$myvalue = null;
		}

		if ($myvalue == 1) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Administrator");
		} else if ($myvalue == 2) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "MOH");
		} else if ($myvalue == 5) {
			if($rrt_sms>0){
			$ebola_login='1';	
			}
			else{
			$ebola_login='0';	
			}
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "KEMRI", 'ebola_login' => $ebola_login);
		} else if ($myvalue == 4) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "District Administrator", 'district' => $district);
		} else if ($myvalue == 3) {
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "County Administrator", 'county' => $county);
		} else if ($myvalue == 7) {
			$ebola_login=1;
			$session_data = array('full_name' => $namer, 'user_level' => $myvalue, 'user_id' => $user_id, 'user_indicator' => "Rapid Response", 'ebola_login' => $ebola_login);
		}
		if (($session_data == "" || $session_data == null)) {
			
				$this -> session -> set_flashdata("login_check", 1);
				redirect("user_management/login");
				exit ;

		} else {
       if ($token_key != "" || $token_key != null) {
				$this -> session -> set_flashdata("token_check", 1);
				redirect("user_management/login");
				exit ;
			}
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
				exit ;

			} else {
				redirect("home_controller");
				exit ;
			}

		}

	}

	public function change_pass_login() {
		$data = array();
		$data['title'] = "Change Password";
		$data['banner_text'] = "Change Password";
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
		
		$username = trim($this -> input -> post('username'));
		// strip ay whitespaces
		$username_check = $this -> check_username($username);

		$email = $this -> input -> post('email');
		$name1 = $this -> input -> post('fname');
		$name2 = $this -> input -> post('lname');
		//$password="msos123";
		$password = "msos123";
		//$id = $this -> input -> post('facility');
		$province = $this -> input -> post('county');
		$district = $this -> input -> post('subcounty');
		$user_access = $this -> input -> post('type');
        $rrt_notify=0;
		if($user_access==1 || $user_access==5 || $user_access==7){
			
		$rrt_notify=$this->input->post('rrt_notify');
		
		}

		if ($user_access == 1 || $user_access == 2 || $user_access == 5 || $user_access==7) {
			$province = "Null";
			$district = "Null";
		} else if ($user_access == 3) {
			$district = "Null";
		} else if ($user_access == 4) {
			$province = "Null";
		}
		$u = new User();
		$u -> fname = $name1;
		$u -> email = $email;
		$u -> username = $username;
		$u -> password = $password;
		$u -> usertype_id = $user_access;
		$u -> telephone = $this -> input -> post('tell');
		$u -> county = $province;
		$u -> district = $district;
		$u -> facility = $this -> input -> post('facility');
		$u->rrt_sms=$rrt_notify;
		$u -> save();

		redirect("user_management/users_facility");

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

		redirect("home_controller");

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

	public function forgot_pass_submit() {

		$this -> load -> library('encrypt');
		$user_email = $this -> input -> post('email');
		$token_time = date('Y-m-d G:i:s', time());
		$encrypt_string = $user_email . $token_time;
		$reset_token = $this -> encrypt -> sha1($encrypt_string);
		$reset_token_url = urlencode($reset_token);
		if ($user_email != '') {

			if (valid_email($user_email)) {

				$user_search = User::get_userbyEmail($user_email);

				if ($user_search['user_fname']) {
					$message = "<strong>Dear " . $user_search['user_fname'] . ",</strong><br/>
                               A password reset request was initialized for mSOS. Please use the link below to reset your password:<br />
							   <br/>
							   <a target='_blank' href='" . base_url() . "user_management/reset_password_email/" . $reset_token_url . "'>Reset Link</a>
							    <br />
							   <br/>
						Please note that this link will be active for only 5 minutes.
							   Contact administrator for additional issues through the email address.
						
                                                <br />
                                                <br />
												<strong>Kind Regards,<br />
											   The mSOS Team.</strong>";
					$sql_email = mysql_real_escape_string($user_email);
					$q = Doctrine_Query::create() -> update('User') -> set('reset_token', '?', $reset_token) -> set('token_generated', '?', $token_time) -> where("email = '$sql_email'");
					$q -> execute();
					$email_response = $this -> send_email($user_search['user_fname'], $user_email, $message);
					if ($email_response['ok'] == true) {

						header('Content-Type: application/json');
						echo json_encode("Reset link was sent to the email address.");
					} else {

						header('Content-Type: application/json');
						echo json_encode("An error was encountered. Please try again later.");
					}
				} else {
					header('Content-Type: application/json');
					echo json_encode("User with email address, $user_email, was not found. Please try again!");
				}
			} else {
				header('Content-Type: application/json');
				echo json_encode("Please Enter a valid email address!");
			}
		} else {
			header('Content-Type: application/json');
			echo json_encode("Please submit an email to continue!");
		}
	}

	public function send_email($fname, $email, $message) {
		$email_response = array();

		if (valid_email($email)) {// validate email. Returns false if email is not valid
			$data['fname'] = $fname;
			$data['email'] = $email;
			$data['message'] = $message;
			$message = $this -> load -> view("email_template", $data, true);

			$config['protocol'] = 'smtp';
			$config['smtp_host'] = 'ssl://smtp.gmail.com';
			$config['smtp_port'] = '465';
			$config['smtp_timeout'] = '7';
			$config['smtp_user'] = 'ddsrmsos@gmail.com';
			$config['smtp_pass'] = 'Y1MR3Wq3pn';
			$config['charset'] = 'utf-8';
			$config['newline'] = "\r\n";
			$config['mailtype'] = 'html';
			// or html
			$config['validation'] = TRUE;
			// bool whether to validate email or not

			$this -> load -> library('email', $config);
			$this -> email -> initialize($config);

			$this -> email -> set_newline("\r\n");
			$this -> email -> from('ddsrmsos@gmail.com');
			// change it to yours
			$this -> email -> to($email);
			// change it to yours
			$this -> email -> bcc('');
			$this -> email -> subject('mSOS Password Reset');
			$this -> email -> message($message);

			if ($this -> email -> send()) {
				return $email_response = array("ok" => true, "email_message" => "Message sent successfull");
			} else {
				return $email_response = array("ok" => false, "email_message" => show_error($this -> email -> print_debugger()));
			}
		} else {

			return $email_response = array("ok" => false, "email_message" => "Invalid email");
		}
	}

	public function reset_password_email($token_key) {
		$user_reset = User::get_userBy_token($token_key);
		if ($user_reset) {

			$date_now = date("Y-m-d G:i:s");
			$date_now = new datetime($date_now);
			$user_reset = new datetime($user_reset);
			$difference_date = $date_now -> diff($user_reset);
			if ($difference_date -> format('%y') > 0 || $difference_date -> format('%m') > 0 || $difference_date -> format('%d') > 0 || $difference_date -> format('%h') > 0 || $difference_date -> format('%i') > 5) {
				/*$u=$q = Doctrine_Query::create() -> update('User') -> set('reset_token', '?', '') -> set('token_generated', '?', '0000-00-00 00:00:00') -> where("reset_token = '$token_key'");
				 $u->execute();*/
				$data['token_control'] = "Invalid";
				$data['error_message'] = 'The reset token has expired. Please note that tokens are valid for 5 minutes only.';
				$this -> load -> view("reset_password", $data);
			} else {
				$data['token_control'] = "Valid";
				$this -> load -> view("reset_password", $data);
			}

		} else {
			$data['token_control'] = "Invalid";
			$data['error_message'] = 'The token key is invalid.';
			$this -> load -> view("reset_password", $data);
		}
	}

	public function reset_password_submit() {
		$new_pass = $this -> input -> post('new_pass');
		$pass = $this -> input -> post('pass');
		$user_token = $this -> input -> post('token_key');
		if ((!empty($new_pass) || !empty($pass)) && ($new_pass == $pass)) {
			$salt = '#*seCrEt!@-*%';
			$old_pass = ( md5($salt . $pass));
			$token_time = "0000-00-00 00:00:00";
			$user_token = mysql_real_escape_string($user_token);
			$q = Doctrine_Query::create() -> update('User') -> set('password', '?', $old_pass) -> set('reset_token', '?', '') -> set('token_generated', '?', $token_time) -> where("reset_token = '$user_token'");
			/*$u=Doctrine::getTable('user') -> where("reset_token = '$user_token'");
			 $u->password=$old_pass;
			 $u->reset_token="";
			 $u->token_generated="0000-00-00 00:00:00";
			 $u->save();*/
			$result = $q -> execute();
			header('Content-Type: application/json');
			if ($result == 0) {
				echo json_encode("Not fine - > $pass : $old_pass");
			} else {
				echo json_encode("Not fine - > $pass : $old_pass");
			}
		} else {
			header('Content-Type: application/json');
			echo json_encode("Empty values");
		}
	}

}// End of class
