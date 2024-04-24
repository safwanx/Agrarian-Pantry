<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
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
            $sql = "INSERT INTO orders (user_id, seller_id, product_id, total_price, quantity) VALUES (?, ?, ?, ?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("iiiii", $user_id, $seller_id, $product_id, $total_price, $quantity);
            $stmt->execute();

            // Get the ID of the last inserted order
            $last_insert_id = $conn->insert_id;
            $sql = "INSERT INTO seller_order (seller_id, order_id) VALUES (?, ?)";
            $stmt = $conn->prepare($sql);
            $stmt->bind_param("ii", $seller_id, $last_insert_id);
            $stmt->execute();
        }

        // Commit the transaction
        $conn->commit();
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="../html/styles.css">
            <title>Order Placed</title>
        </head>
        <body>
            <div id="header"></div>
            <h1>Order Placed Successfully</h1>
            <p>Your order has been placed successfully. Thank you for shopping with us!</p>
            <p>You will be redirected to the home page in 5 seconds.</p>
            <div id="footer"></div>
            <script src="../scripts/header.js"></script>
            <script src="../scripts/footer.js"></script>
        </body>
        </html>
        <?php
        header("refresh:5;url=../html/index.html");
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