<?php include 'includes/DB.php' ?>
<?php include_once("includes/session.php") ?>
<?php include_once("includes/function.php") ?>
<?php 
	$post_id = $_GET['id'];
	if (isset($_POST["Submit_comment"])) {
		$name = mysqli_real_escape_string($con,$_POST["name"]);
		$email = mysqli_real_escape_string($con,$_POST["email"]);
		$comment = mysqli_real_escape_string($con,$_POST["comment"]);
		date_default_timezone_set("Asia/Dhaka");
    	$date_time_now = date("M-d-Y H:i:s");
    	

    	if(empty($name)|| empty($email) || empty($comment)){
    		$_SESSION["ErrorMessage"]="Fields can't be empty";
    	}elseif(strlen($comment)>500){
    		$_SESSION["ErrorMessage"]="Please write your comment within 500 charecter";
    	}else{
    		$query = mysqli_query($con, "INSERT INTO comments VALUES('','$date_time_now', '$name','$email','$comment','OFF','$post_id')");
    		if ($query) {
    			$_SESSION["SuccessMessage"]="Comment submited successfully";
    			Redirect_to("fullPost.php?id={$post_id}");
    		}else{
    			$_SESSION["ErrorMessage"]="Submition failed, Please try again...";
    			Redirect_to("fullPost.php?id={$post_id}");
    		}
    	}
	}
?>

<?php include 'template/header.php' ?>
	<nav class="navbar navbar-inverse" role= "navigation"><!--start navbar -->
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
					<li class="active"><a href="blog.php">Blog</a></li>
					<li><a href="#">About Us</a></li>
					<li><a href="#">Services</a></li>
					<li><a href="#">Contact Us</a></li>
					<li><a href="#">Feature</a></li>
				</ul>
				
				<form action="blog.php" class="navbar-form navbar-right">
					<div class="form-group">
						<input type="text" name="search" class="form-control" placeholder="Search">
					</div>
					<button class="btn btn-default" name="search_button">Go</button>
				</form>
			</div>	
		</div>
	</nav><!--end navbar -->
	<div class="line" style="height: 10px; background-color: #27aae1;"></div>
	<div class="container"><!--start container -->
		<div class="blog-header">
			<h1>The complete CMS Blog</h1>
			<p class="lead">The complete CMS Blog using PHP by shakil</p>
		</div>
		<div class="row"><!--start main body of the blog by row -->
			<div class="col-sm-8">
				<!-- Show the messages -->
				<div>
					<?php echo ErrorMessage(); 
					echo SuccessMessage();
					?> 
				</div>

				<!-- search button -->
				<?php 
					if (isset($_GET["search_button"])) {
						$search = $_GET["search"];
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel WHERE date_time LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' ");
					}else{
						$postIdFromURL = $_GET["id"];
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel WHERE id='$postIdFromURL' ORDER BY date_time DESC");
					}
					while ($vq=mysqli_fetch_array($viewQuery)) {
						$postId = $vq["id"];
						$date_time = $vq["date_time"];
						$title = $vq["title"];
						$category = $vq["category"];
						$author = $vq["author"];
						$image = $vq["image"];
						$post = $vq["post"];
				?> 
					<div class="blogpost thumbnail"><!--start blog post -->
						<img class="img-responsive img-rounded" src="admin/Upload/<?php echo $image; ?>">
						<div class="caption"><!--start blog caption -->
							<h1 id="heading"><?php echo htmlentities($title);?></h1>
							<p class="discription">
								Category:<?php echo htmlentities($category); ?> Published on <?php echo htmlentities($date_time); ?>
							</p>
							<p class="post">
								<?php echo nl2br($post); ?>
							</p>
						</div><!--end blog caption -->
					</div><!--end blog post -->
				<?php } ?>

				<span class="FieldInfo">Comments</span><br>
				<!-- show comments -->
				<?php 
					$extracComments = mysqli_query($con, "SELECT * FROM comments WHERE admin_panel_id='$post_id' AND status='ON'");
					while ($comments = mysqli_fetch_array($extracComments)) {
						$commentDate = $comments['DateTime'];
						$commenterName = $comments['name'];
						$commentsData = $comments['comment'];
				?>

				<div class="comment_block">
					<div class="cmnt_img_block">
						<img class="full_left" src="assets/image/head_wet_asphalt.png">
					</div>
					<div class="cmnt_data_block">
						<p class="commentor"><?php echo $commenterName; ?></p>
						<p class="comnt_date"><?php echo $commentDate; ?></p>
						<p class="cmnt_data"><?php echo nl2br($commentsData); ?></p>
					</div>
				</div>
				<br>
				<hr>

				<?php } ?>
				<span class="FieldInfo">Share your thoughts about this post:-</span><br><br>
				<!-- Comment section -->
				<div>
					<form action="fullPost.php?id=<?php echo $post_id; ?>" method="POST" >
						<fieldset>
							<div class="form-group">
								<label for="name"><span class="FieldInfo">Name</span> </label>
								<input class="form-control" type="text" name="name" id="name" placeholder="Name">
							</div>

							<div class="form-group">
								<label for="email"><span class="FieldInfo">Email</span></label>
								<input class="form-control" type="email" name="email" id="email" placeholder="email@example.com">
							</div>

							<div class="form-group">
								<label for="comment_area"><span class="FieldInfo">Comment</span></label>
								<textarea class="form-control" id="post_text" name="comment" id="comment_area" placeholder="Write your comments..."></textarea> 
							</div>

							<input type="Submit" name="Submit_comment" class="btn btn-primary" value="Submit">
						</fieldset>
						<br>
					</form>
				</div>
			</div>
			
			<div class="col-sm-offset-1 col-sm-3">
				
				<?php include_once "template/sidebar.php"?>
			</div>
		</div><!--end main body of the blog by row -->
	</div><!--end container -->

	<?php include 'template/footer.php' ?>
</body>
</html>