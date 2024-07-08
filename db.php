<?php
$servername = "localhost";
$username = "root"; // replace with your DB username
$password = "Trixogen@24"; // replace with your DB password
$dbname = "tron_internet";

$conn = new mysqli($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>
