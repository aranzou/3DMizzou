<?php
include_once './config/functions_users.php';
include_once './config/functions_phpbb.php';
?>

	<div class="sixteen columns">
	
		<div id="navigation">
			<ul id="nav">
	
				<li><a href="<? echo $directory ?>index.php">Home</a></li>
				<li><a href="<? echo $directory ?>forum/index.php">Forums</a></li>
				<li><a href="<? echo $directory ?>portfolio.php">Portfolio</a></li>
				<li><a href="<? echo $directory ?>roster.php">Roster</a></li>
				<li><a href="<? echo $directory ?>about.php">About Us</a></li>
				<div id="logininfo">
					<? if($user->data['is_registered']) { ?>
						<li><a href="/profile.php?p=profile">Welcome <? echo $user->data['username_clean']; ?>!</a><div class="arrow-down"></div>
							<ul>
								<li><a href="/profile.php?p=profile">My Profile</a></li>
								<li><a href="/profile.php?p=rsvp">RSVP Center</a></li>
								<li><a href="/login.php">Logout</a></li>
							</ul>
						</li>
					<? } else { ?>
						<li><a href="/forms.php?f=register">Register</a></li>
						<li><a href="/login.php">Login</a></li>
					<? } ?>
				</div>
			</ul>
	
		</div> 
		<div class="clear"></div>
		
	</div>
