<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: account.html");
    exit;
} else {
    $user_id = $_SESSION['user_id'];
}

require 'database.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";

// form for profile modification
include '../modify_profile.html';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify-profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, type = ? WHERE id = $user_id");
    $stmt->bind_param("ssss", $name, $email, $phone, $type);

    if ($stmt->execute()) {
        echo "Profile modified successfully";

        header("Location: ../account.html");
        session_unset();
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
}

$conn->close();
?>