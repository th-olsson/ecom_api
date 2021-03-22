<?php #Connects to database using PDO.

$host = 'localhost';
$dbname = 'ecom_api';
$username = 'root';
$password = '';

$db = new PDO("mysql:host=$host;dbname=$dbname", $username, $password);
?>