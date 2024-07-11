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
            <h1>User</h1>
            <br>

            
            <a href="add_admin.php" class="btn-pri">Add User</a>
            <br />
            <br>
            <?php
            if(isset($_SESSION['add'])) {
                echo $_SESSION['add'];
                unset($_SESSION['add']);
            }if (isset($_SESSION['delete'])) {
                echo $_SESSION['delete'];
                unset($_SESSION['delete']);
            }
            if (isset($_SESSION['update'])) {
                echo $_SESSION['update'];
                unset($_SESSION['update']);
            }
            if (isset($_SESSION['pwd-not-match'])) {
                echo $_SESSION['pwd-not-match'];
                unset($_SESSION['pwd-not-match']);
            }
            ?>
            <br />
            <table class="tab">
                <tr>
                    <th>ID</th>
                    <th>Username</th>
                    <th>Edit</th>
                </tr>

                <?php
                $sql = "SELECT * FROM users";
                $result = mysqli_query($conn, $sql);
                if($result==TRUE) {
                    $row = mysqli_num_rows($result);
                    $sn=1;
                    if($row>0) {
                         while($row=mysqli_fetch_assoc($result)) {
                            $id = $row['userid'];
                            $username = $row['username'];
                            echo "<tr>";
                            echo "<td>$sn</td>";
                            echo "<td>$username</td>";
                            echo "<td><a href='edit_user.php?id=$id' class='btn-sec'>Edit</a> <a href='delete_admin.php?id=$id' class='btn-def'>Delete</a></td>";
                            echo "</tr>";
                            $sn++;
                        }
                    }
                }
                ?>
            </table>
        </div>
    </div>
</body>
