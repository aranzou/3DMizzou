<?php 
include 'header.html'; 
?>
<div class="container">	
	<div class="twelve columns">
		<div class="headline"><h3>Unsubscribe from our mailing list</h3></div>
		
		<div class="notification warning closeable" id="notification_3" style="display: block;">
			<p><span>Warning!</span> Important announcements related to the club are sent through our mailing list! By unsubscribing, you might be missing out...</p>
		<a class="close" href="#"></a></div>
		
		<blockquote>Please fill out the following form below to unsubscribe from our mailing list. If you wish to re-subscribe in the future, you can do so by signing into your account and changing your profile preferences.</blockquote>
		
		<form method="post" action="">
			<div class="profile_edit">
				<table border=0>
					<tr><td><span>Email: </span></td><td><input type="text" name="email" class="text" /></td></tr>
				</table>
				<br /><br />
				
				<div class="field">
					<input type="button" id="email_unsubscribe" value="Unsubscribe"/>
					<div class="loading"></div>
				</div>
			</div>
		</form>



	</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>