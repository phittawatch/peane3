<?php
session_start();
include 'connect.php';

// Assuming your form sends POST data with the name 'user_id_input'
$user_id_input = $_POST['user_id_input'];

// SQL query to check if the user ID exists in the database
$sql = "SELECT * FROM users_id WHERE user_id_database = '$user_id_input'";
$result = $conn->query($sql);

if ($result->rowCount() > 0) {
    // User ID exists, set the session variable and redirect to index.php
    $_SESSION['user_id_input'] = $user_id_input;
    header("Location: index.php");
    exit();
} 
else {
    header("Location: login.html");
    unset($_SESSION['user_id_input']);
    session_destroy();
    exit();
}
?>
