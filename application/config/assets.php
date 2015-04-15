<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

if(isset($_SERVER['SERVER_NAME'])){
$config['assets_url'] = 'http://'.$_SERVER['SERVER_NAME'].'/mSOS/assets/';
}
else{
	$config['assets_url'] = 'http://localhost/mSOS/assets/';
}

/* End of file assets.php */
/* Location: ./application/config/assets.php */