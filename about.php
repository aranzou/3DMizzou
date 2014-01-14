<?php
include_once 'config/functions_posts.php';
include_once 'config/functions_users.php';
include 'header.html';

?>

<!-- Content
================================================== -->

<!-- 960 Container -->
<div class="container">

	<div class="sixteen columns">
	
		<!-- Page Title -->
		<div id="page-title">
			<h2>About</h2>
			<div id="bolded-line"></div>
		</div>
		<!-- Page Title / End -->

	</div>
</div>
<!-- 960 Container / End -->


<!-- 960 Container -->
<div class="container">

	<!-- Standard Structure -->
	<div class="two-thirds column">
		<? $aPost = getPost('aboutus'); ?>
		<div class="headline no-margin"><h4><? echo $aPost['title']; ?></h4></div>
		<p><? echo $aPost['text']; ?></p>
	</div>
	
	<div class="one-third column">
		<div class="headline no-margin"><h4>Interested?</h4></div>

		<!-- Large Notice -->
		<div class="large-notice">
			<h2>Join the club</h2>
			<p>If your interested in joining then press the button below!</p>
			<a href="forms.php?f=register" class="button medium color">Join</a>
		</div>
		</p>
	</div>
	
</div>
<!-- 960 Container End -->


</div>
<!-- Wrapper / End -->

<?php include_once 'footer.php'; ?>