<?php
include("../db_connect.php");
global $conn;
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['add_banner'])) {
    $title = $_POST['title'];
    $status = $_POST['status'];

    $banner_image = $_FILES['banner_image']['name'];
    $temp_name = $_FILES['banner_image']['tmp_name'];
    $upload = "../banner_image/" . $banner_image;

    $insert = "INSERT INTO `banner`(`title`, `banner_image`, `status`) 
        VALUES ('$title','$banner_image','$status')";
    $run = mysqli_query($conn, $insert);

    if ($run) {
        echo "Banner added successfully";
        move_uploaded_file($temp_name, $upload);
    }
    else{
        die("Error").mysqli_error($conn);
    }
}
?>