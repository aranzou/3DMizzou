<?php
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(1, $user->data['username_clean'])) {
	deniedUser();
}

include 'header.html'; 
include 'sidebar.html';
?> 

    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">RSVP</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li><a href="events.php">Events</a> <span class="divider">/</span></li>
            <li class="active">RSVP</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
            
<div class="btn-toolbar">
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <table class="table">
      <thead>
		<tr>
		  <th>Name</th>
		  <th>E-Mail</th>
		  <th>PawPrint</th>
		  <th>Registered</th>
		  <th>IP</th>
		</tr>
	  </thead>
      
<?php 
$mysqli = serverConnect();

if(is_numeric($_GET['eid'])) {
	$query = "SELECT * FROM rsvp WHERE eventID =" . $_GET['eid'];
} else {
	die();
}


if ($mysqli->multi_query($query)) {
	do {
		/* store first result set */
		if ($result = $mysqli->store_result()) {
			while ($row = $result->fetch_row()) {
		?>
			  <tbody>
				<tr>
				  <td><? echo $row[1]; ?></td>
				  <td><? echo $row[2]; ?></td>
				  <td><? echo $row[3]; ?></td>
				  <td><? echo $row[4]; ?></td>
				  <td><? echo $row[5]; ?></td>
				</tr> <?
			}
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
