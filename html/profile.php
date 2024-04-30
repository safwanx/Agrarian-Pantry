<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: account.html");
    exit;
} else {
    $user_id = $_SESSION['user_id'];
}

require '../php/database.php';

$user_id = $_SESSION['user_id'];
$sql = "SELECT * FROM users WHERE id = $user_id";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    $user_name = $row['name'];
    $user_email = $row['email'];
    $user_phone = $row['phone'];
    $user_type = $row['type'];
    $user_address = $row['address'];
}

$conn->close();

if (isset($_POST['logout'])) {
    session_destroy();
    header("Location: index.html");
    exit;
}

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="styles.css">
    <title>Profile</title>
</head>
<body>
    <div id="header"></div>
    <main>
        <section class="profile-section">
            <div class="profile-div">
                <h1>Welcome to your profile, <?php echo $user_name; ?></h1>
                <p>Name: <?php echo $user_name; ?></p>
                <p>Email: <?php echo $user_email; ?></p>
                <p>Phone: <?php echo $user_phone; ?></p>
                <p>Role: <?php echo $user_type; ?></p>
                <p>Address: <?php echo $user_address; ?></p>
                <form method="post">
                    <button type="submit" name="logout" class="btn btn-primary">Logout</button>
                </form>
            </div>
            <div class="profile-div">
                <?php 
                    if ($user_type === 'Customer') {
                        include 'customer_profile.html';
                    } elseif ($user_type === 'Seller') {
                        include 'seller_profile.html';
                    }
                ?>
            </div>
        </section>
    </main>

    <div id="footer"></div>
    <script src="../scripts/header.js"></script>
    <script src="../scripts/footer.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
