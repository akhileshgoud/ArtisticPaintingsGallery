<?php  session_start();
if (!isset($_REQUEST['id'])) {
    
}
require_once './GetPaintingsList.php';
require_once './ArtistRoutines.php';
$paintingDetails = getPaintingDetails();
if($paintingDetails === NULL || $paintingDetails === "exception")
{
    header('Location: paintings.php');
}
$artistList = getArtistsList();
$paintingsList = getPaintingsListOfArtworkerId($paintingDetails->artistid);
?>
<html>
    <head>
		<title>Painting</title>
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
            <div class="panel" style="border: 1px solid #337ab7;">
                <div class="col-md-5 bg_blur" id="viewpaintimg">
                    <img src="Resources/art-images/paintings/medium/<?php echo $paintingDetails->imagefilename ?>.jpg" alt="<?php echo $paintingDetails->title ?>" height=300 width=300 data-toggle="modal" data-target=".pop-up-1" style="cursor: pointer;"/>
                </div>
                <div class="col-md-7 col-xs-12" style="padding-left: 0;">
                    <div class="header">
                        <h1><?php echo $paintingDetails->title ?></h1>
                        <h4>Artist: <?php
                            if (array_key_exists($paintingDetails->artistid, $artistList)) {
                                ?>
                                <span><?php echo $artistList[$paintingDetails->artistid]->firstname . " " . $artistList[$paintingDetails->artistid]->lastname ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
						<h4>Genre: <?php
                            if ($paintingDetails->genre !== "") {
                                ?>
                                <span><?php echo $paintingDetails->genre ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h4>Year: <?php
                            if ($paintingDetails->year !== "") {
                                ?>
                                <span><?php echo $paintingDetails->year ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h4>Medium: <?php
                            if ($paintingDetails->medium !== "") {
                                ?>
                                <span><?php echo $paintingDetails->medium ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
						<h4>Height: <?php
                            if ($paintingDetails->height !== "") {
                                ?>
                                <span><?php echo $paintingDetails->height ?> in</span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h4>Width: <?php
                            if ($paintingDetails->width !== "") {
                                ?>
                                <span><?php echo $paintingDetails->width ?> in</span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h4>Gallery: <?php
                            if ($paintingDetails->gallery !== "") {
                                ?>
                                <span><?php echo $paintingDetails->gallery ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h4><?php
                            if ($paintingDetails->Wikipedialink !== "") {
                                ?>
                            <a href="<?php echo $paintingDetails->Wikipedialink ?>" target="_blank">Read More <span class="glyphicon glyphicon-new-window"></span></a>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?>
                        </h4>
                        <h3>Price: <strong><?php
                            if ($paintingDetails->price !== "") {
                                ?>
                                <span><?php echo $paintingDetails->price ?></span>
                                <?php
                            } else {
                                ?>
                                <span>N.A</span>
                                <?php
                            }
                            ?></strong>
							<span><a class="btn btn-lg btn-primary" style="margin-left: 10%;" href="shoppingcart.php?id=<?php echo $paintingDetails->paintingid ?>">Add to cart</a></span>
                        </h3>
                    </div>
                </div>
                <div><p>&nbsp;</p></div>
            </div> 
            
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

        <!--  Modal content for the mixer image example -->
        <div class="modal fade pop-up-1" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel-1" aria-hidden="true">
            <div class="modal-dialog modal-lg">
                <div class="modal-content">

                    <div class="modal-header">
                        <button type="button" class="close" data-dismiss="modal" aria-hidden="true">X</button>
                        <h4 class="modal-title text-center" id="myLargeModalLabel-1"><?php echo $paintingDetails->title ?></h4>
                    </div>
                    <div class="modal-body">
                        <img src="Resources/art-images/paintings/large/<?php echo $paintingDetails->imagefilename ?>.jpg" alt="<?php echo $paintingDetails->title ?>" class="img-responsive img-rounded center-block" >
                    </div>
                </div><!-- /.modal-content -->
            </div><!-- /.modal-dialog -->
        </div>
    </body>
</html>


