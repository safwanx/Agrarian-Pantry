<?php 
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require './php/database.php'; 

$sql = "SELECT * FROM products WHERE product_type = 'meat'"; 
$result = $conn->query($sql); 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Meat</title>
</head>
<style>
    <?php include 'styles.css'; ?>
</style>
<body>
    <div id="header"></div>
    <main>
        <h1>Meat</h1>
        <div class="product-display-container">
            <?php if ($result->num_rows > 0) {
                while ($row = $result->fetch_assoc()) { ?>
                    <div class="product-display-item">
                        <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                        <h2><?php echo $row['name']; ?></h2>
                        <p><?php echo $row['description']; ?></p>
                        <p>Price: $<?php echo $row['price']; ?></p>
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
<?php $conn->close(); ?>