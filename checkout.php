<?php session_start();

	require_once './dbconn.php';

	if ($_SESSION["isLogged"] == false){
		echo '<script type="text/javascript">alert("Please Login to Shop!")</script>';
		header('Location: signin.php');
	}
	else {
		if (count($_SESSION['cart']) == 0) {
			header('Location: paintings.php');			
		}
		else {
			$customer_id = $_SESSION["customer"];
			$total_amt = $_SESSION["total"];
			
			$sql_1 = "INSERT INTO orders (customer, orderamt, status)
					VALUES ('$customer_id', '$total_amt', '0')";
					
			if ($conn->query($sql_1) === TRUE) {
				$_SESSION["order_id"] = $conn->insert_id;
				
				$sql_2 = "SELECT * FROM customers
						  WHERE emailid='$customer_id'";
				
				$result = $conn->query($sql_2);
				if ($result->num_rows > 0) {
					$temp = $result->fetch_assoc();
					
					if ($temp['address'] == NULL || $temp['phone'] == NULL) {
						echo '<script type="text/javascript">alert("Please update your address and/or phone details in your profile before placing the order!")</script>';
						header('Location: customerprofile.php');
					}
				}
				else {
					echo '<script type="text/javascript">alert("Sorry, You cannot place the order!")</script>';
				}
			} 
			else {
				echo '<script type="text/javascript">alert("Sorry, You cannot place the order!")</script>';
			}
		}
	}
	
?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <title>Payment</title>
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
				<div class="col-md-4 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:10%;"><strong>Customer Details</strong></h3>
						<form action="" method="POST" role="form" class="form-signin" style="margin-left:10%;">
							<div class="form-group">
								<label> Customer Name: &nbsp;&nbsp;<?php echo $temp['firstname']?>&nbsp;&nbsp; <?php echo $temp['lastname']?></label>					
							</div>
							<div class="form-group">
								<label style="margin-right: 15%;"> Email Address: &nbsp;&nbsp;<?php echo $temp['emailid']?></label>
							</div>
							<div class="form-group">
								<label style="margin-right: 15%;"> Shipping Address: &nbsp;&nbsp;<?php $_SESSION["shpadd"] = $temp['address']; echo $temp['address']?></label>
							</div>
							<div class="form-group">
								<label> Phone: &nbsp;&nbsp;<?php echo $temp['phone']?></label>
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-4 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:10%;"><strong>Billing Address</strong></h3>
						<form action="placeorder.php" method="POST" role="form" class="form-signin" style="margin-left:15%;">
							<div class="form-group">
								<label> Cardholder Name <span style="color: #ff0000;">*</span></label>								
								<input type="text" class="form-control" id="nameoncard" name="nameoncard" placeholder="" style="margin-left:0;" required >
							</div>
							<div class="form-group">
								<label> Address <span style="color: #ff0000;">*</span></label>
								<input type="text" class="form-control" id="staddress" name="staddress" placeholder="" style="margin-left:0;" required >
							</div>
							<div class="form-group">
								<label> Zip/Postal Code <span style="color: #ff0000;">*</span></label>
								<input type="text" class="form-control" id="zip" name="zip" placeholder="" style="margin-left:0;" required >
							</div>
							<div class="form-group">
								<label> Email for receipt <span style="color: #ff0000;">*</span></label>
								<input type="email" class="form-control" id="receipt_email" name="receipt_email" placeholder="" style="margin-left:0;" required >
							</div>
						</form>
					</div>
				</div>
				<div class="col-md-4 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<h3 class="text-center" style="margin-top:10%;"><strong>Card Details</strong></h3>
						<form action="placeorder.php" method="POST" role="form" class="form-signin" style="margin-left:15%;">
							<div class="form-group">
								<label> Card Number <span style="color: #ff0000;">*</span></label>								
								<input type="text" class="form-control" id="cardnum" name="cardnum" autocomplete="off" placeholder="" style="margin-left:0;" required >
							</div>
							<div class="form-group">
								<label> Expiration Date <span style="color: #ff0000;">*</span></label>
								<div class="form-inline">
									<select name="month" id="month" onchange="" size="1">
										<option value="">Month</option>
										<option value="01">01-January</option>
										<option value="02">02-February</option>
										<option value="03">03-March</option>
										<option value="04">04-April</option>
										<option value="05">05-May</option>
										<option value="06">06-June</option>
										<option value="07">07-July</option>
										<option value="08">08-August</option>
										<option value="09">09-September</option>
										<option value="10">10-October</option>
										<option value="11">11-November</option>
										<option value="12">12-December</option>
									</select>
									<select name="year" id="year" onchange="" size="1">
										<option value="2016">2016</option>
									<?php for($i=1; $i<=20; $i++) {?>
										<option value="<?php echo 2016 + $i ?>"><?php echo 2016 + $i ?></option>
									<?php } ?>
									</select>
								</div>
							</div>
							<div class="form-group">
								<label> CVV/Security Code <span style="color: #ff0000;">*</span></label>
								<input type="text" class="form-control" id="cvv" name="cvv" autocomplete="off" placeholder="" style="margin-left:0;" required >
							</div>
							<h3>Total: $<?php echo $_SESSION["total"]?>.00 &nbsp;&nbsp;<button type="submit" class="btn btn-lg btn-success">Place Order</button></h3>
						</form>
					</div>
				</div>
			</div>
		</div>
        <?php include_once './generalfooter.php'; ?>
	</body>
</html>