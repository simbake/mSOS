<?php
include "dbconnect.php";
$connection=new dbConnect();
$connection->connect();

$kemri_results="SELECT k . * , i.lab_results, i.lab_time, i.incidence_location FROM kemri_response_ebola k, incidence_ebola i WHERE k.incident_id = i.msos_code AND k.notified = '0'";
$results=mysql_query($kemri_results) or die("mySQL Error: ".mysql_error());
if($results){

//-----Start of Loop-----///
while($data=mysql_fetch_assoc($results)){
$incident_id=$data['incident_id'];
if($data['notified']=='0'){
$messo="Kemri Lab Results: Ebola incident ID: ".$data['incident_id'].", Location: ".$data['incidence_location']." found as: ".$data['lab_results'].". Lab time:  ".$data['lab_time'];
$message= rawurlencode($messo);
$sql="SELECT * FROM user WHERE (sms='1' OR sms='2') AND status='1'";
$doing=mysql_query($sql) or die("Error".mysql_error());

//--------start of loop---------//

while($sent_to=mysql_fetch_assoc($doing)){
//echo "Sent to: ".$sent_to['p_no']."<br/>";
$syncmumrecord = file_get_contents("http://sms.sourcecode.co.ke:8080/api/send?username=ddsr_msos&password=9dd4441ee182db1231b40e3b8c86750f&source=DDSR_mSOS&destination=$sent_to[telephone]&text=$message");
}

//-----------End of loop admins-----------//
$send_date=date('Y-m-d G:i:s',time());
$update_tbl="UPDATE kemri_response_ebola SET notified='1', date_notified='$send_date' WHERE incident_id='$incident_id'";
$update_results=mysql_query($update_tbl) or die("Error: ".mysql_error());
}

}
//-------End of loop kemri response------//

}




?>