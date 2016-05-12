<?php

include_once './dbconn.php';

class Paint
{
    public $paintingid;
    public $artistid ;
    public $genre;
    public $imagefilename  ;
    public $title;
    public $year;
    public $width;
    public $height;
    public $medium;
    public $gallery;
    public $price;
    public $Wikipedialink ;
}


function getPaintingsList() {
	$paintsList = array();
	
	$sql = "SELECT * FROM paintings";
	$result = $GLOBALS['conn']->query($sql);
	
	if ($result->num_rows > 0) {
		while($paintDetails = $result->fetch_assoc()){
			$myPaint = new Paint();
			$myPaint->paintingid = $paintDetails["paintingid"];
			$myPaint->artistid = $paintDetails["artistid"];
			$myPaint->genre = $paintDetails["genre"];
			$myPaint->imagefilename = $paintDetails["imagefilename"];
			$myPaint->title = $paintDetails["title"];
			$myPaint->year = $paintDetails["year"];
            $myPaint->width = $paintDetails["width"];
            $myPaint->height = $paintDetails["height"];
			$myPaint->medium = $paintDetails["medium"];
			$myPaint->gallery = $paintDetails["gallery"];
			$myPaint->price = $paintDetails["price"];
			$myPaint->Wikipedialink = $paintDetails["wikipedialink"];
			$paintsList[$paintDetails["paintingid"]] = $myPaint;
		}
		return $paintsList;
	} 
	else {
		return NULL;
	}
	
}

function getPaintingsListForSearch() {

	$paintsList = array();
	
	$sql = "SELECT * FROM paintings";
	$result = $GLOBALS['conn']->query($sql);
	
	if ($result->num_rows > 0) {
		while($paintDetails = $result->fetch_assoc()){
			if (empty($_REQUEST['search'])){
					return getPaintingsList();
			}
            else if (strpos(strtolower($paintDetails["title"]), strtolower($_REQUEST['search'])) !== false) {
				$myPaint = new Paint();
				$myPaint->paintingid = $paintDetails["paintingid"];
				$myPaint->artistid = $paintDetails["artistid"];
				$myPaint->genre = $paintDetails["genre"];
				$myPaint->imagefilename = $paintDetails["imagefilename"];
				$myPaint->title = $paintDetails["title"];
				$myPaint->year = $paintDetails["year"];
				$myPaint->width = $paintDetails["width"];
				$myPaint->height = $paintDetails["height"];
				$myPaint->medium = $paintDetails["medium"];
				$myPaint->gallery = $paintDetails["gallery"];
				$myPaint->price = $paintDetails["price"];
				$myPaint->Wikipedialink = $paintDetails["wikipedialink"];
				$paintsList[$paintDetails["paintingid"]] = $myPaint;
			}
		}
		return $paintsList;
	} 
	else {
		return NULL;
	}
}

function getPaintingDetails()
{	
	$requested = $_REQUEST['id'];
	
	$sql = "SELECT * FROM paintings WHERE paintingid='$requested'";
	$result = $GLOBALS['conn']->query($sql);
	
	if ($result->num_rows > 0) {
		while($paintDetails = $result->fetch_assoc()){
			$myPaint = new Paint();
			$myPaint->paintingid = $paintDetails["paintingid"];
			$myPaint->artistid = $paintDetails["artistid"];
			$myPaint->genre = $paintDetails["genre"];
			$myPaint->imagefilename = $paintDetails["imagefilename"];
			$myPaint->title = $paintDetails["title"];
			$myPaint->year = $paintDetails["year"];
            $myPaint->width = $paintDetails["width"];
            $myPaint->height = $paintDetails["height"];
			$myPaint->medium = $paintDetails["medium"];
			$myPaint->gallery = $paintDetails["gallery"];
			$myPaint->price = $paintDetails["price"];
			$myPaint->Wikipedialink = $paintDetails["wikipedialink"];
			return $myPaint;
		}
	} 
	else {
		return NULL;
	}
	
}

function getPaintingsListOfArtworkerId($artistid)
{
 	$paintsList = array();
	
	$sql = "SELECT * FROM paintings WHERE artistid='$artistid'";
	$result = $GLOBALS['conn']->query($sql);
	
	if ($result->num_rows > 0) {
		while($paintDetails = $result->fetch_assoc()){
			$myPaint = new Paint();
			$myPaint->paintingid = $paintDetails["paintingid"];
			$myPaint->artistid = $paintDetails["artistid"];
			$myPaint->genre = $paintDetails["genre"];
			$myPaint->imagefilename = $paintDetails["imagefilename"];
			$myPaint->title = $paintDetails["title"];
			$myPaint->year = $paintDetails["year"];
            $myPaint->width = $paintDetails["width"];
            $myPaint->height = $paintDetails["height"];
			$myPaint->medium = $paintDetails["medium"];
			$myPaint->gallery = $paintDetails["gallery"];
			$myPaint->price = $paintDetails["price"];
			$myPaint->Wikipedialink = $paintDetails["wikipedialink"];
			$paintsList[$paintDetails["paintingid"]] = $myPaint;
		}
		return $paintsList;
	} 
	else {
		return NULL;
	}
	
}


?>
