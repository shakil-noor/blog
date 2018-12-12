<?php require_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<?php 
	if (isset($_POST["Submit"])) {
		$category = mysqli_real_escape_string($con,$_POST["Category"]);
		date_default_timezone_set("Asia/Dhaka");
    	$date_time_now = date("M-d-Y H:i:s");
    	$admin = $_SESSION['username'];

    	if(empty($category)){
    		$_SESSION["ErrorMessage"]="Field must be filled out";
    		Redirect_to("category.php");
    	}elseif(strlen($category)>100){
    		$_SESSION["ErrorMessage"]="Keep the category name within 100 characters";
    		Redirect_to("category.php");
    	}else{
    		$query = mysqli_query($con, "INSERT INTO category VALUES('','$date_time_now','$category','$admin')");
    		if ($query) {
    			$_SESSION["SuccessMessage"]="Category added successfully";
    			Redirect_to("category.php");
    		}else{
    			$_SESSION["ErrorMessage"]="Failed to add category";
    			Redirect_to("category.php");
    		}
    	}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Category (Admin)</title>
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
					<li class="active"><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Category</a></li>
					<li><a href="manageAdmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
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
				<h1>Managed Categories</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				<div>
					<form action="category.php" method="POST">
						<fieldset>
							<div class="form-group">
								<label  for="categoryName"><span class="FieldInfo">Name:</span> </label>
								<input type="text" name="Category" class="form-control" id="categoryName" placeholder="Category Name">
							</div><br>
							<input type="Submit" name="Submit" class="btn btn-success btn-block" value="Add New Category">
						</fieldset>
						<br>
					</form>
				</div>

				<div class="table-rsponsiv"><!-- start Table div -->
					<h3>Category List</h3>
					<table class="table table-striped table-hover">
						<tr>
							<th>Sr. No</th>
							<th>Date and Time</th>
							<th>Category Name</th>
							<th>Craetor Name</th>
							<th>Action</th>
						</tr>
						<?php
						$category_data = mysqli_query($con, "SELECT * FROM category ORDER BY datetime DESC");
						while($cd = mysqli_fetch_array($category_data)){
							$id = $cd["id"];
							$dateTime = $cd["datetime"];
							$categoryName = $cd["name"];
							$creatorname = $cd["creatorName"];
						?>
						<tr>
							<td><?php echo $id; ?></td>
							<td><?php echo $dateTime; ?></td>
							<td><?php echo $categoryName; ?></td>
							<td><?php echo $creatorname; ?></td>
							<td><a href="deleteCategory.php?id=<?php echo $id; ?>"><span class="btn btn-danger">Delete</span></a></td>
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