<?php
    require 'db_connection.php';
    require 'header.php';
    session_start();
    $item_id=$_GET['id'];
    $user_id=$_SESSION['id'];
    $add_to_cart_query="INSERT INTO `user_products`(`user_id`, `products_id`, `status`) VALUES ('$user_id','$item_id','Added to cart')";
    $add_to_cart_result=mysqli_query($conn,$add_to_cart_query) or die(mysqli_error($con));
    header('location: products.php');
?>