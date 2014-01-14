<?php
include_once 'config/functions_phpbb.php';
include 'header.html';

//Destroy the phpbb session
//TODO Potentially upgrade this to ajax in the future
if($user->data['is_registered']) {
	$kill = new session;
	$kill->session_kill(true);
	?>
	<meta http-equiv="Refresh" content="0; url=/">

	</div></div>
	<?
	include_once 'footer.php';
	die();
}

?>
<script src="js/login.js"></script>

<div class="container">
	<div class="twelve columns">
		<div class="headline no-margin"><h4>Login Form</h4></div>
		
		<div class="form-spacer"></div>
		
		<!-- Success Message -->
		<div class="success-message">
			<div class="notification success closeable">
				<p><span>Success!</span> You have successfully logged in!</p>
			</div>
		</div>
		
		<!-- Form -->
		<div id="contact-form">
			<form method="post" action="">
				
				<div class="field">
					<label>Username:</label>
						<input type="text" name="username" class="text" />
				</div>
				
				<div class="field">
					<label>Password:</label>
						<input type="password" id="password_field" name="passfield" class="text" />
				</div>
				
				<span><a href="/forum/ucp.php?mode=sendpassword">Forgot you password?</a></span><br />
				
				<div class="field">
					<input type="submit" id="loginform" style="button" value="Login"/>
					<div class="loading"></div>
				</div>
				
			</form>
		</div>
</div>
</div>
</div>
<?php include_once 'footer.php'; ?>