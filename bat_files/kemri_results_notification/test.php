<?php
require_once('C:\xampplite\htdocs\msos\bat_files\config.php');

$kemri_results="SELECT k . * , i.confirmation, i.lab_time, i.county, f.facility_name
FROM kemri_response k, incidence i, facility f
WHERE k.incident_id = i.p_id
AND k.notified =  '0'
AND i.disease_id =  '16'
AND f.facility_code = i.mfl_code";
$results=mysql_query($kemri_results) or die("Error: ".mysql_error());
if($results){

//-----Start of Loop-----///
while($data=mysql_fetch_assoc($results)){

if($data['notified']=='0'){
$messo="Kemri Lab Results: Ebola(".$data['incident_id'].") in ".$data['county']." County at ".$data['facility_name']." found as -> ".$data['confirmation'].". ".$data['lab_time'];
$message= rawurlencode($messo);
$sql="SELECT * FROM admin";
$doing=mysql_query($sql) or die("Error".mysql_error());

//--------start of loop---------//

while($sent_to=mysql_fetch_assoc($doing)){
//echo "Sent to: ".$sent_to['p_no']."<br/>";
$syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$sent_to[p_no]&text=$message");
$send_date=date('Y-m-d G:i:s',time());
$update_tbl="UPDATE kemri_response SET notified='1', date_notified='$send_date' WHERE incident_id='$data[incident_id]'";
$update_results=mysql_query($update_tbl) or die("Error: ".mysql_error());
}

//-----------End of loop-----------//

}

}
//-------End of loop------//

}




?>