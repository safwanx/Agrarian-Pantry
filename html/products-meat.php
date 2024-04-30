<?php 
error_reporting(E_ALL); 
ini_set('display_errors', 1); 

require '../php/database.php'; 

$sql = "SELECT * FROM products WHERE product_type = 'meat'"; 
$result = $conn->query($sql); 
?> 

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <link rel="stylesheet" href="styles.css">
    <title>Meat</title>
</head>
<body>
    <div id="header"></div>
    <main>
        <div class="container">
            <h1>Meat</h1>
            <div class="row">
                <?php if ($result->num_rows > 0) {
                    while ($row = $result->fetch_assoc()) { ?>
                        <div class="col-md-4">
                            <div class="product-card card">
                                <img class="card-img-top" src="<?php echo $row['image_url']; ?>" alt="<?php echo $row['name']; ?>">
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $row['name']; ?></h5>
                                    <p class="card-text"><?php echo $row['description']; ?></p>
                                    <p class="card-text">Price: $<?php echo $row['price']; ?></p>
                                    <form action="../php/add_to_cart.php" method="post">
                                        <input type="hidden" name="product_id" value="<?php echo $row['product_id']; ?>">
                                        <input type="hidden" name="product_name" value="<?php echo $row['name']; ?>">
                                        <input type="hidden" name="product_price" value="<?php echo $row['price']; ?>">
                                        <input type="hidden" name="product_image" value="<?php echo $row['image_url']; ?>">
                                        <input type="hidden" name="seller_id" value="<?php echo $row['seller_id']; ?>">
                                        <input type="hidden" name="quantity" value="<?php echo $row['quantity']; ?>">
                                        <button class="btn btn-primary btn-sm rounded-pill" type="submit">Add to Cart</button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    <?php }
                } else {
                    echo "No products found";
                } ?>
            </div>
        </div>
    </main>
    <div id="footer"></div>
    <script src="../scripts/header.js"></script>
    <script src="../scripts/footer.js"></script>
</body>
</html>
<?php $conn->close(); 
?>