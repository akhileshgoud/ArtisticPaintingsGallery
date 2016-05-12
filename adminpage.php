<?php session_start();

	require_once './dbconn.php';
	
	require_once './GetPaintingsList.php';
	require_once './ArtistRoutines.php';

	if ($_SESSION["isLogged"] == false){
		echo '<script type="text/javascript">alert("Please Login!")</script>';
		header('Location: signin.php');
	}
	else if ($_SESSION["role"] != 'admin' ) {
		echo '<script type="text/javascript">alert("Access Restricted!")</script>';
		header('Location: index.php');
	}	
	else {
		$adminid = $_SESSION["customer"];
		
		if ($_SERVER['REQUEST_METHOD'] == 'POST') {
			if ( isset($_POST['artist_firstname']) ) {
					
				$a_firstname = $_POST['artist_firstname'];
				$a_lastname = $_POST['artist_lastname'];
				
				$sql_a = "INSERT INTO artists (firstname, lastname)
						VALUES ('$a_firstname', '$a_lastname')";
						
				if ($conn->query($sql_a) === TRUE) {
					echo '<script type="text/javascript">alert("Artist added!")</script>';
				} else {
					echo '<script type="text/javascript">alert( "Error adding New Artist!")</script>';
				}
			}
			else if (isset($_POST['title'])) {
				
				$p_title = $_POST['title'];
				$p_artist = $_POST['artst'];
				$p_genre = $_POST['genre'];
				$p_year = $_POST['year'];
				$p_width = $_POST['width'];
				$p_height = $_POST['height'];
				$p_medium = $_POST['medium'];
				$p_gallery = $_POST['gallery'];
				$p_price = $_POST['price'];
				$p_wikilink = $_POST['wikilink'];
				
				$temp_imgname = explode(".", $_FILES['img_lg']['name']);
				$p_imgname = $temp_imgname[0];
				
				$upload_dir_lg = 'Resources/art-images/paintings/large';
				$upload_dir_md = 'Resources/art-images/paintings/medium';
				$upload_dir_sm = 'Resources/art-images/paintings/square-medium';
				$upload_dir_st = 'Resources/art-images/paintings/square-thumbs';
				
				if ((($_FILES['img_lg']['type'] == 'image/jpeg') || ($_FILES['img_lg']['type'] == 'image/jpg')) && (($_FILES['img_md']['type'] == 'image/jpeg') || ($_FILES['img_md']['type'] == 'image/jpg')) && (($_FILES['img_sm']['type'] == 'image/jpeg') || ($_FILES['img_sm']['type'] == 'image/jpg')) && (($_FILES['img_st']['type'] == 'image/jpeg') || ($_FILES['img_st']['type'] == 'image/jpg'))) 
				{
					if (($_FILES['img_lg']['error'] > 0) || ($_FILES['img_md']['error'] > 0) || ($_FILES['img_sm']['error'] > 0) || ($_FILES['img_st']['error'] > 0))	
					{
						echo '<script type="text/javascript">alert( "Error with the image uploaded!")</script>';
					}
					else 
					{
						if (file_exists ($upload_dir_lg . $_FILES['img_lg']['name']) || file_exists ($upload_dir_md . $_FILES['img_md']['name']) || file_exists ($upload_dir_sm . $_FILES['img_sm']['name']) || file_exists ($upload_dir_st . $_FILES['img_st']['name'])) 
						{
							echo '<script type="text/javascript">alert( "Error! Painting already exists!")</script>';
						}
						else 
						{
							$filename_lg = $_FILES['img_lg']['name'];
							$filename_md = $_FILES['img_md']['name'];
							$filename_sm = $_FILES['img_sm']['name'];
							$filename_st = $_FILES['img_st']['name'];
							
							if ( move_uploaded_file($_FILES['img_lg']['tmp_name'], "$upload_dir_lg/$filename_lg") && move_uploaded_file($_FILES['img_md']['tmp_name'], "$upload_dir_md/$filename_md") && move_uploaded_file($_FILES['img_sm']['tmp_name'], "$upload_dir_sm/$filename_sm") && move_uploaded_file($_FILES['img_st']['tmp_name'], "$upload_dir_st/$filename_st") )
							{
								$sql_p = "INSERT INTO paintings (artistid, genre, imagefilename, title, year, width, height, medium, gallery, price, wikipedialink)
										  VALUES ('$p_artist', '$p_genre', '$p_imgname', '$p_title', '$p_year', '$p_width', '$p_height', '$p_medium', '$p_gallery', '$p_price', '$p_wikilink')";
								
								if ($conn->query($sql_p) === TRUE) {
									echo '<script type="text/javascript">alert("Painting added!")</script>';
								} else {
									echo '<script type="text/javascript">alert( "Error adding Painting!")</script>';
								}
							}
							else {
								echo '<script type="text/javascript">alert( "Error in uploading images!")</script>';
							}
						}
					}
				} 
				else {
					echo '<script type="text/javascript">alert( "Error! Please upload .jpg images only!")</script>';
				}
			}
		}
		
		$paintingsList = getPaintingsList();
		$artistList = getArtistsList();
		
		$sql1 = "SELECT * FROM customers";
					
		$result1 = $conn->query($sql1);
		$customer_list = array();
		if ($result1->num_rows > 0) {
			while($r1 = $result1->fetch_assoc()) {
				$customer_list[] = $r1;
			}
			
			$sql2 = "SELECT * FROM orderdetails";
					
			$result2 = $conn->query($sql2);
			$orders_list = array();
			if ($result2->num_rows > 0) {
				while($r2 = $result2->fetch_assoc()){
					$orders_list[] = $r2;
				}
			}
		}
	}

