<head>
    <style>
    .row {
        display: grid;
        grid-template-columns: repeat(auto-fit, 18%);
        grid-gap: 15px;
    }

    .product {
        width: 290px;
        height: 320px;
        border: 1px solid #ccc;
        padding: 10px;
        text-align: center;
    }

    .product h3, .product p {
        margin: 5px 0;
    }

    .product a {
        display: block;
        margin-top: 10px;
        padding: 8px;
        background-color: #4caf50;
        color: #fff;
        text-decoration: none;
        border: none;
        cursor: pointer;
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

    img {
        width: 240px;
        height: 180px;
    }

    .foodlist {
        text-align: center;
        font-size: 40px;
        color: #333;
    }
    </style>
</head>

<?php

session_start();
require_once 'db_connect.php';

// Fetch books from database
$sql = "SELECT * FROM food";
$result = $conn->query($sql);

echo "<nav class='navbar'>";
echo "<div class='logo'>偉陽冰室</div>";
echo "<div class='navbar-right'>";
echo "<a href='cart.php'>Cart</a>";
echo "<a href='login.php'>Login</a>";
echo "</div>";
echo "</nav>";
echo "<h2 class='foodlist'>Food List</h2>";
if ($result->num_rows > 0) {
    // output data of each row
    echo "<div class='row'>";
    while($row = $result->fetch_assoc()) {
        echo "<div class='product'>";
        echo "<img src='data:image/jpeg;base64," . base64_encode($row['foodimage']) . "' alt='" . $row["foodname"] . "'>";
        echo "<h3>" . $row["foodname"] . "</h3>";
        echo "<p>Price: $" . $row["price"] . "</p><br>";
        echo "<a href='add_to_cart.php?foodid=" . $row["foodid"] . "'>Add to Cart</a>";
        echo "</div>";
    }
    echo "</div>";
    echo "<br>";
} else {
    echo "0 results";
}

$conn->close();
?>