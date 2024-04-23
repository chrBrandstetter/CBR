<?php 
$servername = "localhost";
$username = "root";
$password = "";
$dbName = "db_rechnungslegung"; 

// Create connection
$conn = new mysqli($servername, $username, $password, $dbName);

$conn->set_charset("utf8mb4");
// Check connection
if ($conn->connect_error) {
  die("Verbindungsfehler: " . $conn->connect_error);
}
?>