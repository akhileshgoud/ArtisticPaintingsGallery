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
			if(empty($_POST['cardnum']) || empty($_POST['month']) || empty($_POST['year']) || empty($_POST['cvv']))
			{
				header('Location: checkout.php');
			}
			else {
				$orderid = $_SESSION["order_id"];
				$cname = $_SESSION["user"];
				$cemail = $_SESSION["customer"];
				$shpaddress = $_SESSION["shpadd"];
				$items = array();
				foreach ($_SESSION['cart'] as $item) {
					$items[] = $item["title"];
				}
				$items_str = implode("," , $items);
				$total_amount = $_SESSION["total"];
				$orderdate = date("F d Y");
				
				$sql = "INSERT INTO orderdetails (order_id, customer_name, customer_email, shipping_add, ord_paintings, order_total, order_date)
						VALUES ('$orderid', '$cname', '$cemail', '$shpaddress', '$items_str', '$total_amount', '$orderdate')";
				
				if ($conn->query($sql) === TRUE) {
					
					$new_sql = "UPDATE orders SET status=1 WHERE orderid=$orderid";
					
					if ($conn->query($new_sql) === TRUE) {
						echo '<script type="text/javascript">alert("Order Placed!")</script>';
						$_SESSION['cart'] = NULL;
						header('Location: customerprofile.php');	
					}	
					else {
						echo '<script type="text/javascript">alert("Sorry, You cannot place the order! "'. $conn->error .')</script>';
					}
				} 
				else {
					echo '<script type="text/javascript">alert("Sorry, You cannot place the order! "'. $conn->error .')</script>';
				}
			}
		}
	}

?>