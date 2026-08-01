<?php
include("db_connect.php");
global $conn;

session_start();
$user_id = $_SESSION['user_id'];

$product_id = $_GET['product_id'];
$type = $_GET['type'];

// Product Stock
$sql = "SELECT * FROM products WHERE id='$product_id'";
$result = mysqli_query($conn, $sql);
$product = mysqli_fetch_assoc($result);
$product_stock = $product['stock'];

$selectCart = "SELECT * FROM cart WHERE user_id = '$user_id' AND product_id = '$product_id'";
$run = mysqli_query($conn, $selectCart);
$data = mysqli_fetch_assoc($run);
$cartQty = $data['quantity'];

if ($type == "plus") {
    $newQty = $cartQty + 1;
    $updateQty = "UPDATE `cart` SET `quantity`='$newQty' WHERE product_id = '$product_id' AND user_id = '$user_id'";
    $res = mysqli_query($conn, $updateQty);
} elseif ($type == "minus") {
    if ($cartQty > 1) {
        $newQty = $cartQty - 1;
        $updateQty = "UPDATE `cart` SET `quantity`='$newQty' WHERE product_id = '$product_id' AND user_id = '$user_id'";
        $res = mysqli_query($conn, $updateQty);
    }
}
