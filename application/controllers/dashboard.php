<?php
class dashboard extends CI_Controller {

	public function index() {
		$this -> dashboard_v1();
	}

	public function dashboard_v1() {
		$user_type = $this -> session -> userdata("user_indicator");
		if ($user_type == "Administrator") {
			//$data['server_load'] = $this -> get_server_load();
			$data['Registered_Users'] = User::count_users();
			$data['reported_cases'] = Incidence::get_incidence_count();
			$data['reported_diseases'] = Incidence::get_disease_count();
			$data['confirmed_cases'] = Incidence::confirm();
			$data['registered_facilities'] = Facility::count_registered_facilities();
			$data['rate_report'] = $this -> reporting_rate_graph('2014');
			//print_r($this -> get_server_load());
			$this -> load -> view('Dashboard_v', $data);

		} else {
			redirect("home_controller");
		}

	}

	public function dashboard_v2() {

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

	public function ip() {
		if ($this -> input -> is_ajax_request()) {

			$check_ip = System_Visits::load_unique_ips();

			$show_out = $check_ip -> count();
			echo json_encode($show_out, JSON_PRETTY_PRINT);
		} else {
			$user_ip = $this -> input -> ip_address();
			$ips = System_Visits::check_ip($user_ip);
			if ($ips) {
				//echo 'ip check: '.$ips;
			} else {
				$ipz = new System_Visits();
				$ipz -> ip_address = $user_ip;

			}
			//print_r($check_ip->toArray());
		}
	}

	function reporting_rate_graph($year) {
		$get_db_dat = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("select monthname(time) as Month, 
  year(time) as Year, count(id) as total  
from incidence WHERE year(time)='$year'
group by monthname(time), year(time)");
		//print_r($get_db_dat);
		$rows = array();
		$rows['name'][] = "Kajiado and Busia";
		foreach ($get_db_dat as $db_data) {
			$rows['data'][] = $db_data['total'];
		}
		$result_1 = array();
		array_push($result_1, $rows);
		return $result_1;
		//echo json_encode($result_1,JSON_NUMERIC_CHECK);
	}

	function geolocate() {
		?>
<script type="text/javascript" src="//js.maxmind.com/js/apis/geoip2/v2.1/geoip2.js"></script>
 
<script type="text/javascript">
 
var onSuccess = function(location){
  alert(
      "Lookup successful:\n\n"
      + JSON.stringify(location, undefined, 4)
  );
};
 
var onError = function(error){
  alert(
      "Error:\n\n"
      + JSON.stringify(error, undefined, 4)
  );
};
 
geoip2.city(onSuccess, onError);
 
</script><?php
	}

	function ip_details($ip) {
		$json = file_get_contents("http://ipinfo.io/{$ip}");
		$details = json_decode($json);
		print_r($details);
		//return $details;
	}

}
