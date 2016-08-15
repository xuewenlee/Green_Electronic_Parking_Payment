<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		/* Get user_contactNo and user_password from the post request
		 * This is the data coming from the Android app */
	
		$plate_num = $_POST['plate_num'];
		
		// Importing database script
		include_once('db_connect.php');
	
		$db = new DB_Connect();
		$mysqli = $db->connect();
		
		$sql = "SELECT * FROM parking_info where plate_num='$plate_num'";
		
		$check = mysqli_fetch_array($mysqli->query($sql));
		
		if(isset($check)) {
			
			echo "Search Successful";
			
		} else {
			
			echo "Invalid Car Plate Number";
			
		}
		
	} else {
		
		echo "Error. Please try again.";
		
	}

?>
