<?php
	include "connectDB2.php";
	
	if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && ($_SERVER['HTTP_X_REQUESTED_WITH'] == 'XMLHttpRequest')) {
		$db = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password);
		if(isset($_POST['action']) && $_POST['action']=='getMonthlyPayment') {
			$firstDate = date('Y-m-01 00:00:00',strtotime($_POST["firstDate"]));
			$lastDate = date('Y-m-t 11:59:59',strtotime($_POST['lastDate']));	
			$plateNum = $_POST['plateNum'];
			
			$monthlyPayment = array();
			$monthlyPayment = getMonthlyPayment($firstDate, $lastDate, $plateNum);
			echo json_encode(array("monthlyPayment"=>$monthlyPayment), JSON_NUMERIC_CHECK);	
			//echo $monthlyPayment;				
		}
	}
	$db = new PDO("mysql:host=$hostname;dbname=$db_name", $username, $password);
	function getMonthlyPayment($firstDate, $lastDate, $plateNum) {
		global $db;
		if($plateNum <> '' AND $plateNum <> null) {
			//SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($firstDate)."'".$search_string;
			$sql = "SELECT FORMAT(sum(payment_amount),2) AS y, 
						DATE_FORMAT(parking_date, '%b/%Y') AS label 
						FROM parking_info 
						WHERE payment_status='approved' AND
						parking_date >= :firstDate AND 
						parking_date <= :lastDate AND 
						plate_num LIKE :plateNum
						GROUP BY YEAR(parking_date), MONTH(parking_date)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':firstDate'=>$firstDate, ':lastDate'=>$lastDate, ':plateNum'=>"%".$plateNum."%"));
			$recordSet = $stmt->fetchAll(PDO::FETCH_ASSOC);
		}
		else {
			//SELECT sum(payment_amount) AS totalMonthlyPayment, MONTHNAME(parking_date) AS parkingMonth, YEAR(parking_date) AS parkingYear FROM parking_info WHERE payment_status='approved' AND parking_date >= '".mysql_real_escape_string($firstDate)."'".$search_string;
			$sql = "SELECT FORMAT(sum(payment_amount),2) AS y, 
						DATE_FORMAT(parking_date, '%b/%Y') AS label 
						FROM parking_info 
						WHERE payment_status='approved' AND
						parking_date >= :firstDate AND 
						parking_date <= :lastDate
						GROUP BY YEAR(parking_date), MONTH(parking_date)";
			$stmt = $db->prepare($sql);
			$stmt->execute(array(':firstDate'=>$firstDate, ':lastDate'=>$lastDate));
			$recordSet = $stmt->fetchAll(PDO::FETCH_ASSOC);			
		}
		return $recordSet;
	}
	
?>