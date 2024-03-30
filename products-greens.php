<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="styles.css">
    <title>Green Produce</title>
</head>
<body>
    <div id="header"></div>
    <main>
        <h1>Green Produce</h1>
        <?php
            require './php/database.php';
            $sql = "SELECT * FROM products WHERE category='green'";
            $result = $conn->query($sql);
            if ($result->num_rows > 0) {
                while($row = $result->fetch_assoc()) {
                    echo "<div class='product'>";
                    echo "<img src='./images/".$row['image']."' alt='".$row['name']."'>";
                    echo "<h2>".$row['name']."</h2>";
                    echo "<p>".$row['description']."</p>";
                    echo "<p>Price: $".$row['price']."</p>";
                    echo "</div>";
                }
            } else {
                echo "No products found";
            }
            $conn->close();
        ?>

    </main>

    <div id="footer"></div>
    <script src="./scripts/header.js"></script>
    <script src="./scripts/footer.js"></script>   
</body>
</html>