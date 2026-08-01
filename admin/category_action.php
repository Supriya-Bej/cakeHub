<?php
include("../db_connect.php");
include("function.php");
global $conn;
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addCategory'])) {
    $category_name = $_POST['name'];
    $status = $_POST['status'];

    $insert = "INSERT INTO `categories`(`name`, `status`) VALUES ('$category_name','$status')";
    $run = mysqli_query($conn, $insert);

    if ($run) {
        echo "<script>
            alert('Category added succesfully');
            window.location.href='add_category.php';
        </script>";
    }
}


// Delete
if (isset($_GET['delete_id'])) {
    $category_id = $_GET['delete_id'];
    $call = delete_data('categories', $category_id);
    if ($call) {
        echo "<script>
            alert('Category delete success');
            window.location.href='add_category.php';
            </script>";
    } else {
        echo "<script>
            alert('Category delete Unsuccess');
            window.location.href='add_category.php';
            </script>";
    }
}
