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
$sql = "SELECT o.orders_id, o.total_price, o.status, o.quantity, p.name FROM orders o JOIN seller_order so ON o.orders_id = so.order_id JOIN products p ON o.product_id = p.product_id WHERE so.seller_id = ?";
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="../styles.css">
    <title>View Orders</title>
</head>
<style><?php include "../html/styles.css" ?></style>
<body>
    <header><?php include "../html/header.html" ?></header>
    <div class="container my-5">
        <h1 class="text-center mb-4">View Orders</h1>
        <div class="table-responsive">
            <table class="table table-striped">
                <thead>
                    <tr>
                        <th>Order ID</th>
                        <th>Product Name</th>
                        <th>Total Price</th>
                        <th>Quantity</th>
                        <th>Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php while ($row = $result->fetch_assoc()) { 
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
                        <td>
                            <?php if ($status !== 'completed') { ?>
                            <form method="post" action="update_order_status.php">
                                <input type="hidden" name="order_id" value="<?php echo $order_id; ?>">
                                <button type="submit" class="btn btn-primary" name="complete_order">Complete Order</button>
                            </form>
                            <?php } ?>
                        </td>
                    </tr>
                    <?php } ?>
                </tbody>
            </table>
        </div>
        <div class="text-center mt-4">
            <button class="btn btn-primary"><a href="../html/profile.php" class="text-white">Back to profile</a></button>
        </div>
    </div>
    <footer><?php include('../html/footer.html'); ?></footer>

    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
</body>
</html>