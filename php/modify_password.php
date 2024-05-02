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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" integrity="sha384-JcKb8q3iqJ61gNV9KGb8thSsNjpSL0n8PARn9HuZOnIxN0hoP+VmmDGMN5t9UJ0Z" crossorigin="anonymous">
    <link rel="stylesheet" href="../html/styles.css">
    <title>Modify Account</title>
</head>
<body>
    <header><?php include('../html/header.html'); ?></header>
    <main>
        <section class="modify-class">
            <div class="modify-container">
                <div class="container">
                    <div class="row justify-content-center">
                        <div class="col-md-6">
                            <form method="post" action="">
                                <div class="form-group">
                                    <label for="old-password">Old Password:</label>
                                    <input type="password" class="form-control" id="old-password" name="old-password" required>
                                </div>
                                <div class="form-group">
                                    <label for="new-password">New Password:</label>
                                    <input type="password" class="form-control" id="new-password" name="new-password" required>
                                </div>
                                <div class="form-group">
                                    <label for="confirm-password">Confirm New Password:</label>
                                    <input type="password" class="form-control" id="confirm-password" name="confirm-password" required>
                                </div>
                                <button type="submit" class="btn btn-primary" name="modify-password">Change Password</button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </main>
    <footer><?php include('../html/footer.html'); ?></footer>
    <script src="https://code.jquery.com/jquery-3.5.1.slim.min.js" integrity="sha384-DfXdz2htPH0lsSSs5nCTpuj/zy4C+OGpamoFVy38MVBnE+IbbVYUew+OrCXaRkfj" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js" integrity="sha384-9/reFTGAW83EW2RDu2S0VKaIzap3H66lZH81PoYlFhbGU+6BZp6G7niu735Sk7lN" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js" integrity="sha384-B4gt1jrGC7Jh4AgTPSdUtOBvfO8shuf57BaghqFfPlYxofvL8/KUEfYiJOMMV+rV" crossorigin="anonymous"></script>
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