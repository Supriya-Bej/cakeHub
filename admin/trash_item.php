<?php
include("../db_connect.php");
global $conn;

/* PAGINATION */
$limit = 5;
$page = isset($_GET['page']) ? $_GET['page'] : 1;
$offset = ($page - 1) * $limit;
$sql = "SELECT * FROM trash ORDER BY trash_id DESC LIMIT $offset,$limit";
$result = mysqli_query($conn, $sql);

/* TOTAL RECORDS */
$totalQuery = "SELECT COUNT(*) AS total FROM trash";
$totalResult = mysqli_query($conn, $totalQuery);
$totalData = mysqli_fetch_assoc($totalResult);
$totalRecords = $totalData['total'];
$totalPages = ceil($totalRecords / $limit);

/* RESTORE PRODUCT */
if (isset($_GET['trash_id'])) {
    $trash_id = $_GET['trash_id'];
    $restore = "SELECT * FROM trash WHERE trash_id='$trash_id'";
    $run = mysqli_query($conn, $restore);

    if (mysqli_num_rows($run) > 0) {
        $data = mysqli_fetch_assoc($run);

        $product_id = $data['product_id'];
        $pro_img = $data['product_image'];
        $pro_name = $data['product_name'];
        $pro_description = $data['product_description'];
        $pro_price = $data['product_price'];
        $pro_stock = $data['product_stock'];
        $cat_id = $data['category_id'];
        $cat_name = $data['category_name'];
        $rating = $data['rating'];


        /*  INSERT INTO PRODUCTS    */
        $insert = "INSERT INTO products(id,name, description, price,stock,image,category_id,category_name,rating)
        VALUES('$product_id','$pro_name','$pro_description','$pro_price','$pro_stock','$pro_img','$cat_id','$cat_name',
            '$rating')";
        $res = mysqli_query($conn, $insert);

        if ($res) {
            /* MOVE IMAGE BACK */
            $new_path = "../products_image/" . $pro_img;
            $old_path = "../delete_img/" . $pro_img;

            if (file_exists($old_path)) {

                if (rename($old_path, $new_path)) {
                    echo "Image Restored";
                } else {
                    echo "Image Move Failed";
                }
            } else {
                echo "Image Not Found";
            }
            /* DELETE FROM TRASH */
            $delete = "DELETE FROM trash WHERE trash_id='$trash_id'";
            mysqli_query($conn, $delete);
            header("Location:products.php");
            exit();
        }
    }
}

