<?php require_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php 
	if (isset($_POST["Submit"])) {
		$getDeleteIdFromURL = $_GET['delete'];
		$query = mysqli_query($con, "DELETE FROM admin_panel WHERE id='$getDeleteIdFromURL' ");
		if ($query) {
			$_SESSION["SuccessMessage"]="Post deleted successfully";
			Redirect_to("dashboard.php");
		}else{
			$_SESSION["ErrorMessage"]="Failed to delete post";
			Redirect_to("dashboard.php");
		}
	}
?>

<!DOCTYPE html>
<html>
<head>
	<title>Delete Post (Admin)</title>
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
					<li><a href="#"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
					<li><a href="#"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
				</ul>
			</div><!-- end col sm2-->

			<div class="col-sm-10"><!-- start cl sm10-->
				<h1>Delete Post</h1><hr>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				<div>
					<?php 
						$deletepostId = $_GET['delete']; //take id from url 
						$query_post = mysqli_query($con, "SELECT * FROM admin_panel WHERE id='$deletepostId'");

						while($query_data = mysqli_fetch_array($query_post)){
							$title_to_update = $query_data['title'];
							$category_to_update = $query_data['category'];
							$image_to_update = $query_data['image'];
							$post_to_update = $query_data['post'];
						}
					?>

					<form action="deletePost.php?delete=<?php echo $deletepostId; ?>" method="POST" enctype="multipart/form-data">
						<fieldset>
							<span class="FieldInfo">Title: <?php echo $title_to_update; ?></span><br><br>

							<span class="FieldInfo">Existing Category: <?php echo $category_to_update; ?></span><br><br>

							
							<span class="FieldInfo">Existing Image: </span>
							<img src="Upload/<?php echo $image_to_update;?>" width="170px"; height="70px">
							<br><br>

							<label  for="post_area"><span class="FieldInfo">Post:</span> </label>
							<textarea disabled class="form-control" id="post_text" name="post" id="post_area"><?php echo $post_to_update; ?></textarea> 
							
							<br>
							<div class="alert alert-danger" style="font-size: 20px;">Are you sure want to delete this post?</div>
							<input type="Submit" name="Submit" class="btn btn-danger btn-block" value="Delete Post">
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