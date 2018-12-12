<?php require_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<?php 
	if (isset($_POST["Submit"])) {
		$title = mysqli_real_escape_string($con,$_POST["title"]);
		$category = mysqli_real_escape_string($con,$_POST["category"]);
		$post = $_POST["post"];
		date_default_timezone_set("Asia/Dhaka");
    	$date_time_now = date("M-d-Y H:i:s");
    	$admin = $_SESSION['username'];
    	$image = $_FILES["image"]["name"];
    	$target = "Upload/".basename($_FILES["image"]["name"]);

    	if(empty($title)){
    		$_SESSION["ErrorMessage"]="Title can't be empty";
    		Redirect_to("addNewPost.php");
    	}elseif(strlen($title)<2){
    		$_SESSION["ErrorMessage"]="Title should be at least 2 characters";
    		Redirect_to("addNewPost.php");
    	}else{
    		$query = mysqli_query($con, "INSERT INTO admin_panel VALUES('','$date_time_now','$title','$category','$admin','$image','$post')");
    		move_uploaded_file($_FILES["image"]["tmp_name"], $target);// save image on upload folder
    		if ($query) {
    			$_SESSION["SuccessMessage"]="New post added successfully";
    			Redirect_to("addNewPost.php");
    		}else{
    			$_SESSION["ErrorMessage"]="Failed to add new post";
    			Redirect_to("addNewPost.php");
    		}
    	}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Add New Post (Admin)</title>
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
					<li class="active"><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
					<li><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Category</a></li>
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
				<h1>Add New Post</h1>
				<div>
                   <?php
               		echo ErrorMessage(); 
					echo SuccessMessage();
    				?>
                </div>
				<div>
					<form action="addNewPost.php" method="POST" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label  for="title"><span class="FieldInfo">Title:</span> </label>
								<input type="text" name="title" class="form-control" id="title" placeholder="Title">
							</div><br>
							<div class="form-group">
								<label  for="category_select"><span class="FieldInfo">Category:</span></label>
								<select class="form-control" id="category_select" name="category">
									<?php
									$category_data = mysqli_query($con, "SELECT * FROM category ORDER BY datetime DESC");
									while($cd = mysqli_fetch_array($category_data)){
										$id = $cd["id"];
										$categoryName = $cd["name"];
									?>
										<option><?php echo $categoryName ?></option>
									<?php } ?>	
								</select>
							</div>
							<div class="form-group">
								<label  for="imageselect"><span class="FieldInfo">Select Image:</span> </label>
								<input type="File" name="image" class="form-control" id="imageselect" >
							</div>
							<div class="form-group">
								<label  for="post_area"><span class="FieldInfo">Post:</span> </label>
								<textarea class="form-control" id="post_text" name="post" id="post_area"></textarea> 
							</div>

							<br>
							<input type="Submit" name="Submit" class="btn btn-success btn-block" value="Add New Category">
						</fieldset>
						<br>
					</form>
				</div>

				
			</div><!-- end col sm10-->
		</div><!-- end row-->
	</div><!-- end container fluid-->

	<?php include_once("template/footer.php") ?>

</body>
</html>