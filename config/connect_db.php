<?php
function serverConnect() {
	$host="localhost";
	$user="printclub";
	$password="D2UpFDFumCPZmx8j";
	$dbname="printclub_site";
	
	//Server Instance
	$result = new mysqli($host, $user, $password, $dbname);
	
	if (!$result) die ('ERROR: DEAD');
	return $result;
}

function execQuery($query, $params, $close) {
	$mysqli = serverConnect();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param($params);
		
		$stmt->execute();
		
		$result = $stmt->get_result();
		
		$row = $result->fetch_assoc();
		
		$stmt->close();
	}
	
	$mysqli->close();
	return $row;
}
?>
