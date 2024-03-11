<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['sign-in'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];


    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "agrarian_pantry";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT id, name, email, password FROM users WHERE email=?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['password'])) {
            // Password is correct
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_email'] = $row['email'];
            header("Location: ../index.html");
            exit();
        } else {
            // Password is incorrect
            header("Location: ../account.html?error=incorect-password");
            exit();
        }
    } else {
        // User not found
        header("Location: ../account.html?error=user-not-found"); 
        exit();
    }

    $stmt->close();
    $conn->close();
}
?>