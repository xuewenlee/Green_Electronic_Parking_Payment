<?php
include 'conn.php';

$parking_location = $_POST["parking_location"];
	$parking_date = $_POST["parking_date"];
	$parking_time = $_POST["parking_time"];
	$plate_num = $_POST["plate_num"];
	$parking_duration = $_POST["parking_duration"];

$sql = "INSERT INTO `alt_parking`.`parking_info`(parking_location, parking_date, parking_time, plate_num, parking_duration) values 
			('$parking_location', '$parking_date', '$parking_time', '$plate_num', '$parking_duration');";

if ($connection->query($sql)) {
	$msg = array("status" =>1 , "msg" => "Your record inserted successfully");
} else {
	echo "Error: " . $sql . "<br>" . mysqli_error($connection);
}

$json = $msg;

header('content-type: application/json');
echo json_encode($json);


@mysqli_close($conn);

?>