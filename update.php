<?php
session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    $foodid = $_POST['foodid'];
    $foodname = $_POST['foodname'];
    $price = $_POST['price'];
    $foodimage = $_POST['foodimage'];

    $sql = "UPDATE student SET foodname = '$foodname', price = '$price', foodimage = '$foodimage' ";
    $sql .= "WHERE foodid = '$foodid'";

    if ($conn->query($sql) === TRUE) {
        header('Location: menu.php');
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }
}
$conn->close();

?>