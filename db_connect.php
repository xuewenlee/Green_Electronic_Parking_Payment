<?php

class DB_Connect {
	
	public function connect() {
		require_once 'config.php';
		
		$con = new mysqli(hostname, user, password, databaseName, '3306');
		
		return $con;
	}
	
	public function close() {
		mysql_close();
	}
}


?>