<head>
<style>
    /* 標題樣式 */
    h1 {
        color: #333;
        font-size: 40px;
        text-align: center;
        margin-bottom: 20px;
    }
    
    /* 購物車項目樣式 */
    .cart-item {
        border: 1px solid #ccc;
        border-radius: 5px;
        padding: 10px;
        margin-bottom: 10px;
    }
    
    /* 書籍小計樣式 */
    .subtotal {
        font-weight: bold;
        color: #333;
    }
    
    /* 按鈕樣式 */
    .btn {
        display: inline-block;
        padding: 6px 12px;
        background-color: #007bff;
        color: #fff;
        text-decoration: none;
        border-radius: 5px;
        transition: background-color 0.3s ease;
    }
    
    .btn:hover {
        background-color: #0056b3;
    }
    
    /* 總計樣式 */
    .total {
        font-weight: bold;
        font-size: 18px;
        margin-top: 20px;
    }
    
    /* 空購物車樣式 */
    .empty-cart {
        text-align: center;
        color: #666;
    }
    
    /* 鏈接樣式 */
    a {
        color: #007bff;
        text-decoration: none;
    }
    
    /* 鏈接懸停樣式 */
    a:hover {
        text-decoration: underline;
    }

    .cart-item {
        display: flex;
        margin-bottom: 10px;
    }

    .image-container {
        margin-right: 10px;
    }

    .info-container {
        display: flex;
        flex-direction: column;
    }

    .book-info {
        margin-bottom: 5px;
    }

    .actions a {
        margin-right: 10px;
    }

    .empty-cart {
        font-size: 140px;
        text-align: center;
        color: green;
    }

    .navbar {
        background-color: #333;
        padding: 10px;
        display: flex;
        justify-content: space-between;
        align-items: center;
        color: #fff;
    }

    .logo {
        font-size: 24px;
        font-weight: bold;
    }

    .navbar-right {
        display: flex;
        gap: 10px;
    }

    .navbar-right a {
        color: #fff;
        text-decoration: none;
    }

    .navbar-right a:hover {
        text-decoration: underline;
    }
</style>
</head>
<div class="navbar">
    <div class='logo'>偉陽冰室</div>
    <div class='navbar-right'>
    <a href="index.php">Menu</a><br>
    <a href="login.php">Login</a>
    </div>
    </div>
<?php
session_start();

// Database connection
require_once 'db_connect.php'; // Ensure this path is correct

function getFoodPriceById($id, $conn) {
    $sql = "SELECT price FROM food WHERE foodid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['price'];
    } else {
        return false;
    }
}

function getFoodNameById($id, $conn) {
    $sql = "SELECT foodname FROM food WHERE foodid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return $row['foodname'];
    } else {
        return false;
    }
}


// Function to save order to database
function saveOrder($cart_data, $conn) {
    foreach ($cart_data as $item) {
        $sql = "INSERT INTO orders (food_id, qty) VALUES (?, ?)";
        $stmt = $conn->prepare($sql);
        $stmt->bind_param("si", $item["item_id"], $item["item_quantity"]);
        $stmt->execute();
    }
}

function getFoodImageById($id, $conn) {
    $sql = "SELECT foodimage FROM food WHERE foodid = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        return base64_encode($row['foodimage']);
    } else {
        return false;
    }
}


echo "<h1>Your Food Order</h1>";

// Initialize cart data
$cart_data = array();

// Check if shopping cart cookie is set
if (isset($_COOKIE["cart"])) {
    $cookie_data = stripslashes($_COOKIE['cart']);
    $cart_data = json_decode($cookie_data, true);
}

// Check if the form has been submitted to save the order
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST["save_order"])) {
    if (!empty($cart_data)) { // Ensure cart is not empty
        saveOrder($cart_data, $conn);
        // Clear the shopping cart cookie after saving the order
        setcookie("cart", "", time() - 3600);
        $cart_data = array();
        echo "<h1>Order saved successfully!</h1>";
    } else {
        echo "<h1>Your cart is empty, nothing to save!</h1>";
    }
}

// Check if cart is not empty before displaying it
if (!empty($cart_data)) {
    $total = 0;
    foreach ($cart_data as $keys => $values) {
        $food_image = getFoodImageById($values["item_id"], $conn);
        $food_price = getFoodPriceById($values["item_id"], $conn);
        $food_name = getFoodNameById($values["item_id"], $conn);
        if ($food_price !== false) {
            $subtotal = $values["item_quantity"] * $food_price;
            $total += $subtotal;
            echo "<div class='cart-item'>
            <div class='image-container'>
            <img src='data:image/jpeg;base64," . $food_image . "' alt='Book Image' width='100' height='100'>
            </div>
            <div class='info-container'>
                <div class='book-info'>
                    <span>Food Name: " . $food_name . "</span><br>
                    <span>Quantity: " . $values["item_quantity"] . "</span><br>
                    <span>Subtotal: $" . number_format($subtotal, 2) . "</span>
                </div>
                <div class='actions'>
                    <a href='update_cart.php?action=add&id=". $values["item_id"] ."'>Add more</a>
                    <a href='update_cart.php?action=remove&id=". $values["item_id"] ."'>Remove one</a>
                    <a href='update_cart.php?action=delete&id=". $values["item_id"] ."'>Delete</a>
                </div>
            </div>
        </div>";
        } else {
            echo "<div>Error: Could not find image for Food Name " . $values["item_id"] . "</div>";
        }
    }if (isset($_COOKIE['cart'])) {
        $cookie_data = stripslashes($_COOKIE['cart']);
        $cart_data = json_decode($cookie_data, true);
        
        $totalQuantity = 0;
        
        // Calculate total quantity
        foreach ($cart_data as $item) {
            $totalQuantity += $item['item_quantity'];
        }
        
        echo "Total Quantity: " . $totalQuantity;
    } else {
        echo "No shopping cart cookie found.";
    };

    // Display total price
    
    echo "<br><div>Total: $" . number_format($total, 2) . "</div><br>";
    
    // Display the form button to save the order
    echo "<form method='post'>
            <input class='btn' type='submit' name='save_order' value='Save Order'>
          </form>";
} else {
    echo "<div class='empty-cart'>Your cart is empty!</div>";
}


// Close database connection if it's not persistent
$conn->close();

// Add links to manage cart
echo "<a href='index.php'>Continue Order</a>";
?>