<?php include './php/totalPrice.php';?>

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
        <div class="cart-container">
            <?php 
            session_start();
            if(isset($_SESSION['cart'])){
                foreach($_SESSION['cart'] as $key => $item){
                    ?>
                    <div class="cart-item">
                        <div>
                            <img src="<?php echo $item['image_url']; ?>" alt="<?php echo $item['name']; ?>">
                        </div>
                        <div>
                            <p><?php echo $item['name']; ?> - $<?php echo $item['price']; ?></p>
                            <label for="quantity_<?php echo $key; ?>">Quantity:</label>
                            <select id="quantity_<?php echo $key; ?>" name="quantity_<?php echo $key; ?>">
                                <?php for($i = 1; $i <= 100; $i++) { ?>
                                    <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                <?php } ?>
                            </select>
                            <a href="./php/remove_from_cart.php?index=<?php echo $key; ?>">Remove</a>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "Your cart is empty.";
            }
            ?>
            <h2>Total Price: $<span id="total-price"><?php echo calculateTotalPrice($_SESSION['cart']); ?></span></h2>
        </div>
    </main>

    <script>
        let totalPrice = <?php echo calculateTotalPrice($_SESSION['cart']); ?>;

        function updateTotalPrice() {
            document.getElementById('total-price').textContent = totalPrice.toFixed(2);
        }

        // Listen for changes in quantity select elements
        <?php foreach($_SESSION['cart'] as $key => $item) { ?>
            document.getElementById('quantity_<?php echo $key; ?>').addEventListener('change', function() {
                let quantity = document.getElementById('quantity_<?php echo $key; ?>').value;
                let price = <?php echo $item['price']; ?>;
                totalPrice += (quantity - 1) * price; // Subtract the previous quantity and add the new quantity
                updateTotalPrice();
            });
        <?php } ?>
    </script>


    <div id="footer"></div>
    <script src="./scripts/header.js"></script>
    <script src="./scripts/footer.js"></script>    
</body>
</html>
