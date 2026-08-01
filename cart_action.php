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
    $check = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$productId'";
    $runCheck = mysqli_query($conn, $check);
    if ($_SERVER['REQUEST_METHOD'] === "GET" && $_GET['badge'] && $_GET['badge'] == "cart") {

        if (mysqli_num_rows($runCheck) > 0) {
            $delete = "DELETE FROM `cart` WHERE user_id = '$user_id' AND product_id='$productId'";
            $run = mysqli_query($conn, $delete);

            if ($run) {
                echo "remove";
            } else {
                "Error:" . mysqli_error($conn);
            }
        } else {
            $insert = "INSERT INTO `cart`(`user_id`, `product_id`) VALUES ('$user_id','$productId')";
            $result = mysqli_query($conn, $insert);
            if ($result) {
                echo "add";
            } else {
                "Error:" . mysqli_error($conn);
            }
        }
    }
}
