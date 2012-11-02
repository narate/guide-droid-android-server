<?php

/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */
/* ::                                                                         : */
/* ::  this routine calculates the distance between two points (given the     : */
/* ::  latitude/longitude of those points). it is being used to calculate     : */
/* ::  the distance between two zip codes or postal codes using our           : */
/* ::  zipcodeworld(tm) and postalcodeworld(tm) products.                     : */
/* ::                                                                         : */
/* ::  definitions:                                                           : */
/* ::    south latitudes are negative, east longitudes are positive           : */
/* ::                                                                         : */
/* ::  passed to function:                                                    : */
/* ::    lat1, lon1 = latitude and longitude of point 1 (in decimal degrees)  : */
/* ::    lat2, lon2 = latitude and longitude of point 2 (in decimal degrees)  : */
/* ::                                                                         : */
/* :::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::::: */

/*
	{	"request" : [
			{
				"id" 			: "LOCATION_ID",
				"title"			: "LOCATION_NAME",
				"lat"			: "LATITUDE",
				"lng"			: "LONGITUDE",
				"description" 	: "DESCRIPTION",
				"distance"		: "DISTANCE"
			},
			{
			
			},
			.
			.
			.
		]		
	}
*/

function distance($lat1, $lon1, $lat2, $lon2) {
    $theta = $lon1 - $lon2;
    $dist = sin(deg2rad($lat1)) * sin(deg2rad($lat2))
            + cos(deg2rad($lat1)) * cos(deg2rad($lat2)) * cos(deg2rad($theta));
    $dist = acos($dist);
    $dist = rad2deg($dist);
    $miles = $dist * 60 * 1.1515;
    // convert miles to kilometers
    return ($miles * 1.609344);
}

// I'm using a separate config file. so pull in those values
require("./../config/config.php");
// pull in the file with the database class
require("./../database.php");
// create the $db object
$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
// connect to the server
$db->connect();
$sql 	= "SELECT * FROM location";
$rows 	= $db->query($sql);
$json 	= array("request" => array());

// Defind place (distance <= radius && place == valueLocation)
while (($record = $db->fetch_array($rows))) {
    // find distance 2point (lat,long)
    $distance = distance($_GET['lat'], $_GET['lng'], $record['LATITUDE'], $record['LONGITUDE']);
    if ($distance <= ceil($_GET['radius'])) {
        $output[] = array(
    	"id" 			=> $record['LOCATION_ID'],
    	"category"		=> $record['LOCATION_CATE_ID'],
        "title" 		=> $record['LOCATION_NAME'],           
        "lat" 			=> $record['LATITUDE'],
        "lng" 			=> $record['LONGITUDE'],
        "description" 	=> $record['DESCRIPTION'],
        "owner" 		=> $record['OWNER_NAME'],
        "distance" 		=> $distance
        );              
    }
}// End loop Defind place
$db->close();


function subval_sort($a,$subkey) {
	foreach($a as $k=>$v) {
		$b[$k] = strtolower($v[$subkey]);
	}
	asort($b);
	foreach($b as $key=>$val) {
		$c[] = $a[$key];
	}
	return $c;
}

$jout = subval_sort($output,'distance');

//print('{"request" : ' . json_encode($output) . '}');
print('{"request" : ' . json_encode($jout) . '}');
?>

