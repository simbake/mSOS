<?php
class weekly_controller extends MY_controller {
	
	
	function __construct() {
		parent::__construct();
		$this -> load -> helper('url');

	}
	
	public function index() {

		$this -> all_weekly();
	}
	
	public function all_weekly(){
		//$this->load->model('weekly_summary_db');
		
		$data['title'] = "Weekly Summary";
		$data['content_view'] = "weekly_summary_view";
		$data['banner_text'] = "Weekly Facilities Summary";
		$data['link'] = "weekly_summary_db";
		$date_today=date('l');
			/*	if($date_today=="Monday"){
				$datee=date_create()->format('Y-m-d');
				
				$data['all'] = weekly_summary_db::weekly_summary_view($datee);
				}*/
				//else{	
	     $data['all'] = weekly_summary_db::weekly_summary_views();
		       //  }
		$data['quick_link'] = "weekly_summary_db";
		$this -> load -> view("template", $data);
			
	}
	public function week_summary_report() {
	$date_today="date('l')";
				/*if($date_today=="Monday"){
				$datee=date_create()->format('Y-m-d');	
				$all = weekly_summary_db::weekly_summary_view($datee);
				}*/
				//else{
		$all = weekly_summary_db::weekly_summary_views();
		        // }
		//$all = Logi::getAll();
		$data = '<table style="margin-left: 0;" border=1 width="80%">';

		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis</td></tr>';
		$data .= '<td><table style="margin-left: 0;" border=1 width="80%">
					<thead>
				<tr>
				<th style="text-align:left;">Facility Name</th>
				<th style="text-align:left;">Date</th>
				<th style="text-align:left;">Day</th>
				<th style="text-align:left;">County</th>
				<th style="text-align:left;">Contact</th>
				<th style="text-align:left;">Phone</th>
				<th style="text-align:left;">System report</th>
				<th style="text-align:left;">Facility report</th>
				</tr>
				</thead>';
		foreach ($all as $row) :
		         $a = $row->date_week ;
						$dates = new DateTime($a);
                         
				$data .= '
						<tr>
				<td style="text-align:left;">'. $row -> Facility->Facility_name .'</td>
				<td style="text-align:left;">'. $dates->format('jS F Y g:i A') .'</td>
			     <td style="text-align:left;">'. $dates->format('l') .'</td>
				<td style="text-align:left;">'. $row -> Facility-> county .'</td>
				<td style="text-align:left;">'. $row -> Facility-> contact.' </td>
				<td style="text-align:left;">'. $row -> Facility-> phone_number.' </td>
				<td style="text-align:left;">'. $row -> sys_number .'</td>
				<td style="text-align:left;">'. $row -> facility_no .'</td>
			</tr>';
			endforeach;

		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		//$day="Monday";
		//echo $day;
		$filename = "weekly summary";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}
	
}
