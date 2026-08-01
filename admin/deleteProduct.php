<?php
include_once("function.php");

if ($_SERVER['REQUEST_METHOD'] === "GET" && $_GET['badge'] == 'product') {
    $id = $_GET['product_id'];
    $call = delete_data('products', $id);
    if ($call) {
        echo "<script>
            alert('Product delete success');
            window.location.href='products.php';
            </script>";
    } else {
        echo "<script>
            alert('Product delete Unsuccess');
            window.location.href='products.php';
            </script>";
    }
}

if ($_SERVER['REQUEST_METHOD'] === "GET" && $_GET['badge'] == 'order') {
    $id = $_GET['order_id'];
    $call = delete_data('orders', $id);
    if ($call) {
        echo "<script>
            alert('Order delete success');
            window.location.href='order.php';
            </script>";
    } else {
        echo "<script>
            alert('Order delete Unsuccess');
            window.location.href='order.php';
            </script>";
    }
}
