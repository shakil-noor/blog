<?php include_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<!DOCTYPE html>
<html>
<head>
	<title>Comments (Admin)</title>
	<link rel="shortcut icon" href="assets/image/cv.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/adminStyle.css">
</head>
<body>
	<nav class="navbar navbar-inverse" role= "navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">Toggle Navigation</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
				</button>
				<a class="navbar-brand" href="blog.php">
					<img style="margin-top: -10px; border-radius: 2px;" src="assets/image/l1.png" width=100; height=40;>
				</a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
				<ul class="nav navbar-nav">
					<li><a href="#">Home</a></li>
					<li><a href="../blog.php" target="_blank">Blog</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				
				<form action="" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" name="search" class="form-control" placeholder="Search">
					</div>
					<button class="btn btn-default" name="search_button">Go</button>
				</form>
			</div>	
		</div>
	</nav>
	<div class="line" style="height: 10px; background-color: #27aae1;"></div>
	<div class="container-fluid"><!-- start container-fluid-->
		<div class="row"><!--start row-->
			<div class="col-sm-2"><!-- start cl sm2/side area-->
				<br>
				<ul id="side_menu" class="nav nav-pills nav-stacked">
					<li><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
					<li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
					<li><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Caregory</a></li>
					<li><a href="manageAdmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
					<li class="active"><a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comment</a></li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
				</ul>
			</div><!-- end col sm2/side area-->

			<div class="col-sm-10"><!-- start cl sm10-->
				
				<h1>Unapprove Comments</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Commentor Name</th>
							<th>Date & Time</th>
							<th>Comment</th>
							<th>Approved</th>
							<th>Delete Comment</th>
							<th>Details</th>
						</tr>
						<?php 
							$commentQuery = mysqli_query($con, "SELECT * FROM comments WHERE status='OFF' ORDER BY DateTime DESC");
							$srNo = 0;
							while ($cmntQuery=mysqli_fetch_array($commentQuery)) {
								$commentId = $cmntQuery["id"];
								$commentorName = $cmntQuery["name"];
								$date_time = $cmntQuery["DateTime"];
								$comment = $cmntQuery["comment"];
								$commentedPostId = $cmntQuery["admin_panel_id"];
								$srNo++;
								if (strlen($commentorName)>10) {
									$commentorName = substr($commentorName, 0, 10). '...';
								}
						?>
						<tr>
							<td><?php echo htmlentities($srNo); ?></td>
							<td style="color: #5e5eff;"><?php echo htmlentities($commentorName); ?></td>
							<td><?php echo htmlentities($date_time); ?></td>
							<td><?php echo htmlentities($comment); ?></td>
							<td>
								<a href="approveComment.php?id=<?php echo $commentId; ?>"><span class="btn btn-success">Approve</span></a>
							</td>
							<td>
								<a href="deleteComment.php?delete=<?php echo $commentId; ?>"><span class="btn btn-danger">Delete</span></a> 
							</td>
							<td>
								<a href="../fullPost.php?id=<?php echo $commentedPostId; ?>" target="_blank"><span class="btn btn-info">Live Preview</span></a> 
							</td>
						</tr>
						<?php } ?>
					</table>
				</div>

				<!-- Show Approved comments -->
				<h1>Approved Comments</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Commentor Name</th>
							<th>Date & Time</th>
							<th>Comment</th>
							<th>Approve</th>
							<th>Delete Comment</th>
							<th>Details</th>
						</tr>
						<?php 
							$commentQuery = mysqli_query($con, "SELECT * FROM comments WHERE status='ON' ORDER BY DateTime DESC");
							$srNo = 0;
							while ($cmntQuery=mysqli_fetch_array($commentQuery)) {
								$commentId = $cmntQuery["id"];
								$commentorName = $cmntQuery["name"];
								$date_time = $cmntQuery["DateTime"];
								$comment = $cmntQuery["comment"];
								$commentedPostId = $cmntQuery["admin_panel_id"];
								$srNo++;

								if (strlen($commentorName)>10) {
									$commentorName = substr($commentorName, 0, 10). '...';
								}
						?>
							<tr>
								<td><?php echo htmlentities($srNo); ?></td>
								<td style="color: #5e5eff;"><?php echo htmlentities($commentorName); ?></td>
								<td><?php echo htmlentities($date_time); ?></td>
								<td><?php echo htmlentities($comment); ?></td>
								<!-- <td>
									<a href="editPost.php?edit=<?php echo $commentId; ?>"><span class="btn btn-success">Approve</span></a>
								</td> -->
								<td>
									<a href="deleteComment.php?delete=<?php echo $commentId; ?>"><span class="btn btn-danger">Delete</span></a> 
								</td>
								<td>
									<a href="../fullPost.php?id=<?php echo $commentedPostId; ?>" target="_blank"><span class="btn btn-info">Live Preview</span></a> 
								</td>
							</tr>
						<?php } ?>
					</table>
				</div>
				
			</div><!-- end col sm10-->
		</div><!-- end row-->
	</div><!-- end container fluid-->
	
<?php include_once("template/footer.php") ?>

</body>
</html>