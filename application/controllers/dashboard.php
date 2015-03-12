<?php
class dashboard extends CI_Controller {

	public function index() {
		$this -> home();
	}

	public function home() {
		$user_type = $this -> session -> userdata("user_indicator");
		if ($user_type == "Administrator") {
			$data['server_load'] = $this -> get_server_load();
			$data['Registered_Users'] = User::count_users();
			$data['reported_cases'] = Incidence::get_incidence_count();
			$data['reported_diseases'] = Incidence::get_disease_count();
			$data['confirmed_cases'] = Incidence::confirm();
			//print_r($this -> get_server_load());
			$this -> load -> view('Dashboard_v', $data);

		} else {
			redirect("home_controller");
		}

	}

	function get_server_load() {

		$cmd = 'typeperf  -sc 1  "\Processor(_Total)\% Processor Time"';
		exec($cmd, $lines, $retval);
		if ($retval == 0) {
			$values = str_getcsv($lines[2]);

			if ($this -> input -> is_ajax_request()) {
				echo json_encode(intval($values[1]), JSON_PRETTY_PRINT);
			} else {

				return intval($values[1]);
			}
		} else {
			return false;
		}

	}

}
