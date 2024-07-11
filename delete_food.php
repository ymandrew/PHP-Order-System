<?php
    session_start();
    require_once 'db_connect.php';
    
    $id = $_GET['foodid'];
    $conn = mysqli_connect('localhost', 'root', '', 'restaurant') or die(mysqli_error());
    
    $sql = "DELETE FROM food WHERE foodid = $id";
    $result = mysqli_query($conn, $sql);
    
    if($result){
        echo "<script>alert('Food Deleted Successfully')</script>";
        header('location:admin.php');
    }else{
        echo "<script>alert('Food Not Deleted Successfully')</script>";
        header('location:admin.php');
    }
?>