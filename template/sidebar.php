<!-- show post category -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Category</h2>
					</div>
					<div class="panel-body">
						<?php
						$viewCat = mysqli_query($con, "SELECT * FROM category ORDER BY datetime DESC");
						while($VC = mysqli_fetch_array($viewCat)){
							$id = $VC['id'];
							$category = $VC['name'];
							?>
							<a href="blog.php?category=<?php echo $category ?>"><span id="heading"><?php echo $category."<br>"; ?></span></a>
							<?php
						}
						?>
					</div>
					<div class="panel-footer">
						
					</div>
				</div>
				<!-- show recent post -->
				<div class="panel panel-primary">
					<div class="panel-heading">
						<h2 class="panel-title">Recent Post</h2>
					</div>
					<div class="panel-body">
						Content
					</div>
					<div class="panel-footer">
						
					</div>
				</div>