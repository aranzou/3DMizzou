<?php 
session_start();
include 'header.html';
include '../config/functions_admin.php'; 
include '../config/functions_users.php';
include '../config/functions_phpbb.php';
?>

<div class="row-fluid">
    <div class="dialog">

<?php
if($user->data['is_registered']) {
	$kill = new session;
	$kill->session_kill(true);
	?>
	<meta http-equiv="Refresh" content="0; url=/admin/login.php">
	<?
	die();
}
?>
<script>
	//This is the login form
	function test() {
		var result=true;
		
		var username = $('input[name=username]');
		var password = $('input[name=password]');
							
		var data = 'username=' + username.val() + '&pass=' + password.serialize();
										
		// Start jQuery
		$.ajax({
		
			url: "../config/phpbbauthapi.php?r=tiger",	
			
			// POST method is used
			type: "POST",

			// Pass the data			
			data: data,		
			
			//Do not cache the page
			cache: false,
			
			// Success
			success: function (html) {				
			
				if (html==1) {		
					window.location = '/admin';
				}
				
				else {
					//alert('Sorry, unexpected error. Please try again later.');
					alert(html);				
				}
			}		
		});
		return false;
	
	};

</script>
        <div class="block">
            <p class="block-heading">Sign In</p>
            <div class="block-body">
                <form action="" method="post">
                    <label>Username</label>
                    <input type="text" name="username" class="span12" value="<? if(isset($_POST["username"])) { echo $_POST["username"]; }?>">
                    <label>Password</label>
                    <input type="password" name="password" class="span12">
                    <input type="button" id="loginform" class="btn btn-primary pull-right" onclick="test()" value="Submit">
                    <label class="remember-me"><input type="checkbox"> Remember me</label>
                    <div class="clearfix"></div>
                </form>
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


