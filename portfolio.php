<?php 
include 'header.html'; 
include_once 'config/connect_db.php';
?>

<!-- 960 Container -->
<div class="container">

	<div class="sixteen columns">
	
		<!-- Page Title -->
		<div id="page-title">
			<h2>Portfolio</h2>
			
			<div class="clear"></div>
			
			<div id="bolded-line"></div>
		</div>
		<!-- Page Title / End -->

	</div>
</div>
<!-- 960 Container / End -->

<!-- 960 Container -->
<div class="container">
	
	<!-- Portfolio Content -->
	<div id="portfolio-wrapper">
		<?php 
		$mysqli = serverConnect();
		$query = "SELECT picName, thumbnail, picTitle, description FROM sitePics";
		
		if ($mysqli->multi_query($query)) {
			do {
				/* store first result set */
				if ($result = $mysqli->store_result()) {
					while ($row = $result->fetch_row()) { ?>
					<div class="eight columns portfolio-item">
						<div class="picture"><a href="images/upload/site/<? echo $row[0]; ?>" rel="image" title="Maritime Details"><img src="images/upload/site/thumbs/<? echo $row[1]; ?>" alt=""/><div class="image-overlay-zoom"></div></a></div>
							<div class="item-description alt">
							<h5><a href="single_project.html"><? echo $row[2]; ?></a></h5>
							<p><? echo $row[3]; ?></p>
						</div>
					</div>
					<? }
					$result->free();
				}
			} while ($mysqli->next_result());
		}
		?>


	</div>
	<!-- End Portfolio Content -->
		
</div>
<!-- End 960 Container -->

</div>
<!-- Wrapper / End -->

<?php include 'footer.php'; ?>