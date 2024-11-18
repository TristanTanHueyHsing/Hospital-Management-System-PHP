<?php
session_start();
error_reporting(0);
include("include/config.php");

if(isset($_POST['submit'])) {
    // Sanitize user inputs to prevent SQL injection
    $uname = mysqli_real_escape_string($con, $_POST['username']);
    $upassword = $_POST['password']; // password will be handled later for security

    // Use a prepared statement to prevent SQL injection
    $stmt = $con->prepare("SELECT * FROM admin WHERE username=?");
    $stmt->bind_param("s", $uname); // Bind username parameter
    $stmt->execute();
    $result = $stmt->get_result();
    $num = $result->fetch_array(MYSQLI_ASSOC);

    if($num) {
        // Verify password using password_verify() for hashed passwords
        if(password_verify($upassword, $num['password'])) {
            // Check if the password is from an older hash format
            if (!password_needs_rehash($num['password'], PASSWORD_DEFAULT)) {
                // If the password needs to be rehashed, update the password in the database
                $new_hashed_password = password_hash($upassword, PASSWORD_DEFAULT);
                $update_stmt = $con->prepare("UPDATE admin SET password=? WHERE username=?");
                $update_stmt->bind_param("ss", $new_hashed_password, $uname);
                $update_stmt->execute();
                $update_stmt->close();
            }

            // Set session variables for login
            $_SESSION['login'] = $_POST['username'];
            $_SESSION['id'] = $num['id'];
            header("location:dashboard.php");
        } else {
            $_SESSION['errmsg'] = "Invalid username or password";
        }
    } else {
        $_SESSION['errmsg'] = "Invalid username or password";
    }

    // Close the statement
    $stmt->close();
}
?>



<!DOCTYPE html>
<html lang="en">
	<head>
		<title>Admin-Login</title>
		<meta charset="utf-8" />
		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=0, minimum-scale=1.0, maximum-scale=1.0">
		<meta name="apple-mobile-web-app-capable" content="yes">
		<meta name="apple-mobile-web-app-status-bar-style" content="black">
		<meta content="" name="description" />
		<meta content="" name="author" />
		<link href="http://fonts.googleapis.com/css?family=Lato:300,400,400italic,600,700|Raleway:300,400,500,600,700|Crete+Round:400italic" rel="stylesheet" type="text/css" />
		<link rel="stylesheet" href="vendor/bootstrap/css/bootstrap.min.css">
		<link rel="stylesheet" href="vendor/fontawesome/css/font-awesome.min.css">
		<link rel="stylesheet" href="vendor/themify-icons/themify-icons.min.css">
		<link href="vendor/animate.css/animate.min.css" rel="stylesheet" media="screen">
		<link href="vendor/perfect-scrollbar/perfect-scrollbar.min.css" rel="stylesheet" media="screen">
		<link href="vendor/switchery/switchery.min.css" rel="stylesheet" media="screen">
		<link rel="stylesheet" href="assets/css/styles.css">
		<link rel="stylesheet" href="assets/css/plugins.css">
		<link rel="stylesheet" href="assets/css/themes/theme-1.css" id="skin_color" />
	</head>
	<body class="login">
		<div class="row">
			<div class="main-login col-xs-10 col-xs-offset-1 col-sm-8 col-sm-offset-2 col-md-4 col-md-offset-4">
				<div class="logo margin-top-30">
				<h2>Admin Login</h2>
				</div>

				<div class="box-login">
					<form class="form-login" method="post">
						<fieldset>
							<legend>
								Sign in to your account
							</legend>
							<p>
								Please enter your name and password to log in.<br />
								<span style="color:red;"><?php echo htmlentities($_SESSION['errmsg']); ?><?php echo htmlentities($_SESSION['errmsg']="");?></span>
							</p>
							<div class="form-group">
								<span class="input-icon">
									<input type="text" class="form-control" name="username" placeholder="Username">
									<i class="fa fa-user"></i> </span>
							</div>
							<div class="form-group form-actions">
								<span class="input-icon">
									<input type="password" class="form-control password" name="password" placeholder="Password"><i class="fa fa-lock"></i>
									 </span>
							</div>
							<div class="form-actions">
								
								<button type="submit" class="btn btn-primary pull-right" name="submit">
									Login <i class="fa fa-arrow-circle-right"></i>
								</button>
							</div>
							<a href="../../index.php">Bacto Home Page</a>
							
						</fieldset>
					</form>

					<div class="copyright">
						<span class="text-bold text-uppercase">Hospital Management System</span>
					</div>
			
				</div>

			</div>
		</div>
		<script src="vendor/jquery/jquery.min.js"></script>
		<script src="vendor/bootstrap/js/bootstrap.min.js"></script>
		<script src="vendor/modernizr/modernizr.js"></script>
		<script src="vendor/jquery-cookie/jquery.cookie.js"></script>
		<script src="vendor/perfect-scrollbar/perfect-scrollbar.min.js"></script>
		<script src="vendor/switchery/switchery.min.js"></script>
		<script src="vendor/jquery-validation/jquery.validate.min.js"></script>
	
		<script src="assets/js/main.js"></script>

		<script src="assets/js/login.js"></script>
		<script>
			jQuery(document).ready(function() {
				Main.init();
				Login.init();
			});
		</script>
	
	</body>
	<!-- end: BODY -->
</html>