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
    <title>Modify Account</title>
</head>
<body>
    <header><?php include('../html/header.html'); ?></header>
    <main>
        <section class="modify-class">
            <div class="modify-container">
                <form method="post" action="">
                    <label for="old-password">Old Password:</label>
                    <input type="password" id="old-password" name="old-password" required><br><br>
                    <label for="new-password">New Password:</label>
                    <input type="password" id="new-password" name="new-password" required><br><br>
                    <label for="confirm-password">Confirm New Password:</label>
                    <input type="password" id="confirm-password" name="confirm-password" required><br><br>
                    <button type="submit" name="modify-password">Change Password</button>
                </form>
            </div>
        </section>
    </main>
    <footer><?php include('../html/footer.html'); ?></footer>
    <script src="../scripts/account.js"></script>
</body>
</html>

<?php
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['modify-password'])) {
    $old_password = $_POST['old-password'];
    $new_password = $_POST['new-password'];
    $confirm_password = $_POST['confirm-password'];

    if (password_verify($old_password, $row['password'])) {
        if ($new_password == $confirm_password) {
            $hashed_new_password = password_hash($new_password, PASSWORD_DEFAULT);
            $stmt = $conn->prepare("UPDATE users SET password = ? WHERE id = $user_id");
            $stmt->bind_param("s", $hashed_new_password);
            if ($stmt->execute()) {
                echo "Password changed successfully";
                header("Location: ../html/account.html");
                session_unset();
                exit();
            } else {
                echo "Error: " . $sql . "<br>" . $conn->error;
            }
            $stmt->close();
        } else {
            echo "New passwords do not match";
        }
    } else {
        echo "Old password is incorrect";
    }
}
$conn->close();
?>