<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
}

// Initialize the cart if it is not set
if (!isset($_SESSION['cart'])) {
    $_SESSION['cart'] = array();
}

// Check if the required POST data is present
if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_image']) && isset($_POST['seller_id']) && isset($_POST['quantity'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];
    $seller_id = $_POST['seller_id'];
    $quantity = $_POST['quantity'];

    // Check if the product is already in the cart
    $index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));
    if ($index !== false) {
        // If the product is already in the cart, increase the quantity
        $_SESSION['cart'][$index]['quantity'] += $quantity;
    } else {
        // If the product is not in the cart, add it as a new item
        $_SESSION['cart'][] = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'seller_id' => $seller_id,
            'quantity' => $quantity
        );
    }

    echo "Product added to cart.";
    header("Location: ../html/cart.php");
    exit();
} else {
    echo "Invalid request.";
    header("Location: ../html/index.php");
    exit();
}
?>
