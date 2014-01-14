<?php 
include 'header.html'; 
include_once 'config/functions_users.php';

$officers = getOfficerMemberInfo();
$tech = getTechMemberInfo();
$active = getActiveMemberInfo();
?>

<div class="container">
	<div class="sixteen columns">
		<div class="warning-message">
			<div class="notification success">
				<p><span>Under Construction!</span> This page is coming soon!</p>
			</div>
		</div>
	<div>	
</div>
<div class="container">		
	<div class="eight columns">
		<div class="headline no-margins">
			<h3>Officers</h3>
		</div>
		<? $count=0;
		while($count<=$officers["count"]) { ?>
			<h4><a href="users.php?u=<? echo $officers[$count]['pawprint']; ?>"><? echo $officers[$count]['firstname'] . ' ' . $officers[$count]['lastname']; ?></a></h4>
		<? $count++;
		} ?>
		<div class="headline no-margins">
			<h3>Tech Members</h3>
		</div>
		<? $count=0;
		while($count<=$tech["count"]) { ?>
			<h4><a href="users.php?u=<? echo $tech[$count]['pawprint']; ?>"><? echo $tech[$count]['firstname'] . ' ' . $tech[$count]['lastname']; ?></a></h4>
		<? $count++;
		} ?>
	</div>
	
	<div class="eight columns">
		<div class="headline no-margins">
			<h3>Active Members</h3>
		</div>
		<? $count=0;
		while($count<=$active["count"]) { ?>
			<h4><a href="users.php?u=<? echo $active[$count]['pawprint']; ?>"><? echo $active[$count]['firstname'] . ' ' . $active[$count]['lastname']; ?></a></h4>
		<? $count++;
		} ?>			
	</div>
</div>

</div>
</div>
</div>
<?php include 'footer.php'; ?>