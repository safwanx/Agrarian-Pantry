<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account.html");
    exit;
}
$user_id = $_SESSION['user_id'];

// Connect to the database
require 'database.php';

// Get the orders for the user
$sql = "SELECT * FROM orders WHERE user_id = ?";
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
<body>
<div id="header"></div>
<h1>View Orders</h1>
<table>
    <tr>
        <th>Order ID</th>
        <th>Total Price</th>
        <th>Status</th>
        <th>Details</th>
    </tr>
    <?php
    while ($row = $result->fetch_assoc()) {
        $order_id = $row['orders_id'];
        $total_price = $row['total_price'];
        $status = $row['status'];
        ?>
        <tr>
            <td><?php echo $order_id; ?></td>
            <td><?php echo $total_price; ?></td>
            <td><?php echo $status; ?></td>
            <td><a href="order_details.php?order_id=<?php echo $order_id; ?>">View Details</a></td>
        </tr>
        <?php
    }
    ?>
</table>
</body>
</html>
