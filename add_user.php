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

  .tab-30 {
    width: 30%;
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
<body>
    <div class="navbar">
    <div class='logo'>偉陽冰室</div>
    <div class='navbar-right'>
    <a href="admin.php">Admin</a><br>
    <a href="order.php">Order</a><br>
    <a href="menu.php">Menu</a><br>
    <a href="index.php">Log Out</a>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <h1>Add Admin</h1>

            <form action="" method="POST">
                <table class="tab-30">
                <tr>
                    <td>User Name: </td>
                    <td><input type="text" name="username" placeholder="Enter Your User Name"></td>
                </tr>
                <tr>
                    <td>Password: </td>
                    <td><input type="password" name="password" placeholder="Enter Your Password"></td>
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

<?php

session_start();
require_once 'db_connect.php';

if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

if(isset($_POST['submit'])){
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);
    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $conn = mysqli_connect('localhost', 'root', '', 'restaurant') or die(mysqli_error());
    $stmt = mysqli_prepare($conn, $sql);
    mysqli_stmt_bind_param($stmt, 'ss', $username, $password);
    $res = mysqli_stmt_execute($stmt);

    if($res) {
        $_SESSION['add'] = "Admin added successfully!";
        header('Location: admin.php');
    } else {
        $_SESSION['add'] = "Failed to add admin!";
        header('Location: add_admin.php');
    }
}
?>