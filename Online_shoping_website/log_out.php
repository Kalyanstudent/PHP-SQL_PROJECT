<?php
session_start();

if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['logout'])) {
    if ($_POST['logout'] === 'yes') {
        session_unset();
        session_destroy();
        echo 'success'; // Respond with 'success' to indicate the session was destroyed
    } else {
        echo 'fail'; // Optional: respond with 'fail' if needed
    }
} else {
    // If accessed directly, redirect to index.php
    header('Location: index.php');
    exit();
}
?>
