<?php
include_once 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(4, $user->data['username_clean'])) {
	deniedUser();
}

include_once '../config/functions_users.php';

include 'header.html'; 
include 'sidebar.html';


function badgemenu() { ?>
        <form name="badgemenu" id="tab3">
        <label>Earned Badge(s)</label>
        <? $category = getBadgeCategories(); 
           $earned = getEarnedBadges($_GET['u']);?>
        <div class="well">
            <table class="table">
              <thead>
                    <tr>
                      <th>X</th>
                      <th>Badge Name</th>
                      <th>Description</th>
                      <th>Image</th>
                    </tr>
              </thead>
              <tbody>
        <?
        $count = 1;
        while($count <= count($category)) {
            $badge = getBadgesByCategory($category[$count]["id"]);
        ?>

                    <tr><th colspan="4">Category: <? echo $category[$count]["name"]; ?></th></tr>
        <?
            $count2 = 1;
            while($count2 <= count($badge)) {
        ?>
                    <tr id="<? echo $badge[$count2]["id"]; ?>">
                            <? 
                            $count3=0;
                            $active=0;
                            while($count3 <= count($earned)) { 
                                if($earned[$count3]["badge"]==$badge[$count2]["id"]) { ?>
                                    <td><input type="checkbox" name="earnedbadges" value="<? echo $badge[$count2]["id"]; ?>" checked="checked"/></td>
                            <?
                                $active=1;
                                break;
                                }
                            $count3++;
                            }
                            
                            if($active==0) { ?>
                                <td><input type="checkbox" name="earnedbadges" value="<? echo $badge[$count2]["id"]; ?>"/></td>
                            <? } ?>
                            <td><? echo $badge[$count2]["name"]; ?></td>
                            <td><? echo $badge[$count2]["description"]; ?></td>
                            <td><? echo $badge[$count2]["image"]; ?></td>
                    </tr>	
        <?	
                $count2++;
           }
        $count++;
        } ?>
                </tbody>
             </table>
     </div>
    </form> 
<? } ?> 

