<?php

    $servername = "localhost";
    $username = "root";
    $dbpassword = "";
    $dbname = "agrarian_pantry";

    $conn = new mysqli($servername, $username, $dbpassword, $dbname);

    if ($conn->connect_error) {
        die("Connection failed: " . $conn->connect_error);
    }

    $stmt = $conn->prepare("SELECT * FROM products");
    $stmt->execute();

    $result = $stmt->get_result();

    $products = array();
    while($row = mysqli_fetch_assoc($result)) {
        $products[] = $row;
    }

    mysqli_close($conn);
    echo json_encode($products);
?>