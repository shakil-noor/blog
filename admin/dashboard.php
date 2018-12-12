<?php include_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<!DOCTYPE html>
<html>
<head>
	<title>Dashboard (Admin)</title>
	<link rel="shortcut icon" href="assets/image/cv.png">
	<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">
	<link rel="stylesheet" type="text/css" href="assets/css/adminStyle.css">
</head>
<body>
	<?php include_once("template/nav.php") ?>
	<div class="line" style="height: 10px; background-color: #27aae1;"></div>
	<div class="container-fluid"><!-- start container-fluid-->
		<div class="row"><!--start row-->
			<div class="col-sm-2"><!-- start cl sm2/side area-->
				<br>
				<ul id="side_menu" class="nav nav-pills nav-stacked">
					<li class="active"><a href="dashboard.php"><span class="glyphicon glyphicon-th"></span> Dashboard</a></li>
					<li><a href="addNewPost.php"><span class="glyphicon glyphicon-list-alt"></span> Add New Post</a></li>
					<li><a href="category.php"><span class="glyphicon glyphicon-tags"></span> Caregory</a></li>
					<li><a href="manageAdmin.php"><span class="glyphicon glyphicon-user"></span> Manage Admin</a></li>
					<li>
						<a href="comments.php"><span class="glyphicon glyphicon-comment"></span> Comments 
							<!-- Show the number of u apprve comments -->
								<span class="label pull-right label-warning">
									<?php 
										$comment_count = count_comment();
										echo $comment_count;
									?>
								</span>
								<?php //} ?>
						</a>
					</li>
					<li><a href="logout.php"><span class="glyphicon glyphicon-log-out"></span> LogOut</a></li>
				</ul>
			</div><!-- end col sm2/side area-->

			<div class="col-sm-10"><!-- start cl sm10-->
				
				<h1>Admin Dashboard</h1>
				<div><?php echo ErrorMessage(); 
					echo SuccessMessage();
				?> </div>
				<div class="table-responsive">
					<table class="table table-striped table-hover">
						<tr>
							<th>No</th>
							<th>Post title</th>
							<th>Date & Time</th>
							<th>Author</th>
							<th>Category</th>
							<th>Banner</th>
							<th>Comment</th>
							<th>Action</th>
							<th>Details</th>
						</tr>
						<?php 
							$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel ORDER BY date_time ASC");
							$srNo = 0;
							while ($vq=mysqli_fetch_array($viewQuery)) {
								$postId = $vq["id"];
								$title = $vq["title"];
								$date_time = $vq["date_time"];
								$author = $vq["author"];
								$category = $vq["category"];
								$image = $vq["image"];
								$post = $vq["post"];
								$srNo++;
						?>
							<tr>
								<td><?php echo $srNo ?></td>
								<td><?php echo $title ?></td>
								<td><?php echo $date_time ?></td>
								<td><?php echo $author ?></td>
								<td><?php echo $category ?></td>
								<td><img src="Upload/<?php echo $image; ?>" width="140px"; height="70px"></td>
								<td>
									<?php 
										$cmtApproveQuery = mysqli_query($con, "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$postId' AND status='ON' ");
										$RowApproved = mysqli_fetch_array($cmtApproveQuery);
										$totalApproved = array_shift($RowApproved);

										if($totalApproved>0){
									?>
									<span class="label pull-right label-success">
										<?php echo $totalApproved;?>
									</span>
									<?php } ?>

									<?php 
										$cmtUnapproveQuery = mysqli_query($con, "SELECT COUNT(*) FROM comments WHERE admin_panel_id='$postId' AND status='OFF' ");
										$RowUnapproved = mysqli_fetch_array($cmtUnapproveQuery);
										$totalUnapproved = array_shift($RowUnapproved);

										if($totalUnapproved>0){
									?>
									<span class="label pull-left label-warning">
										<?php echo $totalUnapproved;?>
									</span>
									<?php } ?>
								</td>
								<td>
									<a href="editPost.php?edit=<?php echo $postId; ?>"><span class="btn btn-warning">Edit</span></a> 
									<a href="deletePost.php?delete=<?php echo $postId; ?>"><span class="btn btn-danger">Delete</span></a> 
								</td>
								<td>
									<a href="../fullPost.php?id=<?php echo $postId; ?>" target="_blank"><span class="btn btn-info">Live Preview</span></a> 
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