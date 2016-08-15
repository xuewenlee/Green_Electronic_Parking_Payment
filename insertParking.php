<?php

if($_SERVER["REQUEST_METHOD"]=="POST") {
	require 'connect.php';
	createParking();
}

function createparking(){
	global  $connect;
	
	$parking_location = $_POST["parking_location"];
	$parking_date = $_POST["parking_date"];
	$parking_time = $_POST["parking_time"];
	$plate_num = $_POST["plate_num"];
	$parking_duration = $_POST["parking_duration"];
	
	$query = "Insert into parking_info(parking_location, parking_date, parking_time, plate_num, parking_duration) values 
			('$parking_location', '$parking_date', '$parking_time', '$plate_num', '$parking_duration');";
	
	mysqli_query($connect, $query) or die (mysqli_error($connect));
	mysqli_close($connect);
			
}

?>