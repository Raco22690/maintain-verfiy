<?php
// Database configuration
$servername = "localhost"; // Replace with your server name
$username = "root";      // Replace with your database username
$password = "A12345678";          // Replace with your database password
$dbname = "mydatabase";       // Replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    // Stop script execution and display an error
    die("Connection failed: " . $conn->connect_error);
}

// Set character set to utf8mb4 for full Unicode support
$conn->set_charset("utf8mb4");
?>