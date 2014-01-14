<?php 
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(1, $user->data['username_clean'])) {
	deniedUser();
}

include 'header.html'; 
include 'sidebar.html'; 

?>
    <div class="content">
        
        <div class="header">
            <div class="stats">

</div>

            <h1 class="page-title">Dashboard</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Dashboard</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
                    

<div class="row-fluid">

    <div class="block">
        <a href="#page-stats" class="block-heading" data-toggle="collapse">Latest Stats</a>
        <div id="page-stats" class="block-body collapse in">

            <div class="stat-widget-container">
                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title"><? echo countUsers(); ?></p>
                        <p class="detail">Accounts</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title"><? echo countMembers(); ?></p>
                        <p class="detail">Members</p>
                    </div>
                </div>

                <div class="stat-widget">
                    <div class="stat-button">
                        <p class="title"><? echo countUnapproved(); ?></p>
                        <p class="detail">Needs Approving</p>
                    </div>
                </div>

            </div>
        </div>
    </div>
</div>

<?php include 'footer.html'; ?>

