<?php include 'includes/DB.php' ?>
<?php include 'template/header.php' ?>
<?php include 'template/nav.php' ?>
	<div class="line" style="height: 10px; background-color: #27aae1;"></div>
	<div class="container"><!--start container -->
		<div class="row"><!--start main body of the blog by row -->
			<div class="col-sm-8">
				<?php 
					if (isset($_GET["search_button"])) {
						$search = $_GET["search"];
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel WHERE date_time LIKE '%$search%' OR title LIKE '%$search%' OR category LIKE '%$search%' OR post LIKE '%$search%' ");
					}else{
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel ORDER BY date_time DESC");
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
								<?php 
									if (strlen($post)>150) {
										$post=substr($post, 0,150). '...';
									}
									echo ($post);
								?>
							</p>
						</div><!--end blog caption -->
						<a href="fullPost.php?id=<?php echo $postId ?>"><span class="btn btn-info">Read More &rsaquo;&rsaquo;</span></a>
					</div><!--end blog post -->
				<?php } ?>
			</div>
			<div class="col-sm-offset-1 col-sm-3">
				<h2>About Me</h2>
				<p>
					বেশির ভাগ মানুষের মত আমিও যখন স্কুল, কলেজ ছেড়ে বিশ্ববিদ্যালয়ে ভর্তি হই তখন বিশ্ববিদ্যালয়ে বন্ধুদের সাথেই বেশি যোগাযোগ হতে শুরু হয় আর স্কুল কলেজ বন্ধুদের সাথে যোগাযোগ কমতে থাকে। কিন্তু তাই বলে আগের বন্ধুদের সাথে একেবারেই যোগাযোগ বন্ধ করে দিব এতটা বিবেকহীন মনেহয় এখন হইনাই। ফোন মেসেঞ্জার যে যেভাবে নক দেয় তাকে সেভাবে রেস্পন্স করার চেষ্টা করি। হে হয়ত এটা হতেপারে যে আমি নিজে থেকে খুব বেশি নক দেইনা বা যতটুকু করার সময়ের কারনে শত করা হয়ে উঠে না। 
				</p>
			</div>
		</div><!--end main body of the blog by row -->
	</div><!--end container -->

	<?php include 'template/footer.php' ?>
</body>
</html>