?>
<!DOCTYPE html>
<html lang="en">
	<head>
        <title>Admin Panel</title>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
		
		<link rel="shortcut icon" href="Logo/favicon.ico" type="image/x-icon">
		<link rel="icon" href="Logo/favicon.ico" type="image/x-icon">

        <!-- jQuery (necessary for Bootstrap's JavaScript plugins) -->
        <script src="//ajax.googleapis.com/ajax/libs/jquery/1.12.0/jquery.min.js"></script>
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
			<h2 class="text-center" style="margin-top:2%; margin-bottom:2%;"><strong>Welcome <?php echo $_SESSION["user"] ?></strong></h2>
			<div class="row">
				<div class="col-md-12 col-xs-12">
					<div class="panel" style="border: 1px solid #337ab7;">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#plist">Paintings</a></li>
							<li><a data-toggle="tab" href="#alist">Artists</a></li>
							<li><a data-toggle="tab" href="#clist">Customers</a></li>
							<li><a data-toggle="tab" href="#olist">Orders</a></li>
							<li><a data-toggle="tab" href="#add_artist">Add Artists</a></li>
							<li><a data-toggle="tab" href="#add_paitings">Add Paintings</a></li>
						</ul>
						<div class="tab-content">
							<div id="plist" class="tab-pane fade in active">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>List of Paintings</strong></h3>
								<?php
								if ($paintingsList == NULL || $paintingsList == "exception") {
									?>
									<h3 class="text-center">No Paintings available!&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="#add_paitings">Add Paintings</a></h3>
									<?php
								} else {
									?>
								<table class="table table-bordered" style="margin-top:2%;">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												Artist
											</th>
											<th>
												Genre
											</th>
											<th>
												Image
											</th>
											<th>
												Title
											</th>
											<th>
												Year
											</th>
											<th>
												Width
											</th>
											<th>
												Height
											</th>
											<th>
												Medium
											</th>
											<th>
												Gallery
											</th>
											<th>
												Price
											</th>
											<th>
												Wiki Link
											</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($paintingsList as $paint) { ?>
										<tr>
											<td>
												<span><?php echo $paint->paintingid ?></span>
											</td>
											<td>
												<span><?php echo $artistList[$paint->artistid]->firstname . " " . $artistList[$paint->artistid]->lastname ?></span>
											</td>
											<td>
												<span><?php echo $paint->genre ?></span>
											</td>
											<td>
												<span><?php echo $paint->imagefilename ?></span>
											</td>
											<td>
												<span><?php echo $paint->title ?></span>
											</td>
											<td>
												<span><?php echo $paint->year ?></span>
											</td>
											<td>
												<span><?php echo $paint->width ?></span>
											</td>
											<td>
												<span><?php echo $paint->height ?></span>
											</td>
											<td>
												<span><?php echo $paint->medium ?></span>
											</td>
											<td>
												<span><?php echo $paint->gallery ?></span>
											</td>
											<td>
												<span><?php echo $paint->price ?></span>
											</td>
											<td>
												<span class="fix_size"><?php echo $paint->Wikipedialink ?></span>
											</td>
										</tr>
									<?php } ?>
									</tbody>
								</table>
								<?php
								}
								?>
							</div>
							<div id="alist" class="tab-pane fade in">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>List of Artists</strong></h3>
								<?php
								if ($artistList == NULL || $artistList == "exception") {
									?>
									<h3 class="text-center">No Artists available!&nbsp;&nbsp;&nbsp;<a class="btn btn-primary" href="#add_artist">Add Artists</a></h3>
									<?php
								} else {
									?>
								<table class="table table-bordered" style="margin-top:2%;">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												First Name
											</th>
											<th>
												Last Name
											</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($artistList as $ar) { ?>
										<tr>
											<td>
												<span><?php echo $ar->artistid ?></span>
											</td>
											<td>
												<span><?php echo $ar->firstname ?></span>
											</td>
											<td>
												<span><?php echo $ar->lastname ?></span>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php
								}
								?>
							</div>
							<div id="clist" class="tab-pane fade in">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>List of Customers</strong></h3>
								<?php
								if (count($customer_list) == 0) {
									?>
									<h3 class="text-center">No Customers to Display!</h3>
									<?php
								} else {
									?>
								<table class="table table-bordered" style="margin-top:2%;">
									<thead>
										<tr>
											<th>
												ID
											</th>
											<th>
												First Name
											</th>
											<th>
												Last Name
											</th>
											<th>
												Email
											</th>
											<th>
												Address
											</th>
											<th>
												Phone
											</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($customer_list as $c) { ?>
										<tr>
											<td>
												<span><?php echo $c["cid"] ?></span>
											</td>
											<td>
												<span><?php echo $c["firstname"] ?></span>
											</td>
											<td>
												<span><?php echo $c["lastname"] ?></span>
											</td>
											<td>
												<span><?php echo $c["emailid"] ?></span>
											</td>
											<td>
												<span><?php echo $c["address"] ?></span>
											</td>
											<td>
												<span><?php echo $c["phone"] ?></span>
											</td>
										</tr>
										<?php } ?>
									</tbody>
								</table>
								<?php
								}
								?>
							</div>
							<div id="olist" class="tab-pane fade in">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>List of Orders</strong></h3>
								<?php
								if (count($customer_list) == 0) {
									?>
									<h3 class="text-center">No Orders to Display!</h3>
									<?php
								} else {
									?>
								<table class="table table-bordered" style="margin-top:2%;">
									<thead>
										<tr>
											<th>
												Order No.
											</th>
											<th>
												Order Date
											</th>
											<th>
												Name
											</th>
											<th>
												Email
											</th>
											<th>
												Shipping Address
											</th>
											<th>
												Paintings
											</th>
											<th>
												Total
											</th>
										</tr>
									</thead>
									<tbody>
									<?php foreach($orders_list as $o) { ?>
										<tr>
											<td>
												<span><?php echo $o["ordernum"] ?></span>
											</td>
											<td>
												<span><?php echo $o["order_date"] ?></span>
											</td>
											<td>
												<span><?php echo $o["customer_name"] ?></span>
											</td>
											<td>
												<span><?php echo $o["customer_email"] ?></span>
											</td>
											<td>
												<span><?php echo $o["shipping_add"] ?></span>
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
							<div id="add_artist" class="tab-pane fade in">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>Add Artists</strong></h3>
								<form action="adminpage.php" method="POST" role="form" class="text-center form-signin" style="margin-top: 5%;">
									<div class="form-group">
										<label style="float: left; margin-left: 20%;"> First Name <span style="color: #ff0000;">*</span> </label><br><br>
										<input type="text" class="form-control" id="artist_firstname" name="artist_firstname" autocomplete="off" required >
									</div>
									<div class="form-group">
										<label style="float: left; margin-left: 20%;"> Last Name <span style="color: #ff0000;">*</span> </label><br><br>
										<input type="text" class="form-control" id="artist_lastname" name="artist_lastname" autocomplete="off" required >
									</div>
									<button type="submit" class="btn btn-primary">Add Artist</button>
								</form>
							</div>
							<div id="add_paitings" class="tab-pane fade in">
								<h3 class="text-center" style="margin-top:2%; color: #337ab7;"><strong>Add Paintings</strong></h3>
								<form action="adminpage.php" method="POST" enctype="multipart/form-data" role="form" class="text-center form-signin" style="margin-top: 3%; margin-bottom: 3%; height: 100%;">
									<div class="form-group">
										<input type="text" class="form-control" id="title" name="title" placeholder="Title" autocomplete="off" required >
									</div>											
									<div class="form-group">
										<div class="form-inline">
											<label> Select Artist <span style="color: #ff0000;">*</span> &nbsp;&nbsp;</label>
											<select name="artst" id="artst" onchange="" size="1">
											<?php foreach($artistList as $at) { ?>
												<option value="<?php echo $at->artistid ?>"><?php echo $at->firstname . " " . $at->lastname ?></option>
											<?php } ?>
											</select>
										</div>
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="genre" name="genre" placeholder="Genre" >
									</div>
									<em style="text-center;"><span style="color: #ff0000;">**</span> &nbsp;&nbsp;All images below must have same name and only .jpg extension. &nbsp;&nbsp;<span style="color: #ff0000;">**</span></em><br><br>
									<div class="form-inline">
										<div class="form-group">
											<label> Painting Image Large Size <span style="color: #ff0000;">*</span> &nbsp;&nbsp;</label>
										</div>
										<div class="form-group">
											<input type="file" name="img_lg" id="img_lg" required >
										</div>
									</div><br>
									<div class="form-inline">
										<div class="form-group">
											<label> Painting Image Medium Size <span style="color: #ff0000;">*</span> &nbsp;&nbsp;</label>
										</div>
										<div class="form-group">
											<input type="file" name="img_md" id="img_md" required >
										</div>
									</div><br>
									<div class="form-inline">
										<div class="form-group">
											<label> Painting Image Small Size <span style="color: #ff0000;">*</span> &nbsp;&nbsp;</label>
										</div>
										<div class="form-group">
											<input type="file" name="img_sm" id="img_sm" required >
										</div>
									</div><br>
									<div class="form-inline">
										<div class="form-group">
											<label> Painting Image Thumbnail Size <span style="color: #ff0000;">*</span> &nbsp;&nbsp;</label>
										</div>
										<div class="form-group">
											<input type="file" name="img_st" id="img_st" required >
										</div>
									</div><br>
									<div class="form-group">
										<input type="text" class="form-control" id="price" name="price" placeholder="Price" required >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="year" name="year" placeholder="Year" >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="width" name="width" placeholder="Width" >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="height" name="height" placeholder="Height" >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="medium" name="medium" placeholder="Medium" >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="gallery" name="gallery" placeholder="Gallery" >
									</div>
									<div class="form-group">
										<input type="text" class="form-control" id="wikilink" name="wikilink" placeholder="Wikipedia Link" >
									</div>
									<button type="submit" class="btn btn-primary">Add Painting</button>
								</form>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
            <?php include_once './generalfooter.php'; ?>
	</body>
</html>