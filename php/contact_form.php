<?php
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Validate input fields
    $name = trim($_POST["name"]);
    $email = filter_var(trim($_POST["email"]), FILTER_SANITIZE_EMAIL);
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

    $stmt = $conn->prepare("INSERT INTO contact_form (name, email, message) VALUES (?, ?, ?)");
    $stmt->bind_param("sss", $name, $email, $message);

    // Insert data into database
    if ($stmt->execute()) {
        echo "New record created successfully";
        header("refresh:2;url=../index.html");
    } else {
        echo "Error: " . $stmt->error;
    }

    $stmt->close();
    $conn->close();
}
?>
