<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Cart</title>
</head>
<body>
    <div id="header"></div>
    <main>
        <h1>Cart</h1>
        <div class="cart-items">
            <?php 
            session_start();
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $item){
                    echo "<p>{$item['name']} - {$item['price']}</p>";
                    echo "<a href='./php/remove_from_cart.php?index={$key}'>Remove</a>";
                }
            } else {
                echo "Your cart is empty.";
            }
            ?>
        </div>
    </main>

    <div id="footer"></div>
    <script src="./scripts/header.js"></script>
    <script src="./scripts/footer.js"></script>    
</body>
</html>
