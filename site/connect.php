<?php
// connect.php

$servername = "db";       // Because our service is named "db" in docker-compose.yml
$username   = "root";
$password   = "123";
$dbname     = "mydb";

$conn = new mysqli($servername, $username, $password, $dbname);

// Check if connection failed
if ($conn->connect_error) {
  die("Connection failed: " . $conn->connect_error);
}
?>
