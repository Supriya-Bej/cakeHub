<?php
include("../db_connect.php");
global $conn;
session_start();

if (isset($_SESSION['admmin_id'])) {
    // Fetch all category before submited
    $sql = "SELECT products.*, categories.name AS category_name 
        FROM products LEFT JOIN categories ON products.category_id = categories.id";
    $result = mysqli_query($conn, $sql);

    // Total Products
    $totalProducts = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM products")
    )['total'];

    // In Stock Products
    $inStock = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM products WHERE stock > 0")
    )['total'];

    // Out of Stock Products
    $outStock = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM products WHERE stock <= 0")
    )['total'];

    // Total Categories
    $totalCategories = mysqli_fetch_assoc(
        mysqli_query($conn, "SELECT COUNT(*) AS total FROM categories")
    )['total'];

    if (!$result) {
        echo "Error:" . mysqli_error($conn);
    }
} else {
    header("Location:login.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Products - Bakery Admin</title>

    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: linear-gradient(135deg, #fff0f5, #ffe4ec);
            font-family: 'Segoe UI', sans-serif;
        }

        /* Main Card */
        .main-card {
            background: rgba(255, 255, 255, 0.8);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        /* Total Products */
        .stats-card {
            border-radius: 18px;
            padding: 20px;
            color: white;
            transition: .3s;
            box-shadow: 0 10px 20px rgba(0, 0, 0, .1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
        }

        .bg-products {
            background: linear-gradient(135deg, #a64703, #f8c7d6);
        }

        .bg-stock {
            background: linear-gradient(135deg, #167239, #87c5bf);
        }

        .bg-out {
            background: linear-gradient(135deg, #870425, #f8afa3);
        }

        .bg-category {
            background: linear-gradient(135deg, #533a6e, #bed2f5);
        }

        .stats-number {
            font-size: 30px;
            font-weight: 700;
        }

        .stats-title {
            font-size: 15px;
            opacity: .9;
        }

        /* Header */
        .page-title {
            font-weight: 700;
            color: #ff4f81;
        }

        /* Search */
        .search-box {
            border-radius: 30px;
            padding-left: 15px;
        }

        /* Buttons */
        .btn-main {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            /* color: white; */
            border-radius: 10px;
        }

        .btn-main:hover {
            opacity: 0.9;
        }

        /* Table */
        .table thead {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            /* color: white; */
        }

        .table tbody tr {
            transition: 0.3s;
        }

        .table tbody tr:hover {
            background: #fff3f7;
        }

        /* Product Image */
        .product-img {
            width: 45px;
            height: 45px;
            border-radius: 10px;
            object-fit: cover;
        }

        /* Badges */
        .badge-edit {
            background: #ffe1ea;
            color: #ff4f81;
            border-radius: 8px;
        }

        .badge-delete {
            background: #ff4f81;
            border-radius: 8px;
        }

        /* Action hover */
        .badge:hover {
            transform: scale(1.05);
            transition: 0.2s;
        }

        /* Action Buttons Container */
        .action-btn {
            width: 38px;
            height: 38px;
            display: flex;
            align-items: center;
            justify-content: center;
            border-radius: 10px;
            text-decoration: none;
            transition: 0.3s;
            font-size: 14px;
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include("sidebar.php") ?>

            <div class="col-lg-10 mt-4">

                <div class="main-card">

                    <!-- HEADER -->
                    <div class="d-flex justify-content-between align-items-center mb-4 flex-wrap gap-3">

                        <h3 class="page-title">Products</h3>

                    </div>
                    <div class="row mb-4">

                        <div class="col-md-3 mb-3">
                            <div class="stats-card bg-products">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-title">Total Products</div>
                                        <div class="stats-number">
                                            <?php echo $totalProducts; ?>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-cake-candles fa-2x"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="stats-card bg-stock">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-title">In Stock</div>
                                        <div class="stats-number">
                                            <?php echo $inStock; ?>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-check-circle fa-2x"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="stats-card bg-out">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-title">Out Of Stock</div>
                                        <div class="stats-number">
                                            <?php echo $outStock; ?>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-triangle-exclamation fa-2x"></i>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-3 mb-3">
                            <div class="stats-card bg-category">
                                <div class="d-flex justify-content-between align-items-center">
                                    <div>
                                        <div class="stats-title">Categories</div>
                                        <div class="stats-number">
                                            <?php echo $totalCategories; ?>
                                        </div>
                                    </div>
                                    <i class="fa-solid fa-layer-group fa-2x"></i>
                                </div>
                            </div>
                        </div>

                    </div>

                    <!-- ACTION BUTTONS -->
                    <div class="d-flex justify-content-end gap-3 mb-3 flex-wrap">

                        <a href="add_category.php" class="btn btn-main text-light">
                            ➕ Add Category
                        </a>

                        <a href="add.php" class="btn btn-main text-light">
                            ➕ Add Product
                        </a>

                    </div>

                    <!-- TABLE -->
                    <div class="table-responsive">
                        <table class="table align-middle text-center" id="myTable">

                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Name</th>
                                    <th>Description</th>
                                    <th>Price</th>
                                    <th>Stock</th>
                                    <th>Category</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php $row = mysqli_fetch_all($result, MYSQLI_ASSOC);
                                if (!empty($row)) {
                                    foreach ($row as $key => $value) {
                                ?>
                                        <tr>
                                            <td>
                                                <img src="../products_image/<?php echo $value['image']; ?>" class="product-img">
                                            </td>

                                            <td class="fw-semibold"><?php echo $value['name']; ?></td>

                                            <td class="text-wrap" style="max-width:200px;">
                                                <?php echo $value['description']; ?>
                                            </td>

                                            <td>₹<?php echo $value['price']; ?></td>

                                            <td>
                                                <?php if ($value['stock'] > 0) { ?>
                                                    <span class="badge bg-success p-2">In Stock</span>
                                                <?php } else { ?>
                                                    <span class="badge bg-danger p-2">Out of Stock</span>
                                                <?php } ?>
                                            </td>

                                            <td><?php echo $value['category_name']; ?></td>

                                            <td>
                                                <div class="d-flex justify-content-center gap-2">

                                                    <!-- EDIT -->
                                                    <a href="editProduct.php?product_id=<?php echo $value['id']; ?>"
                                                        class="action-btn badge-edit "
                                                        title="Edit Product">
                                                        <i class="fa fa-pen"></i>
                                                    </a>

                                                    <!-- DELETE -->
                                                    <a href="deleteProduct.php?product_id=<?php echo $value['id']; ?>&badge=product"
                                                        class="action-btn badge-delete text-light"
                                                        title="Delete Product"
                                                        onclick="return confirm('Are you sure you want to delete?')">
                                                        <i class="fa fa-trash"></i>
                                                    </a>
                                                </div>
                                            </td>
                                        </tr>

                                <?php }
                                } ?>
                            </tbody>

                        </table>
                    </div>

                    <!-- Trash Button -->
                    <a href="trash_item.php" class="">
                        <button class="btn btn-dark rounded-pill px-4 fw-semibold mt-3">
                            <i class="fa fa-trash me-2"></i>
                            Trash
                        </button>

                    </a>
                </div>


            </div>
        </div>


    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-4.0.0.js"></script>

    <!-- DataTable -->
    <script src="//cdn.datatables.net/2.3.7/js/dataTables.min.js"></script>

    <script>
        let table = new DataTable('#myTable');
    </script>

</body>

</html>