<?php require_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php 
	if (isset($_POST["Submit"])) {
		$title = mysqli_real_escape_string($con,$_POST["title"]);
		$category = mysqli_real_escape_string($con,$_POST["category"]);
		$post = mysqli_real_escape_string($con,$_POST["post"]);
		date_default_timezone_set("Asia/Dhaka");
    	$date_time_now = date("M-d-Y H:i:s");
    	$admin = "Shakil";
    	$image = $_FILES["image"]["name"];
    	$target = "Upload/".basename($_FILES["image"]["name"]);

    	if(empty($title)){
    		$_SESSION["ErrorMessage"]="Title can't be empty";
    		Redirect_to("editPost.php");
    	}elseif(strlen($title)<2){
    		$_SESSION["ErrorMessage"]="Title should be at least 2 characters";
    		Redirect_to("editPost.php");
    	}else{
    		$getEditIdFromURL = $_GET['edit'];
    		$query = mysqli_query($con, "UPDATE admin_panel SET date_time='$date_time_now', title='$title', category='$category', author='$admin', image='$image', post='$post' WHERE id='$getEditIdFromURL' ");
    		move_uploaded_file($_FILES["image"]["tmp_name"], $target);// save image on upload folder
    		if ($query) {
    			$_SESSION["SuccessMessage"]="Post updated successfully";
    			Redirect_to("dashboard.php");
    		}else{
    			$_SESSION["ErrorMessage"]="Failed to update post";
    			Redirect_to("editPost.php");
    		}
    	}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Edit Post (Admin)</title>
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
					<li><a href="manageAdmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
					<li><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
				</ul>
			</div><!-- end col sm2-->

			<div class="col-sm-10"><!-- start cl sm10-->
				<h1>Update Post</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				<div>
					<?php 
						$postId = $_GET['edit']; //take id from url 
						$query_post = mysqli_query($con, "SELECT * FROM admin_panel WHERE id='$postId'");

						while($query_data = mysqli_fetch_array($query_post)){
							$title_to_update = $query_data['title'];
							$category_to_update = $query_data['category'];
							$image_to_update = $query_data['image'];
							$post_to_update = $query_data['post'];
						}
					?>
					<form action="editPost.php?edit=<?php echo $postId; ?>" method="POST" enctype="multipart/form-data">
						<fieldset>
							<div class="form-group">
								<label  for="title"><span class="FieldInfo">Title:</span> </label>
								<input type="text" name="title" class="form-control" id="title" value="<?php echo $title_to_update; ?>">
							</div><br>

							<div class="form-group">
								<span class="FieldInfo">Existing Category: </span>
								<?php echo $category_to_update; ?>
								<br>
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
								<span class="FieldInfo">Existing Image: </span>
								<img src="Upload/<?php echo $image_to_update;?>" width="170px"; height="70px">
								<br>
								<label  for="imageselect"><span class="FieldInfo">Select Image:</span> </label>
								<input type="File" name="image" class="form-control" id="imageselect" >
							</div>

							<div class="form-group">
								<label  for="post_area"><span class="FieldInfo">Post:</span> </label>
								<textarea class="form-control" name="post" id="post_area"><?php echo $post_to_update; ?></textarea> 
							</div>

							<br>
							<input type="Submit" name="Submit" class="btn btn-success btn-block" value="Update Post">
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