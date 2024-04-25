<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
}

// Get the user ID from the session
$user_id = $_SESSION['user_id'];

// Connect to the database
require 'database.php';

// Retrieve order history for the user
$sql = "SELECT oh.order_id, oh.status, oh.created_at, o.seller_id, o.product_id, o.total_price, o.quantity, p.name, p.image_url
        FROM order_history oh
        JOIN orders o ON oh.order_id = o.orders_id
        JOIN products p ON o.product_id = p.product_id
        WHERE o.user_id = ?
        ORDER BY oh.created_at DESC";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();

// Display order history
if ($result->num_rows > 0) {
    while ($row = $result->fetch_assoc()) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <link rel="stylesheet" href="styles.css">
            <title>Order History</title>
        </head>
        <body>
            <div id="header"></div>
            <main>
                <h1>Order History</h1>
                <div class="order-history-container">
                    <div class="order-history-item">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>" style="max-width: 100px;">
                        <p>Product Name: <?php echo $row['name']; ?></p>
                        <p>Price: $<?php echo $row['total_price']; ?></p>
                        <p>Quantity: <?php echo $row['quantity']; ?></p>
                        <p>Seller ID: <?php echo $row['seller_id']; ?></p>
                        <p>Order ID: <?php echo $row['order_id']; ?></p>
                        <p>Status: <?php echo $row['status']; ?></p>
                        <p>Order Date: <?php echo $row['created_at']; ?></p>
                    </div>
                </div>
            </main>
            <div id="footer"></div>
            <!-- <script src="../scripts/header.js"></script>
            <script src="../scripts/footer.js"></script> -->
        </body>
        </html>
        <?php
    }
} else {
    echo "No order history found.";
}

// Close the database connection
$stmt->close();
$conn->close();
?>
