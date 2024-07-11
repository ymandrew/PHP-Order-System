<?php
// add_to_cart.php
session_start();
$foodid = $_GET['foodid'];
$quantity = 1; // Default quantity is 1

if (isset($_COOKIE['cart'])) {
    $cart_data = json_decode($_COOKIE['cart'], true);
} else {
    $cart_data = array();
}

$item_id_list = array_column($cart_data, 'item_id');
if (in_array($foodid, $item_id_list)) {
    // Check if the bookid is in the cart
    foreach ($cart_data as $keys => $values) {
        if ($cart_data[$keys]["item_id"] == $foodid) {
            $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + $quantity;
        }
    }
} else {
    $item_array = array(
        'item_id'       => $foodid,
        'item_quantity' => $quantity
    );
    $cart_data[] = $item_array;
}

$item_data = json_encode($cart_data);
setcookie('cart', $item_data, time() + (86400 * 30));
header("location:index.php?success=1");
?>