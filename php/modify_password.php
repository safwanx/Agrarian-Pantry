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

// form for password change
include '../modify_password.html';


if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify-password'])) {
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    $sql = "SELECT password FROM users WHERE id = $user_id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $hashed_password = $row['password'];

        if (password_verify($old_password, $hashed_password)) {
            if ($new_password == $confirm_password) {
                $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
                $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = $user_id");
                $stmt->bind_param("s", $hashed_new_password);

                if ($stmt->execute()) {
                    echo "Password changed successfully";
                    header("Location: ../account.html");
                    session_unset();
                    exit();
                } else {
                    echo "Error: " . $sql . "<br>" . $conn->error;
                }
                $stmt->close();
            } else {
                echo "New passwords do not match";
            }
        } else {
            echo "Old password is incorrect";
        }
    }
}

$conn->close();
?>