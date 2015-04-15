<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
class Cron_jobs extends MY_Controller {

	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}

	public function index() {
		die("Not allowed");
	}

	public function do_foo() {
		echo "hello fool. Seems it was successfull :-)";
	}

	public function rrt_locationSubmit_reminder() {

		$incidence = incidence_ebola::get_null_locations();

		foreach ($incidence as $message_details) {
			foreach ($message_details->ebl_numbers as $user) {

				$message = "Hello " . $user -> fname . ". Please send the location of the following events: " . $message_details -> mSOS_id;

				$msg_send = rawurlencode($message);

				$syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=" . $message_details -> reported_by . "&text=$msg_send");

			}
		}
		$this->test();

	}

	public function test() {
		$incidence = incidence_ebola::getAll_null_locations();
		$message_rrt_admin = "The location of the following cases has not been reported: ";
		$now = date("Y-m-d G:i:s", time());
		$now = new DateTime($now);
		foreach ($incidence as $incidence_details) {
			$incidence_time = $incidence_details -> incidence_time;
			$incidence_time = new Datetime($incidence_time);
			$difference = $incidence_time -> diff($now);
			//echo $difference -> format("%h hours")."<br/>";
			if ($difference -> format("%h hours") >= 3) {
				$message_time = $this -> time_elapsed_human($incidence_details -> incidence_time, time());
				$message_rrt_admin .= "$incidence_details->msos_code -> " . $message_time . " ";
			} else {
				die("None found");
			}

		}
		$message_rrt_admin .= ".Please follow it up. Thanks";

		$msq_encode = rawurlencode($message_rrt_admin);
		//echo $msq_encode;
		$syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=254729928476&text=$msq_encode");

	}

	/*
	 header('Content-Type: application/json');
	 echo json_encode($incidence->toArray(), JSON_PRETTY_PRINT);
	 */
}
