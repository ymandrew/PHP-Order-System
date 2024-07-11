<head>
    <style>
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

    table tr th {
        border-bottom: 1px solid black;
        padding: 1%;
        text-align: left;
    }

    table tr td {
        padding: 1%;
    }

    .tab-30 {
    width: 30%;
  }

    .row{
        padding: 1%;
        width: 80%;
        margin: 0 auto;
    }

    .container{
        margin: 1% 0;
    }

  .tab {
    width: 100%;
  }

  .btn-pri{
    background-color: #4caf50;
    padding: 1%;
    color: white;
    text-decoration: none;
  }

  .btn-sec{
    background-color: blue;
    padding: 1%;
    color: white;
    text-decoration: none;
  }

  .btn-def{
    background-color: red;
    padding: 1%;
    color: white;
    text-decoration: none;
  }

  .btn-add {
    background-color: #1271E6;
    padding: 1%;
    color: white;
    text-decoration: none;
    border-radius: 5px;
    cursor: pointer;
    margin-top: 1%;
    margin-bottom: 1%;
    display: inline-block;
    text-align: center;
    font-size: 16px;
    font-weight: bold;
  }

    </style>
</head>

<?php

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {

    $foodid = $_POST['foodid'];
    $foodname = $_POST['foodname'];
    $price = $_POST['price'];
    $foodimage = $_FILES['foodimage']['name'];

    $sql = "INSERT INTO food (foodid, foodname, price, foodimage) VALUES ('$foodid', '$foodname', '$price', '$foodimage')";
    if ($conn->query($sql) === TRUE) {
        echo "<script>alert('New food added successfully!');</script>";
        header('Location: menu.php');
    } else {
        echo "<script>alert('Error: " . $conn->error . "');</script>";
    }
}

$conn->close();
?>

<body>
    <div class="navbar">
    <div class='logo'>偉陽冰室</div>
    <div class='navbar-right'>
    <a href="admin.php">Admin</a><br>
    <a href="menu.php">Menu</a><br>
    <a href="index.php">Log Out</a>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <h1>Add New Food</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tab-30">

                <tr>
                    <td>Food ID: </td>
                    <td><input type="text" name="foodid" placeholder="Enter Food ID"></td>
                </tr>
                <tr>
                    <td>Food Name: </td>
                    <td><input type="text" name="foodname" placeholder="Enter Food Name"></td>
                </tr>
                <tr>
                    <td>Price: </td>
                    <td><input type="number" name="price" placeholder="Enter Price"></td>
                </tr>
                <tr>
                    <td>Picture: </td>
                    <td><input type="file" name="foodimage" ></td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value=" ADD " class="btn-add"></td>
                </tr>
                </table>
            </form>
        </div>
    </div>
</body>
