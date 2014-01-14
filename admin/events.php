<?php
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(4, $user->data['username_clean'])) {
	deniedUser();
}

include_once '../config/functions_admin.php';
include_once '../config/functions_users.php';

include 'header.html'; 
include 'sidebar.html';
?> 

<script>
var eventID;

function setID($eventID) {
	eventID = $eventID;
}

function DeleteItem() {
    $.post("functions.php", { id: eventID, action: "deleteEvent"}, function(data) {
        element = document.getElementById(eventID);
		element.parentNode.removeChild(element);
    });
}

function createForm() {
	window.location.href="forms.php?f=event";
}

</script>

    <div class="content">
        
        <div class="header">
            <h1 class="page-title">Events</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Events</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">

<? if($_GET['s']=="active") { ?>        
<div class="btn-toolbar">
    <button onclick="createForm()" class="btn btn-primary"><i class="icon-plus"></i> New Event</button>
  <div class="btn-group">
  </div>
</div>
<? } ?>
<div class="well">
    <table class="table">
      <thead>
		<tr>
		  <th>Type</th>
		  <th>Name</th>
		  <th>Location</th>
		  <th>Capacity</th>
		  <th>Registered</th>
		  <th>Date/Time</th>
		  <th style="width: 50px;"></th>
		</tr>
	  </thead>
          
         <? 
         
         $events = getAllEventInfo(); 
         $count=0;
         while($count != count($events)) {
         
            if($_GET['s']=="active"&&($events[$count]["date"] > date('Y-m-d H:i:s'))) {
            ?>
                <tbody>
                      <tr>
                        <td><? echo $events[$count]["type"]; ?></td>
                        <td><? echo $events[$count]["name"]; ?></td>
                        <td><? echo $events[$count]["location"]; ?></td>
                        <td><? echo $events[$count]["capacity"]; ?></td>
                        <td><? echo getRSVPcount($events[$count]["id"]); ?></td>
                        <td><? echo $events[$count]["date"]; ?></td>
                        <td>
                                <a href="../forms.php?f=rsvp&id=<? echo $events[$count]["id"]; ?>"><i class="icon-file"></i></a>
                            <a href="rsvp.php?eid=<? echo $events[$count]["id"]; ?>"><i class="icon-list"></i></a>
                                <a href="edit.php?u=<? echo $events[$count]["id"]; ?>&p=event&s=<? echo $_GET['s']; ?>"><i class="icon-pencil"></i></a>
                        </td>
                      </tr>                    
                </tbody>
            <? 
            } else if ($_GET['s']=="expired"&&($events[$count]["date"] < date('Y-m-d H:i:s'))) {
                ?>
                <tbody>
                      <tr>
                        <td><? echo $events[$count]["type"]; ?></td>
                        <td><? echo $events[$count]["name"]; ?></td>
                        <td><? echo $events[$count]["location"]; ?></td>
                        <td><? echo $events[$count]["capacity"]; ?></td>
                        <td><? echo getRSVPcount($events[$count]["id"]); ?></td>
                        <td><? echo $events[$count]["date"]; ?></td>
                        <td>
                                <a href="../forms.php?f=rsvp&id=<? echo $events[$count]["id"]; ?>"><i class="icon-file"></i></a>
                            <a href="rsvp.php?eid=<? echo $events[$count]["id"]; ?>"><i class="icon-list"></i></a>
                                <a href="edit.php?u=<? echo $events[$count]["id"]; ?>&p=event&s=<? echo $_GET['s']; ?>"><i class="icon-pencil"></i></a>
                        </td>
                      </tr>                    
                </tbody>
                <?
            }
         $count++;
         } ?>
        
    </table>
</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">◊</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this event?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" onclick="DeleteItem()" data-dismiss="modal">Delete</button>
  </div>
</div>

<?php include 'footer.html'; ?>
