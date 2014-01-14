<?php
include_once '/var/www/3dmizzou/config/connect_db.php';

function isAdminUser($username) {
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
	if($access_lvl=="" || $access_lvl==0) {
		return false;
	}
	return true;
}

function getOfficer($pos) {
	$mysqli = serverConnect();
	
	$query = "SELECT p1.userID, p1.profilePic, p2.posName, p1.officerBio, p1.favQuote, p1.facebookURL, p1.linkedinURL, p1.googleplusURL FROM officers p1, officer_position p2 WHERE p1.officerPos = p2.positionID AND p1.officerPos = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('s', $pos);
		
		$stmt->execute();
		
		$stmt->bind_result($userid, $profile, $position, $bio, $quote, $facebook, $linkedin, $googleplus);
		
		$stmt->fetch();
		
		$stmt->close();
		
		$memberinfo = getMemberInfo($userid);
				
		$officerinfo = array("userid" => $userid, 
					 "first" => $memberinfo["firstname"],
					 "last" => $memberinfo["lastname"],
					 "bio" => $bio, 
					 "pos" => $position,
					 "profilePic" => $profile,
					 "userID" => $userid,
					 "schoolYear" => $memberinfo["schoolYear"],
					 "major" => $memberinfo["major"],
					 "facebook" => $facebook,
					 "linkedin" => $linkedin,
					 "googleplus" => $googleplus,
					 "quote" => $quote);
	} 
	
	$mysqli->close();
	return $officerinfo;
}

function getOfficerByID($id) {
	$mysqli = serverConnect();
	
	$query = "SELECT p2.posName, p1.officerBio, p1.favQuote FROM officers p1, officer_position p2 WHERE p1.officerPos = p2.positionID AND p1.userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
		
		$stmt->bind_result($position, $bio, $quote);
		
		$stmt->fetch();
		
		$stmt->close();
		
		$memberinfo = getMemberInfo($id);
				
		$officerinfo = array(
					 "firstname" => $memberinfo["firstname"],
					 "lastname" => $memberinfo["lastname"],
					 "bio" => $bio, 
					 "pos" => $position,
					 "schoolYear" => $memberinfo["schoolYear"],
					 "pawprint" => $memberinfo["pawprint"],
					 "major" => $memberinfo["major"],
					 "registerDate" => $memberinfo["registerDate"],
					 "quote" => $quote);
	} 
	
	$mysqli->close();
	return $officerinfo;
}

function getUsername($id) {
	$mysqli = serverConnect();
	
	$query = "SELECT firstname, lastname FROM users WHERE userID=?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
		
		$stmt->bind_result($firstname, $lastname);
		
		$stmt->fetch();
		
		$stmt->close();
				
		$row = array("first" => $firstname, "last" => $lastname);
	} 
	
	$mysqli->close();
	return $row;
}

function getUserID($pawprint) {
	$mysqli = serverConnect();
	
	$query = "SELECT userID FROM users WHERE pawprint=?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('s', $pawprint);
		
		$stmt->execute();
		
		$stmt->bind_result($userID);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $userID;
}

function getMemberInfo($userID) {
	$mysqli = serverConnect();
	
	$query = "SELECT username, firstname, lastname, pawprint, email, approved, major, schoolYear, registerDate FROM users WHERE userID=?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
		
		$stmt->bind_result($username, $firstname, $lastname, $pawprint, $email, $approved, $major, $schoolYear, $registerDate);
		
		$stmt->fetch();
		
		$stmt->close();
				
		$row = array("username" => $username,
					 "firstname" => $firstname,
					 "lastname" => $lastname,
					 "pawprint" => $pawprint,
					 "email" => $email,
					 "approved" => $approved,
					 "major" => $major,
					 "schoolYear" => $schoolYear,
					 "registerDate" => $registerDate);
	} 
	
	$mysqli->close();
	return $row;
}

