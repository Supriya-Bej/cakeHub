<?php
include_once("../db_connect.php");
global $conn;

// Select from all table
function allDetails($table_name)
{
    global $conn;
    $sql = "SELECT * FROM {$table_name} ORDER BY id DESC";
    $run = mysqli_query($conn, $sql);
    if ($run) {
        if (mysqli_num_rows($run)) {
            return mysqli_fetch_all($run, MYSQLI_ASSOC);
        } else {
            return false;
        }
    } else {
        return false;
    }
}

// Delet from all table
function delete_data($table_name, $id)
{
    global $conn;

    // Fetch original data
    $select = "SELECT * FROM {$table_name} WHERE id='$id'";
    $run = mysqli_query($conn, $select);

    if (!$run || mysqli_num_rows($run) == 0) {
        return false;
    }
    $data = mysqli_fetch_assoc($run);

    /* STORE PRODUCT DELETE DATA */
    if ($table_name == "products") {

        $product_id = $data['id'];
        $product_name = $data['name'];
        $product_description = $data['description'];
        $product_price = $data['price'];
        $product_stock = $data['stock'];
        $product_image = $data['image'];
        $category_id = $data['category_id'];

        // Get category name
        $cat_sql = "SELECT * FROM categories WHERE id='$category_id'";
        $cat_run = mysqli_query($conn, $cat_sql);
        $cat_data = mysqli_fetch_assoc($cat_run);
        $category_name = $cat_data['name'] ?? '';

        // Insert into trash
        $trash = "INSERT INTO trash(product_id,product_name,product_description, product_price, product_stock,
            product_image, category_id,category_name) VALUES ('$product_id','$product_name','$product_description',
            '$product_price','$product_stock','$product_image','$category_id','$category_name')";

        mysqli_query($conn, $trash);

        // MOVE PRODUCT IMAGE TO delete_img FOLDER
        if (!empty($product_image)) {
            $old_path = "../products_image/" . $product_image;
            $new_path = "../delete_img/" . $product_image;

            // check image exist
            if (file_exists($old_path) && is_file($old_path)) {
                // move image
                rename($old_path, $new_path);
            }
        }
    }

    /*
    =========================
    FINAL DELETE
    =========================
    */

    $delete = "DELETE FROM {$table_name} WHERE id='$id'";
    $delete_run = mysqli_query($conn, $delete);

    if ($delete_run) {
        return true;
    } else {
        return false;
    }
}

// Get Edit data
function get_single_details($table_name, $id)
{
    global $conn;

    // Fetch data
    if ($table_name == 'products') {
        $sql = "SELECT products.*, categories.name AS category_name FROM products 
                LEFT JOIN categories ON products.category_id = categories.id WHERE products.id = '$id'";
    } else if ($table_name == 'orders') {
        $sql = "SELECT orders.*, orderstatus.status, products.* FROM orders LEFT JOIN 
        orderstatus ON orders.status = orderstatus.status LEFT JOIN products ON orders.product_id = products.id
         WHERE orders.id = '$id'";
    } else {
        $sql = "SELECT * FROM {$table_name} where id='$id'";
    }
    $run = mysqli_query($conn, $sql);
    if ($run && mysqli_num_rows($run) > 0) {
        return mysqli_fetch_assoc($run);
    } else {
        return false;
    }
}
