<?php
include 'config/auth.php';
include_once '../config/functions_admin.php'; 

if(!accessLevelVerify(4, $user->data['username_clean'])) {
	deniedUser();
}

include_once '../config/functions_admin.php';
include_once '../config/functions_users.php';

include 'header.html'; 
include 'sidebar.html';
?> 

<? function listbadges() { ?>
<script>
var badgeID;

function setID($badgeID) {
	badgeID = $badgeID;
}

function DeleteItem() {
    $.post("functions.php", { id: badgeID, action: "deleteBadge"}, function(data) {
        element = document.getElementById(badgeID);
		element.parentNode.removeChild(element);
    });
}

function createForm() {
    window.location.href="badges.php?p=createbadge";
}

</script>

    <div class="content">
        
        <div class="header">

            
            <h1 class="page-title">Badges</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Badges</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
       
<div class="btn-toolbar">
    <button onclick="createForm()" class="btn btn-primary"><i class="icon-plus"></i> Add a Badge</button>
  <div class="btn-group">
  </div>
</div>

<?
$category = getBadgeCategories();

$count = 1;
while($count <= count($category)) {
	$badge = getBadgesByCategory($category[$count]["id"]);
?>
	
		<h4>Category: <? echo $category[$count]["name"]; ?></h4>
		<div class="well">
			<table class="table">
			  <thead>
				<tr>
				  <th>Badge Name</th>
                                  <th>Description</th>
				  <th>Image</th>
				  <th style="width: 26px;"></th>
				</tr>
			  </thead>
				<tbody>
<?
	$count2 = 1;
	while($count2 <= count($badge)) {
?>
					<tr id="<? echo $badge[$count2]["id"]; ?>">
						<td><? echo $badge[$count2]["name"]; ?></td>
                                                <td><? echo $badge[$count2]["description"]; ?></td>
						<td><? echo $badge[$count2]["image"]; ?></td>
						<td>
							<a href="badges.php?p=editBadge&id=<? echo $badge[$count2]["id"]; ?>"><i class="icon-pencil"></i></a>
							<a href="#myModal" role="button" onclick="setID(<? echo $badge[$count2]["id"]; ?>)" data-toggle="modal"><i class="icon-remove"></i></a>
						</td>
					</tr>	
<?	
		$count2++;
	}
?>
			   </tbody>
			</table>
		</div>
<?
$count++;
} ?>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">◊</button>
    <h3 id="myModalLabel">Cancel Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this badge?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" onclick="DeleteItem()" data-dismiss="modal">Delete</button>
  </div>
</div>
                
<? } 

function create() { ?>
        <script>
        function Cancel() {
            window.history.back(-1);
        }

        function SaveItem() {
            
            var badgename = $('input[name=badgename]');
            
            var description = document.getElementById('desc');
            
            var category_object = document.getElementById("category_select");
            var category = (category_object.options[category_object.selectedIndex]).value;

            if(badgename.val()=="") {
                    alert("Please fill in ALL fields!");
                    return false;
            }

            $.post("functions.php", { 
                        name: badgename.val(),
                        description: description.value,
                        category: category,
                        action: "addBadge"
                        }, function(data) {
                                alert(data);
            });

        }   
    </script>
    
        <div class="content">

            <div class="header">

                <h1 class="page-title">Create Badge</h1>
            </div>

                    <ul class="breadcrumb">
                <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                <li><a href="badges.php?p=listbadge">Badges</a> <span class="divider">/</span></li>
                <li class="active">Create Badge</li>
            </ul>

            <div class="container-fluid">
                <div class="row-fluid">

    <div class="btn-toolbar">
        <button class="btn btn-primary" onclick="SaveItem();"><i class="icon-save"></i> Save</button>
        <a href="#myModal" data-toggle="modal" class="btn">Cancel</a>
      <div class="btn-group">
      </div>
    </div>
    <div class="well">
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane active in" id="home">
        <? $badges = getBadgeCategories();?>
        <form id="tab">
            <label>Name</label>
                <input type="text" name="badgename" class="input-xlarge">
            <label>Description</label>
                <textarea id="desc" cols="20" rows="10" class="input-xlarge"></textarea>
            <label>Category</label>
                <select id="category_select" class="input-xlarge">
                    <? 
                    $count=1;
                    while($count <= count($badges)) { ?>
                        <option value="<? echo $badges[$count]["id"]; ?>"><? echo $badges[$count]["name"]; ?></option>
                    <? 
                    $count++;
                    } ?>
                </select>
        </form>
          </div>
      </div>

    </div>

    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
      </div>
      <div class="modal-body">

        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to cancel?</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" onclick="Cancel()" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    
            </div>
        </div>
    </div>
<? } 

