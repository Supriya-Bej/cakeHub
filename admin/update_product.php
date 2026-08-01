<?php
include("../db_connect.php");
global $conn;
if (isset($_GET['update_id'])) {
    $id = $_GET['update_id'];
    $sql = "SELECT * FROM products where id = '$id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    $old_image = $data['image'];

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateProduct'])) {
        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];
        $uploads = "../products_image/" . $image;

        $name = $_POST['name'];
        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $rating = $_POST['rating'];
        $category_id = $_POST['category_id'];

        if ($image) {
            if (!empty($old_image)) {
                unlink("../products_image/" . $old_image);
            }
            move_uploaded_file($tempname, $uploads);
            $update = "UPDATE `products` SET `name`='$name',`description`='$desc',`price`='$price',
                `stock`='$stock',`rating`='$rating',`image`='$image',`category_id`='$category_id' WHERE id = '$id'";
        } else {

            $update = "UPDATE `products` SET `name`='$name',`description`='$desc',`price`='$price',
                `stock`='$stock',`rating`='$rating',`category_id`='$category_id' WHERE id = '$id'";
        }
        $run = mysqli_query($conn, $update);

        if ($run) {
            echo "<script>
                alert('Product update success');
                window.location.href='products.php';
                </script>";
            exit();
        } else {
            echo "Update unsuccessful";
        }
    }
    exit();
}
