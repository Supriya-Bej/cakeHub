<?php
include("../db_connect.php");
global $conn;
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateOrder'])) {
    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update = "UPDATE `orders` SET `status`='$status' WHERE id='$order_id'";
    $run = mysqli_query($conn, $update);
    if ($run) {
        echo "<script>
            alert('Update success');
            window.location.href = 'order.php';
            </script>";
    } else {
        echo "<script>
            alert('Update not success');
            window.location.href = 'order.php';
            </script>";
    }
}
