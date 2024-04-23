<?php
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "db_terminkalender"; 

//Baue Verbindung auf
$conn = new mysqli($servername, $username, $password, $dbName);

$conn->set_charset("utf8mb4"); 

//Überprüfe Verbindung ob Verbindungsfehler besteht
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>