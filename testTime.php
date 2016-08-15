<?php 
{
include 'connect.php';
global $connect;
//$selectFn = $_REQUEST["selectFN"];
$selectFn = "fnServerTime";
if($selectFn == "fnServerTime")
{
	fnServerTime($connect);
}
}

function  fnServerTime ($connect)
{
	date_default_timezone_set("Asia/Kuala_Lumpur");
	echo date("G:i:s");
	
}

?>