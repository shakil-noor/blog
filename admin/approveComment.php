<?php include_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php confirm_login() ?>
<?php
	if (isset($_GET["id"])) {
		$idForUpdate = $_GET['id'];
		$query = mysqli_query($con, "UPDATE comments SET status='ON' WHERE id='$idForUpdate'");

		if ($query) {
			$_SESSION["SuccessMessage"] = "Comment Approved Successfull";
			Redirect_to('comments.php');
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Please try again!!";
			Redirect_to('comments.php');
		}
	}

?>