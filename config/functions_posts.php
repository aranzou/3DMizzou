<?php
require_once 'config/connect_db.php';

function getPost($location) {
	$mysqli = serverConnect();
	
	$query = "SELECT title, pageText FROM pages WHERE siteSector=?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('s', $location);
		
		$stmt->execute();
		
		$stmt->bind_result($title, $text);
		
		$stmt->fetch();
		
		$stmt->close();
				
		$row = array("title" => $title, "text" => $text);
	} 
	
	$mysqli->close();
	return $row;
}
?>