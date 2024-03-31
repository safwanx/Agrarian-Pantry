<?php
error_reporting(E_ALL);
ini_set('display_errors', 1);

require './php/database.php';

$sql = "SELECT * FROM products WHERE product_type = 'baked'";
$result = $conn->query($sql);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Baked Goods</title>
</head>
<style>
    <?php include 'styles.css'; ?>
</style>
<body>
    <div id="header"></div>
    <main>
        <h1>Baked Goods</h1>
        <?php
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
        ?>
            <section class="product-display-section">
                <div class="product-display-class">
                    <img src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                    <h2><?php echo $row['name']; ?></h2>
                    <p><?php echo $row['description']; ?></p>
                    <p>Price: $<?php echo $row['price']; ?></p>
                </div>
            </section>
        <?php
            }
        } else {
            echo "No products found";
        }
        ?>
    </main>
    <div id="footer"></div>
    <script src="./scripts/header.js"></script>
    <script src="./scripts/footer.js"></script>
</body>
</html>
<?php
$conn->close();
?>