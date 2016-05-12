<?php
	session_start();
	
	if ($_SESSION["isLogged"] == true) {
		header('Location: index.php');
	}
	
	include_once './dbconn.php';
	
	if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if ( isset($_POST['uemail']) ) {
			
			$email = $_POST['uemail'];
			$pwd = $_POST['pwd'];
			
			$sql1 = "SELECT uname, role FROM users
					WHERE email='$email' AND password='$pwd'";
					
			$result1 = $conn->query($sql1);

			if ($result1->num_rows > 0) {
				$r = $result1->fetch_assoc();
				if ($r['role'] == 'admin')
				{
					$_SESSION["isLogged"] = true;
					$_SESSION["user"] = $r['uname'];
					$_SESSION["customer"] = $email;
					$_SESSION["role"] = 'admin';
					header('Location: adminpage.php');
				} elseif ($r['role'] == 'customer')
				{
					$_SESSION["isLogged"] = true;
					$_SESSION["user"] = $r['uname'];
					$_SESSION["customer"] = $email;
					$_SESSION["role"] = 'customer';
					header('Location: paintings.php');
				} else
				{
					echo '<script type="text/javascript">alert("Login Failed! Access Restricted!")</script>';
				}								
			} else {
				echo '<script type="text/javascript">alert("Login Failed! Username and Password Do Not Match the Records!")</script>';
			}
		}
		elseif ( isset($_POST['firstname']) ) {
			
			$firstname = $_POST['firstname'];
			$lastname = $_POST['lastname'];
			$emailid = $_POST['email'];
			$pswd = $_POST['pswd'];
			$rpswd = $_POST['rpswd'];
			
			if ($pswd != $rpswd) {
				echo '<script type="text/javascript">alert("Registration Failed! Passwords do not match.")</script>';
			} else {
				$sql2 = "INSERT INTO users (uname, email, password)
						VALUES ('$firstname', '$emailid', '$pswd')";
						
				if ($conn->query($sql2) === TRUE) {
					$sql3 = "INSERT INTO customers (firstname, lastname, emailid)
							VALUES ('$firstname', '$lastname', '$emailid')";
							
					if ($conn->query($sql3) === TRUE) {
						echo '<script type="text/javascript">alert("You have been registered! Please Login and update your ADDRESS and PHONE details!")</script>';
					} else {
						echo '<script type="text/javascript">alert( "Registration Failed! Email already exists!")</script>';
					}
				} else {
					echo '<script type="text/javascript">alert( "Registration Failed! Email already exists!")</script>';
				}
			}
			
		}
	}
	
	$conn->close();
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <title>Login or Sign Up</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" href="Logo/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Logo/favicon.ico" type="image/x-icon">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.0/jquery.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
        <!-- Bootstrap -->
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/admin-panel.css" rel="stylesheet">
        <link href="css/top-button.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">		
    </head>
    <body>
        <div class="container">
			<?php include_once './generalheader.php'; ?>
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:10%;"><strong>Login</strong></h3>
						<form action="signin.php" method="POST" role="form" class="text-center form-signin">
							<div class="form-group">
								<input type="email" class="form-control" id="uemail" name="uemail" placeholder="Enter email" required >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="pwd" name="pwd" placeholder="Enter password" required >
							</div>
							<div class="checkbox">
								<label><input type="checkbox"> Remember me</label>
							</div>
							<button type="submit" class="btn btn-primary">Login</button>
							<br><br><br><a href="#" class="text-center">Forgot Password?</a>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:10%;"><strong>Register/Sign Up</strong></h3>
						<form action="signin.php" method="POST" role="form" class="text-center form-signin">
							<div class="form-inline">
								<div class="form-group">
									<input type="text" class="form-control" id="firstname" name="firstname" placeholder="Firstname" required >
								</div>
								<div class="form-group">								
									<input type="text" class="form-control" id="lastname" name="lastname" placeholder="Lastname" required >
								</div>
							</div>
							<div class="form-group">
								<input type="email" class="form-control" id="email" name="email" placeholder="Email" required >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="pswd" name="pswd" placeholder="Password" required >
							</div>
							<div class="form-group">
								<input type="password" class="form-control" id="rpswd" name="rpswd" placeholder="Retype Password" required >
							</div>
							  <button type="submit" class="btn btn-primary">Register</button>
						</form>
					</div>
				</div>
			</div>
		</div>
            <?php include_once './generalfooter.php'; ?>
	</body>
</html>
