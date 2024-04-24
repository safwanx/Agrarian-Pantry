<?php
session_start();

$index = $_GET['index'];

unset($_SESSION['cart'][$index]);

header('Location: ../html/cart.php');
?>
