<?php

//if($_SERVER["REQUEST_METHOD"]=="POST")
{
	include 'connect.php';
	global $connect;
	$selectFn = $_REQUEST["selectFN"];
	//$selectFn = "fnGetParkRate";
	if($selectFn == "fnshowParking")
	{
		fnShowParking($connect);
	}
	else if($selectFn == "fnGetParkRate")
	{
		fnGetParkRate($connect);
	}
	else if($selectFn == "fnGetNotification")
	{
		fnGetNotification($connect);
	}
	else if ($selectFn == "fnInsert")
	{
		fnInsert($connect);
	}
	else if ($selectFn == "fnUpdatePayment")
	{
		fnUpdate($connect);
	}
	else if ($selectFn == "fnEnforcerLogin")
	{
		fnEnforcerLogin($connect);
	}
	else if($selectFn == "fnServerTime")
	{
		fnServerTime($connect);
	}
	else if($selectFn == "fnUpdateQrPayment")
	{
		fnUpdateQrPayment($connect);
	}
	else if($selectFn == "fnGetCredit")
	{
		fnGetCredit($connect);
	}
	else if($selectFn == "fnGetParkStatus")
	{
		fnGetParkStatus($connect);
	}

}
//shows all columns from table parking_info
function fnshowParking($connect)
{


	$query = " select * FROM PARKING_INFO; ";

	$result = mysqli_query($connect, $query);
	$number_of_rows = mysqli_num_rows($result);

	$temp_array = array();

	if($number_of_rows > 0) {
		while ($row = mysqli_fetch_assoc($result)){
			$temp_array[] = $row;
		}
	}

	header('Content-Type: application/json');
	echo json_encode(array("parking"=>$temp_array));
	mysqli_close($connect);
}

//displays parking rate into mobile app
function fnGetParkRate($connect)
{
	$strqry = "select * from parking_rate";

	$result = mysqli_query($connect, $strqry);

	$temp_array = array();

	while($row = mysqli_fetch_object($result))
	{
	  	$temp_array[] = $row;
	}

	echo json_encode($temp_array);
}


//display notification for user
function fnGetNotification($connect)
{
	$strqry = "select payment_status from parking_info where parking_id = (select max(parking_id) from parking_info)";
	//order by

	$result = mysqli_query($connect, $strqry);

	$temp_array = array();

	while($row = mysqli_fetch_object($result))
	{
		$temp_array[] = $row;

	}

	echo json_encode($temp_array);
}

function fnEnforcerLogin($connect)
{
	/* $username = $_POST['editUsername'];
	$password = $_POST['editPassword'];

	$flag['code']=0;
	$str = "No Such User Found";


	$query_search = "SELECT * FROM enforcer WHERE username='$username' and password='$password'";
	$query_exec = mysql_query($query_search) or die(mysql_error());
	$rows = mysql_num_rows($query_exec);

	if($rows == 0) {
		$flag['code']=0;
		}
		else  {
			$flag['code']=1;
		}

		print(json_encode($flag));


	@mysqli_close($conn); */

	$username = $_POST['username'];
	$password = $_POST['password'];
	$encrypt_password = md5($password);
	$result = mysqli_query($con,"SELECT id FROM enforcer where
			Username='$username' and Password='$encrypt_password'");
	$row = mysqli_fetch_array($result);
	$data = $row[0];

	if($data){
		echo "{response:".$data."}";
	}
	mysqli_close($connnect);

}

//inserts data from mobile app into parking_info table
function fnInsert($connect)
{
	$parking_date = date("Y-m-d");
	$parking_start_time = $_REQUEST["parking_start_time"];
	$parking_end_time = $_REQUEST["parking_end_time"];
	$plate_num = $_REQUEST["plate_num"];
	$parking_duration = $_REQUEST["parking_duration"];
	$parking_amount = $_REQUEST["parking_amount"];
	//$parking_status = $_POST["parking_status"];

	$sql = "INSERT INTO `alt_parking`.`parking_info`(parking_date, parking_start_time, parking_end_time, plate_num, parking_duration, payment_amount, payment_status) values
	('$parking_date', '$parking_start_time', '$parking_end_time', '$plate_num', '$parking_duration', '$parking_amount', '')";

	if ($connect->query($sql)) {
		$msg = array("status" =>1 , "msg" => "Your record inserted successfully");
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$json = $msg;

	header('content-type: application/json');
	echo json_encode($json);


	@mysqli_close($conn);
}

//updates status of paymnet into parking_info table
function fnUpdate($connect)
{
	//$parking_date = date("Y-m-d");
	$paymentStat = $_REQUEST["paymentStat"];
	$plate_num = $_REQUEST["plate_num"];


	$sql = "UPDATE parking_info set  payment_status = ('$paymentStat') where plate_num = ('$plate_num')";

	if ($connect->query($sql)) {
		$msg = array("status" =>1 , "msg" => "Your record updated successfully");
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$json = $msg;

	header('content-type: application/json');
	echo json_encode($json);


	@mysqli_close($conn);
}

function fnServerTime ($connect)
{
	date_default_timezone_set("Asia/Kuala_Lumpur");
	$json['time'] = date("G:i:s");
	echo json_encode($json);
}

function fnUpdateQrPayment ($connect)
{
	$qrResult = $_REQUEST["qrResult"];
	$total_amount = $_REQUEST["total_amount"];

	$sqlcd = "SELECT qrCredit FROM qr_code WHERE qrCode = ('$qrResult')";
	$result = mysqli_query($connect, $sqlcd);
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$qrCredit = 0;
	foreach($rows as $row)
	{
	 $qrCredit = $row['qrCredit'];

	}

	$balance = $qrCredit - $total_amount;

	$sql = "UPDATE qr_code set qrCredit = ('$balance') where qrCode = ('$qrResult')";

	if ($connect->query($sql)) {
		$msg = array("status" =>1 , "msg" => "Your record updated successfully", "balance" =>$balance);
	} else {
		echo "Error: " . $sql . "<br>" . mysqli_error($connect);
	}

	$json = $msg;

	header('content-type: application/json');
	echo json_encode($json);


	@mysqli_close($conn);

}

function fnGetCredit($connect)
{
	$qrResult = $_REQUEST["qrResult"];
	$sqlcd = "SELECT qrCredit FROM qr_code WHERE qrCode = ('$qrResult')";
	$result = mysqli_query($connect, $sqlcd);
	$rows = mysqli_fetch_all($result, MYSQLI_ASSOC);
	$qrCredit = 0;
	foreach($rows as $row)
	{
	 $qrCredit = $row['qrCredit'];
	}

	$json['credit'] = $qrCredit;
	echo json_encode($json);

	@mysqli_close($conn);
}

//send parking status into mobile app
function fnGetParkStatus($connect)
{

	$plate_num = $_REQUEST["plate_num"];
	$parking_end_time = $_REQUEST["parking_end_time"];
	$strqry = "select payment_status from parking_info where plate_num = ('$plate_num') AND parking_end_time = ('$parking_end_time')";

	$result = mysqli_query($connect, $strqry);

	$temp_array = array();

	while($row = mysqli_fetch_object($result))
	{
	  	$temp_array[] = $row;
	}

	echo json_encode($temp_array);
}
?>
