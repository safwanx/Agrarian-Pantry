<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../account.html");
    exit;
} else {
    $user_id = $_SESSION['user_id'];
}

if (isset($_POST['product_id']) && isset($_POST['product_name']) && isset($_POST['product_price']) && isset($_POST['product_image'])) {
    $product_id = $_POST['product_id'];
    $product_name = $_POST['product_name'];
    $product_price = $_POST['product_price'];
    $product_image = $_POST['product_image'];

    // Check if the product is already in the cart
    $index = array_search($product_id, array_column($_SESSION['cart'], 'product_id'));

    if ($index !== false) {
        // If the product is already in the cart, increase the quantity
        $_SESSION['cart'][$index]['quantity'] += 1;
    } else {
        // If the product is not in the cart, add it as a new item
        $_SESSION['cart'][] = array(
            'product_id' => $product_id,
            'product_name' => $product_name,
            'product_price' => $product_price,
            'product_image' => $product_image,
            'quantity' => 1
        );
    }

    echo "Product added to cart.";
    header("Location: ../cart.php");
} else {
    echo "Invalid request.";
}
?>

