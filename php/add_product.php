<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
}
require 'database.php';

// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Retrieve form data
    $product_type = $_POST["product_type"];
    $seller_id = $_POST["seller_id"];
    $name = $_POST["name"];
    $description = $_POST["description"];
    $price = $_POST["price"];
    $quantity = $_POST["quantity"];
    $image_url = $_POST["image_url"];

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO products (product_type, seller_id, name, description, price, quantity, image_url) VALUES (?, ?, ?, ?, ?, ?, ?)");
    $stmt->bind_param("ssssdss", $product_type, $seller_id, $name, $description, $price, $quantity, $image_url);

    // Execute the statement
    if ($stmt->execute()) {
        echo "New product added successfully";
    } else {
        echo "Error: " . $stmt->error;
    }

    // Close the statement
    $stmt->close();
}

// Close the connection
$conn->close();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product</title>
    <style><?php include('../html/styles.css'); ?></style>
</head>
<body>
    <header><?php include('../html/header.html'); ?></header>
    <main>
        <div class="add-product-container">
            <h2>Add Product</h2>
            <form method="post" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                <label for="product_type">Product Type:</label>
                <select name="product_type" id="product_type">
                    <option value="greens">Greens</option>
                    <option value="meat">Meat</option>
                    <option value="dairy">Dairy</option>
                    <option value="baked">Baked</option>
                </select>

                <label for="seller_id">Seller ID:</label>
                <input type="text" name="seller_id" id="seller_id">

                <label for="name">Name:</label>
                <input type="text" name="name" id="name">

                <label for="description">Description:</label>
                <textarea name="description" id="description"></textarea>

                <label for="price">Price:</label>
                <input type="text" name="price" id="price">

                <label for="quantity">Quantity:</label>
                <input type="text" name="quantity" id="quantity">

                <label for="image_url">Image URL:</label>
                <input type="text" name="image_url" id="image_url">

                <input type="submit" name="submit" value="Add Product">
            </form>
        </div>

    </main>
    <footer><?php include('../html/footer.html'); ?></footer>
</body>
</html>