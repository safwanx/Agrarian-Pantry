<?php
//server connection
$servername = "localhost";
$username = "root";
$password = "";
$dbname = "pantry_database";

$conn = new MySQLi($servername, $username, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
else{

}
?>