<?php
		
		/* Get username and password from the post request
		 * This is the data coming from the Android app */
		$summon_time = $_POST['time'];
		$summon_date = $_POST['date'];
		$summon_plate_num = $_POST['plateNo'];
		
		
		
		// Importing database script
		include_once('db_connect.php');
	
		$db = new DB_Connect();
		$mysqli = $db->connect();
		
		$sql = "insert into summon_info(summon_time,summon_date,summon_plate_num) values ('$summon_time','$summon_date','$summon_plate_num')";
		
		$check = $mysqli->query($sql);
		
		if(isset($check)) {
			
			echo "Insert Successful";
			
		} else {
			
			echo "Invalid Username or Password";
			
		}
		
	 
		
?>