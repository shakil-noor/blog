<?php require_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<?php 
	if (isset($_POST["Submit"])) {
		$username = mysqli_real_escape_string($con,$_POST["username"]);
		$password = mysqli_real_escape_string($con,$_POST["password"]);
		$confirmPassword = mysqli_real_escape_string($con,$_POST["confirmPassword"]);
		date_default_timezone_set("Asia/Dhaka");
    	$date_time_now = date("M-d-Y H:i:s");

    	if(empty($username) || empty($password) || empty($confirmPassword)){
    		$_SESSION["ErrorMessage"]="All Field must be filled out";
    		Redirect_to("manageAdmin.php");
    	}elseif(strlen($password)< 6){
    		$_SESSION["ErrorMessage"]="Please use atleast 6 characters for password";
    		Redirect_to("manageAdmin.php");
    	}elseif(strlen($confirmPassword)< 6){
    		$_SESSION["ErrorMessage"]="Please use atleast 6 characters for password";
    		Redirect_to("manageAdmin.php");
    	}elseif($password!==$confirmPassword){
    		$_SESSION["ErrorMessage"]="Passwords doesn't matched";
    		Redirect_to("manageAdmin.php");
    	}else{
    		$query = mysqli_query($con, "INSERT INTO admins VALUES('','$username','$password','$date_time_now','admin')");
    		if ($query) {
    			$_SESSION["SuccessMessage"]="New admin added successfully";
    			Redirect_to("manageAdmin.php");
    		}else{
    			$_SESSION["ErrorMessage"]="Failed to add new admin";
    			Redirect_to("manageAdmin.php");
    		}
    	}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Manage Admin</title>
	<link rel="shortcut icon" href="assets/image/cv.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/adminStyle.css">
</head>
<body>
	<?php include_once("template/nav.php") ?>
	<div class="line" style="height: 10px; background-color: #27aae1;"></div>
	<div class="container-fluid"><!-- start container-fluid-->
		<div class="row"><!--start row-->
			<div class="col-sm-2 left-one"><!-- start cl sm2-->
				<ul id="side_menu" class="nav nav-pills nav-stacked">
					<li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
					<li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
					<li><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Category</a></li>
					<li class="active"><a href="manageAdmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
					<li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comment
						<span class="label pull-right label-warning">
									<?php 
										$comment_count = count_comment();
										echo $comment_count;
									?>
								</span>
								<?php //} ?>
					</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
				</ul>
			</div><!-- end col sm2-->

			<div class="col-sm-10"><!-- start cl sm10-->
				<h1>Managed Admin</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				<div>
					<form action="manageAdmin.php" method="POST">
						<fieldset>
							<div class="form-group">
								<label  for="username"><span class="FieldInfo">Username:</span> </label>
								<input type="text" name="username" class="form-control" id="username" placeholder="Username">
							</div><br>
							<div class="form-group">
								<label  for="password"><span class="FieldInfo">Password:</span> </label>
								<input type="password" name="password" class="form-control" id="password" placeholder="Password">
							</div><br>
							<div class="form-group">
								<label  for="confirmPassword"><span class="FieldInfo">Confirm Password:</span> </label>
								<input type="password" name="confirmPassword" class="form-control" id="confirmPassword" placeholder="Confirm Password">
							</div><br>

							<input type="Submit" name="Submit" class="btn btn-success btn-block" value="Add New Admin">
						</fieldset>
						<br>
					</form>
				</div>

				<div class="table-rsponsiv"><!-- start Table div -->
					<h3>Category List</h3>
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr. No</th>
							<th>username</th>
							<th>Date & Time</th>
							<th>Added By</th>
							<th>Action</th>
						</tr>
						<?php
						$admin_data = mysqli_query($con, "SELECT * FROM admins");
						while($ad = mysqli_fetch_array($admin_data)){
							$id = $ad["id"];
							$username = $ad["username"];
							$dateTime = $ad["date_time"];
							$addedBy = $ad["added_by"];
						?>
						<tr>
							<td><?php echo $id; ?></td>
							<td><?php echo $username; ?></td>
							<td><?php echo $dateTime; ?></td>
							<td><?php echo $addedBy; ?></td>
							<td><a href="deleteAdmin.php?id=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
						</tr>
						<?php } ?>
					</table>
				</div><!-- end Table div -->
			</div><!-- end col sm10-->
		</div><!-- end row-->
	</div><!-- end container fluid-->


	<?php include_once("template/footer.php") ?>
</body>
</html>