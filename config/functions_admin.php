<?php
require_once '/var/www/3dmizzou/config/connect_db.php';

function isAdmin($username) {
	$mysqli = serverConnect();
	
	$query = "SELECT access_lvl FROM officer_position WHERE positionID = (SELECT officerPos FROM officers WHERE userID = (SELECT userID FROM users WHERE username = ?))";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('s', $username);
		
		$stmt->execute();
				
		$stmt->bind_result($access_lvl);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	if($access_lvl=="") {
		$access_lvl=0;
	}
	return $access_lvl;
}

function getUserType($userID) {
	$mysqli = serverConnect();
	
	$query = "SELECT userType FROM users WHERE userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->bind_result($type);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $type;
}

function countUsers() {
	$mysqli = serverConnect();
	
	$query = "SELECT count(userID) FROM users";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function countMembers() {
	$mysqli = serverConnect();
	
	$query = "SELECT count(userID) FROM users WHERE userType != 5 AND userType != 6";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function countUnapproved() {
	$mysqli = serverConnect();
	
	$query = "SELECT count(userID) FROM users WHERE approved=0;";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function removeUser($userID) {
	$mysqli = serverConnect();
	
	$query = "DELETE FROM users WHERE userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
}
		
function updateUser($userId, $username, $pawprint, $first, $last, $email, $status, $major, $schoolYear, $type) {
	$mysqli = serverConnect();
	
	$query = "UPDATE users SET username=?, pawprint=?, firstname=?, lastname=?, email=?, approved=?, major=?, schoolYear=?, userType=? WHERE userID=?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ssssssssss', $username, $pawprint, $first, $last, $email, $status, $major, $schoolYear, $type, $userId);

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

function updateOfficer($userID, $bio, $quote) {
	$mysqli = serverConnect();
	
	$query = "UPDATE officers SET officerBio=?, favQuote=? WHERE userID = ?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ssd', $bio, $quote, $userID);
		
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

function removeOfficer($userID) {
	$mysqli = serverConnect();
	
	$query = "DELETE FROM officers WHERE userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
}

function getOfficerProfile($userID) {
	$mysqli = serverConnect();
	
	$query = "SELECT count(userID) FROM users WHERE approved=0";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function getEventInfo($eventID) {
	$mysqli = serverConnect();
	
	$query = "SELECT eventName, eventType, description, Location, capacity, eventDate FROM events WHERE eventID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $eventID);
		
		$stmt->execute();
		
		$stmt->bind_result($eventName, $eventType, $description, $location, $capacity, $eventDate);
		
		$stmt->fetch();
		
		$stmt->close();
					 
                $row = array(                "name" 			=> $eventName,
                                             "type"                  => $eventType,
                                             "description"           => $description,
                                             "location"		=> $location,
                                             "capacity"		=> $capacity,
                                             "date"			=> $eventDate);
	} 
	
	$mysqli->close();
	return $row;
}

function getAllEventInfo() {
	$mysqli = serverConnect();
	
	$query = "SELECT eventID, eventName, eventType, description, Location, capacity, eventDate FROM events";
                
            if ($mysqli->multi_query($query)) {
                do {
                        /* store first result set */
                        if ($result = $mysqli->store_result()) {
                                $result_array = array();
                                $count = 0;
                                        while ($row = $result->fetch_row()) {
                                                $eventType = getEventType($row[2]);
                                                $result_array[$count] = 						
                                                        array(  "id"                    => $row[0],
                                                                "name" 			=> $row[1],
                                                                "type"                  => $eventType,
                                                                "description"           => $row[3],
                                                                "location"		=> $row[4],
                                                                "capacity"		=> $row[5],
                                                                "date"			=> $row[6]);
                                                $count++;
                                        }
                                $result->free();
                        }
                } while ($mysqli->next_result());

	} 
	
	$mysqli->close();
	return $result_array;
}

function getAllEventTypes() {
$mysqli = serverConnect();
	
	$query = "SELECT typeID, typeName FROM eventTypes";
                
            if ($mysqli->multi_query($query)) {
                do {
                        /* store first result set */
                        if ($result = $mysqli->store_result()) {
                                $result_array = array();
                                $count = 0;
                                        while ($row = $result->fetch_row()) {	
                                                $result_array[$count] = 						
                                                        array(  "id"                    => $row[0],
                                                                "name"                    => $row[1]);
                                                $count++;
                                        }
                                $result->free();
                        }
                } while ($mysqli->next_result());

	} 
	
	$mysqli->close();
	return $result_array;
}

function getEventType($id) {
    $mysqli = serverConnect();
	
	$query = "SELECT typeName FROM eventTypes WHERE typeID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
		
		$stmt->bind_result($typeName);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $typeName;
}

function updateEventInfo($eventID, $eventName, $eventType, $description, $location, $capacity, $eventDate) {
	$mysqli = serverConnect();
	
	$query = "UPDATE events SET eventName = ?, eventType=?, description=?, Location=?, capacity=?, eventDate=? WHERE eventID = ?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('sdssssd', $eventName, $eventType, $description, $location, $capacity, $eventDate, $eventID);
		
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

function deleteEvent($eventID) {
	$mysqli = serverConnect();
	
	$query = "DELETE FROM events WHERE eventID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $eventID);
		
		$stmt->execute();
				
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
}

function createEvent($eventName, $description, $location, $type, $capacity, $eventDate, $created) {
	$mysqli = serverConnect();
        
	$query = "INSERT INTO events (eventName, description, Location, eventType, capacity, eventDate, dateAdded) VALUES (?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('sssdsss', $eventName, $description, $location, $type, $capacity, $eventDate, $created);
		
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

function getGroupEmails($group) {
	$mysqli = serverConnect();
	$query = "SELECT email FROM users WHERE userType = " . $group . " AND email_announcements = 1";
	$count = 1;
	$emailArray = array();
	
	if ($mysqli->multi_query($query)) {
		do {
			if ($result = $mysqli->store_result()) {
				while ($row = $result->fetch_row()) {
					$emailArray[$count] = $row[0];
					$count++;
				}
				$result->free();
			}
		} while ($mysqli->next_result());
	}
	return $emailArray;
}

function sendEmail($group, $subject, $message) {
	$mem_types = explode(" ", $group);
	
	$email_message = file_get_contents("../includes/email_header.html");
	$email_message .= $message;
	$email_message .= file_get_contents("../includes/email_footer.html");
	
	$count = 0;
	while($count != (count($mem_types)-1)) {
		$emails = getGroupEmails($mem_types[$count]);
		
		$headers = 
		'MIME-Version: 1.0' . "\r\n" .
		'Content-Type: text/html; charset=ISO-8859-1' . "\r\n" .
		'From: 3DPC@3dmizzou.org' . "\r\n" .
		'Reply-To: support@3dmizzou.org' . "\r\n" .
		'X-Mailer: PHP/' . phpversion();
		
		$count2 = 1;
		while($count2 <= count($emails)) {		
			mail($emails[$count2], $subject, $email_message, $headers);
			$count2++;
		}
						
		$count++;
	}
}

function getBadgeCategories() {
	$mysqli = serverConnect();
	$query = "SELECT * FROM badgeCategories";
	$count = 1;
	$catArray = array();
	
	if ($mysqli->multi_query($query)) {
		do {
			if ($result = $mysqli->store_result()) {
				while ($row = $result->fetch_row()) {
					$catArray[$count] = array("id" => $row[0], "name" => $row[1], "description" => $row[2]);
					$count++;
				}
				$result->free();
			}
		} while ($mysqli->next_result());
	}
	return $catArray;
}

function getBadgesByCategory($id) {
	$mysqli = serverConnect();
	$query = "SELECT * FROM badges WHERE category = " . $id;
	$count = 1;
	$badgeArray = array();
	
	if ($mysqli->multi_query($query)) {
		do {
			if ($result = $mysqli->store_result()) {
				while ($row = $result->fetch_row()) {
					$badgeArray[$count] = array("id" => $row[0], "name" => $row[1], "description" => $row[2], "category" => $row[3], "image" => $row[4]);
					$count++;
				}
				$result->free();
			}
		} while ($mysqli->next_result());
	}
	return $badgeArray;
}

function getBadge($id) {
	$mysqli = serverConnect();
	$query = "SELECT name, description, category, img_url FROM badges WHERE badgeID = ?";

	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
		
		$stmt->bind_result($name, $description, $category, $imgurl);
		
		$stmt->fetch();
		
		$stmt->close();
					 
	    $row = array(    "name"    => $name,
                             "description"  => $description,
                             "category" => $category,
                             "image" => $imgurl
            );
	} 
	
	$mysqli->close();
	return $row;
}

function getOpenOfficerPositions() {
	$mysqli = serverConnect();
	$query = "SELECT positionID, posName FROM officer_position WHERE positionID NOT IN (SELECT officerPos FROM officers)";
	$officerArray = array();
	
	if ($mysqli->multi_query($query)) {
		do {
			if ($result = $mysqli->store_result()) {
				while ($row = $result->fetch_row()) {
					$officerArray[$count] = array("id" => $row[0], "name" => $row[1]);
					$count++;
				}
				$result->free();
			}
		} while ($mysqli->next_result());
	}
	$officerArray["count"] = ($count);
	return $officerArray;
}

function getOfficerPosition($id) {
	$mysqli = serverConnect();
	
	$query = "SELECT positionID, posName FROM officer_position WHERE positionID = (SELECT officerPos FROM officers WHERE userID = ? )";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
		
		$stmt->bind_result($positionID, $posName);
		
		$stmt->fetch();
		
		$stmt->close();
					 
	   $row = array("id" 			=> $positionID,
	   				"name"	=> $posName,
					);
	} 
	
	$mysqli->close();
	return $row;
}

function updateOfficerPosition($userID, $positionID) {
	$mysqli = serverConnect();
	
	$query = "UPDATE officers SET officerPos = ? WHERE userID = ?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('dd', $positionID, $userID);

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

function setOfficerPosition($userID, $positionID) {
	$mysqli = serverConnect();
	
	$query = "INSERT INTO officers (userID, officerPos) VALUES (?, ?)";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('dd', $userID, $positionID);
		
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

function addBadge($name, $description, $category) {
    $mysqli = serverConnect();
    $query = "INSERT INTO badges (name, description, category) VALUES (?, ?, ?)";
    $stmt = $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('sss', $name, $description, $category);

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

function deleteBadge($badgeID) {
    $mysqli = serverConnect();
	
	$query = "DELETE FROM badges WHERE badgeID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $badgeID);
		
		$stmt->execute();
				
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
}

function createCategories($name, $description) {
    $mysqli = serverConnect();
    $query = "INSERT INTO badgeCategories (cat_name, cat_description) VALUES (?, ?)";
    $stmt = $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('ss', $name, $description);

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

function editBadges($name, $description, $category, $badgeID) {
    $mysqli = serverConnect();
    $query = "UPDATE badges SET name=?, description=?, category=? WHERE badgeID = ?";
    $stmt = $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('sssd', $name, $description, $category, $badgeID);

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

function getCategory($id) {
    $mysqli = serverConnect();
    $query = "SELECT cat_name, cat_description FROM badgeCategories WHERE catID = ?";

    $stmt =  $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('d', $id);

            $stmt->execute();

            $stmt->bind_result($name, $description);

            $stmt->fetch();

            $stmt->close();

        $row = array(    "name"    => $name,
                         "description"  => $description,
        );
    } 

    $mysqli->close();
    return $row;
}

function editCategoryByID($id, $name, $description) {
    $mysqli = serverConnect();
    $query = "UPDATE badgeCategories SET cat_name=?, cat_description=? WHERE catID = ?";
    $stmt = $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('ssd', $name, $description, $id);

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

function deleteCategory($id) {
    $mysqli = serverConnect();
    $query = "DELETE FROM badgeCategories WHERE catID = ?";
    $stmt =  $mysqli->stmt_init();

    if ($stmt = $mysqli->prepare($query)) {
            $stmt->bind_param('d', $id);

            $stmt->execute();

            $stmt->fetch();

            $stmt->close();
    } 

    $mysqli->close();
}

function addbadgetouser($badges, $userID) {        
    $mysqli = serverConnect();
    $count=0;
    while($count < count($badges)) {
        $query = "INSERT INTO badgesAwarded (badgeID, userID) VALUES (?, ?)";
        $stmt = $mysqli->stmt_init();

        if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('dd', $badges[$count], $userID);

                $stmt->execute();

                $stmt->close();
        } 
        $count++;
    }
	
    $mysqli->close();
	return true;
}

function removebadgefromuser($badges, $userID) {
    $mysqli = serverConnect();
    $count=0;
    while($count < count($badges)) {
        $query = "DELETE FROM badgesAwarded WHERE badgeID=? AND userID=?";
        $stmt = $mysqli->stmt_init();
        
        if ($stmt = $mysqli->prepare($query)) {
                $stmt->bind_param('dd', $badges[$count], $userID);
        
                $stmt->execute();
                
                $stmt->close();
        } 
        $count++;
    }
	
    $mysqli->close();
	return true;
}

function validate_regpassword($password)
{
	if ($password === '')
	{
		// Password empty or no password complexity required.
		return 'EMPTY_PASS';
	} else if (strlen($password)<5||strlen($password)>100) {
		return 'PASS_LENGTH';
	}

	$pcre = $mbstring = false;

	// generic UTF-8 character types supported?
	if ((version_compare(PHP_VERSION, '5.1.0', '>=') || (version_compare(PHP_VERSION, '5.0.0-dev', '<=') && version_compare(PHP_VERSION, '4.4.0', '>='))) && @preg_match('/\p{L}/u', 'a') !== false)
	{
		$upp = '\p{Lu}';
		$low = '\p{Ll}';
		$num = '\p{N}';
		$sym = '[^\p{Lu}\p{Ll}\p{N}]';
		$pcre = true;
	}
	else if (function_exists('mb_ereg_match'))
	{
		mb_regex_encoding('UTF-8');
		$upp = '[[:upper:]]';
		$low = '[[:lower:]]';
		$num = '[[:digit:]]';
		$sym = '[^[:upper:][:lower:][:digit:]]';
		$mbstring = true;
	}
	else
	{
		$upp = '[A-Z]';
		$low = '[a-z]';
		$num = '[0-9]';
		$sym = '[^A-Za-z0-9]';
		$pcre = true;
	}

	$chars = array();

	//Require symbols
	//$chars[] = $sym;

	// Require mixed case letters and numbers
	//$chars[] = $num;

	// Require mixed case letters
	//$chars[] = $low;
	//$chars[] = $upp;

	if ($pcre)
	{
		foreach ($chars as $char)
		{
			if (!preg_match('#' . $char . '#u', $password))
			{
				return 'Error: ';
			}
		}
	}
	else if ($mbstring)
	{
		foreach ($chars as $char)
		{
			if (mb_ereg($char, $password) === false)
			{
				return 'INVALID_CHARS';
			}
		}
	}

	return false;
}
?>