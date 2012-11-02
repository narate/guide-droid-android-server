<?php 	
header('Content-Type: bitmap; charset=utf-8');
/*
$photo = $_REQUIRE['file_upload'];
$category_id = $_REQUIRE['category_id'];
$location_name = $_REQUIRE['location_name'];

if($photo == null){	
	Do not upload photo
	Insert new location  		
	
}else{	
	Upload photo
	and Insert new location	
}
*/
/*
	$base=$_REQUEST['photo'];
    $binary=base64_decode($base);
    header('Content-Type: bitmap; charset=utf-8');
    $date = new DateTime();
    $path = './upload/'. $date->getTimestamp() .'.jpg';
    $file = fopen($path, 'a');    
    fwrite($file, $binary);
    fclose($file);
    chmod($path, 0766); 
    echo 'Image upload complete!!, Please check your php file directory……';
*/
 function getExtension($str) {
	  $i = strrpos($str, ".");
	  if (!$i) {
	  return "";
  }
  $l = strlen($str) - $i;
  $ext = substr($str, $i + 1, $l);
  return $ext;
  }

  // I'm using a separate config file. so pull in those values
  require("./../config/config.php");
  // pull in the file with the database class
  require("./../database.php");
  // create the $db object
  $db = new Database(DB_SERVER, DB_USER, DB_PASS, DB_DATABASE);
  // connect to the server
  $db->connect();
  // insert a new record using query_insert()
  $dataInsert['LOCATION_CATE_ID'] = $_POST["location_cate_id"];
  $dataInsert['LOCATION_NAME'] = $_POST["name"];
  $dataInsert['LATITUDE'] = $_POST["latitude"];
  $dataInsert['LONGITUDE'] = $_POST["longitude"];
  $dataInsert['DESCRIPTION'] = $_POST["description"];
  $dataInsert['OWNER_NAME'] = $_POST["user_name"];
  $dataInsert['DATE_CREATE'] = "NOW()";
 
  $insertLocation = $db->query_insert("location", $dataInsert); 

  $sql = "SELECT * FROM photo where LOCATION_CATE_ID ='" . $_POST["location_cate_id"] . "'";
  $rows = $db->query($sql);
  if ($db->fetch_array($rows) == "") {
  	 mkdir("./../upload/" . $_POST["location_cate_id"]);
  }
  //Find LOCATION_ID  
  $sql = "SELECT MAX( LOCATION_ID ) as maxLo_ID FROM location";
  $q_maxLocationID = $db->query($sql);
  if ($_maxLocationID = $db->fetch_array($q_maxLocationID)) {
	  $maxLocationID = $_maxLocationID['maxLo_ID'];
	  mkdir("./../upload/" . $_POST["location_cate_id"] . "/" . $maxLocationID);
  }

  $dir = "./../upload/" . $_POST["location_cate_id"];
  $subDirImage = $maxLocationID;   
  $new_image_name = $subDirImage . "_1" . ".jpg";
  $path = "$dir/$subDirImage/" . $new_image_name;
 
  	$base=$_REQUEST['photo_upload'];
	$binary=base64_decode($base);	
	$file = fopen($path, 'a');    
	fwrite($file, $binary);
	fclose($file);
	chmod($path, 0766); 

	$location_id_response = $maxLocationID;
 
  $UploadImage['LOCATION_ID'] = $maxLocationID;
  $UploadImage['LOCATION_CATE_ID'] = $_POST["location_cate_id"];
  $UploadImage['PHOTO_NAME'] = $new_image_name;
  $UploadImage['OWNER_NAME'] = $_POST["user_name"];
  //** Insert Record ***//
  $insertPhoto = $db->query_insert("photo", $UploadImage);

	// INSERT USER
	$_user_id 		= $_REQUEST['user_id'];
  	$_user_name 	= $_REQUEST['user_name'];
  	$_user_username = $_REQUEST['user_username'];
  
  	$userInsert['USER_ID'] 			= $_user_id;
  	$userInsert['USER_NAME'] 		= $_user_name;
  	$userInsert['USER_USERNAME'] 	= $_user_username;

  	$sql 	= "SELECT * FROM user where USER_USERNAME ='" . $_user_username . "'";
  	$rows 	= $db->query($sql);
  	if ($db->fetch_array($rows) == "") {  	
  		$insertUser = $db->query_insert("user", $userInsert); 
  	}else{
  	}  
  	
	$db->close();  
	echo "Added location #" . $location_id_response ."E";
?>  
