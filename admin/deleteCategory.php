<?php include_once("include/DB.php") ?>
<?php include_once("include/session.php") ?>
<?php include_once("include/function.php") ?>
<?php
	if (isset($_GET["id"])) {
		$idFordelete = $_GET['id'];
		$query = mysqli_query($con, "DELETE FROM category WHERE id='$idFordelete'");

		if ($query) {
			$_SESSION["SuccessMessage"] = "Category Delete Successfully";
			Redirect_to('category.php');
		}else{
			$_SESSION["ErrorMessage"] = "Something went wrong. Please try again!!";
			Redirect_to('category.php');
		}
	}

?>