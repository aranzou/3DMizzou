<?php 
include 'header.html'; 
include_once 'config/functions_users.php';
include_once 'config/functions_admin.php';

if(isset($_GET['u'])) $pawprint = $_GET['u'];
if($pawprint!=NULL) $userID = getUserID($pawprint);

if(isOfficer($userID)) { 
	$isofficer = true;
	$userinfo = getOfficerByID($userID);
} else {
	$userinfo = getMemberInfo($userID);
}

$date = explode(" ", $userinfo['registerDate']);

if($_GET['p']=="") $_GET['p']="profile";

?>

<div class="container"><br />
	<div class="four columns">
		<div class="userelements"><img src="uploads/profile/<? echo getAvatar($userID); ?>" /></div>
		<div class="headline"><h3>Menu</h3></div>
		<div id="sidebar">
			<ul>
				<li><a href="users.php?u=<? echo $userinfo['pawprint']; ?>&p=profile">Profile Info</a></li>
				<li><a href="users.php?u=<? echo $userinfo['pawprint']; ?>&p=badges">Badges Earned</a></li>
				<li><a href="users.php?u=<? echo $userinfo['pawprint']; ?>&p=portfolio">Portfolio</a></li>
			</ul>
		</div>
	</div>
	
		<div class="twelve columns">
			<h2><? echo $userinfo['firstname'] . ' ' . $userinfo['lastname']; ?></h2>
	<? if($_GET['p']=="profile") { ?>	
			<? if ($isofficer) { ?>
			<div class="headline no-margins">
				<h3>Officer Info</h3>
			</div>
			
			<div class="userelements">
				<b>Officer Position: </b><p><? echo $userinfo['pos']; ?></p>
				<b>Officer Bio: </b><p><? echo $userinfo['bio']; ?></p>
				<b>Favorite Quote: </b><p><? echo $userinfo['quote']; ?></p>
			</div>
			
			<? } ?>
			
			<div class="headline no-margins">
				<h3>User Info</h3>
			</div>
			
			<div class="userelements">
				<span>PawPrint: </span><div class="elementsinline"><? echo $userinfo['pawprint']; ?></div>
				<span>Major: </span><div class="elementsinline"><? echo $userinfo['major']; ?></div>
				<span>School Year: </span><div class="elementsinline"><? echo $userinfo['schoolYear']; ?></div>
				<span>Member Since: </span><div class="elementsinline"><? echo $date[0]; ?></div>
			</div>
			
	<? } else if ($_GET['p']=="badges") { ?>
		<div class="badgePlaceholder">
			<div class="headline no-margins">
				<h3>Badges and Rank Info</h3>
			</div>
			<? $category = getBadgeCategories(); ?>
				<? $catCount=0;
				while($catCount <= count($category)) { ?>
					<ul class="polaroids">
						<? $count=0;
						$earned = getEarnedBadgesByCategory($userID, $category[$catCount]["id"]); ?>
						<? while($count < count($earned)) { ?>
							<li>
								<a href="" title="<? echo $earned[$count]["name"] ?>">
									<img src="images/badges/stock.png" />
								</a>
							</li>
						<? 
						$count++; } ?>
					</ul> 
					<? $catCount++;
				 } ?>
			</div>

	<? } else if ($_GET['p']=="portfolio") { ?>
			<div class="headline no-margins">
				<h3>User Portfolio</h3>
			</div>
			<div class="warning-message">
				<div class="notification warning">
					<p><span>Notice!</span> This feature is coming soon!</p>
				</div>
			</div>
	<? } ?>
	</div>
</div>
</div>
</div>
<?php include 'footer.php'; ?>
