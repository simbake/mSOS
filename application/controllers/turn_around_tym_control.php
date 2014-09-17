<?php
if (!defined('BASEPATH'))
	exit('No direct script access allowed');
	
class turn_around_tym_control extends MY_Controller {
function __construct() {
		parent::__construct();
		$this->load->helper('url');
		
	}
	public function index() {

		$this -> turn_around_tbl_view();
	}
public function turn_around_tbl_view(){
        $data['title'] = "Turn Around Time";
		$data['content_view'] = "turn_around_tbl_view";
		$data['banner_text'] = "Turn Around Time";
		$data['link'] = "turn_around_tbl_view";
	    //$data['all'] = Incidence::get_All();
		$data['quick_link'] = "turn_around_tbl_view";
		$this -> load -> view("template", $data);


}

public function report_download_excel(){

$data = '<table style="margin-left: 0;" border=1 width="80%">';
           $generated = date("Y-m-d G:i:s", time());
		   $fgt=new datetime($generated);
		$data .= '<tr><td style="font-weight: bold; text-align:left;">DDSR Data Analysis   |     Generated: '. $fgt->format('j F, Y g:i A').'</td></tr>';
		$data .= '<td><table style="margin-left: 0;" border=1 width="80%">
					<thead>
				<tr>
				<th style="text-align:left;">Incident Id</th>
				<th style="text-align:left;">Alert Date</th>
				<th style="text-align:left;">District Response Date</th>
				<th style="text-align:left;">Alert-District Elapsed Time</th>
				<th style="text-align:left;">Kemri Response Time</th>
				<th style="text-align:left;">District-Kemri Elapsed Time</th>
				<th style="text-align:left;">Alert-Kemri Elapsed Time</th>
				</thead>';
		$fetch_incidence = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT k.*,i.* FROM incidence i,kemri_response k WHERE i.p_id=k.incident_id");
                foreach($fetch_incidence as $row):
				
                $fetch_log = Doctrine_Manager::getInstance() -> getCurrentConnection() -> fetchAll("SELECT district_incident FROM incident_log WHERE incident_id='$row[id]'");
				 foreach($fetch_log as $rowz):
				 $g = $rowz['district_incident'];
								$g = explode('|', $g);
								$no=count($g);
								if($no>=5){
								//$act = $g[0];
								//$note = $g[1];
								//$find = $g[2];
								$tim = $g[3];
								//$take = $g[4];
								$dttg = new DateTime($tim);
								}
								$a=$row['time']; $dt = new DateTime($a);
                                 $interval = date_diff($dt, $dttg);
								 $b=$row['lab_time']; $dts = new DateTime($b);
								 $intervals = date_diff($dttg, $dts);
								 $intervalz = date_diff($dt, $dts);
				$data .= '
						<tr>
				<td style="text-align:left;">'. $row['p_id'] .'</td>
				<td style="text-align:left;">'. $dt->format('j F, Y g:i A') .'</td>
			
				<td style="text-align:left;">'. $dttg->format('j F, Y g:i A') .'</td>
				<td style="text-align:left;"><strong>'. $interval->format('%a days %h hours %i minutes %s seconds').'</strong> </td>
				<td style="text-align:left;">'. $dts->format('j F, Y g:i A').' </td>
				<td style="text-align:left;"><strong>'. $intervals->format('%a days %h hours %i minutes %s seconds') .'</strong></td>
				<td style="text-align:left;"><strong>'. $intervalz->format('%a days %h hours %i minutes %s seconds') .'</strong></td>
			</tr>';
			endforeach;
			endforeach;

		$data .= '</tbody></table></td>';

		$data .= '</table>';
		$time = date("Y-m-d G:i:s", time());
		//$day="Monday";
		//echo $day;
		$filename = "Turn Around Time";
		header("Content-type: application/x-msdownload");
		header("Content-Disposition: attachment; filename=$filename.xls");
		echo "$data";
	}

}