function getOfficerMemberInfo() {
	$mysqli = serverConnect();
	
	$query = "SELECT username, firstname, lastname, pawprint, email, approved, major, schoolYear, registerDate FROM users WHERE userType = (SELECT positionID FROM member_type WHERE name = 'Officer') ORDER BY firstname";

	if ($mysqli->multi_query($query)) {
		do {
			/* store first result set */
			if ($result = $mysqli->store_result()) {
				$result_array = array();
				$count = 0;
					while ($row = $result->fetch_row()) {	
						$result_array[$count] = 						
							array("username" => $row[0],
								 "firstname" => $row[1],
								 "lastname" => $row[2],
								 "pawprint" => $row[3],
								 "email" => $row[4],
								 "approved" => $row[5],
								 "major" => $row[6],
								 "schoolYear" => $row[7],
								 "registerDate" => $row[8]);
						$count++;
					}
				$result_array["count"] = $result->num_rows-1;
				$result->free();
			}
		} while ($mysqli->next_result());
	}

	$mysqli->close();
	return $result_array;
}

function getTechMemberInfo() {
	$mysqli = serverConnect();
	
	$query = "SELECT username, firstname, lastname, pawprint, email, approved, major, schoolYear, registerDate FROM users WHERE userType = (SELECT positionID FROM member_type WHERE name = 'Tech Member') ORDER BY firstname";

	if ($mysqli->multi_query($query)) {
		do {
			/* store first result set */
			if ($result = $mysqli->store_result()) {
				$result_array = array();
				$count = 0;
					while ($row = $result->fetch_row()) {	
						$result_array[$count] = 						
							array("username" => $row[0],
								 "firstname" => $row[1],
								 "lastname" => $row[2],
								 "pawprint" => $row[3],
								 "email" => $row[4],
								 "approved" => $row[5],
								 "major" => $row[6],
								 "schoolYear" => $row[7],
								 "registerDate" => $row[8]);
						$count++;
					}
				$result_array["count"] = $result->num_rows-1;
				$result->free();
			}
		} while ($mysqli->next_result());
	}

	$mysqli->close();
	return $result_array;
}

function getActiveMemberInfo() {
	$mysqli = serverConnect();
	
	$query = "SELECT username, firstname, lastname, pawprint, email, approved, major, schoolYear, registerDate FROM users WHERE userType = (SELECT positionID FROM member_type WHERE name = 'Active Member') ORDER BY firstname";

	if ($mysqli->multi_query($query)) {
		do {
			/* store first result set */
			if ($result = $mysqli->store_result()) {
				$result_array = array();
				$count = 0;
					while ($row = $result->fetch_row()) {	
						$result_array[$count] = 						
							array("username" => $row[0],
								 "firstname" => $row[1],
								 "lastname" => $row[2],
								 "pawprint" => $row[3],
								 "email" => $row[4],
								 "approved" => $row[5],
								 "major" => $row[6],
								 "schoolYear" => $row[7],
								 "registerDate" => $row[8]);
						$count++;
					}
				$result_array["count"] = $result->num_rows-1;
				$result->free();
			}
		} while ($mysqli->next_result());
	}

	$mysqli->close();
	return $result_array;
}

function createMember($first, $last, $type, $pawprint, $email, $major, $schoolyear, $date) {
	$mysqli = serverConnect();
	
	//A little bit of formatting before submitting the query
	$pawprint = strtolower($pawprint[0]);
	$email = strtolower($email);
	
	$query = "INSERT INTO users (email, firstname, lastname, userType, major, pawprint, schoolYear, username, registerDate) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('sssdsssss', $email, $first, $last, $type, $major, $pawprint, $schoolyear, $pawprint, $date);
		
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

function updateUserProfile($userId, $first, $last, $email, $major, $schoolYear) {
	$mysqli = serverConnect();
	
	$query = "UPDATE users SET firstname=?, lastname=?, email=?, major=?, schoolYear=? WHERE userID=?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ssssss', $first, $last, $email, $major, $schoolYear, $userId);

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

function getRSVPcount($id) {
	$mysqli = serverConnect();
	
	$query = "SELECT count(pawprint) FROM rsvp WHERE eventID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('d', $id);
		
		$stmt->execute();
				
		$stmt->bind_result($useramt);
		
		$stmt->fetch();
		
		$stmt->close();
	} 
	
	$mysqli->close();
	return $useramt;
}

function isOfficer($userID) {
	$mysqli = serverConnect();
	
	$query = "SELECT userID FROM users WHERE userType = (SELECT positionID FROM member_type WHERE name = 'Officer') AND userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {	
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->bind_result($results);
		
		$stmt->fetch();
		
		$stmt->close();
		
		if($results == $userID) {
			$mysqli->close();
			return true;
		}
	} 
	
	$mysqli->close();
	return false;
}

