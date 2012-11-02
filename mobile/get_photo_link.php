<?php
	/*
		$place_id = $_REQUEST['place_id'];
		print json_encode ->
			{"photo": [				
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					"photo_link":"PHOTO_LINK",
					.,
					.,
					.,
					"photo_link":"PHOTO_LINK"
				]
			}
		
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
  $sql = "SELECT PHOTO_NAME FROM photo WHERE LOCATION_ID = $location_id ORDER BY RAND() LIMIT 10";
  $rows = $db->query($sql);  

	while (($record = $db->fetch_array($rows))) {  		
		$photo[] = array("photo_link" => $record['PHOTO_NAME']);       
	}// End loop Defind place
  
	$db->close();  

  print('{ "photo": ' . json_encode($photo) . '}');

?>
