 <?php
      define('DB_HOST','localhost');
	  define('DB_USER','root');
	  define('DB_PASSWORD','FnP5FjbnMrzXCm');
	  define('DB_DATABASE','idsr_alert');
	  $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	  $db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}
	
	/*define('DB_HOST','localhost');
	  define('DB_USER','root');
	  define('DB_PASSWORD','p@55w0rddv1');
	  define('DB_DATABASE','idsr_alert');
	  $link = mysql_connect(DB_HOST, DB_USER, DB_PASSWORD);
	if(!$link) {
		die('Failed to connect to server: ' . mysql_error());
	}
	  $db = mysql_select_db(DB_DATABASE);
	if(!$db) {
		die("Unable to select database");
	}*/
?>