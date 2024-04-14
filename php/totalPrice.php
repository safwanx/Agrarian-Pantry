<?php
function calculateTotalPrice($cart) {
    $totalPrice = 0;
    foreach ($cart as $item) {
        $totalPrice += $item['price'];
    }
    return $totalPrice;
}
?>