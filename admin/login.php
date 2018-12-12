<?php include_once("include/DB.php") ?>
<?php include_once("include/function.php") ?>
<?php include_once("include/session.php") ?>

<?php 
	if (isset($_POST["submit"])) {
		$username = mysqli_real_escape_string($con,$_POST["username"]);
		$_SESSION['username'] = $username; //store username into session variable
		$password = mysqli_real_escape_string($con,$_POST["password"]);
		

    	if(empty($username) || empty($password)){
    		$_SESSION["ErrorMessage"]="All Field must be filled out";
    		Redirect_to("login.php");
    	}else{
    		$check_database_query = mysqli_query($con, "SELECT * FROM admins WHERE username='$username' AND password='$password'");
			//var_dump($check_database_query); exit;
			$check_login_query = mysqli_num_rows($check_database_query);
			
			if($check_login_query == 1){
				$row = mysqli_fetch_array($check_database_query);
				$user_id = $row['id'];
				$username = $row['username'];
				
				$_SESSION['username'] = $username;
				$_SESSION['user_id'] = $user_id;
				header("location: dashboard.php");
			}else{
				$_SESSION["ErrorMessage"]="Your password or username was incorrect";
    			Redirect_to("login.php");
			}
    	}
	}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
		<meta name="description" content="">
		<meta name="author" content="">
		<link rel="shortcut icon" href="assets/image/cv.png">

		<title>Signin</title>

		<!-- Bootstrap core CSS -->
		<link rel="stylesheet" type="text/css" href="assets/css/bootstrap.min.css">

		<!-- Custom styles for this template -->
		<link href="assets/css/signin.css" rel="stylesheet">
	</head>

	<body class="text-center">
	    <div class="container">
	    	<div class="row">
	    		<div class=".form-control-sm">
	    			<form class="form-signin" action="login.php" method="POST">
	      	<img class="mb-4" src="assets/image/cv.png" alt="" width="72" height="72">
	      	<h1 class="h3 mb-3 font-weight-normal">Please Sign in</h1>
	      	<!-- Show error messages -->
	        <div><?php echo ErrorMessage(); 
						echo SuccessMessage();
					?> 
			</div>
	      	<label for="username" class="sr-only">Username</label>
	      	<input type="text" name="username" id="username" class="form-control" placeholder="Username" required autofocus value= "<?php if(isset($_SESSION['username'])) {
								echo $_SESSION['username'];
							}  
							?>">
	      	<label for="inputPassword" class="sr-only">Password</label>
	      	<input type="password" name="password" id="inputPassword" class="form-control" placeholder="Password" required>
	      	<div class="checkbox mb-3">
		        <label>
		         	<input type="checkbox" value="remember-me"> Remember me
		        </label>
	      	</div>
	      	<button class="btn btn-lg btn-info btn-block" name="submit" type="submit">Sign in</button>
	    </form>
	    		</div>
	    	</div>
	    </div>
	</body>
</html>
