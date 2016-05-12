<?php  session_start();

if(isset($_REQUEST['id'])) {
	//header('Location: paintings.php');
	require_once './GetPaintingsList.php';
	require_once './ArtistRoutines.php';
	require_once './dbconn.php';
	$paintingDetails = getPaintingDetails();

	$artistList = getArtistsList();
	$paintingsList = getPaintingsListOfArtworkerId($paintingDetails->artistid);
	
	if ($_SESSION["isLogged"] == false){
		echo '<script type="text/javascript">alert("Please Login to Shop!")</script>';
		header('Location: signin.php');
	}
	else {
		if (isset($_SESSION['cart'][$paintingDetails->paintingid]))
		{
			echo '<script type="text/javascript">alert("Item already in cart!")</script>';
		} else {			
			$_SESSION['cart'][$paintingDetails->paintingid] = array("pid" => $paintingDetails->paintingid, "image" => $paintingDetails->imagefilename, "title" => $paintingDetails->title, "quantity" => 1, "price" => $paintingDetails->price);
		}	
	}
}
else {
	if (isset($_REQUEST['remove'])) {
		$key = $_REQUEST['remove'];
		unset($_SESSION['cart'][$key]);
		echo '<script type="text/javascript">alert("Item Removed from Cart!")</script>';
	} else {
		if ($_SESSION["isLogged"] == false){
			echo '<script type="text/javascript">alert("Please Login to Shop!")</script>';
			header('Location: signin.php');
		}	
	}
}  
?>
<html>
    <head>
		<title>Shopping Cart</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" href="Logo/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Logo/favicon.ico" type="image/x-icon">
		
        <link href='http://fonts.googleapis.com/css?family=Open+Sans' rel='stylesheet' type='text/css'>
        <link href="//maxcdn.bootstrapcdn.com/font-awesome/4.2.0/css/font-awesome.min.css" rel="stylesheet">
        <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" rel="stylesheet">
        <link href="css/admin-panel.css" rel="stylesheet">
        <link href="css/style.css" rel="stylesheet">
        <script src="https://code.jquery.com/jquery.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/js/bootstrap.min.js"></script>
    </head>
    <body>
        <div class="container" >
            <?php include_once './generalheader.php'; ?>
			<div class="panel panel-primary" id="project-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Your Cart Contents:
                    </h3>
                </div>
                <div class="panel-body">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="tabbable" id="tabs-377554">
                                <div class="tab-content">
                                    <div class="tab-pane active" id="panel-1">
                                        <div class="box">
                                            <div class="box-body table-responsive">
                                                <?php
                                                if (count($_SESSION['cart']) == 0 ) {
                                                    ?>
                                                    <h2>Cart is empty!&nbsp;&nbsp;&nbsp;<a class="btn btn-success" href="paintings.php">Shop now</a></h2>
                                                    <?php
                                                } else {
                                                    ?>
													<table class="table table-bordered">
                                                        <thead>
                                                            <tr>
                                                                <th>
                                                                    Painting
                                                                </th>
                                                                <th>
                                                                    Title
                                                                </th>
                                                                <th>
                                                                    Price
                                                                </th>
                                                                <th>
                                                                    &nbsp;
                                                                </th>
                                                            </tr>
                                                        </thead>
                                                        <tbody>
															<?php
															$total = 0;
                                                            foreach ($_SESSION['cart'] as $paint) {
																$new_price = trim($paint["price"], "$");
																$total += floatval($new_price);
                                                                ?>
                                                                <tr>
                                                                    <td>
																		<img src="Resources/art-images/paintings/square-thumbs/<?php echo $paint["image"] ?>.jpg" />
																	</td>
																	<td>
                                                                        <span><a href="viewpainting.php?id=<?php echo $paint["pid"] ?>"><?php echo $paint["title"] ?></a></span>
                                                                    </td>
																	<td>
                                                                        <span><?php echo $paint["price"] ?></span>
                                                                    </td>
																	<td>
																		<span><a class="btn btn-danger" href="shoppingcart.php?remove=<?php echo $paint["pid"] ?>">Remove</a></span>
																	</td>
																</tr>
                                                            <?php } ?>
																<tr>
																	<td>
																		&nbsp;
																	</td>
																	<td style="text-align: right;">
																		<h3><strong>Total</strong></h3>
																	</td>
																	<td>
																		<h3><strong>$<?php $_SESSION["total"] = $total; echo $total ?>.00</strong></h3>
																	</td>
																	<td>
																		<span><a class="btn btn-lg btn-success" href="checkout.php">Checkout</a></span>
																	</td>
																</tr>
                                                        </tbody>
                                                    </table>
                                                    <?php
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
			<?php if(isset($_REQUEST['id'])) { ?>
			<div class="panel panel-primary" id="project-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Similar Paintings
                    </h3>
                </div>
                <div class="panel-body">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="tab-content">
                                    <div class="tab-pane active" id="panel-1">
                                        <div class="box">
                                            <div class="box-body">
                                                <?php
                                                if ($paintingsList == NULL || $paintingsList == "exception") {
                                                    ?>
                                                    <h2>No records found</h2>
                                                    <?php
                                                } else {
                                                    //var_dump($artistList);
                                                            foreach ($paintingsList as $paint) {
                                                                ?>
													<div class="square">
													   <div class="square-content">
															<div class="square-table">
																<div class="square-table-cell">
																	<ul><img class="rs" src="Resources/art-images/paintings/square-medium/<?php echo $paint->imagefilename ?>.jpg"/>
																	<li><span><strong><?php echo $paint->title ?></strong></span></li>
																	<li><span>by <em><?php echo $artistList[$paint->artistid]->firstname . " " . $artistList[$paint->artistid]->lastname ?></em></span></li>
																	<li><span><?php echo $paint->price ?></span></li>
																	<li><span><a class="btn btn-primary" style="margin-top:5%;" href="viewpainting.php?id=<?php echo $paint->paintingid ?>">View</a></span>&nbsp;&nbsp;&nbsp;&nbsp;<span><a class="btn btn-primary" style="margin-top:5%;" href="shoppingcart.php?id=<?php echo $paint->paintingid ?>">Add to cart</a></span></li>
																	</ul>
																</div>
															</div>
														</div>
													</div>
                                                    
                                                    <?php
													}
                                                }
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                        </div>
                    </div>
                </div>
            </div>
            <?php }
			include_once './generalfooter.php'; ?>
        </div>
	</body>
</html>