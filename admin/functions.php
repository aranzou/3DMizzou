<?php
include_once 'config/auth.php';
include_once '../config/functions_admin.php'; 

function deniedAccess() {
	echo 'Access Denied! You do not have access to perform this function.';
	die();
}

if(!accessLevelVerify(1, $user->data['username_clean'])) {
	deniedAccess();
}

	include_once '../config/functions_users.php';

	if($_POST['action']=="deleteUser") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
	
		removeUser($_POST['id']);
		//deleteUserPHPBB($_POST['username']);
	} else if ($_POST['action']=="updateUser") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
		$result = 0;	
		if(updateUser($_POST['id'], $_POST['username'], $_POST['pawprint'], $_POST['first'], $_POST['last'], $_POST['email'], $_POST['status'], $_POST['major'], $_POST['schoolYear'], $_POST['type'])) {
			$result++;
		}
		
		if($_POST['position']!="") {
			if($_POST['type']==6) {
				if($_POST['currentPos']>0) {
					if(updateOfficerPosition($_POST['id'], $_POST['position'])) {
						$result++;
					}
				} else {
					if(setOfficerPosition($_POST['id'], $_POST['position'])) {
						$result++;
					}
				}
			} else {
				removeOfficer($_POST['id']);
			}
		}
                
        $original = getEarnedBadges($_POST['id']);
        
        $badgeArray = explode(" ", $_POST['badges']);
        sort($badgeArray, SORT_NUMERIC);
        
        $add = array();
        $remove = array();
        $arr1count=0; $arr2count=1;
        while($original[$arr1count]["badge"]!="" && $badgeArray[$arr2count]!="") {
            if($original[$arr1count]["badge"] < $badgeArray[$arr2count]) {
                array_push($remove, $original[$arr1count]["badge"]);
                $arr1count++;
            } else if ($original[$arr1count]["badge"] > $badgeArray[$arr2count]) {
                array_push($add, $badgeArray[$arr2count]);
                $arr2count++;
            } else if ($original[$arr1count]["badge"] == $badgeArray[$arr2count]) {
                $arr1count++;
                $arr2count++;
            }
        }
        
        if($arr1count==count($original)||$arr1count==0) {
            while($arr2count!=count($badgeArray)) {
                array_push($add, $badgeArray[$arr2count]);
                $arr2count++;
            }
        }
		if ($arr2count==count($badgeArray)||$arr2count==1) {
            while($arr1count!=count($original)) {
                array_push($remove, $original[$arr1count]["badge"]);
                $arr1count++;
            }
        }
		                
		if($add[0]!="") {
			if(addbadgetouser($add, $_POST['id'])) {
				$result++;
			}
		} 
		
		if($remove[0]!="") {
			if(removebadgefromuser($remove, $_POST['id'])) {
				$result++;
			}
		}
						
		if($result>0) {
			echo "User has successfully been updated!";
		} else {
			echo "Error: The update has failed.";
		}
		
	} else if ($_POST['action']=="officer_delete") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
		removeOfficer($_POST['id']);
	} else if ($_POST['action']=="officer_update") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(1, $user->data['username_clean'])) {
			deniedAccess();
		}
		
		if(updateOfficer($_POST['id'], $_POST['bio'], $_POST['quote'])) {
			echo 'User has successfully been updated!';
		} else {
			echo 'Error: The update has failed.';
		}
	} else if ($_POST['action']=="updateEvent") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
		
		if(updateEventInfo($_POST['id'], $_POST['eventName'], $_POST['type'], $_POST['description'], $_POST['location'], $_POST['capacity'], $_POST['eventDate'])) {
			echo 'Event has successfully been updated!';
		} else {
			echo 'Error: The update has failed.';
		}
	} else if ($_POST['action']=="deleteEvent") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
		
		deleteEvent($_POST['id']);
	} else if ($_POST['action']=="createEvent") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}
		
		if(createEvent($_POST['eventName'], $_POST['description'], $_POST['location'], $_POST['type'], $_POST['capacity'], $_POST['eventDate'], $_POST['dateCreated'])) {
			echo 'Event has successfully been created!';
		} else {
			echo 'Error: Unable to create event... :(';
		}
	} else if ($_POST['action']=="sendEmail") {
		/* ACCESS AUTHORIZATION CHECK */
		if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
		}

		sendEmail($_POST['type'], $_POST['subject'], $_POST['message']);
		echo "E-mail(s) have been sent.";
	} else if ($_POST['action']=="addBadge") {
            /* ACCESS AUTHORIZATION CHECK */
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            if(addBadge($_POST['name'], $_POST['description'], $_POST['category'])) {
                echo 'Badge has successfully been added';
            } else {
                echo 'Error: Unable to add badge.';
            }
        } else if ($_POST['action']=="deleteBadge") {
            /* ACCESS AUTHORIZATION CHECK */
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            deleteBadge($_POST['id']);
        } else if ($_POST['action']=='editBadge') {
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            if(editBadges($_POST['name'], $_POST['description'], $_POST['category'], $_POST['badgeID'])) {
                echo 'Badge has successfully been edited';
            } else {
                echo 'Error: Unable to edit badge.';
            }
        } else if($_POST['action']=='addCategory') {
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            if(createCategories($_POST['name'], $_POST['description'])) {
                echo 'Category has successfully been added';
            } else {
                echo 'Error: Unable to add Category.';
            }    
        } else if($_POST['action']=='editCategory') {
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            if(editCategoryByID($_POST['id'], $_POST['name'], $_POST['description'])) {
                echo 'Category has successfully been edited';
            } else {
                echo 'Error: Unable to edit category.';
            }    
        } else if($_POST['action']=='deleteCategory') {
            if(!accessLevelVerify(4, $user->data['username_clean'])) {
			deniedAccess();
            }
            
            deleteCategory($_POST['id']); 
        }
	
?>