<?php
include("../db_connect.php");
include("function.php");
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addStatus'])) {
    $status_name = $_POST['status'];

    $insert = "INSERT INTO `orderstatus`(`status`) VALUES ('$status_name')";
    $run = mysqli_query($conn, $insert);

    if ($run) {
        echo "<script>
            alert('Status added succesfully');
            window.location.href='add_status.php';
        </script>";
    }
}
