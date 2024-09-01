<?php
$servername = "localhost";
$username = "root";  // default username for XAMPP
$password = "";      // default password for XAMPP (empty by default)
$dbname = "student_portfolio";  // make sure this matches your new database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
