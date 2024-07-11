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

$id = $_GET['id'];
if (isset($_GET['id'])){
    $id = $_GET['id'];
}

$conn = mysqli_connect('localhost', 'root', '', 'restaurant') or die(mysqli_error());
$sql = "SELECT * FROM users WHERE userid=$id";
$result = mysqli_query($conn, $sql);

if ($result==true){
    $count = mysqli_num_rows($result);
    if ($count == 1){
        $row = mysqli_fetch_assoc($result);
        $username = $row['username'];
    } else {
        header("Location: admin.php");
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
            <h1>Update User</h1>

            <form action="" method="POST" enctype="multipart/form-data">
                <table class="tab-30">
                    <tr>
                        <td>User Name: </td>
                        <td><input type="text" name="username" placeholder="Reset User Name"></td>
                    </tr>
                    <tr>
                        <td>Password: </td>
                        <td><input type="password" name="newpassword" placeholder="Reset Password"></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <input type="submit" name="submit" value=" UPDATE " class="btn-add">
                        </td>
                    </tr>
                </table>
            </form>
        </div>
    </div>

    <?php
    if(isset($_POST['submit'])){
        $id = $_POST['id'];
        $username = $_POST['username'];
        $password = hash('sha256', $_POST['newpassword']);

        $sql = "SELECT * FROM users WHERE userid=$id";
        $result = mysqli_query($conn, $sql);

        if($result){
            $count = mysqli_num_rows($result);
            if($count == 1){
                if($password){
                    $sql2 = "UPDATE users SET username='$username', password='$password' WHERE userid=$id";
                    
                    $res2 = mysqli_query($conn, $sql2);
                    if($res2 == true){
                        $_SESSION['update'] = "User Updated Successfully";
                        header("Location: admin.php");
                    }
                }
            }
        }  
    }
    ?>
</body>