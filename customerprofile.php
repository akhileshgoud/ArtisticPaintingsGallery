<?php session_start();

	require_once './dbconn.php';

	if ($_SESSION["isLogged"] == false){
		echo '<script type="text/javascript">alert("Please Login to Shop!")</script>';
		header('Location: signin.php');
	}
	else {
		$customerid = $_SESSION["customer"];
		
		if (isset($_POST['address']) || isset($_POST['phone'])) {
			$new_address = $_POST['address'];
			$new_phone = $_POST['phone'];

			$sql = "UPDATE customers SET address='$new_address', phone='$new_phone' WHERE emailid='$customerid'";
			
			if ($conn->query($sql) === TRUE) {
				echo '<script type="text/javascript">alert("Details Updated!")</script>';
			} else {
				echo '<script type="text/javascript">alert("Details cannot be Updated!")</script>';				
			}
		}
		
		$sql1 = "SELECT * FROM customers
				WHERE emailid='$customerid'";
					
		$result1 = $conn->query($sql1);
		if ($result1->num_rows > 0) {
			$temp = $result1->fetch_assoc();
			
			if ($temp['address'] == NULL || $temp['phone'] == NULL) {
				echo '<script type="text/javascript">alert("Please update your address and/or phone details in your profile before placing any orders!")</script>';
			}
			
			$sql2 = "SELECT * FROM orderdetails
					WHERE customer_email='$customerid'";
					
			$result2 = $conn->query($sql2);
			$s = array();
			if ($result2->num_rows > 0) {
				while($r = $result2->fetch_assoc()){
					$s[] = $r;
				}
			}
		}
		else {
			echo '<script type="text/javascript">alert("User does not exist as customer!")</script>';
			header('Location: signin.php');
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <title>Customer Profile</title>
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
			<h2 class="text-center" style="margin-top:5%; margin-bottom:5%;"><strong>Welcome <?php echo $_SESSION["user"] ?></strong></h2>
			<div class="row">
				<div class="col-md-6 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:5%; color: #337ab7;"><strong>Your Details</strong></h3>
						<form action="customerprofile.php" method="POST" role="form" class="form-signin" style="margin-left:10%; margin-top:5%;">
							<div class="form-group">
								<label> Name: &nbsp;&nbsp;<?php echo $temp['firstname']?>&nbsp;&nbsp;<?php echo $temp['lastname']?></label>					
							</div>
							<div class="form-group">
								<label> Email: &nbsp;&nbsp;<?php echo $temp['emailid']?></label>
							</div>
							<div class="form-group">
								<label> Address <span style="color: #ff0000;">*</span> </label>
								<input type="textarea" class="form-control" id="address" name="address" style="margin-left:0;" placeholder="<?php echo $temp['address'] ?>" required >
							</div>
							<div class="form-group">
								<label> Phone <span style="color: #ff0000;">*</span> </label>
								<input type="text" class="form-control" id="phone" name="phone" style="margin-left:0;" placeholder="<?php echo $temp['phone'] ?>" required >
							</div>
							<button type="submit" class="btn btn-primary">Update</button><a class="btn btn-primary" href="paintings.php" style="margin-left: 5%;">Shop now</a>
						</form>
					</div>
				</div>
				<div class="col-md-6 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7; height: 382.5px;">
						<h3 class="text-center" style="margin-top:5%;  color: #337ab7;"><strong>Your Orders</strong></h3>
						<?php
						if (count($s) == 0 ) {
							?>
							<h3 class="text-center">No recent orders!&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="paintings.php">Shop now</a></h3>
							<?php
						} else {
							?>
						<table class="table table-bordered" style="margin-top:5%; height: 300px;">
							<thead>
								<tr>
									<th>
										Order Number
									</th>
									<th>
										Order Date
									</th>
									<th>
										Order Contents
									</th>
									<th>
										Order Amount
									</th>
								</tr>
							</thead>
							<tbody>
							<?php foreach($s as $o) { ?>
								<tr>
									<td>
										<span><?php echo $o["ordernum"] ?></span>
									</td>
									<td>
										<span><?php echo $o["order_date"] ?></span>
									</td>
									<td>
										<span><?php echo $o["ord_paintings"] ?></span>
									</td>
									<td>
										<span>$<?php echo $o["order_total"] ?>.00</span>
									</td>
								</tr>
							<?php } ?>
							</tbody>
						</table>
						<?php
						}
						?>
					</div>
				</div>
			</div>
		</div>
            <?php include_once './generalfooter.php'; ?>
	</body>
</html>