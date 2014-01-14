<?php
if($_GET['r']!='tiger') {
	die();
}

include_once '../config/connect_db.php';
include 'functions_users.php';
include 'functions_admin.php';

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../forum/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// The common.php file is required.
include($phpbb_root_path . 'common.' . $phpEx);
require($phpbb_root_path . 'includes/functions_user.' . $phpEx);

if(isset($_POST['pawprint'])) {
    $pawprint = $_POST['pawprint'];
    //Standard User
    $type = 4;
    $group_id = 8;
} else if(isset($_POST['username'])) {
    $pawprint = $_POST['username'];
    //NonStandard User
    $type = 7;
    $group_id = 9;
    $_POST["yearschool"] = "";
    $_POST["major"] = "";
}

if(user_get_id_name($pawprint, $user_type = false)) {
	$passString = $_POST['pass'];
	$password = end(explode("=", $passString));
		
	if(validate_regpassword($password)) {
		die();
	}
	
	if(createMember($_POST["first"], $_POST["last"], $type, $pawprint, $_POST["email"], $_POST["major"], $_POST["yearschool"], date("Y-m-d H:i:s"))) {
		echo '1';
	} else {
		echo 'Error: Unable to register on website...';
		die();
	}
} else {
	echo 'Error: Already Registered on the Website!';
	die();
}

$user_type = USER_INACTIVE;
$username = array_shift($pawprint);
$user_email = $_POST['email'];
$user_ip = $_SERVER['REMOTE_ADDR'];
$user_inactive_reason = INACTIVE_REGISTER;
$registration_time = time();
$user_actkey = gen_rand_string(mt_rand(6, 10));

$user_row = array(
	'username'              => $username,
	'user_password'         => phpbb_hash($password),
	'user_email'            => $user_email,
	'group_id'              => (int) $group_id,
	'user_type'             => $user_type,
	'user_actkey'			=> $user_actkey,
	'user_ip'               => $user_ip,
	'user_inactive_reason'  => $user_inactive_reason,
	'user_regdate'          => $registration_time
);

// Register user...
$user_id = user_add($user_row);

if ($user_id === false)
{
	echo 'Error: Unable to register on the forums..';
	//trigger_error('NO_USER', E_USER_ERROR);
} 

//Now we send the activation email
$message = $user->lang['ACCOUNT_INACTIVE'];
$email_template = 'user_welcome_inactive';

include_once($phpbb_root_path . 'includes/functions_messenger.' . $phpEx);

$messenger = new messenger(false);

$messenger->template($email_template, 'en_US');

$messenger->to($user_row['user_email'], $user_row['username']);

//$messenger->anti_abuse_headers($config, $user);

$server_url = 'http://www.3dmizzou.org/forum';

$messenger->assign_vars(array(
	'WELCOME_MSG'	=> htmlspecialchars_decode(sprintf($user->lang['WELCOME_SUBJECT'], $config['sitename'])),
	'USERNAME'		=> htmlspecialchars_decode($_POST['pawprint']),
	'U_ACTIVATE'	=> "$server_url/ucp.$phpEx?mode=activate&u=$user_id&k=$user_actkey")
);

$messenger->send(NOTIFY_EMAIL);

?>