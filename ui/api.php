<?php
if (!isset($_CODE_API_)) {
    throw new Exception("Code file not included for api.php!");
}
?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<meta name="viewport" content="width=device-width, initial-scale=1">
</head>

<body>

	<?php
	include __DIR__ .'/header.php';
	include __DIR__ .'/sidebar.php';
	?>

	<!-- Main workspace starts from here -->
	<div id="content-wrapper">
		<div class="row">
			<ol class="breadcrumb">
			    <li><a href="dashboard.php">Home</a></li>
			    <li class="active">API</li>
			</ol>
		</div>
		<div class="row">
		    <div class="col-md-9">
		    	<h3>List of all APIs</h3>
		    </div>
		    <div class="col-md-3">
				<a href="api_add.php" type="button" class="btn btn-success pull-right">Add</a>
			</div>
		</div>
		<div class="row">
			<div class="col-md-12">
				<table class="table">
					<tr style="background-color: #E0E0E0;">
						<th class="col-md-1"><center>#ID</center></th>
						<th class="col-md-1">Code</th>
						<th class="col-md-3">Name</th>
						<th class="col-md-2">Template Used</th>
						<th class="col-md-2"><center>Created On</center></th>
						<th class="col-md-3 pull-right">Actions</th>
					</tr>
					<?php
						foreach ($apis as $value) {
							echo '<tr>';
							echo '<td><center>' .$value['id'] .'</center></td>';
							echo '<td>' .$value['code'] .'</td>';
							echo '<td>' .$value['name'] .'</td>';
							echo '<td>' .$value['template_name'] .'</td>';
							echo '<td><center>' .date("D, d M 20y", $value['created_on']).'<br>'.date("h:i:s A (e)", $value['created_on']).'</center></td>';
							echo '<td class="pull-right">';
								$view = "api_view.php?id=".$value['id'];
								echo '<a class="btn btn-info button-view" href='.$view.' role="button" id='.$value['id'].'>View</a> ';
								$edit = "api_edit.php?id=".$value['id'];
								echo '<a class="btn btn-primary button-edit" href='.$edit.' role="button" id='.$value['id'].'>Edit</a> ';
								echo '<a class="btn btn-danger button-delete" href="#" role="button" data-toggle="modal" data-target="#delete" id='.$value['id'].'>Delete</a> ';
							echo '</td>';
							echo '</tr>';
						}
					?>
				</table>
			</div>
		</div>
		<div id="delete" class="modal fade" role="dialog" style="z-index: 15000; margin-top:100px;">
  			<div class="modal-dialog">
    			<div class="modal-content">
    				<div class="modal-header">
        				<h4 class="modal-title">Delete API</h4>
      				</div>
      				<div class="modal-body">
        				<p>Are you sure you want to delete this API?</p>
        				<br>
        				<button type="button" class="btn btn-danger button-delete-confirm" data-dismiss="modal">Delete</button>
        				<button type="button" class="btn btn-link" data-dismiss="modal">Cancel</button>
        			</div>
    			</div>
  			</div>
		</div>
	</div>
<script src="js/jAlert-v3.js"></script>
<script src="js/jAlert-functions.js"></script>
<script src="js/main.js"></script>
<script src="js/api.js"></script>
</body>
</html>