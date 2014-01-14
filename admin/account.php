<?php
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(1, $user->data['username_clean'])) {
	deniedUser();
}

include '../config/functions_users.php';

include 'header.html'; 
include 'sidebar.html';

$userID = getUserID($user->data['username_clean']);
?> 

<script>
var userID = "<? echo $userID; ?>";

function SaveItem() {	
	//Get BIO and Quote from textarea
	var biotextarea = document.getElementById('bio');
	var Form_bio = biotextarea.value;
	var quotetextarea = document.getElementById('quote');
	var Form_quote = quotetextarea.value;
	
    $.post("functions.php", { 
		id: userID, 
		action: "officer_update",
		bio: Form_bio,
		quote: Form_quote
		}, function(data) {
			//alert("User " + userID + " has been updated.");
			alert(data);
    });
}
</script>

    <div class="content">
        
        <div class="header">
            
            <h1 class="page-title">Edit User</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Officer Profile</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    
<div class="btn-toolbar">
    <button class="btn btn-primary" onclick="SaveItem()"><i class="icon-save"></i> Save</button>
  <div class="btn-group">
  </div>
</div>
<div class="well">
    <ul class="nav nav-tabs">
      <li class="active"><a href="#home" data-toggle="tab">Bio</a></li>
    </ul>
    <div id="myTabContent" class="tab-content">
      <div class="tab-pane active in" id="home">
	<?php $row = getOfficerByID($userID); ?>
    <form id="tab">
        <label>Officer Bio</label>
        <textarea id="bio" rows="5" class="input-xlarge"><? echo $row['bio']; ?></textarea>
        <label>Favorite Quote</label>
        <textarea value="" id="quote" rows="5" class="input-xlarge"><? echo $row['quote']; ?></textarea>
    </form>
      </div>

  </div>

</div>

    
            </div>
        </div>
    </div>
    


    <script src="lib/bootstrap/js/bootstrap.js"></script>
    <script type="text/javascript">
        $("[rel=tooltip]").tooltip();
        $(function() {
            $('.demo-cancel-click').click(function(){return false;});
        });
    </script>
    
  </body>
</html>