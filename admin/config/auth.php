<?
include_once '../config/functions_phpbb.php';
include_once '../config/functions_admin.php'; 

function accessLevelVerify($security_level, $username) {
	$user_level = isAdmin($username);
	if($user_level >= $security_level) {
		return true;
	} 
	return false;
}

function deniedUser() {
	include 'header.html';	
	?>
	
	<div class="sidebar-nav">
		<a href="#dashboard-menu" class="nav-header" data-toggle="collapse"><i class="icon-dashboard"></i>Dashboard</a>
        <ul id="dashboard-menu" class="nav nav-list collapse in">
            <li><a href="index.php">Home</a></li>
            <li><a href="login.php">Login</a></li>
        </ul>
	</div>
	
	    <div class="content">
			<div class="header">  
				<h1 class="page-title">Unauthorized Access</h1>
			</div>
        
			<div class="well">
				<p>You do not have the appropriate access level to view this page</p>
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
<? 
	die();
} ?>