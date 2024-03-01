<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $company = trim($_POST["company"]); 
    $message = trim($_POST["message"]);

    if (empty($name) || empty($email) || empty($phone) || empty($company) || empty($message)) {
        echo "Please fill all fields.";
        exit;
    }

    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agrarian_pantry";

    $conn = new mysqli($servername, $username, $password, $dbname);
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO seller_form (name, email, phone, company, message) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssss", $name, $email, $phone, $company, $message);

    if ($stmt->execute()) {
        echo "Your form has been submitted successfully. We will be in touch shortly.";
        header("refresh:2;url=../index.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>