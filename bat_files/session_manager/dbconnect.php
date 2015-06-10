<?php
class dbConnect{
	
private $server_name="localhost";
private $username="root";
private $pass="";
private $conn;
private $dbname="idsr_alert";
private $select;
public function connect(){
	//$conn = mysql_connect($server_name,$username,$pass)
	global $conn;/* 
 	$conn=new MySQLi($server_name,$username,$pass,$dbname)
or die("cannot connect".mysql_error());*/
global $username,$password,$dbname;
$conn =mysql_connect("localhost","root", "SDG@Dfvnt67tr4") ;
	if(!$conn) {
		die('Failed to connect to server: ' . mysql_error());
	}
	else{
	//echo "connection successful";	
	$dbs =mysql_select_db("idsr_alert");
	//$db = mysql_select_db(DB_DATABASE);
	if(!$dbs) {
		die("Unable to select database ").mysql_error();
	}
	}
	
	//Select database
	
	

}

}
?>