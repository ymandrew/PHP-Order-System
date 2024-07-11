<?php

session_start();
require_once 'db_connect.php';

$id = $_GET['id'];
$conn = mysqli_connect('localhost', 'root', '', 'restaurant') or die(mysqli_error());

$sql = "DELETE FROM users WHERE userid = $id";
$result = mysqli_query($conn, $sql);

if($result){
    echo "<script>alert('User Deleted Successfully')</script>";
    header('location:admin.php');
}else{
    echo "<script>alert('User Not Deleted Successfully')</script>";
    header('location:admin.php');
}


?>  