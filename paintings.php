<?php session_start();
require_once './GetPaintingsList.php';
require_once './ArtistRoutines.php';
$titlefortable="";
$artistList = getArtistsList();
if ($_POST && isset($_REQUEST['search'])) {
    $paintingsList = getPaintingsListForSearch();
	if (empty($_REQUEST['search'])) {
	    $titlefortable = "All";
	} else {
		$titlefortable = "Search : " . $_REQUEST['search'];	
	}
}else {
    $paintingsList = getPaintingsList();
    $titlefortable = "All";
}

?>
<!DOCTYPE html>
<html>
    <head>
        <title>Gallery of Art</title>
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
            <!-- Include all compiled plugins (below), or include individual files as needed -->
            <?php include_once './generalheader.php'; ?>
            <div class="panel panel-primary" id="project-panel">
                <div class="panel-heading">
                    <h3 class="panel-title">
                        Paintings (<?php echo $titlefortable ?>)
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
																	<ul><a href="viewpainting.php?id=<?php echo $paint->paintingid ?>"><img class="rs" src="Resources/art-images/paintings/square-medium/<?php echo $paint->imagefilename ?>.jpg"/></a>
																	<li><span><a href="viewpainting.php?id=<?php echo $paint->paintingid ?>" style="color: #000;"><strong><?php echo $paint->title ?></strong></a></span></li>
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
			
            <?php include_once './generalfooter.php'; ?>
        </div>
    </body>
</html>



