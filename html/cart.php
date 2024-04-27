<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header('Location: account.html');
    exit();
}

$total_items = 0;
$total_price = 0;
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="styles.css">
    <title>Cart</title>
</head>
<body>
    <div id="header"></div>
    <h1>Cart</h1>
    <div class="cart-container">
        <?php if (empty($_SESSION['cart'])) { ?>
            <p>Your cart is empty.</p>
        <?php } else { ?>
            <table>
                <tr>
                    <th>Product Image</th>
                    <th>Product Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Total Price</th>
                </tr>
                <?php foreach ($_SESSION['cart'] as $item): ?>
                <tr>
                    <td><img src="<?php echo $item['product_image']; ?>" alt="<?php echo $item['product_name']; ?>" style="max-width: 100px;"></td>
                    <td><?php echo $item['product_name']; ?></td>
                    <td>$<?php echo $item['product_price']; ?></td>
                    <td>
                        <form action="../php/update_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $item['product_id']; ?>">
                            <select name="quantity" class="quantity-select" onchange="this.form.submit()">
                                <?php for ($i = 1; $i <= 10; $i++): ?>
                                <option value="<?php echo $i; ?>" <?php if ($i == $item['quantity']) echo 'selected'; ?>><?php echo $i; ?></option>
                                <?php endfor; ?>
                            </select>
                        </form>
                    </td>
                    <td>$<?php echo $item['product_price'] * $item['quantity']; ?></td>
                </tr>
                <?php $total_items += $item['quantity']; $total_price += $item['product_price'] * $item['quantity']; endforeach; ?>
            </table>
            <div class="total-section">
                Total Items: <?php echo $total_items; ?><br>
                Total Price: $<?php echo $total_price; ?>
            </div>
            <div class="place-order-button d-flex justify-content-center">
                <button class="btn btn-danger me-2">
                    <a href="../php/remove_from_cart.php?index=<?php echo array_search($item, $_SESSION['cart']); ?>" class="text-decoration-none text-white">Remove</a>
                </button>
                <button class="btn btn-primary">
                    <a href="../php/cart-order.php" class="text-decoration-none text-white">Place Order</a>
                </button>
            </div>
        <?php } ?>
    </div>
    <div id="footer"></div>
    <script src="../scripts/header.js"></script>
    <script src="../scripts/footer.js"></script>
</body>
</html>