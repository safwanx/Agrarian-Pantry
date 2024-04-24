<?php
session_start();
// Check form for sign-up
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sign-up'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];

    require 'database.php';

    // Hash the password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // Insert user into database, prevent sqli
    $stmt = $conn->prepare("INSERT INTO users (name, email, password, phone, type) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $hashed_password, $phone, $type);

    if ($stmt->execute()) {
        // User created successfully, redirect to sign in page
        header("Location: ../html/account.html");
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

    $stmt->close();
    $conn->close();
}
?>
