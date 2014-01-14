<?php 
include 'header.html'; 
include_once 'config/functions_users.php';
include_once 'config/functions_misc.php';
include_once 'config/functions_images.php';

if(!$user->data['is_registered']) {
	echo "Error: User is not logged in.";
	die();
}

$userID = getUserID($user->data['username_clean']);
$memarray = getMemberInfo($userID);

?>
<div class="container">
	<div class="four columns">
		<div class="headline"><h3>Menu</h3></div>
		<div id="sidebar">
			<ul>
				<li><a href="profile.php?p=profile">Profile Info</a></li>
				<li><a href="profile.php?p=rank">Badges/Rank Info</a></li>
				<li><a href="profile.php?p=rsvp">RSVP Future Meetings</a></li>
			</ul>
		</div>
	</div>
	
	<?php	
		if(!isset($_GET['p'])) {
			$_GET['p']="profile";
		}
	
		if($_GET['p']=="profile") {
			$title = "Profile Info";
		} else if ($_GET['p']=="rank") {
			$title = "Badges/Rank";
		} else if ($_GET['p']=="rsvp") {
			$title = "RSVP Center";
		} else if ($_GET['p']=="avatar") {
			$title = "Upload an Avatar";
		}
	?>
	<div class="twelve columns">
		<div class="headline"><h3><? echo $title; ?></h3></div>
		<?php
		if($_GET['p']=="profile") {
			?>
			<div class="success-message">
				<div class="notification success closeable">
					<p><span>Success!</span> You have updated your profile!</p>
				</div>
			</div>
			<div class="profile_edit">
				<form method="post" action="">
					<input type="hidden" name="username" value="<? echo $userID; ?>"/>
					<table border=0>
						<tr><td><span>Username: </span></td><td><? echo $memarray['username']; ?></td></tr>
						<tr><td><span>First Name: </span></td><td><input type="text" name="firstname" class="text" value="<? echo $memarray['firstname']; ?>" /></td></tr>
						<tr><td><span>Last Name: </span></td><td><input type="text" name="lastname" class="text" value="<? echo $memarray['lastname']; ?>" /></td></tr>
						<tr><td><span>PawPrint: </span></td><td><? echo $memarray['pawprint']; ?></td></tr>
						<tr><td><span>E-Mail: </span></td><td><input type="text" name="email" class="text" value="<? echo $memarray['email']; ?>" /></td></tr>
						<tr><td><span>Current Major: </span></td><td><input type="text" name="currentmajor" class="text" value="<? echo $memarray['major']; ?>" /></td></tr>
						<tr><td><span>Year in School: </span></td><td>
							  <select type="text" id="yearschool" class="dropdown" >
							  <option value="Freshman" <? if ($memarray['schoolYear']=="Freshman") echo 'selected="selected"'; ?>>Freshman</option>
							  <option value="Sophmore" <? if ($memarray['schoolYear']=="Sophmore") echo 'selected="selected"'; ?>>Sophmore</option>
							  <option value="Junior" <? if ($memarray['schoolYear']=="Junior") echo 'selected="selected"'; ?>>Junior</option>
							  <option value="Senior" <? if ($memarray['schoolYear']=="Senior") echo 'selected="selected"'; ?>>Senior</option>
							  <option value="SeniorPlus" <? if ($memarray['schoolYear']=="SeniorPlus") echo 'selected="selected"'; ?>>Senior +</option>
							</select>
						</td></tr>
						<tr><td><span>Registered On: </span></td><td><? echo $memarray['registerDate']; ?></td></tr>
						<tr><td><span>Avatar: </span><br />(Click to edit)</td><td><div class="userelements"><a href="profile.php?p=avatar"><img src="uploads/profile/<? echo getAvatar($userID); ?>" /></a></div></td></tr>
					</table>
					
					<br /><br />
					<div class="field">
						<input type="button" id="mainprofile" value="Update Info"/>
						<div class="loading"></div>
					</div>
				
				</form>
			</div>
			<?
		} else if ($_GET['p']=="rank") {
		?>
			<div class="warning-message">
			<div class="notification warning">
				<p><span>Notice!</span> This feature is coming soon!</p>
			</div>
			</div>
		<?
		} else if ($_GET['p']=="rsvp") { ?>
           <link rel='stylesheet' type='text/css' href='js/jquery/fullcalendar/fullcalendar.css' />
           <link rel='stylesheet' type='text/css' href='js/jquery/fullcalendar/fullcalendar.print.css' media='print' />
           <script type='text/javascript' src='js/jquery/fullcalendar/fullcalendar.min.js'></script>
           <script type='text/javascript'>

                   $(document).ready(function() {

                           $('#calendar').fullCalendar({

                                   editable: false,

                                   events: "config/calendar_config.php",
                                   eventColor: "grey",

                                   loading: function(bool) {
                                           if (bool) $('#loading').show();
                                           else $('#loading').hide();
                                   },
                                   
                                   eventClick: function(calEvent, jsEvent, view) {
                                        $( "#dialog-" + calEvent.id).dialog( "open" );
                                   }
                           });

                   });

           </script>
           <style type='text/css'>
                   #loading {
                           position: absolute;
                           top: 5px;
                           right: 5px;
                           }

                   #calendar {
                           width: 100%;
                           margin: 0 auto;
                           text-align: center;
                           font-size: 14px;
                           font-family: "Lucida Grande",Helvetica,Arial,Verdana,sans-serif;
                           }

           </style>

           <div id='loading' style='display:none'>loading...</div>
           <div id='calendar'></div>
           
           <? 
           $events = getrsvpeventslist();
           $count=0;
           while($count < count($events)) {
               $rsvpcount = getRSVPcount($events[$count]["id"]);
               $date = date_create($events[$count]["date"]);
					
               if($rsvpcount > $events[$count]["max"]) {
                    $rsvpcount = $events[$count]["max"];
               }
           ?>
                <script>
                        $(function() {
                                $( "#progressbar<? echo $events[$count]["id"]; ?>" ).progressbar({
                                        value: <? echo $rsvpcount; ?>,
                                        max: <? echo $events[$count]["max"]; ?>
                                });
                        });
                        
                        $(function() {
                                $('.rsvpfull<? echo $events[$count]["id"]; ?>').hide();

                                <? if(existsRSVP($events[$count]["id"], $user->data['username_clean'])) { ?>
                                        $('.rsvp<? echo $events[$count]["id"]; ?>').hide();
                                <? } else { ?>
                                        $('.rsvplock<? echo $events[$count]["id"]; ?>').hide();
                                <? } ?>
                        });
                        
                        $(function() {
                            $( "#dialog-<? echo $events[$count]["id"]; ?>" ).dialog({
                              autoOpen: false,
                              resizable: false,
                              width: 500,
                              modal: true,
                              buttons: {
                                Cancel: function() {
                                  $( this ).dialog( "close" );
                                }
                              }
                            });
                         });
                </script>
                
                    <div id="dialog-<? echo $events[$count]["id"]; ?>" title="<? echo $events[$count]["name"]; ?> (<? echo date_format($date, 'l jS F Y \a\t g:ia'); ?>)">
                        <ul class="tabs-nav">
                                <li class="active"><a href="#tab1">Location</a></li>
                                <li><a href="#tab2">Description</a></li>
                        </ul>

                        <div class="tabs-container">
                            <div class="tab-content" id="tab1">
                                <b>Event Location: </b><br/><? echo $events[$count]["location"]; ?>
                            </div>

                                <div class="tab-content" id="tab2">
                                <b>Event Description: </b><br />
                                <? echo $events[$count]["description"]; ?>
                                </div>
                        </div>
                        
                        <?
                        if($events[$count]["max"]!=0) {
                        ?>
                            <div style="float: left; width: 150px;">
                                RSVP Total: <b id="amount<? echo $events[$count]["id"]; ?>"></b>/<? echo $events[$count]["max"]; ?>
                                <div id="progressbar<? echo $events[$count]["id"]; ?>" style="height: 15px; width: 100%"></div>
                            </div>
                            <form name="form_<? echo $events[$count]["id"]; ?>" method="post">
                            <div style="float: right;">
                                    <? if(date("Y-m-d H:i:s") < $events[$count]["date"]) { ?>
                                    <input type="button" id="user_rsvp" class="button color medium rsvp<? echo $events[$count]["id"]; ?>" onclick="submit_rsvp(<? echo $events[$count]["id"]; ?>, '<? echo $user->data['username_clean']; ?>')" value="RSVP!"/>
                                    <input type="button" id="locked_rsvp" class="button gray medium rsvplock<? echo $events[$count]["id"]; ?>" onclick="unsubmit_rsvp(<? echo $events[$count]["id"]; ?>, '<? echo $user->data['username_clean']; ?>')" value="Un-RSVP" />
                                    <input type="button" id="full_rsvp" class="button gray medium rsvpfull<? echo $events[$count]["id"]; ?>" value="RSVP!" />
                                    <div class="loading"></div>
                                    <? } ?>
                            </div><br /><br />		
                            </form> 
                        <?
                        }
                        ?>
                    </div>
                
                        <script>
                        $('#amount<? echo $events[$count]["id"]; ?>').text(<? echo $rsvpcount; ?>);
                            
                        $(function() {
                            //This logic will allow for instant
                            var rsvpamt = <? echo $rsvpcount; ?>;

                            $('.rsvp<? echo $events[$count]["id"]; ?>').click(function() {
                                rsvpamt+=1;
                                $('#amount<? echo $events[$count]["id"]; ?>').text(rsvpamt);
                                $("#progressbar<? echo $events[$count]["id"]; ?>").progressbar("option", "value", rsvpamt);
                            });
                        
                            $('.rsvplock<? echo $events[$count]["id"]; ?>').click(function() {
                                rsvpamt-=1;
                                $('#amount<? echo $events[$count]["id"]; ?>').text(rsvpamt);
                                $("#progressbar<? echo $events[$count]["id"]; ?>").progressbar("option", "value", rsvpamt);
                            });
                        });
                        </script>

<?
    $count++;
           } ?>
                    
		<? } else if ($_GET['p']=="avatar") { ?>
			<div class="container">
				<div class="sixteen columns">
					<blockquote>Before uploading your image, please check the following.
					<ul class="check_list">
						<li>The image is a jpg, jpeg, gif, or png</li>
						<li>The image is 200x200 pixels</li>
						<li>The image is appropriate and reflects 3DPC and University values!</li>
					</ul>
					</blockquote>
				</div>
			</div><br />
		<?
			if(isset($_FILES["file"])) {
				$allowedExts = array("jpg", "jpeg", "gif", "png");
				$extension = end(explode(".", $_FILES["file"]["name"]));
				if ((($_FILES["file"]["type"] == "image/gif")
					|| ($_FILES["file"]["type"] == "image/jpeg")
					|| ($_FILES["file"]["type"] == "image/png")
					|| ($_FILES["file"]["type"] == "image/pjpeg"))
					&& ($_FILES["file"]["size"] < 128000)
					&& in_array($extension, $allowedExts)) {
						if ($_FILES["file"]["error"] > 0) {
							echo "Return Code: " . $_FILES["file"]["error"] . "<br>";
						} else {
							$file_directory = "uploads/profile/";
							$file_name = "avatar_" . $user->data['username_clean'] . '.' . $extension;
							$file_directory_name = $file_directory . $file_name;
					
							if (file_exists($file_directory_name)) {
								unlink($file_directory_name);
								move_uploaded_file($_FILES["file"]["tmp_name"],
								$file_directory_name);
								resizeImage($file_directory_name);
								if(modifyAvatarInfo($userID, $_FILES["file"]["type"], ($_FILES["file"]["size"] / 1024), $file_name, date('Y-m-d H:i:s'))) { ?>
									<div class="notification success closeable" id="notification_2" style="display: block;">
										<p><span>Success!</span> You did it, the image was updated!</p>
									<a class="close" href="#"></a></div> <?
								} else {
									unlink($file_directory_name); ?>
									<div class="notification error closeable" id="notification_1" style="display: block;">
										<p><span>Error!</span> Unable to update the Image!</p>
									<a class="close" href="#"></a></div> <?
								}
							} else {
								move_uploaded_file($_FILES["file"]["tmp_name"],
								$file_directory_name);
								resizeImage($file_directory_name);
								if(addAvatarInfo($userID, $_FILES["file"]["type"], ($_FILES["file"]["size"] / 1024), $file_name, date('Y-m-d H:i:s'))) { ?>
									<div class="notification success closeable" id="notification_2" style="display: block;">
										<p><span>Success!</span> You did it, the image was uploaded!</p>
									<a class="close" href="#"></a></div> <?
								} else {
									unlink($file_directory_name); ?>
									<div class="notification error closeable" id="notification_1" style="display: block;">
										<p><span>Error!</span> Unable to add the Image!</p>
									<a class="close" href="#"></a></div> <?
								}
							}
						}
					} else { ?>
						<div class="notification error closeable" id="notification_1" style="display: block;">
							<p><span>Error!</span> Invalid Image Type!</p>
						<a class="close" href="#"></a></div> <?
				}

			}
		
		?>	
			<div class="container">
				<div class="four columns">
					<? $today = date("F j, Y, g:i a"); ?>
					<img src="uploads/profile/<? echo getAvatar($userID); ?>?myPic='<? echo urlencode($today); ?>'" /><br />
				</div>
				<div class="four columns">
					<form action="profile.php?p=avatar" method="post" enctype="multipart/form-data">
						<label for="file">Filename:</label>
						<input type="file" name="file" id="file"><br /><br />
						<input type="submit" name="submit" class="button color" value="Submit">
					</form>
				</div>
		<? } ?>
	</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>