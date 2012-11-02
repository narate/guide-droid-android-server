<?php
	header('Content-Type: bitmap; charset=utf-8');
	/*
		$location_id 		= $_REQUEST['location_id'];
		$location_cate_id 	= $_REQUEST['location_cate_id'];
		$owner				= $_REQUEST['owner']
		
		INSERT TO DATABASE : check location_cate_id and then location_id. check max photo_id and +1 then insert
	*/
	
	// I'm using a separate config file. so pull in those values
  	require("./../config/config.php");
  	// pull in the file with the database class
  	require("./../database.php"); 
  	//echo 'LOCATION_CATE_ID : ' . $_POST['location_cate_id'] . 'LOCATION_ID : ' . $_POST['location_id']
  	// create the $db object
  	$db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  	// connect to the server
  	$db->connect();  
  	$sql = "SELECT * FROM photo where LOCATION_CATE_ID ='" . $_POST["location_cate_id"] . "'";
    	$rows = $db->query($sql);
        if ($db->fetch_array($rows) == "") {
            mkdir("./../upload/" . $_POST["location_cate_id"], 0766);
        }
        //Find LOCATION_ID       
        $sql = "SELECT * FROM photo where LOCATION_ID ='" . $_POST["location_id"] . "'";
        $q_location = $db->query($sql);
        if ($db->fetch_array($q_location) == "") {
            mkdir("./../upload/" . $_POST["location_cate_id"] . "/" . $_POST["location_id"], 0766);
        }
        
	$sql 		= "SELECT COUNT( LOCATION_ID ) as newID FROM  photo WHERE LOCATION_ID = '" . $_POST["location_id"] . "'";
    $q_photoID 	= $db->query($sql);
    $photoID 	= -1;
    if ($_photoID 	= $db->fetch_array($q_photoID)) {
        $photoID 	= $_photoID['newID'];
        $subPhotoID = $photoID + 1;
    }
    
    $dir 			= $_POST["location_cate_id"];
    $subDirImage 	= $_POST["location_id"];
    
    $date = getdate();
    // Photo name : timestamp-random(year,timestamp)-locationid_photoid.jpg
    $photo_name 	= $date[0] . '-' .rand($date[year],$date[0]). '-' . $subDirImage . "_" . $subPhotoID . ".jpg";
    $path = "./../upload/$dir/$subDirImage/" . $photo_name;  
   
   	// Write photo
  	$base 				= $_POST['photo_upload'];
  	if($base != ""){
		$binary 			= base64_decode($base);	
		$file 				= fopen($path, 'a');    
		fwrite($file, $binary);
		fclose($file);
		chmod($path, 0766);
		
		$UploadImage['LOCATION_CATE_ID'] 	= $_POST["location_cate_id"];
	  	$UploadImage['LOCATION_ID'] 		= $_POST["location_id"];
	  	$UploadImage['PHOTO_NAME'] 			= $photo_name;
	  	$UploadImage['OWNER_NAME'] 			= $_POST["user_name"];
  	
  	$insertPhoto = $db->query_insert("photo", $UploadImage);
	} else{
		echo "ไม่มีภาพอัพโหลด";
	}

	//Find PHOTO_ID  
  	$sql 				= "SELECT MAX( PHOTO_ID ) as maxPho_ID FROM photo";
  	$q_maxPhotoID 		= $db->query($sql);
  	if($_maxPhotoID 	= $db->fetch_array($q_maxPhotoID)){
  		$maxPhoto_ID 	= $_maxPhotoID['maxPho_ID'];
  	}
  	

  // INSER OWNER

  $_user_id 		= $_REQUEST['user_id'];
  $_user_name 		= $_REQUEST['user_name'];
  $_user_username 	= $_REQUEST['user_username'];

  $userInsert['USER_ID'] 		= $_user_id;
  $userInsert['USER_NAME'] 	= $_user_name;
  $userInsert['USER_USERNAME'] 	= $_user_username;

  $sql 		= "SELECT * FROM user where USER_USERNAME ='" . $_user_username . "'";
  $rows 	= $db->query($sql);
  if ($db->fetch_array($rows) == "") {  	
  		$insertUser = $db->query_insert("user", $userInsert); 
  }else{
  }
  	$db->close();  

	echo "Added Photo #" . $maxPhoto_ID ."E";	

?>