function addAvatarInfo($userID, $type, $size, $img_name, $date) {
	$mysqli = serverConnect();
	
	$query = "INSERT INTO avatars (userID, imageSize, imageType, uploadDate, avatarURL) VALUES (?, ?, ?, ?, ?)";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('dssss', $userID, $size, $type, $date, $img_name);

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

function modifyAvatarInfo($userID, $type, $size, $img_name, $date) {
	$mysqli = serverConnect();
	
	$query = "UPDATE avatars SET imageSize = ?, imageType = ?, uploadDate = ?, avatarURL = ? WHERE userID = ?";
	$stmt = $mysqli->stmt_init();
	
	if ($stmt = $mysqli->prepare($query)) {
		$stmt->bind_param('ssssd', $size, $type, $date, $img_name, $userID);

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

function getAvatar($userID) {
	$mysqli = serverConnect();
	
	$query = "SELECT avatarURL FROM avatars WHERE userID = ?";
	$stmt =  $mysqli->stmt_init();

	if ($stmt = $mysqli->prepare($query)) {	
		$stmt->bind_param('d', $userID);
		
		$stmt->execute();
				
		$stmt->bind_result($avatarURL);
		
		$stmt->fetch();
		
		$stmt->close();
		
		if(!isset($avatarURL)) {
			$avatarURL = "placeholder.jpg";
		}
		
	} 
	
	$mysqli->close();
	return $avatarURL;
}

function getMemberType() {
	$memArray = array();
	$mysqli = serverConnect();
	$query = "SELECT * FROM member_type";
	$count = 0;
	
	if ($mysqli->multi_query($query)) {
		do {
			/* store first result set */
			if ($result = $mysqli->store_result()) {
				while ($row = $result->fetch_row()) {
					$memArray[$count] = array("name" => $row[1], "id" => $row[0]);
					$count++;
				}
				$result->free();
			}
		} while ($mysqli->next_result());
		$memArray["count"] = $count;
	}
	return $memArray;
}

function getEarnedBadges($userID) {
    if(!is_numeric($userID)) {
       return; 
    }
    
    $memArray = array();
    $mysqli = serverConnect();
    $query = "SELECT badgeID, name, img_url FROM badges WHERE badgeID IN (SELECT badgeID FROM badgesAwarded WHERE userID=" . $userID . ") ORDER BY category ASC";
    $count = 0;

    if ($mysqli->multi_query($query)) {
            do {
                    /* store first result set */
                    if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                    $memArray[$count] = array("badge" => $row[0], "name" => $row[1], "image" => $row[2]);
                                    $count++;
                            }
                            $result->free();
                    }
            } while ($mysqli->next_result());
    }
    return $memArray;    
}

function getEarnedBadgesByCategory($userID, $category) {
    if(!is_numeric($userID)) {
       return; 
    }
    
    $memArray = array();
    $mysqli = serverConnect();
    $query = "SELECT badgeID, name, img_url FROM badges WHERE badgeID IN (SELECT badgeID FROM badgesAwarded WHERE userID=" . $userID . " AND category = " . $category . ") ORDER BY category ASC";
    $count = 0;

    if ($mysqli->multi_query($query)) {
            do {
                    /* store first result set */
                    if ($result = $mysqli->store_result()) {
                            while ($row = $result->fetch_row()) {
                                    $memArray[$count] = array("badge" => $row[0], "name" => $row[1], "image" => $row[2]);
                                    $count++;
                            }
                            $result->free();
                    }
            } while ($mysqli->next_result());
    }
    return $memArray;    
}

?>