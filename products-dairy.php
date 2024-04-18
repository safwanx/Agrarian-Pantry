<?php 
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require './php/database.php'; 

$sql = "SELECT * FROM products WHERE product_type = 'dairy'"; 
$result = $conn->query($sql); 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="./styles.css">
    <title>Dairy</title>
</head>

<body>
    <div id="header"></div>
    <main>
        <h1>Dairy</h1>
        <div class="product-display-container">
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="product-display-item">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                        <h2><?php echo $row['name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <p>Price: $<?php echo $row['price']; ?></p>
                        <form action="./php/add_to_cart.php" method="post">
                            <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                            <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                            <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                            <input type="hidden" name="product_image" value="<?php echo $row['image_url']; ?>">
                            <input type="hidden" name="seller_id" value="<?php echo $row['seller_id']; ?>">
                            <button id="add-to-crt-btn" type="submit">Add to Cart</button>
                        </form>
                    </div>
                <?php }
            } else {
                echo "No products found";
            } ?>
        </div>
    </main>
    <div id="footer"></div>
    <script src="./scripts/header.js"></script>
    <script src="./scripts/footer.js"></script>
</body>
</html>
<?php $conn->close(); 
?>