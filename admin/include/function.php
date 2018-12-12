<?php require("DB.php") ?>
<?php include_once("session.php") ?>
<?php
	function Redirect_to($NewLocation){
		header("Location:".$NewLocation);
		exit();
	}

	 function count_comment(){
	 	global $con;
		$TotalCmnt = mysqli_query($con, "SELECT * FROM comments WHERE status='OFF' ");
		$Rows = mysqli_num_rows($TotalCmnt);
		//$TotalRows = array_shift($Rows);

		if($Rows>0){
			return $Rows;
		}
	}

	function Login_attempt($username,$password){
		$query =mysqli_query($con, "SELECT * FROM admins WHERE username='$username' AND password='$password' ");
		if ($admin=mysqli_fetch_assoc($query)) {
			return $admin;
		}else{
			return null;
		}
	}

	function login(){
		if (isset($_SESSION['user_id'])) {
			return true;
		}
	}

	function confirm_login(){
		if(!login()){
			Redirect_to("login.php");
		}
	}
	
?>