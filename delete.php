<?php 								
	include("connectDB2.php");
	$sql="DELETE FROM enforcer WHERE id='{$_GET['id']}'" or die(mysql_error());
	mysql_query($sql, $con);	
	header('location:option.php');
?>