<?php
class graphz extends CI_Controller{
	
	public function index(){
		$this->graphz_test();
	}
	
	public function graphz_test(){
		
	$this->load->view("graphz_v.php");
	
	}
	
}