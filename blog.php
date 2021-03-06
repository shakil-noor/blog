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
					}elseif(isset($_GET['category'])){
						$category = $_GET['category'];
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel WHERE category='$category' ORDER BY date_time DESC");
					}elseif(isset($_GET["page"])){
						$page = $_GET["page"];
						if ($page<1) {
							$showPostFrom = 0;
						}else{
							$showPostFrom = ($page*3)-3;
						}
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel ORDER BY date_time DESC LIMIT $showPostFrom,3");
					}else{
						$viewQuery = mysqli_query($con,"SELECT * FROM admin_panel ORDER BY date_time DESC LIMIT 0,3");
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
				<nav>
					<ul class="pagination pul-left pagination-lg">
				<?php

				if (isset($page)) {
					if ($page>1) {
						?>
						<li><a href="blog.php?page=<?php echo $page-1;?>">&laquo;</a></li>
						<?php
					}
				}

					$paginationQuery = mysqli_query($con,"SELECT COUNT(*) FROM admin_panel");
					$rowPagination = mysqli_fetch_array($paginationQuery);
					$totalPost = array_shift($rowPagination);
					$postPerPage = $totalPost/3;
					$postPerPage = ceil($postPerPage);

					for ($i=1; $i<=$postPerPage  ; $i++) { 
						if(isset($page)){
							if($i==$page){

							?>
								<li class="active"><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
							<?php
							}else{?>
								<li><a href="blog.php?page=<?php echo $i; ?>"><?php echo $i; ?></a></li>
								<?php
							}
						}

					}
					if (isset($page)) {
						if ($page+1<=$postPerPage) {
							?>
							<li><a href="blog.php?page=<?php echo $page+1;?>">&raquo;</a></li>
							<?php
						}
					}

				?>
					</ul>
				</nav>
			</div>
			<div class="col-sm-offset-1 col-sm-3">
				
				<?php include_once "template/sidebar.php"?>


			</div>
		</div><!--end main body of the blog by row -->
	</div><!--end container -->

	<?php include 'template/footer.php' ?>
</body>
</html>