<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $name = trim($_POST["name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
    $phone = trim($_POST["phone"]);
    $message = trim($_POST["message"]);

    // Check if all fields are filled
    if (empty($name) || empty($email) || empty($message)) {
        echo "Please fill all fields.";
        exit;
    }

    // Create connection
    $servername = "localhost";
    $username = "root";
    $password = "";
    $dbname = "agrarian_pantry";

    $conn = new mysqli($servername, $username, $password, $dbname);
    // Check connection
    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, phone, message) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $name, $email, $phone, $message);

    // Insert data into database
    if ($stmt->execute()) {
        echo "Form submitted successfully. We will get back to you soon.";
        header("refresh:2;url=../index.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
