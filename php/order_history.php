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
$sql = "SELECT oh.order_id, oh.status, oh.created_at, o.seller_id, o.product_id, o.total_price, o.quantity, p.name, p.image_url FROM order_history oh JOIN orders o ON oh.order_id = o.orders_id JOIN products p ON o.product_id = p.product_id WHERE o.user_id = ? ORDER BY oh.created_at DESC";
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
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/css/bootstrap.min.css">
    <link rel="stylesheet" href="../html/styles.css">
    <title>Order History</title>
</head>
<style><?php include "../html/styles.css" ?></style>
<body>
    <header><?php include "../html/header.html" ?></header>
    <main class="container my-5">
        <h1 class="text-center mb-4">Order History</h1>
        <?php if ($result->num_rows > 0) { ?>
            <div class="row">
                <?php while ($row = $result->fetch_assoc()) { ?>
                    <div class="col-md-6 col-lg-4 mb-4">
                        <div class="card h-100">
                            <img src="<?php echo $row['image_url']; ?>" class="card-img-top" alt="<?php echo $row['name']; ?>">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                <p class="card-text">Price: $<?php echo $row['total_price']; ?></p>
                                <p class="card-text">Quantity: <?php echo $row['quantity']; ?></p>
                                <p class="card-text">Seller ID: <?php echo $row['seller_id']; ?></p>
                                <p class="card-text">Order ID: <?php echo $row['order_id']; ?></p>
                                <p class="card-text">Status: <?php echo $row['status']; ?></p>
                                <p class="card-text">Order Date: <?php echo $row['created_at']; ?></p>
                            </div>
                        </div>
                    </div>
                <?php } ?>
            </div>
        <?php } else { ?>
            <p class="text-center">No order history found.</p>
        <?php } ?>
    </main>
    <footer><?php include "../html/footer.html"?></footer>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php
// Close the database connection
$stmt->close();
$conn->close();
?>