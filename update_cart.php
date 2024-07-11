<?php
session_start();

if(isset($_COOKIE["cart"])) {
    $cookie_data = stripslashes($_COOKIE['cart']);
    $cart_data = json_decode($cookie_data, true);
    foreach($cart_data as $keys => $values) {
        if($cart_data[$keys]['item_id'] == $_GET["id"]) {
            if($_GET["action"] == "add") {
                $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] + 1;
            }
            if($_GET["action"] == "remove") {
                $cart_data[$keys]["item_quantity"] = $cart_data[$keys]["item_quantity"] - 1;
                if($cart_data[$keys]["item_quantity"] <= 0) {
                    unset($cart_data[$keys]);
                }
            }
            if($_GET["action"] == "delete") {
                unset($cart_data[$keys]);
            }
        }
    }
    $item_data = json_encode($cart_data);
    setcookie("cart", $item_data, time() + (86400 * 30));
}
header("location:cart.php");
?>