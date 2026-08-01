<?php
include("../db_connect.php");
include("function.php");
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addMethod'])) {
    $method = $_POST['method'];

    $insert = "INSERT INTO `payment_type`(`method`) VALUES ('$method')";
    $run = mysqli_query($conn, $insert);

    if ($run) {
        echo "<script>
            alert('Method added succesfully');
            window.location.href='add_paymentMethod.php';
        </script>";
    }
}
