<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve the product ID and new quantity from the form
    $product_id = $_POST['product_id'];
    $new_quantity = $_POST['quantity'];

    // Update the quantity and price in the cart
    foreach ($_SESSION['cart'] as &$item) {
        if ($item['product_id'] == $product_id) {
            $item['quantity'] = $new_quantity;
            $item['total_price'] = $item['product_price'] * $new_quantity;
            break;
        }
    }

    // Redirect back to the cart page
    $_SESSION['message'] = "Cart updated successfully.";
    header("Location: ../html/cart.php");
    exit;
} else {
    // If the request method is not POST, redirect to the homepage
    header("Location: ../html/index.html");
    exit;
}
?>
