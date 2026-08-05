<?php
include_once("function.php");
include("back_colour.php");
?>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php

// ================= DELETE PRODUCT =================

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['badge']) && $_GET['badge'] == 'product') {

    $id = $_GET['product_id'];
    $call = delete_data('products', $id);

    if ($call) {

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Product deleted successfully.',
            confirmButtonColor: '#ff6b81',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href='products.php';
        });
        </script>";
    } else {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Delete Failed!',
            text: 'Unable to delete product.',
            confirmButtonColor: '#dc3545',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href='products.php';
        });
        </script>";
    }

    exit();
}


// ================= DELETE ORDER =================

if ($_SERVER['REQUEST_METHOD'] === "GET" && isset($_GET['badge']) && $_GET['badge'] == 'order') {

    $id = $_GET['order_id'];
    $call = delete_data('orders', $id);

    if ($call) {

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Deleted!',
            text: 'Order deleted successfully.',
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
            title: 'Delete Failed!',
            text: 'Unable to delete order.',
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