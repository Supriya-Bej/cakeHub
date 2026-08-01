<?php
session_start();
include("db_connect.php");
global $conn;


// include("header.php");
if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}
if ($_SERVER['REQUEST_METHOD'] === "GET") {
    $productId = $_GET['product_id'];
    $user_id = $_SESSION['user_id'];

    $check = "SELECT * FROM wishlist WHERE user_id = '$user_id' AND product_id = '$productId'";
    $runCheck = mysqli_query($conn, $check);
    
    if (mysqli_num_rows($runCheck) > 0) {
        $delete = "DELETE FROM `wishlist` WHERE user_id = '$user_id' AND product_id='$productId'";
        $delete_result = mysqli_query($conn, $delete);
        if ($delete_result) {
            echo "removed";
        } else {
            "Error:" . mysqli_error($conn);
        }
    } else {
        $insert = "INSERT INTO `wishlist`(`user_id`, `product_id`) VALUES ('$user_id','$productId')";
        $result = mysqli_query($conn, $insert);
        if ($result) {
            echo "added";
        } else {
            "Error:" . mysqli_error($conn);
        }
    }
}

// $select = "SELECT * FROM wishlist";
// $run = mysqli_query($conn, $select);
// $data = mysqli_fetch_assoc($run);