function editBadge() { ?>
        <script>
        function Cancel() {
            window.history.back(-1);
        }

        function SaveItem() {
            
            var badgename = $('input[name=badgename]');
            var badgeid = $('input[name=badgeid]');
            
            var description = document.getElementById('desc');
            
            var category_object = document.getElementById("category_select");
            var category = (category_object.options[category_object.selectedIndex]).value;

            if(badgename.val()=="") {
                    alert("Please fill in ALL fields!");
                    return false;
            }

            $.post("functions.php", { 
                        name: badgename.val(),
                        badgeID: badgeid.val(),
                        description: description.value,
                        category: category,
                        action: "editBadge"
                        }, function(data) {
                                alert(data);
            });

        }   
    </script>
    
        <div class="content">

            <div class="header">

                <h1 class="page-title">Create Badge</h1>
            </div>

                    <ul class="breadcrumb">
                <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                <li><a href="badges.php?p=listbadge">Badges</a> <span class="divider">/</span></li>
                <li class="active">Create Badge</li>
            </ul>

            <div class="container-fluid">
                <div class="row-fluid">

    <div class="btn-toolbar">
        <button class="btn btn-primary" onclick="SaveItem();"><i class="icon-save"></i> Save</button>
        <a href="#myModal" data-toggle="modal" class="btn">Cancel</a>
      <div class="btn-group">
      </div>
    </div>
    <div class="well">
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane active in" id="home">
        <? 
        $badgeinfo = getBadge($_GET['id']);
        $cats = getBadgeCategories();?>
        <form id="tab">
            <input type="hidden" name="badgeid" value="<? echo $_GET['id']; ?>"/>
            <label>Name</label>
                <input type="text" name="badgename" value="<? echo $badgeinfo["name"]; ?>" class="input-xlarge">
            <label>Description</label>
                <textarea id="desc" cols="20" rows="10" class="input-xlarge"><? echo $badgeinfo["description"]; ?></textarea>
            <label>Category</label>
                <select id="category_select" class="input-xlarge">
                    <? 
                    $count=1;
                    while($count <= count($cats)) {
                        if($cats[$count]["id"]==$badgeinfo["category"]) { ?>
                            <option value="<? echo $cats[$count]["id"]; ?>" selected="selected"><? echo $cats[$count]["name"]; ?></option>
                        <? } else { ?>
                            <option value="<? echo $cats[$count]["id"]; ?>"><? echo $cats[$count]["name"]; ?></option>
                        <? } ?>
                    <? 
                    $count++;
                    } ?>
                </select>
        </form>
          </div>
      </div>

    </div>

    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Delete Confirmation</h3>
      </div>
      <div class="modal-body">

        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to cancel?</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" onclick="Cancel()" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    
            </div>
        </div>
    </div>    
<? }

function listCategories() { ?>
<script>
var catID;

function setID($catID) {
	catID = $catID;
}

function DeleteItem() {
    $.post("functions.php", { id: catID, action: "deleteCategory"}, function(data) {
        element = document.getElementById(catID);
		element.parentNode.removeChild(element);
    });
}

function createForm() {
    window.location.href="badges.php?p=createcategory";
}

</script>

    <div class="content">
        
        <div class="header">

            
            <h1 class="page-title">Categories</h1>
        </div>
        
                <ul class="breadcrumb">
            <li><a href="index.php">Home</a> <span class="divider">/</span></li>
            <li class="active">Categories</li>
        </ul>

        <div class="container-fluid">
            <div class="row-fluid">
       
<div class="btn-toolbar">
    <button onclick="createForm()" class="btn btn-primary"><i class="icon-plus"></i> Add a Category</button>
  <div class="btn-group">
  </div>
</div>
	
		<div class="well">
			<table class="table">
			  <thead>
				<tr>
				  <th>Category Name</th>
                                  <th>Description</th>
				  <th style="width: 26px;"></th>
				</tr>
			  </thead>
				<tbody>
                        <?
                        $category = getBadgeCategories();

                        $count = 1;
                        while($count <= count($category)) {
                        ?>
                                <tr id="<? echo $category[$count]["id"]; ?>">
                                        <td><? echo $category[$count]["name"]; ?></td>
                                        <td><? echo $category[$count]["description"]; ?></td>
                                        <td>
                                                <a href="badges.php?p=editcategory&id=<? echo $category[$count]["id"]; ?>"><i class="icon-pencil"></i></a>
                                                <a href="#myModal" role="button" onclick="setID(<? echo $category[$count]["id"]; ?>)" data-toggle="modal"><i class="icon-remove"></i></a>
                                        </td>
                                </tr>
                        <?
                        $count++;
                        } ?>
			   </tbody>
			</table>
		</div>

<div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
  <div class="modal-header">
    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">◊</button>
    <h3 id="myModalLabel">Delete Confirmation</h3>
  </div>
  <div class="modal-body">
    
    <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to delete this badge?</p>
  </div>
  <div class="modal-footer">
    <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
    <button class="btn btn-danger" onclick="DeleteItem()" data-dismiss="modal">Delete</button>
  </div>
</div>
                
<? }

