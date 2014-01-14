<?php 
require_once '/var/www/3dmizzou/config/connect_db.php';

function insertRSVP($eventID, $name, $email, $pawprint, $date, $ip) {
	$mysqli = serverConnect();
	
	$query = "INSERT INTO rsvp(eventID, name, email, pawprint, dateRegistered, ipaddress) VALUES (?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ssssss', $eventID, $name, $email, $pawprint, $date, $ip);
		
		$stmt->execute();
		
		$rowsAffected = $stmt->affected_rows;
						
		$stmt->close();
				
		if($rowsAffected > 0) {
			$mysqli->close();
			return true;
		}
				
	} 
	$mysqli->close();
	
	return false;
}


function existsRSVP($eventID, $pawprint) {
	$mysqli = serverConnect();
	
	$query = "SELECT count(pawprint) FROM rsvp WHERE pawprint=? AND eventID=?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('sd', $pawprint, $eventID);
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		if($useramt > 0) {
			return $useramt;
		}
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function availableRSVP() {

}

function unRSVP($eventID, $pawprint) {
	$mysqli = serverConnect();
	
	$query = "DELETE FROM rsvp WHERE eventID = ? and pawprint = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ds', $eventID, $pawprint);
		
		$stmt->execute();
				
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
}

function unsubscribe_email($email) {
	$mysqli = serverConnect();
	
	$query = "UPDATE users SET email_announcements = '0' WHERE email = ?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('s', $email);

		$stmt->execute();
		
		$rowsAffected = $stmt->affected_rows;
						
		$stmt->close();
		
		if($rowsAffected > 0) {
			$mysqli->close();
			return true;
		}
				
	} 
	$mysqli->close();
	
	return false;
}

function getrsvpeventslist() {
    $memArray = array();
    $mysqli = serverConnect();
    $query = "SELECT eventID, eventName, description, Location, capacity, eventDate FROM events ORDER BY eventDate";
    $count = 0;

    if ($mysqli->multi_query($query)) {
            do {
                    /* store first result set */
                    if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                    $memArray[$count] = array("id" => $row[0], "name" => $row[1], "description" => $row[2], "location" => $row[3], "max" => $row[4], "date" => $row[5]);
                                    $count++;
                            }
                            $result->free();
                    }
            } while ($mysqli->next_result());
    }
    return $memArray;
}

function getrsvpeventscalendar() {
    $memArray = array();
    $mysqli = serverConnect();
    $query = "SELECT p1.eventID, p1.eventName, p1.eventDate, p2.typeColor FROM events p1, eventTypes p2 WHERE p1.eventType = p2.typeID ORDER BY eventDate";
    
    $count = 0;
    if ($mysqli->multi_query($query)) {
            do {
                    /* store first result set */
                    if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                    $memArray[$count] = array("id" => $row[0], "name" => $row[1], "date" => $row[2], "color" => $row[3]);
                                    $count++;
                            }
                            $result->free();
                    }
            } while ($mysqli->next_result());
    }
    return $memArray;
}

?>