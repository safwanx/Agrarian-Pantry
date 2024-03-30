<?php
$servername = "localhost";
$username = "root";
$dbpassword = "";
$dbname = "agrarian_pantry";

$conn = new mysqli($servername, $username, $dbpassword, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>