<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: ../html/account.html');
    exit;
}

// Include database connection file
require 'database.php';

// Fetch the list of products for the dropdown
$stmt = $conn->prepare('SELECT product_id, name FROM products WHERE seller_id = ?');
$stmt->bind_param('i', $_SESSION['user_id']);
$stmt->execute();
$result = $stmt->get_result();
$products = $result->fetch_all(MYSQLI_ASSOC);
$stmt->close();

// Fetch the product details from the database if the product_id is provided
$product_id = isset($_GET['product_id']) ? $_GET['product_id'] : null;
$product = null;
if ($product_id) {
    $stmt = $conn->prepare('SELECT * FROM products WHERE product_id = ?');
    $stmt->bind_param('i', $product_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $product = $result->fetch_assoc();
    $stmt->close();
}

// Update the product if the form is submitted
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $product_id = $_POST['product_id'];
    $name = $_POST['name'];
    $description = $_POST['description'];
    $price = $_POST['price'];
    $quantity = $_POST['quantity'];
    $product_type = $_POST['product_type'];
    $image_url = $_POST['image_url'];

    $stmt = $conn->prepare('UPDATE products SET name = ?, description = ?, price = ?, quantity = ?, product_type = ?, image_url = ? WHERE product_id = ?');
    $stmt->bind_param('ssddisi', $name, $description, $price, $quantity, $product_type, $image_url, $product_id);

    if ($stmt->execute()) {
        echo '<div class="alert alert-success">Product updated successfully.</div>';
    } else {
        echo '<div class="alert alert-danger">Error: ' . $stmt->error . '</div>';
    }

    $stmt->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Modify Product</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../html/styles.css">
</head>
<body>
    <header><?php include '../html/header.html'; ?></header>
    <section class="modify-class">
        <div class="modify-container">
            <div class="container my-5">
                <h1>Modify Product</h1>
                <form method="post" action="<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>">
                    <div class="form-group">
                        <label for="product_id">Product ID</label>
                        <select class="form-control" id="product_id" name="product_id" required>
                            <option value="">Select a product</option>
                            <?php foreach ($products as $p): ?>
                                <option value="<?php echo $p['product_id']; ?>" <?php echo $product && $product['product_id'] == $p['product_id'] ? 'selected' : ''; ?>><?php echo $p['product_id']; ?></option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?php echo $product ? $product['name'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" id="description" name="description" rows="3" required><?php echo $product ? $product['description'] : ''; ?></textarea>
                    </div>
                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="number" class="form-control" id="price" name="price" step="0.01" value="<?php echo $product ? $product['price'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="quantity">Quantity</label>
                        <input type="number" class="form-control" id="quantity" name="quantity" value="<?php echo $product ? $product['quantity'] : ''; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="product_type">Product Type</label>
                        <select class="form-control" id="product_type" name="product_type" required>
                            <option value="greens" <?php echo $product && $product['product_type'] === 'greens' ? 'selected' : ''; ?>>Greens</option>
                            <option value="meat" <?php echo $product && $product['product_type'] === 'meat' ? 'selected' : ''; ?>>Meat</option>
                            <option value="dairy" <?php echo $product && $product['product_type'] === 'dairy' ? 'selected' : ''; ?>>Dairy</option>
                            <option value="baked" <?php echo $product && $product['product_type'] === 'baked' ? 'selected' : ''; ?>>Baked</option>
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="image_url">Image URL</label>
                        <input type="text" class="form-control" id="image_url" name="image_url" value="<?php echo $product ? $product['image_url'] : ''; ?>">
                    </div>
                    <button type="submit" class="btn btn-primary">Modify</button><br><br>
                    <a href="../html/profile.php" class="btn btn-primary">Back to Profile</a>
                </form>
            </div>
        </div>
    </section>
    <footer><?php include '../html/footer.html'; ?></footer>
</body>
</html>