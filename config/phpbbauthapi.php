<?php
if($_GET['r']!='tiger') {
	die();
}
include_once '../config/connect_db.php';

$passString = $_POST['pass'];
$passArray = explode("=", $passString);
$password = $passArray[1];

//Create the phpBB environment for the script
define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '/var/www/3dmizzou/forum/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);
include($phpbb_root_path . 'common.' . $phpEx);

// Start session management
$user->session_begin();
$auth->acl($user->data);
$user->setup();

if($user->data['is_registered']) {
    echo 'Error: User already logged in';
} else {
	if(isset($_POST['username'])&&isset($password)) {
		$result = $auth->login($_POST['username'], $password, $autologin = false, $viewonline = 1, $admin = 0);
		
		if($result['status']==LOGIN_SUCCESS) {
			echo '1';
		} else {
			 if($result['error_msg']=="LOGIN_ERROR_PASSWORD" || $result['error_msg']=="LOGIN_ERROR_USERNAME") echo "Error: Incorrect Username or Password";
			 else if($result['error_msg']=="LOGIN_ERROR_ACTIVE" || $result['error_msg']=="ACTIVE_ERROR") echo "This account has not been activated by e-mail.";
			 else echo $result['error_msg'];
		}
		
	} else {
		echo 'Error: Invalid Fields!';
	}
}

?>