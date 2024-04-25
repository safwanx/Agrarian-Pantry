<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: ../html/account.html");
    exit;
} else {
    $user_id = $_SESSION['user_id'];
}

require 'database.php';

$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);
$row = $result->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../html/styles.css">
    <title>Modify Profile</title>
</head>
<body>
    <header><?php include('../html/header.html'); ?></header>
    <main>
        <section class="modify-class">
            <div class="modify-container">
                <form method="post" action="">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" value="<?php echo $row['name']; ?>" required><br><br>
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" value="<?php echo $row['email']; ?>" required><br><br>
                    <label for="phone">Phone:</label>
                    <input type="tel" id="phone" name="phone" value="<?php echo $row['phone']; ?>" required><br><br>
                    <label for="text">Type</label>
                    <select name="type" id="type">
                        <option value="Seller" <?php echo ($row['type'] == 'Seller') ? 'selected' : ''; ?>>Seller</option>
                        <option value="Customer" <?php echo ($row['type'] == 'Customer') ? 'selected' : ''; ?>>Customer</option>
                    </select><br><br>
                    <button type="submit" name="modify-profile">Change Profile</button>
                </form>
            </div>
        </section>
    </main>
    <footer><?php include('../html/footer.html'); ?></footer>
    <script src="../scripts/account.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify-profile'])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $type = $_POST['type'];

    $stmt = $conn->prepare("UPDATE users SET name = ?, email = ?, phone = ?, type = ? WHERE id = $user_id");
    $stmt->bind_param("ssss", $name, $email, $phone, $type);
    if ($stmt->execute()) {
        echo "Profile modified successfully";
        header("Location: ../html/account.html");
        session_unset();
        exit();
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
    $stmt->close();
}
$conn->close();
?>