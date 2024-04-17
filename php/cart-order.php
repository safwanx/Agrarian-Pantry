<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account.html");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Check if the cart is not empty
if (!empty($_SESSION['cart'])) {
    // Connect to the database
    require 'database.php';

    // Begin a transaction
    $conn->begin_transaction();

    try {
        // Loop through the cart items and insert orders
        foreach ($_SESSION['cart'] as $item) {
            $product_id = $item['product_id'];
            $seller_id = $item['seller_id'];
            $quantity = $item['quantity'];
            $price = $item['product_price'];

            // Calculate the total price for this order
            $total_price = $quantity * $price;

            // Insert the order
            $sql = "INSERT INTO orders (user_id, seller_id, product_id, total_price) VALUES (?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiii", $user_id, $seller_id, $product_id, $total_price);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();

        // Display the thank you message and order summary
        echo "<h1>Thank you for your order!</h1>";
        echo "<h2>Order Summary:</h2>";
        echo "<ul>";
        foreach ($_SESSION['cart'] as $item) {
            echo "<li>" . $item['product_name'] . " - $" . $item['product_price'] * $item['quantity'] . "</li>";
        }
        echo "</ul>";
        echo "<button><a href='../products.html' class='btn'>Continue Shopping</a><button>";
        // Clear the cart
        unset($_SESSION['cart']);
    } catch (Exception $e) {
        // Rollback the transaction in case of an error
        $conn->rollback();
        echo "An error occurred while placing the order: " . $e->getMessage();
    } finally {
        // Close the database connection
        $conn->close();
    }
} else {
    echo "Your cart is empty. Please add some products to your cart before placing an order.";
    header("refresh:5;url=../products.html");
}
?>