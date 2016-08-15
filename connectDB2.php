<?php
    $hostname="localhost";
    $username="root";
    $password="";
    $db_name="alt_parking";
    $con=mysql_connect($hostname,$username,$password);
    mysql_select_db($db_name,$con) or die ("Error connecting to the Database");
    mysql_query("SET NAMES 'utf8'",$con); 
 
?>