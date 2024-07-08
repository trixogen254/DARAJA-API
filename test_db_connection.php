<?php
// Database connection details
$servername = "localhost";
$username = "root"; // replace with your database username
$password = "Trixogen@24"; // replace with your database password
$dbname = "tron_internet"; // replace with your database name

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
} else {
    echo "Database connection successful!";
}

// Close connection
$conn->close();
?>
