<head>
    <title>登入</title>
    <style>
        body {
            font-family: Arial, sans-serif;
            background-color: #f2f2f2;
            padding: 20px;
        }

        h1 {
            text-align: center;
            color: #333;
            margin-bottom: 20px;
        }

        form {
            width: 300px;
            margin: 0 auto;
            background-color: #fff;
            padding: 20px;
            border: 1px solid #ccc;
            border-radius: 5px;
        }

        label {
            display: block;
            margin-bottom: 10px;
            color: #333;
        }

        input[type="text"],
        input[type="password"] {
            width: 100%;
            padding: 10px;
            border: 1px solid #ccc;
            border-radius: 3px;
        }

        input[type="submit"] {
            width: 100%;
            padding: 10px;
            background-color: #333;
            color: #fff;
            border: none;
            border-radius: 3px;
            cursor: pointer;
        }

        input[type="submit"]:hover {
            background-color: #555;
        }

        .error-message {
            color: red;
            margin-top: 10px;
        }
    </style>
</head>

<?php
// login.php
session_start();
require_once 'db_connect.php';

$error = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = hash('sha256', $_POST['password']);

    // Check username and password from database
    $sql = "SELECT userid FROM users WHERE username = '$username' AND password = '$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $row = $result->fetch_assoc();
        if ($row['userid'] == 1) {
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $username;
            header('Location: admin.php');
        } else {
            $_SESSION['loggedin'] = TRUE;
            $_SESSION['username'] = $username;
            header('Location: menu.php');
        }
        exit;
    } else {
        $error = "Incorrect username/password!";
    }
}

// Login form
echo "<h1>Login</h1>";
echo "<form method='post' action='login.php'>
        <h4>Username:</h4>
        <input type='text' name='username' required><br>
        <h4>Password:</h4> <input type='password' name='password' required><br><br>
        <span class='error-message'>$error</span><br><br>
        <input type='submit' value='Login'>
      </form>";
?>