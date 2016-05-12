<?php

include_once './dbconn.php';

class Artist {

    public $artistid;
    public $firstname;
    public $lastname;

}

function getArtistsList() {
    
	$artistsList = array();
	
	$sql = "SELECT * FROM artists";
	$result = $GLOBALS['conn']->query($sql);
	
	if ($result->num_rows > 0) {
		while($artistDetails = $result->fetch_assoc()){
			$artist = new Artist();
			$artist->artistid = $artistDetails["artistid"];
			$artist->firstname = $artistDetails["firstname"];
			$artist->lastname = $artistDetails["lastname"];
			$artistsList[$artistDetails["artistid"]] = $artist;
		}
		return $artistsList;
	} 
	else {
		return NULL;
	}
	
}

?>
