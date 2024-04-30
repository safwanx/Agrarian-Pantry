<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
}

$user_id = $_SESSION['user_id'];

// Connect to the database
require 'database.php';

// Check if the "complete_order" button was clicked
if (isset($_POST['complete_order'])) {
    $order_id = $_POST['order_id'];

    // Update the order status to "completed"
    $sql = "UPDATE orders SET status = 'completed' WHERE orders_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();

    // update the order staus in order_history table
    $sql = "UPDATE order_history SET status = 'completed' WHERE order_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $order_id);
    $stmt->execute();
    

    // Redirect back to the view_orders page
    header("Location: view_orders.php");
    exit;
}
?>