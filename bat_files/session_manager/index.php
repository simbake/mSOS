<?php
include "dbconnect.php";
//include "../msos/system/libraries/session.php";
$connection=new dbConnect();
$connection->connect();

$sql="SELECT * FROM session_activity WHERE active='0'";
$query=mysql_query($sql);
if($query){
while($res=mysql_fetch_assoc($query)){

$activity_tym=$res['last_activity'];
$activity=new datetime($activity_tym);
$tym=date('Y-m-d G:i:s',time());
$current_tym=new datetime($tym);

//echo $activity_tym." Current tym: ".$tym."<br/>";
//echo "session id: ".$res['session_id']."<br/>";
$interval = date_diff($activity, $current_tym);
$period=$interval->format('%i');
//echo $current_tym->format('G')."<br/>";
//echo $period;
if($period>=6){
//echo "$period <br/>";
$sq="SELECT * FROM logi WHERE id='$res[logi_id]' AND status='Active'";
$retunz=mysql_query($sq);
$results=mysql_fetch_assoc($retunz);
if($results){
$sqlz="UPDATE logi SET status='Inactive',t_logout='$tym' WHERE id='$results[id]'";
$checkz=mysql_query($sqlz);
$sqls="UPDATE session_activity SET active='1' WHERE logi_id='$results[id]' AND active='0'";
$checkz=mysql_query($sqls);

if(!$checkz){
//echo "Error occurred: ".mysql_error();
}
if(!$checkz){
//echo "Error occurred: ".mysql_error();
}
}
else{
//echo "sql error: ".mysql_error();
}

}
else{
//echo "Not greater than 5 <br/>";

}
//echo "<strong>".$interval->format('%R%a days %h hours %i minutes %s seconds')."</strong><br/>";
}

}
else{
//echo "Error or no files found: ".mysql_error();
}
//echo "<script>window.close();</script>";
?>
