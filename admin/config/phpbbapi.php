<?php
/* Administrative Side of phpBB */
include_once '../../config/connect_db.php';
//include 'functions_users.php';
//include 'functions_admin.php';

define('IN_PHPBB', true);
$phpbb_root_path = (defined('PHPBB_ROOT_PATH')) ? PHPBB_ROOT_PATH : '../../forum/';
$phpEx = substr(strrchr(__FILE__, '.'), 1);

// The common.php file is required.
include($phpbb_root_path . 'common.' . $phpEx);
require($phpbb_root_path . 'includes/functions_user.' . $phpEx);


//user_delete('retain', $rtn, $username); 
?>