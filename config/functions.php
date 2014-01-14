<?php
include_once 'functions_misc.php';
include_once 'functions_users.php';


if($_GET['f']=="rsvp") {
	$date = date("Y-m-d H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];
	if(insertRSVP($_POST['eventid'], $_POST['name'], $_POST['email'], $_POST['pawprint'], $date, $ip)) {
		echo 'You have successfully been added to the RSVP';
	} else {
		if(existsRSVP($_POST['eventid'], $_POST['pawprint'])) {
			echo 'You have already been added to the RSVP';
		} else {
		 	echo 'Error: Please check your form.';
		}
	}
} else if ($_GET['f']=="updateprofile") {

	if(updateUserProfile($_POST['userid'], $_POST['firstname'], $_POST['lastname'], $_POST['email'], $_POST['currentmajor'], $_POST['yearschool'])) {
		echo 1;
	} else {
		echo 'Error: Unable to update profile!';
	}
} else if ($_GET['f']=="userrsvp") {
	$userID = getUserID($_POST['pawprint']);
	$meminfo = getMemberInfo($userID);
	$name = $meminfo['firstname'] . ' ' . $meminfo['lastname'];
	
	$date = date("Y-m-d H:i:s");
	$ip = $_SERVER['REMOTE_ADDR'];
	if(insertRSVP($_POST['eventid'], $name, $meminfo['email'], $_POST['pawprint'], $date, $ip)) {
		echo 'You have successfully been added to the RSVP';
	} else {
		if(existsRSVP($_POST['eventid'], $_POST['pawprint'])) {
			echo 'You have already been added to the RSVP';
		} else {
		 	echo 'Error: Please check your form.';
		}
	}
} else if ($_GET['f']=="userunrsvp") {
	unRSVP($_POST['eventid'], $_POST['pawprint']);
	echo 'You have successfully been removed from the RSVP form!';
} else if ($_GET['f']=="unsubscribe") {
	if(unsubscribe_email($_POST['email'])) {
		echo 'You have successfully been removed from our mailing list.';
	} else {
		echo 'Error: E-mail not registered for newsletters. Please contact us at support@3dmizzou.org';
	}
}
?>