function createcategory() { ?>
<script>
        function Cancel() {
            window.history.back(-1);
        }

        function SaveItem() {
            
            var catname = $('input[name=catname]');            
            var description = document.getElementById('desc');

            if(catname.val()=="") {
                    alert("Please fill in ALL fields!");
                    return false;
            }

            $.post("functions.php", { 
                        name: catname.val(),
                        description: description.value,
                        action: "addCategory"
                        }, function(data) {
                                alert(data);
            });

        }   
    </script>
    
        <div class="content">

            <div class="header">

                <h1 class="page-title">Create Category</h1>
            </div>

                    <ul class="breadcrumb">
                <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                <li><a href="badges.php?p=listcategory">Categories</a> <span class="divider">/</span></li>
                <li class="active">Create Category</li>
            </ul>

            <div class="container-fluid">
                <div class="row-fluid">

    <div class="btn-toolbar">
        <button class="btn btn-primary" onclick="SaveItem();"><i class="icon-save"></i> Save</button>
        <a href="#myModal" data-toggle="modal" class="btn">Cancel</a>
      <div class="btn-group">
      </div>
    </div>
    <div class="well">
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane active in" id="home">
        <form id="tab">
            <label>Name</label>
                <input type="text" name="catname" class="input-xlarge">
            <label>Description</label>
                <textarea id="desc" cols="20" rows="10" class="input-xlarge"></textarea>
        </form>
          </div>
      </div>

    </div>

    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Cancel Confirmation</h3>
      </div>
      <div class="modal-body">

        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to cancel?</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" onclick="Cancel()" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    
            </div>
        </div>
    </div> 
<? }

function editCategory() { ?>
<script>
        function Cancel() {
            window.history.back(-1);
        }

        function SaveItem() {
            
            var catid = $('input[name=catid]');
            var catname = $('input[name=catname]');            
            var description = document.getElementById('desc');

            if(catname.val()=="") {
                    alert("Please fill in ALL fields!");
                    return false;
            }

            $.post("functions.php", { 
                        id: catid.val(),
                        name: catname.val(),
                        description: description.value,
                        action: "editCategory"
                        }, function(data) {
                                alert(data);
            });

        }   
    </script>
    
        <div class="content">

            <div class="header">

                <h1 class="page-title">Edit Category</h1>
            </div>

                    <ul class="breadcrumb">
                <li><a href="index.php">Home</a> <span class="divider">/</span></li>
                <li><a href="badges.php?p=listcategory">Categories</a> <span class="divider">/</span></li>
                <li class="active">Edit Category</li>
            </ul>

            <div class="container-fluid">
                <div class="row-fluid">

    <div class="btn-toolbar">
        <button class="btn btn-primary" onclick="SaveItem();"><i class="icon-save"></i> Save</button>
        <a href="#myModal" data-toggle="modal" class="btn">Cancel</a>
      <div class="btn-group">
      </div>
    </div>
    <? $category = getCategory($_GET['id']); ?>
    <div class="well">
        <div id="myTabContent" class="tab-content">
          <div class="tab-pane active in" id="home">
        <form id="tab">
            <input type="hidden" value="<? echo $_GET['id']; ?>" name="catid" />
            <label>Name</label>
                <input type="text" name="catname" value="<? echo $category["name"]; ?>" class="input-xlarge">
            <label>Description</label>
                <textarea id="desc" cols="20" rows="10" class="input-xlarge"><? echo $category["description"]; ?></textarea>
        </form>
          </div>
      </div>

    </div>

    <div class="modal small hide fade" id="myModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
      <div class="modal-header">
        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
        <h3 id="myModalLabel">Cancel Confirmation</h3>
      </div>
      <div class="modal-body">

        <p class="error-text"><i class="icon-warning-sign modal-icon"></i>Are you sure you want to cancel?</p>
      </div>
      <div class="modal-footer">
        <button class="btn" data-dismiss="modal" aria-hidden="true">Cancel</button>
        <button class="btn btn-danger" onclick="Cancel()" data-dismiss="modal">Cancel</button>
      </div>
    </div>

    
            </div>
        </div>
    </div> 
<? }

if($_GET['p']=="listbadge") {
    listbadges();
} else if ($_GET['p']=="createbadge") {
    create();
} else if ($_GET['p']=="editBadge") {
    editBadge();
} else if ($_GET['p']=="listcategory") {
    listCategories();
} else if ($_GET['p']=="createcategory") {
    createcategory();
} else if ($_GET['p']=="editcategory") {
    editCategory();
}

include 'footer.html'; ?>
