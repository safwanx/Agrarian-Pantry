<?php
session_start();

// Check if the product ID, name, and price are set
if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];

    // Initialize the cart if it doesn't exist
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = array();
    }

    // Check if the product is already in the cart
    $found = false;
    foreach ($_SESSION['cart'] as $item) {
        if ($item['id'] == $product_id) {
            $found = true;
            break;
        }
    }

    // If the product is not in the cart, add it
    if (!$found) {
        $_SESSION['cart'][] = array(
            'id' => $product_id,
            'name' => $product_name,
            'price' => $product_price
        );
    }

    // Redirect back to the previous page
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
} else {
    // Redirect back to the previous page if the required parameters are not set
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>
