<?php

	if($_SERVER['REQUEST_METHOD'] == 'POST') {
		
		/* Get username and password from the post request
		 * This is the data coming from the Android app */
		$username = $_POST['username'];
		$password = $_POST['password'];
		$password = md5($password);
		
		// Importing database script
		include_once('db_connect.php');
	
		$db = new DB_Connect();
		$mysqli = $db->connect();
		
		$sql = "SELECT * FROM enforcer where username = '$username' and
		password = '$password'";
		
		$check = mysqli_fetch_array($mysqli->query($sql));
		
		if(isset($check)) {
			
			echo "Login Successful";
			
		} else {
			
			echo "Invalid Username or Password";
			
		}
		
	} else {
		
		echo "Error. Please try again.";
		
	}

?>