/* PERMANENT DELETE */
if (isset($_GET['delete_id'])) {
    $delete_id = $_GET['delete_id'];

    /* GET IMAGE */
    $select_delete = "SELECT * FROM trash WHERE trash_id='$delete_id'";
    $run_delete = mysqli_query($conn, $select_delete);

    if (mysqli_num_rows($run_delete) > 0) {
        $delete_data = mysqli_fetch_assoc($run_delete);
        $image = $delete_data['product_image'];
        $img_path = "../delete_img/" . $image;

        if (file_exists($img_path) && is_file($img_path)) {
            unlink($img_path);
        }

        $delete_query = "DELETE FROM trash WHERE trash_id='$delete_id'";
        $delete_run = mysqli_query($conn, $delete_query);
        if ($delete_run) {
            header("Location:trash_item.php?msg=deleted");
            exit();
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>Trash Items</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #fff8fa, #ffeef3);
            font-family: 'Poppins', sans-serif;
        }

        .main-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(255, 105, 180, .15);
        }

        .card-header {
            background: linear-gradient(135deg, #ff6b9a, #ff9eb5) !important;
            border: none;
        }

        .card-header h3 {
            font-weight: 700;
            letter-spacing: .5px;
        }

        .back-btn {
            background: #fff;
            color: #ff6b9a;
            border: none;
            font-weight: 600;
            border-radius: 12px;
        }

        .back-btn:hover {
            background: #fff0f5;
            color: #ff4f87;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead th {
            background: #fff0f5;
            color: #ff4f87;
            border: none;
            font-weight: 700;
            white-space: nowrap;
        }

        .table tbody tr {
            transition: .3s;
        }

        .table tbody tr:hover {
            background: #fff8fa;
        }

        .product-img {
            width: 80px;
            height: 70px;
            object-fit: cover;
            border-radius: 15px;
            border: 3px solid #ffd6e3;
        }

        .product-name {
            font-weight: 600;
            color: #444;
        }

        .price {
            font-weight: 700;
            color: #ff4f87;
        }

        .stock-badge {
            background: #d4edda;
            color: #198754;
            border-radius: 20px;
            padding: 6px 12px;
        }

        .rating-badge {
            background: #fff3cd;
            color: #856404;
            border-radius: 20px;
            padding: 6px 12px;
        }

        .category-badge {
            background: #ffe5ee;
            color: #ff4f87;
            border-radius: 20px;
            padding: 6px 12px;
        }

        .restore-btn {
            background: #28a745;
            border: none;
            border-radius: 20px;
            padding: 7px 14px;
        }

        .delete-btn {
            background: #ff6b9a;
            border: none;
            border-radius: 20px;
            padding: 7px 14px;
        }

        .delete-btn:hover {
            background: #ff4f87;
        }

        .pagination .page-link {
            border: none;
            margin: 0 4px;
            border-radius: 10px;
            color: #ff4f87;
            font-weight: 600;
        }

        .pagination .active .page-link {
            background: #ff6b9a;
            border-color: #ff6b9a;
        }

        .empty-state {
            padding: 50px;
            text-align: center;
        }

        .empty-state i {
            font-size: 70px;
            color: #ffc0cb;
        }

        .empty-state h4 {
            color: #ff4f87;
            margin-top: 15px;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="card shadow border-0">

            <div class="card-header text-white py-3">
                <div class="d-flex justify-content-between align-items-center">

                    <h3 class="mb-0">
                        🎂 Trash Products
                    </h3>

                    <a href="dashboard.php" class="btn back-btn">
                        <i class="fa fa-arrow-left"></i> Back
                    </a>

                </div>
            </div>

            <div class="card-body">

                <!-- SUCCESS MESSAGE -->

                <?php if (isset($_GET['msg'])) { ?>

                    <?php if ($_GET['msg'] == 'restored') { ?>

                        <div class="alert alert-success">

                            Product Restored Successfully

                        </div>

                    <?php } ?>

                    <?php if ($_GET['msg'] == 'deleted') { ?>

                        <div class="alert alert-danger">
                            Product Deleted Permanently
                        </div>

                    <?php } ?>

                <?php } ?>

                <!-- TABLE -->

                <div class="table-responsive">

                    <table class="table table-bordered table-hover align-middle text-center">

                        <thead>

                            <tr>

                                <th>ID</th>

                                <th>Image</th>

                                <th>Product Name</th>

                                <th>Description</th>

                                <th>Price</th>

                                <th>Stock</th>

                                <th>Rating</th>

                                <th>Category</th>

                                <th>Created</th>

                                <th width="220">Action</th>

                            </tr>

                        </thead>

                        <tbody>

                            <?php
                            if (mysqli_num_rows($result) > 0) {

                                while ($row = mysqli_fetch_assoc($result)) {
                            ?>

                                    <tr>

                                        <td>
                                            <?= $row['product_id']; ?>
                                        </td>

                                        <td>
                                            <img src="../delete_img/<?= $row['product_image']; ?>"
                                                class="product-img">
                                        </td>

                                        <td class="product-name">
                                            <?= $row['product_name']; ?>
                                        </td>

                                        <td>
                                            <?= $row['product_description']; ?>
                                        </td>

                                        <td>
                                            <span class="price">
                                                ₹<?= $row['product_price']; ?>
                                            </span>
                                        </td>
                                        <td>
                                            <span class="stock-badge">
                                                <?= $row['product_stock']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="rating-badge">
                                                ⭐ <?= $row['rating']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <span class="category-badge">
                                                <?= $row['category_name']; ?>
                                            </span>
                                        </td>

                                        <td>
                                            <?= $row['created_at']; ?>
                                        </td>

                                        <td>
                                            <div class="d-flex justify-content-center gap-2">

                                                <a href="trash_item.php?trash_id=<?= $row['trash_id']; ?>"
                                                    class="btn restore-btn text-white">
                                                    <i class="fa-solid fa-rotate-left"></i>
                                                    Restore
                                                </a>

                                                <a href="trash_item.php?delete_id=<?= $row['trash_id']; ?>"
                                                    class="btn delete-btn text-white"
                                                    onclick="return confirm('Permanent delete?')">
                                                    <i class="fa-solid fa-trash"></i>
                                                    Delete
                                                </a>

                                            </div>
                                        </td>

                                    </tr>

                                <?php
                                }
                            } else { ?>

                                <tr>
                                    <td colspan="10">
                                        <div class="empty-state">
                                            <i class="fa-solid fa-cake-candles"></i>
                                            <h4>No Deleted Cakes Found</h4>
                                            <p class="text-muted">
                                                Your trash bin is currently empty.
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                            <?php }
                            ?>
                        </tbody>

                    </table>

                </div>

                <!-- PAGINATION -->

                <nav class="mt-4">

                    <ul class="pagination justify-content-center">

                        <?php for ($i = 1; $i <= $totalPages; $i++) { ?>

                            <li class="page-item <?= ($page == $i) ? 'active' : ''; ?>">

                                <a class="page-link"
                                    href="trash_item.php?page=<?= $i; ?>">

                                    <?= $i; ?>

                                </a>

                            </li>

                        <?php } ?>

                    </ul>

                </nav>

            </div>

        </div>

    </div>

</body>

</html>