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
  img {
    max-width: 80px;
    max-height: 80px;
  }

  .delete-button {
        display: inline-block;
        padding: 5px 10px;
        background-color: #f44336;
        color: white;
        border: none;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        margin-left: 5px;
        cursor: pointer;
    }

    .update-button{
        display: inline-block;
        padding: 5px 10px;
        background-color: #1270E5;
        color: white;
        border: none;
        text-align: center;
        text-decoration: none;
        font-size: 14px;
        margin-left: 5px;
        cursor: pointer;
    }

    </style>    
    <script>
        function confirmDelete(foodname) {
            if (confirm('您確定要刪除食物: ' + foodname + ' 的紀錄嗎？')) {
                window.location.href = 'delete.php?foodid=' + foodname;
            }
        }
    </script>
</head>
<?php

session_start();
require_once 'db_connect.php';

// Check if user is logged in
if (!isset($_SESSION['loggedin'])) {
    header('Location: login.php');
    exit;
}

$sql = "SELECT * FROM food";
$result = mysqli_query($conn, $sql);

$conn->close();
?>
<body>
    <div class="navbar">
    <div class='logo'>偉陽冰室</div>
    <div class='navbar-right'>
    <a href="menu.php">Menu</a><br>
    <a href="index.php">Log Out</a>
    </div>
    </div>
    <div class="container">
        <div class="row">
            <h1>Menu</h1>
            <br />
            <a href="add_food.php" class="btn-pri">Add New Food</a>
            <br /><br />
            <table class="tab">
            <tr>
              <th>Food Image</th>
              <th>Food ID</th>
              <th>Food name</th>
              <th>Price</th>
              <th></th>
            </tr>
            <?php if (mysqli_num_rows($result) > 0): ?>
                    <?php while ($row = mysqli_fetch_assoc($result)): ?>
                        <tr>
                            <td><?php echo "<img src='data:image/jpeg;base64," . base64_encode($row['foodimage']) . "' alt='" . $row["foodname"] . "'>"; ?></td>
                            <td><?php echo $row["foodid"]; ?></td>
                            <td><?php echo $row["foodname"]; ?></td>
                            <td><?php echo $row["price"]; ?></td>
                            <td>
                                <form action="update_menu.php" method="post">
                                    <input type="submit" class="update-button"  value="更新">
                                    <a href="delete_food.php?foodid=<?php echo $row['foodid']; ?>" class="delete-button" onclick="confirmDelete('<?php echo $row['foodname']; ?>')">刪除</a>
                                </form>
                                
                            </td>
                        </tr>
                    <?php endwhile; ?>
                <?php endif; ?>
            </table>
        </div>
    </div>
</body>

