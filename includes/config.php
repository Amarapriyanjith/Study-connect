<?php
// Database configuration parameters
$host = "localhost";
$username = "root";
$password = "";
$database = "user_system";

// Create database connection
$conn = new mysqli($host, $username, $password, $database);

// Check connection and handle errors gracefully
if ($conn->connect_error) {
    die("Database Connection Failed: " . $conn->connect_error);
}

// Set charset to utf8mb4 for proper text handling
$conn->set_charset("utf8mb4");
?>