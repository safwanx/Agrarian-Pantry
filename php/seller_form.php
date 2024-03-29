<?php
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = trim($_POST["name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $password = trim($_POST["password"]);
    $company = trim($_POST["company"]); 

    if (empty($name) || empty($email) || empty($phone) || empty($password) || empty($company)) {
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

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $stmt = $conn->prepare("INSERT INTO users (name, email, phone, password, company) VALUES (?, ?, ?, ?, ?)");
    if ($stmt === false) {
        die("Error preparing statement: " . $conn->error);
    }
    $stmt->bind_param("sssss", $name, $email, $phone, $hashed_password, $company);

    if ($stmt->execute()) {
        header("refresh:3;url=../index.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Seller</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="seller-page">
        <h1>Your form has been submitted successfully. We will be in touch shortly.</h1>
        <p>Redirecting to home page...</p>
    </div>
</body>
</html>