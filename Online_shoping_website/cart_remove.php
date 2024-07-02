<?php
require 'db_connection.php';
session_start();

if (isset($_GET['id']) && isset($_SESSION['id'])) {
    $item_id = intval($_GET['id']);
    $user_id = $_SESSION['id'];
    
    $delete_query = "DELETE FROM user_products WHERE user_id = $user_id AND products_id = $item_id";
    
    if ($conn->query($delete_query) === TRUE) {
        echo 'Item removed successfully';
    } else {
        echo 'Error removing item: ' . $conn->error;
    }
} else {
    echo 'Invalid request';
}

?>
