<?php #Connects to database using PDO.

$db_host = 'localhost';
$db_dbname = 'ecom_api';
$db_username = 'root';
$db_password = '';

$db = new PDO("mysql:host=$db_host;dbname=$db_dbname", $db_username, $db_password);
?>