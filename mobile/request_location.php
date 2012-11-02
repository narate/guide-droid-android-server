<?php
	/*
		$place_id = $_REQUEST['place_id'];
		print json_encode ->
			{"place": [
				"place_id":"ID",
				"place_cate_id","PLACE_CATE_ID",
				"title":"TITLE",
				"latitude":"LATITUDE",
				"longitude":"LONGITUDE",
				"description":"DESCRIPTION",
				"owner":"OWNER",
				"photo":[
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					.,
					.,
					.,
					"photo_link":"PHOTO_LINK"
				]
			]}
		
		PHOTO_LINK = link to photo e.g. http://localhost/navigator/upload/location_cate_id/place_id/photo_name.jpg
		* All photo
	*/
	
  // I'm using a separate config file. so pull in those values
  require("./../config/config.php");
  // pull in the file with the database class
  require("./../database.php");
  // pull in the file -> create directory
  require("./../mkdir.php");
  // create the $db object
  $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  // connect to the server
  $db->connect();
  
  $location_id = $_REQUEST['location_id'];
  $sql = "SELECT * FROM photo WHERE LOCATION_ID = $location_id";
  $rows = $db->query($sql);  

	while (($record = $db->fetch_array($rows))) {  		
		$photo[] = array("photo_link" => $record['PHOTO_NAME']);       
	}// End loop Defind place
	
	$sql = "SELECT * FROM location WHERE LOCATION_ID = $location_id";
  	$rows = $db->query($sql);

	while (($record = $db->fetch_array($rows))) { 		
		$place[] = array(
		"place_id" 		=> $record['LOCATION_ID'],
		"place_cate_id" => $record['LOCATION_CATE_ID'],
		"title" 		=> $record['LOCATION_NAME'],
		"latitude" 		=> $record['LATITUDE'],
		"longitude" 	=> $record['LONGITUDE'],
		"description"	=> $record['DESCRIPTION'],
		"owner"			=> $record['OWNER_NAME'],
		"photo"			=> $photo	
		);       
	}// End loop Defind place
  
	$db->close();  

  print('{ "place": ' . json_encode($place) . '}');

?>
