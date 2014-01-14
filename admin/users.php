<?php
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(1, $user->data['username_clean'])) {
	deniedUser();
}

include 'header.html'; 
include 'sidebar.html';
?> 

<script>
var name;
var userID;

function setID($userID) {
	userID = $userID;
}

function DeleteItem() {
    $.post("functions.php", { id: userID, action: "deleteUser"}, function(data) {
        element = document.getElementById(userID);
		element.parentNode.removeChild(element);
    });
}
</script>

    <div class="content">
        
        <div class="header">
<?

if($_GET['t']=='r') {
	$query = "SELECT userID, firstname, lastname, username, email, major FROM users WHERE userType=4 ORDER BY firstname";
	$title = "Registers Users";
} else if($_GET['t']=='active') {
	$query = "SELECT userID, firstname, lastname, username, email, major FROM users WHERE userType=2 ORDER BY firstname";
	$title = "Active Members";
} else if($_GET['t']=='tech') {
	$query = "SELECT userID, firstname, lastname, username, email, major FROM users WHERE userType=1 ORDER BY firstname";
	$title = "Tech Users";
} else if($_GET['t']=='o') {
	$query = "SELECT p1.userID, p1.firstname, p1.lastname, p1.username, p1.email, p3.posName FROM users p1, officers p2, officer_position p3 WHERE p1.userID = p2.userID AND p2.officerPos = p3.positionID";
	$title = "Officers";
} else if($_GET['t']=='u') {
	$query = "SELECT userID, firstname, lastname, username, email, major FROM users WHERE approved=0 ORDER BY firstname";
	$title = "Unapproved Users";
}

?>
            
            <h1 class="page-title"><? echo $title; ?></h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Users</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
            
<div class="btn-toolbar">
    <button class="btn btn-primary"><i class="icon-plus"></i> New User</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
		<tr>
		  <th>#</th>
		  <th>First Name</th>
		  <th>Last Name</th>
		  <th>Username</th>
		  <th>E-mail</th>
		  <th>Major</th>
		  <th style="width: 26px;"></th>
		</tr>
	  </thead>
      
<?php 
$mysqli = serverConnect();

if ($mysqli->multi_query($query)) {
	do {
		/* store first result set */
		if ($result = $mysqli->store_result()) {
			while ($row = $result->fetch_row()) { ?>
			  <tbody>
				<tr id="<? echo $row[0]; ?>">
				  <td><? echo $row[0]; ?></td>
				  <td><? echo $row[1]; ?></td>
				  <td><? echo $row[2]; ?></td>
				  <td><? echo $row[3]; ?></td>
				  <td><? echo $row[4]; ?></td>
				  <td><? echo $row[5]; ?></td>
				  <td>
					  <a href="edit.php?t=<? echo $_GET[t]; ?>&u=<? echo $row[0]; ?>&p=user"><i class="icon-pencil"></i></a>
					  <a href="#myModal" role="button" onclick="setID(<? echo $row[0]; ?>)" data-toggle="modal"><i class="icon-remove"></i></a>
				  </td>
				</tr>
			<? }
			$result->free();
		}
		/* print divider */
		if ($mysqli->more_results()) {
			printf("-----------------\n");
		}
	} while ($mysqli->next_result());
}

/* close connection */
$mysqli->close();
?>
                    
      </tbody>
    </table>
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

<?php include 'footer.html'; ?>
