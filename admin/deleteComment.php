<?php include_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php
	if (isset($_GET["delete"])) {
		$idForUpdate = $_GET['delete'];
		$query = mysqli_query($con, "DELETE FROM comments WHERE id='$idForUpdate'");

		if ($query) {
			$_SESSION["SuccessMessage"] = "Comment Delete Successfully";
			Redirect_to('comments.php');
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Please try again!!";
			Redirect_to('comments.php');
		}
	}

?>