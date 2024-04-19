<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account.html");
    exit;
}

// Check if order_id is provided in the URL
if (!isset($_GET['order_id'])) {
    header("Location: view_orders.php");
    exit;
}
$order_id = $_GET['order_id'];

// Connect to the database
require 'database.php';

// Get order details
$sql = "SELECT o.product_id, o.quantity, o.total_price
        FROM orders o
        JOIN products p ON o.product_id = p.product_id
        WHERE o.orders_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $order_id);
$stmt->execute();
$result = $stmt->get_result();

// Display order details
if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $product_id = $row['product_id'];
    $quantity = $row['quantity'];
    $price = $row['total_price'];
    ?>
    <!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>Order Details</title>
</head>
<body>
    <div id="header"></div>
    <h1>Order Details</h1>
    <table>
        <tr>
            <th>Product ID</th>
            <th>Quantity Ordered</th>
            <th>Total Price</th>
        </tr>
        <?php
        if ($result->num_rows > 0) {
            $row = $result->fetch_assoc();
            $product_id = $row['product_id'];
            $quantity = $row['quantity'];
            $price = $row['total_price'];
            ?>
            <tr>
                <td><?php echo $product_id; ?></td>
                <td><?php echo $quantity; ?></td>
                <td>$<?php echo $price; ?></td>
            </tr>
            <?php
        } else {
            echo "<tr><td colspan='3'>Order details not found.</td></tr>";
        }
        ?>
    </table>
</body>
</html>

    <?php
} else {
    echo "Order details not found.";
}
?>
