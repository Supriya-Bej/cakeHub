<?php
include("../db_connect.php");
include("back_colour.php");
global $conn;
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateOrder'])) {

    $order_id = $_POST['order_id'];
    $status = $_POST['status'];

    $update = "UPDATE orders SET status='$status' WHERE id='$order_id'";
    $run = mysqli_query($conn, $update);

    if ($run) {

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Success!',
            text: 'Order status updated successfully.',
            confirmButtonColor: '#ff6b81',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href='order.php';
        });
        </script>";
    } else {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Update Failed!',
            text: 'Unable to update order status.',
            confirmButtonColor: '#dc3545',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href='order.php';
        });
        </script>";
    }

    exit();
}
?>