<?php if($_GET['p']=="user") { 
$usertype = getUserType($_GET['u']);
$currentPosition = getOfficerPosition($_GET['u']);
?>
<script>
var userID = "<? echo $_GET['u']; ?>";

function DeleteItem() {
    $.post("functions.php", { id: userID, action: "deleteUser"}, function(data) {
		alert("User " + userID + " has been deleted.");
		window.history.back(-1);
    });
}

function SaveItem() {

	var Form_username = $('input[name=username]');
	var Form_pawprint = $('input[name=pawprint]');
	var Form_first = $('input[name=first]');
	var Form_last = $('input[name=last]');
	var Form_email = $('input[name=email]');
	var currentPos = <? echo $currentPosition["id"]; ?>
	
	var select_form = document.getElementById("status");
	var Form_status = (select_form.options[select_form.selectedIndex]).value;
	
	var Form_major = $('input[name=major]');
	var Form_schoolYear = $('input[name=schoolYear]');
	
	var type_form = document.getElementById("type");
	var Form_type = (type_form.options[type_form.selectedIndex]).value;
        
        var c_value = "";
	for (var i=0; i < document.badgemenu.earnedbadges.length; i++) {
		if (document.badgemenu.earnedbadges[i].checked) {
			c_value = c_value + document.badgemenu.earnedbadges[i].value + " ";
		}
	}
	
	if($("#type").val() == 6) {
		var officer = document.getElementById("officerPos");
		var officer_value = (officer.options[officer.selectedIndex]).value;
					
		if(officer_value==0) {
			alert("Please select an officer position!");
			return false;
		}
	} else {
		var officer_value = 0;
	}
	
    $.post("functions.php", { 
		id: userID, 
		action: "updateUser",
		username: Form_username.val(),
		pawprint: Form_pawprint.val(),
                badges: c_value,
		first: Form_first.val(),
		last: Form_last.val(),
		email: Form_email.val(),
		status: Form_status,
		major: Form_major.val(),
		schoolYear: Form_schoolYear.val(),
		type: Form_type,
		currentPos: currentPos,
		position: officer_value
		}, function(data) {
			//alert("User " + userID + " has been updated.");
			alert(data);
			location.reload();
    });
    
}
</script>
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Edit User</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li><a href="users.php?t=<? echo $_GET['t']; ?>">Users</a> <span class="divider">/</span></li>
            <li class="active">Edit</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" onclick="SaveItem()"><i class="icon-save"></i> Save</button>
    <a href="#myModal" data-toggle="modal" class="btn">Delete</a>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">Profile</a></li>
      <li><a href="#badge" data-toggle="tab">Badges</a></li>
      <li><a href="#profile" data-toggle="tab">Password</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
            <? $row = getMemberInfo($_GET['u']); ?>
<form id="tab">
        <label>Username</label>
        <input type="text" name="username" value="<? echo $row['username']; ?>" class="input-xlarge">
        <label>PawPrint</label>
        <input type="text" name="pawprint" value="<? echo $row['pawprint']; ?>" class="input-xlarge">
        <label>First Name</label>
        <input type="text" name="first" value="<? echo $row['firstname']; ?>" class="input-xlarge">
        <label>Last Name</label>
        <input type="text" name="last" value="<? echo $row['lastname']; ?>" class="input-xlarge">
        <label>Email</label>
        <input type="text" name="email" value="<? echo $row['email']; ?>" class="input-xlarge">
        <label>Account Status</label>
		<select id="status" class="input-xlarge">
		<?php if($row['approved']==1) { ?>
			  <option value="1" selected="selected">Active</option>
			  <option value="0">Inactive</option>
		  <?php } else if($row['approved']==0) { ?>
			  <option value="1">Active</option>
			  <option value="0" selected="selected">Inactive</option>
		  <?php } ?>
		</select>
		<label>Major</label>
		<input type="text" name="major" value="<? echo $row['major']; ?>" class="input-xlarge">
		<label>School Year</label>
		<input type="text" name="schoolYear" value="<? echo $row['schoolYear']; ?>" class="input-xlarge">
		<label>Account Type</label>
		<select id="type" class="input-xlarge">
		<?php
		$mysqli = serverConnect();
		$query = "SELECT * FROM member_type";
		
		if ($mysqli->multi_query($query)) {
			do {
				/* store first result set */
				if ($result = $mysqli->store_result()) {
					while ($row = $result->fetch_row()) { ?>
						<option value="<? echo $row[0]; ?>" <? if($usertype==$row[0]) { echo 'selected="selected"';}?>><? echo $row[1]; ?></option>
					<? }
					$result->free();
				}
			} while ($mysqli->next_result());
		}
		?>
		</select>
		
		<!-- Need to clean this part of the script up! -->

		<? $officerPos = getOpenOfficerPositions(); ?>
		<label class="officerposition">Officer Position</label>
		<select class="officerposition" id="officerPos" class="input-xlarge">
			<? 
			//The following sets the officer type. If the officer does not have a position then it's set to null
			?> <option value="<? echo $currentPosition["id"]; ?>" selected="selected"><? echo $currentPosition["name"]; ?></option> <?
			$count=1;
			while($count<$officerPos["count"]) { ?>
				<option value="<? echo $officerPos[$count]["id"]; ?>"><? echo $officerPos[$count]["name"]; ?></option>
			<? 
			$count++;
			} ?>
		</select>
		<script>
			if($("#type").val()==6) { 
				$('.officerposition').show();
			} else {
				$('.officerposition').hide();
			}
			
			$('#type').change(function () {
				if($("#type").val()==6) {
					$('.officerposition').show();
				} else {
					$('.officerposition').hide();
				}
			});
		</script>
</form>
      </div>
        <div class="tab-pane fade" id="badge">
            <? badgemenu(); ?>
        </div>
      <div class="tab-pane fade" id="profile">
    <form id="tab2">
        <label>New Password</label>
        <input name="pass" type="password" class="input-xlarge">
        <div>
            <button class="btn btn-primary">Update</button>
        </div>
    </form>
      </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the user?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" onclick="DeleteItem()" data-dismiss="modal">Delete</button>
  </div>
</div>

    
            </div>
        </div>
    </div>
<? } else if ($_GET['p']=="event") {
		$row = getEventInfo($_GET['u']); 
		if(isset($row['date'])) {
			$datetime = explode(" ", $row['date']);
			$time = explode(":", $datetime[1]);
		}
?>
<script>
var eventID = "<? echo $_GET['u']; ?>";

function SaveItem() {

	var eventName = $('input[name=eventname]');
	var description = document.getElementById('description');
	var location = document.getElementById('location');
	var capacity = $('input[name=capacity]');
	var eventDate = $('input[name=eventdate]');
	var hour = $('input[name=hour]');
	var minute = $('input[name=minute]');
        var eventtype = document.getElementById("eventType");
	var type = (eventtype.options[eventtype.selectedIndex]).value;
	
	var processedDate = eventDate.val() + ' ' + hour.val() + ':' + minute.val() + ':00';
	
	if(eventName.val()=="" || description.value=="" || location.value=="" || capacity.val()=="" || eventDate.val()=="") {
		alert("Please fill in ALL fields!");
		return false;
	}
	
    $.post("functions.php", { 
		id: eventID, 
		action: "updateEvent",
		eventName: eventName.val(),
                type: type,
		description: description.value,
		location: location.value,
		capacity: capacity.val(),
		eventDate: processedDate
		}, function(data) {
			//alert("User " + userID + " has been updated.");
			alert(data);
    });
    
    //window.history.back(-1);
}

function DeleteItem() {
    $.post("functions.php", { id: eventID, action: "deleteEvent"}, function(data) {
		alert("Event " + eventID + " has been deleted.");
		window.history.back(-1);
    });
}

    $(function() {
        $('#datepicker').datepicker({ dateFormat: 'yy-mm-dd', minDate:  '<? echo date("Y-m-d H:i:s");?>'}).val();
    });

    $(function() {
        $( "#hourslider" ).slider({
            range: "max",
            min: 7,
            max: 22,
            value: <? echo $time[0]; ?>,
            slide: function( event, ui ) {
                $( "#houramt" ).val( ui.value );
            }
        });
        $( "#houramt" ).val( $( "#hourslider" ).slider( "value" ) );
        $( "#minuteslider" ).slider({
            range: "max",
            min: 00,
            max: 60,
            value: <? echo $time[1]; ?>,
            step: 15,
            slide: function( event, ui ) {
                $( "#minamt" ).val( ui.value );
            }
        });
        $( "#minamt" ).val( $( "#minuteslider" ).slider( "value" ) );
    });
</script>
    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Edit Event</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li><a href="events.php?s=<? echo $_GET['s']; ?>">Events</a> <span class="divider">/</span></li>
            <li class="active">Edit</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" onclick="SaveItem()"><i class="icon-save"></i> Save</button>
    <a href="#myModal" data-toggle="modal" class="btn">Delete</a>
  <div class="btn-group">
  </div>
</div>
<div class="well">

    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
    <form id="tab">
        <label>Name of Event</label>
        <input type="text" name="eventname" value="<? echo $row['name']; ?>" class="input-xlarge">
		<label>Event Description</label>
		<textarea value="" id="description" rows="5" class="input-xlarge"><? echo $row['description']; ?></textarea>
		<label>Location</label>
		<textarea value="" id="location" rows="5" class="input-xlarge"><? echo $row['location']; ?></textarea>
		<label>Capacity</label>
		<input type="text" name="capacity" value="<? echo $row['capacity']; ?>" class="input-xlarge">
		<label>Date of Event</label>
		<input type="text" name="eventdate" id="datepicker" size=30 value="<? echo $datetime[0]; ?>" class="input-xlarge">
                <label>Type of Event</label>
                <select id="eventType" class="input-xlarge">
                    <?
                    $count=0;
                    $eventTypes = getAllEventTypes();
                    while($count < count($eventTypes)) {
                        if($eventTypes[$count]["id"]==$row['type']) {
                            echo "<option value='" . $eventTypes[$count]["id"] . "' selected='selected'>" . $eventTypes[$count]["name"] . "</option>";
                        } else {
                            echo "<option value='" . $eventTypes[$count]["id"] . "'>" . $eventTypes[$count]["name"] . "</option>";
                        }
                        $count++;
                    }
                    ?>
                </select>
		<br /><br /><label><b>Time of Event</b></label>
		<label for="houramt">Hour:</label>
		<input type="text" name="hour" id="houramt" style="border: 0; color: #f6931f; font-weight: bold;" disabled/>
		<div id="hourslider" class="input-xlarge"></div>
		<label for="minamt">Minute:</label>
		<input type="text" id="minamt" name="minute" style="border: 0; color: #f6931f; font-weight: bold;" disabled/>
		<div id="minuteslider" class="input-xlarge"></div>
    </form>
      </div>
  </div>

</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">◊</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete the event?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" onclick="DeleteItem()" data-dismiss="modal">Delete</button>
  </div>
</div>

    
            </div>
        </div>
    </div>
<? } ?>


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>