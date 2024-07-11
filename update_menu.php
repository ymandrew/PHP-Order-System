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
    width: 20%;
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

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$foodid = $foodname = $price = "";
$message = "";
if ($_SERVER['REQUEST_METHOD'] == "POST") {
    if (isset($_POST['foodid'])) {
        // Retrieve the submitted values
        $foodid = $_POST['foodid'];
        $foodname = $_POST['foodname'];
        $price = $_POST['price'];

        // Update the database
        $sql = "UPDATE food SET foodname='$foodname', price='$price' WHERE foodid='$foodid'";
        if ($conn->query($sql) === TRUE) {
            $message = "Food information updated successfully";
        } else {
            $message = "Error updating food information: " . $conn->error;
        }

        $conn->close();
    } else {
        $message = "Please enter a valid Food ID";
    }
}
?>

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
            <h1>Update</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tab-30">
                    <tr>
                        <td>Food ID: </td>
                        <td><input type="text" name="foodid" placeholder="Enter Food ID" value="<?php echo $foodid; ?>"></td>
                    </tr>
                    <tr>
                        <td>Food Name: </td>
                        <td><input type="text" name="foodname" placeholder="Enter Food Name" value="<?php echo $foodname; ?>"></td>
                    </tr>
                    <tr>
                        <td>Price: </td>
                        <td><input type="number" name="price" placeholder="Enter Price" value="<?php echo $price; ?>"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td><input type="submit" name="submit" value="Update" class="btn-add"></td>
                    </tr>
                </table>
            </form>

            <?php
            if (!empty($message)) {
                echo "<p>$message</p>";
            }
            ?>
        </div>
    </div>
</body>