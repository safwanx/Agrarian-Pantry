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

// Get the orders for the seller with product names
$sql = "SELECT o.orders_id, o.total_price, o.status, o.quantity, p.name
        FROM orders o
        JOIN seller_order so ON o.orders_id = so.order_id
        JOIN products p ON o.product_id = p.product_id
        WHERE so.seller_id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $user_id);
$stmt->execute();
$result = $stmt->get_result();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../styles.css">
    <title>View Orders</title>
</head>
<style><?php include "../html/styles.css" ?></style>
<body>
    <div id="header"></div>
    <div class="view-order-container">
        <h1>View Orders</h1>
        <table>
            <tr>
                <th>Order ID</th>
                <th>Product Name</th>
                <th>Total Price</th>
                <th>Quantity</th>
                <th>Status</th>
            </tr>
            <?php
            while ($row = $result->fetch_assoc()) {
                $order_id = $row['orders_id'];
                $product_name = $row['name'];
                $total_price = $row['total_price'];
                $quantity = $row['quantity'];
                $status = $row['status'];
                ?>
                <tr>
                    <td><?php echo $order_id; ?></td>
                    <td><?php echo $product_name; ?></td>
                    <td><?php echo $total_price; ?></td>
                    <td><?php echo $quantity; ?></td>
                    <td><?php echo $status; ?></td>
                </tr>
                <?php
            }
            ?>
        </table>
        <button><a href="../html/profile.php">Back to profile</a></button>
    </div>
    <div id="footer"></div>

    <script src="../scripts/header.js"></script>
    <script src="../scripts/footer.js"></script>
</body>
</html>
