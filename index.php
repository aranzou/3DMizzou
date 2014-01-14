<?php
include_once 'config/functions_posts.php';
include 'header.html';

?>

<!-- 
<div class="container">
	<div class="sixteen columns">
	<br /><div class="large-notice">
			
		<? $hPost = getPost('home'); ?>
		<div class="sixteen columns">
			<h2><? echo $hPost['title']; ?></h2></div>
			<p><? echo $hPost['text']; ?></p>
		</div>
		
	</div>
</div>

960 Container -->

<div class="container">

	<!-- Flexsder -->
	<div class="sixteen columns">
		<section class="slider">
			<div class="flexslider home">
				<ul class="slides">
				
					<li>
						<img src="images/slider/IMGA0049.jpg" alt="" />
					</li>
					
					<li>
						<img src="images/slider/IMGA0014.jpg" alt="" />
					</li>
					
					<li>
						<img src="images/slider/IMGA0029.jpg" alt="" />
					</li>
					
				</ul>
			</div>
		</section>
  	</div>
	<!-- Flexslider / End -->
	
</div>
<!-- 960 Container / End -->


<!-- 960 Container -->
<div class="container">

	<!-- Icon Boxes -->
	<div class="icon-box-container">

		<!-- Icon Box Start -->
		<div class="one-third column">
			<div class="icon-box">
				<i class="ico-sun"></i>
				<h3>Gain Insight</h3>
				<p>Learn the basics of what 3D printing is and how you can use it.</p>
			</div>
		</div>
		<!-- Icon Box End -->
		
		<!-- Icon Box Start -->
		<div class="one-third column">
			<div class="icon-box">
				<i class="ico-book-open"></i>
				<h3>Develop Skills</h3>
				<p>Learn some basic modeling skills.</p>
			</div>
		</div>
		<!-- Icon Box End -->
		
		<!-- Icon Box Start -->
		<div class="one-third column">
			<div class="icon-box">
				<i class="ico-cogwheel"></i>
				<h3>Get Hands-On Experience</h3>
				<p>Get printing yourself!</p>
			</div>
		</div>
		<!-- Icon Box End -->
		
	</div>
	<!-- Icon Boxes / End -->
	
</div>
<!-- 960 Container / End -->

<!-- 960 Container / End -->

</div>
<!-- Wrapper / End -->


<?php include_once 'footer.php'; ?>