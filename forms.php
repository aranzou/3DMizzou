<?php
include 'header.html';
include_once 'config/functions_admin.php';

//Forms as listed below
function register() { 
?>
<div class="container">

	<!-- Text -->
	<div class="sixteen columns">
		<p>Register to become a member of the website by filling out the form below. Please note that by filling the form out below, you are expressing interest in becoming a member of the 3D Print Club. An e-mail will be sent later to verify your interest.</p>
		<p>This registration form is for University of Missouri students only.</p>
	</div>

	<!-- Contact Form -->
	<div class="twelve columns">
		<div class="headline no-margin"><h4>Registration Form</h4></div>
		
		<div class="form-spacer"></div>
		
		<!-- Success Message -->
		<div class="success-message">
			<div class="notification success closeable">
				<p><span>Success!</span> You have registered on our website! An activation link has been sent to your e-mail, please click on the link to activate your account.</p>
			</div>
		</div>

		<!-- Form -->
		<div id="contact-form">
			<form method="post" action="forms.php?f=register">
				
				<div class="field">
					<label>First name:</label>
						<input type="text" name="first" class="text" />
				</div>
				
				<div class="field">
					<label>Last name:</label>
						<input type="text" name="last" class="text" />
				</div>
				
				<div class="field">
					<label>PawPrint:</label>
						<input type="text" name="pawprint" class="text" />
				</div>	

				<div class="field">
					<label>Email:</label>
						<input type="text" name="email" class="text" />
				</div>	

				<div class="field">
					<label>Current Major:</label>
						<input type="text" name="major" class="text" />
				</div>
				
				<div class="field">
					<label>Password: (*Min: 5, Max: 20)</label>
						<input type="password" name="pass" class="text" />
				</div>

				<div class="field">
					<label>Year in School:</label>
					  <select type="text" id="yearschool" class="dropdown" >
					  <option value="Freshman">Freshman</option>
					  <option value="Sophmore">Sophomore</option>
					  <option value="Junior">Junior</option>
					  <option value="Senior">Senior</option>
					  <option value="SeniorPlus">Senior +</option>
					</select>
				</div><br />		
				
				<!--<div class="field">
					<button type="submit">Register!</button>
				</div>-->
				
				<div class="field">
					<input type="button" id="createmem" value="Register!"/>
					<div class="loading"></div>
				</div>
				
			</form>
		</div>

</div>
</div>
</div>
<?}

function nonmizzouregister() { 
?>
<div class="container">

	<!-- Text -->
	<div class="sixteen columns">
		<p>Register to become a member of the website by filling out the form below. Please note that by filling the form out below, you are expressing interest in becoming a member of the 3D Print Club. An e-mail will be sent later to verify your interest.</p>
		<p>This registration form is for the General Public</p>
	</div>

	<!-- Contact Form -->
	<div class="twelve columns">
		<div class="headline no-margin"><h4>Registration Form</h4></div>
		
		<div class="form-spacer"></div>
		
		<!-- Success Message -->
		<div class="success-message">
			<div class="notification success closeable">
				<p><span>Success!</span> You have registered on our website! An activation link has been sent to your e-mail, please click on the link to activate your account.</p>
			</div>
		</div>

		<!-- Form -->
		<div id="contact-form">
			<form method="post" action="">
				
				<div class="field">
					<label>First name:</label>
						<input type="text" name="first" class="text" />
				</div>
				
				<div class="field">
					<label>Last name:</label>
						<input type="text" name="last" class="text" />
				</div>
				
				<div class="field">
					<label>Username:</label>
						<input type="text" name="username" class="text" />
				</div>	

				<div class="field">
					<label>Email:</label>
						<input type="text" name="email" class="text" />
				</div>	
				
				<div class="field">
					<label>Password: (*Min: 5, Max: 20)</label>
						<input type="password" name="pass" class="text" />
				</div>	
				
				<!--<div class="field">
					<button type="submit">Register!</button>
				</div>-->
				
				<div class="field">
					<input type="button" id="createnonmem" value="Register!"/>
					<div class="loading"></div>
				</div>
				
			</form>
		</div>

</div>
</div>
</div>
<?}

function rsvp() { 
$eventID = $_GET['id'];
$eventinfo = getEventInfo($eventID);

if($eventinfo['description']=="") { ?>
<div class="container">

	<!-- Text -->
	<div class="sixteen columns">
		<p>Error: Event doesn't exist!</p>
	</div>
</div>
</div>
</div>
<? 
include_once 'footer.php';
die();
}
?>
<div class="container">

	<!-- Text -->
	<div class="sixteen columns">
		<p><? echo $eventinfo['description']; ?>
		<br /><br /><blockquote>This will not register you as a member of the club or subscribe you to a mailing list. If you would like to become a member in addition to RSVPing, please <a href="http://3dmizzou.org/forms.php?f=register">register on our website</a></blockquote></p>
		
		<div class="notification notice">
			<p><span>The location of the first meeting:</span> <? echo $eventinfo['location']; ?></p></p>
		</div>
	</div>

	<!-- Contact Form -->
	<div class="twelve columns">
		<div class="headline no-margin"><h4>RSVP Form</h4></div>
		
		<div class="form-spacer"></div>
		
		<!-- Success Message -->
		<div class="success-message">
			<div class="notification success closeable">
				<p><span>Success!</span> Your message has been sent.</p>
			</div>
		</div>

		<!-- Form -->
		<div id="contact-form">
			<form method="post" action="">
			
				<input type="hidden" name="eventid" value="<? if(is_numeric($_GET['id'])) echo $_GET['id']; ?>" class="text" />
				
				<div class="field">
					<label>Name:</label>
					<input type="text" name="rsvpname" class="text" />
				</div>
				
				<div class="field">
					<label>PawPrint: <span>*</span></label>
					<input type="text" name="rsvppawprint" class="text" />
				</div>
				
				<div class="field">
					<label>Email: <span>*</span></label>
					<input type="text" name="rsvpemail" class="text" />
				</div>		
				
				<div class="field">
					<input type="button" id="rsvp" value="RSVP!"/>
					<div class="loading"></div>
				</div>
				
			</form>
		</div>

	</div>
</div>
</div>
<? }

if($_GET['f']=='register') {
	if(!$user->data['is_registered']) {
		register();
	} else {
		echo '<meta http-equiv="REFRESH" content="0;url=/">';
		die();
	}
} else if ($_GET['f']=='rsvp') {
	if(!$user->data['is_registered']) {
		if(is_numeric($_GET['id'])) {
			rsvp();
		} else {
			echo '<meta http-equiv="REFRESH" content="0;url=/">';
			die();
		}
	} else {
		echo '<meta http-equiv="REFRESH" content="0;url=/profile.php?p=rsvp">';
		die();
	}
} else if ($_GET['f']=='nonmizzou') {
    if(!$user->data['is_registered']) {
		nonmizzouregister();
    } else {
            echo '<meta http-equiv="REFRESH" content="0;url=/">';
            die();
    }
}


include_once 'footer.php'; ?>
