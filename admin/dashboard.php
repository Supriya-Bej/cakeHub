<?php
include("../db_connect.php");
global $conn;
include("function.php");
include("count_function.php");
session_start();

if (!isset($_SESSION['admmin_id'])) {
    header("Location:login.php");
}

$total_orders = countDetails('orders');
$total_products = countDetails('products');
$total_users = countDetails('users');
$total_revenue = count_revenue('orders');
$message_count = countDetails('contact');

$select = "SELECT * FROM `banner`";
$res = mysqli_query($conn, $select);
$banner_data = mysqli_fetch_all($res, MYSQLI_ASSOC);

if (isset($_GET['toggle_status'])) {

    $id = $_GET['toggle_status'];

    $check = "SELECT * FROM banner WHERE banner_id='$id'";
    $run_check = mysqli_query($conn, $check);
    $data = mysqli_fetch_assoc($run_check);

    if ($data['status'] == 1) {
        $status = 0;
    } else {
        $status = 1;
        $updateStatus = "UPDATE `banner` SET `status`='0' WHERE banner_id!='$id'";
        mysqli_query($conn, $updateStatus);
    }

    $update = "UPDATE banner SET status='$status' WHERE banner_id='$id'";
    mysqli_query($conn, $update);

    header("Location:dashboard.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background-color: #f6f7fb;
            font-family: 'Segoe UI', sans-serif;
        }

        /* Topbar */
        .topbar {
            background: linear-gradient(135deg, #f3b1c3, #f9778b);
            padding: 15px 20px;
            border-radius: 15px;
            color: white;
        }

        .cake-stat-card {
            position: relative;
            background: #fff;
            border-radius: 30px;
            padding: 35px 25px;
            text-align: center;
            overflow: hidden;
            box-shadow: 0 15px 35px rgba(0, 0, 0, .08);
            transition: .4s;
        }

        .cake-stat-card:hover {
            transform: translateY(-12px) rotate(-1deg);
        }

        .cream-top {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 35px;
            background: #ffe8ef;
            border-radius: 0 0 50px 50px;
        }

        .cake-icon {
            width: 80px;
            height: 80px;
            margin: auto;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 30px;
            color: #fff;
            margin-top: 20px;
            margin-bottom: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, .15);
        }

        .pink {
            background: linear-gradient(135deg, #ff6b9d, #ff9ec0);
        }

        .blue {
            background: linear-gradient(135deg, #4facfe, #00f2fe);
        }

        .green {
            background: linear-gradient(135deg, #43e97b, #38f9d7);
        }

        .orange {
            background: linear-gradient(135deg, #fa709a, #fee140);
        }

        .cake-stat-card h6 {
            color: #888;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .cake-stat-card h2 {
            font-size: 38px;
            font-weight: 800;
            color: #333;
        }

        .cake-wave {
            position: absolute;
            bottom: -20px;
            left: 0;
            width: 100%;
            height: 60px;
            background: #fff3f7;
            border-radius: 50% 50% 0 0;
        }

        /* Table */
        .table {
            border-radius: 10px;
            overflow: hidden;
        }

        .table thead {
            background: #d991a3;
            color: white;
        }

        .table tbody tr:hover {
            background-color: #f9f1f3;
        }

        .card-header {
            border-radius: 10px 10px 0 0 !important;
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

        /* Banner */

        .table thead tr {
            background-color: #f8d7df;
        }

        .table thead th {
            border: none;
            padding: 18px;
            color: #8b4d5d;
            font-size: 15px;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 18px;
            border-color: #f1f1f1;
        }

        .table tbody tr:hover {
            background-color: #fff7f9;
            transition: 0.3s;
        }

        .badge {
            font-size: 13px;
            font-weight: 500;
        }

        .btn-warning {
            background-color: #f4a261;
            border: none;
        }

        .btn-warning:hover {
            background-color: #e58b3d;
        }

        .btn-danger {
            border: none;
        }

        .card {
            border-radius: 25px;
        }
    </style>
</head>

<body>

    <?php include("sidebar.php") ?>

    <div class="col-lg-10 mt-3">

        <!-- Topbar -->
        <div class="topbar d-flex justify-content-between align-items-center mb-4">

            <div class="d-flex align-items-center gap-2">
                <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas" data-bs-target="#mobileMenu">
                    <i class="fa fa-bars"></i>
                </button>

                <h5 class="mb-0 fw-bold">Admin Dashboard</h5>
            </div>

            <div class="d-flex align-items-center gap-3">

                <!-- Search Box -->
                <!-- <div class="position-relative">
                    <input type="text" class="form-control search-box pe-5" placeholder="Search here...">

                    <i class="fa fa-search position-absolute top-50 end-0 translate-middle-y me-3 text-muted"></i>
                </div> -->

                <!-- Message Notification Box -->


                <div class="position-relative">

                    <a href="user_message.php">
                        <button class="btn btn-light rounded-circle shadow-sm"
                            style="width:45px;height:45px;">
                            <i class="fa-solid fa-envelope text-dark"></i>
                        </button>
                    </a>

                    <!-- Count Badge -->
                    <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger"
                        style="font-size:11px;">

                        <?= $message_count; ?>

                    </span>

                </div>

                <!-- Admin Profile -->
                <!-- <button class="btn btn-light rounded-circle shadow-sm"
                    style="width:45px;height:45px;">

                    <i class="fa fa-user text-dark"></i>

                </button> -->

            </div>

        </div>

        <div class="row g-4 mb-4">

            <!-- Orders -->
            <div class="col-lg-3 col-md-6">
                <div class="cake-stat-card">
                    <div class="cream-top"></div>

                    <div class="cake-icon pink">
                        <i class="fa-solid fa-cart-shopping"></i>
                    </div>

                    <h6>Total Orders</h6>
                    <h2><?= $total_orders ?></h2>

                    <div class="cake-wave"></div>
                </div>
            </div>

            <!-- Cakes -->
            <div class="col-lg-3 col-md-6">
                <div class="cake-stat-card">
                    <div class="cream-top"></div>

                    <div class="cake-icon blue">
                        <i class="fa-solid fa-cake-candles"></i>
                    </div>

                    <h6>Total Cakes</h6>
                    <h2><?= $total_products ?></h2>

                    <div class="cake-wave"></div>
                </div>
            </div>

            <!-- Users -->
            <div class="col-lg-3 col-md-6">
                <div class="cake-stat-card">
                    <div class="cream-top"></div>

                    <div class="cake-icon green">
                        <i class="fa-solid fa-users"></i>
                    </div>

                    <h6>Total Customers</h6>
                    <h2><?= $total_users ?></h2>

                    <div class="cake-wave"></div>
                </div>
            </div>

            <!-- Revenue -->
            <div class="col-lg-3 col-md-6">
                <div class="cake-stat-card">
                    <div class="cream-top"></div>

                    <div class="cake-icon orange">
                        <i class="fa-solid fa-indian-rupee-sign"></i>
                    </div>

                    <h6>Total Revenue</h6>
                    <h2>₹<?= number_format($total_revenue) ?></h2>

                    <div class="cake-wave"></div>
                </div>
            </div>

        </div>

        <!-- Banner Table Card -->
        <div class="card border-0 shadow-lg rounded-4 mt-4 overflow-hidden">

            <!-- Header -->
            <div class="card-header border-0 py-3 px-4"
                style="background: linear-gradient(135deg, #d991a3, #b76e79);">

                <div class="d-flex justify-content-between align-items-center">

                    <div>
                        <h4 class="text-white fw-bold mb-0">
                            <i class="fa fa-image me-2"></i> Banner Management
                        </h4>
                    </div>

                    <div class="d-flex gap-2">

                        <!-- Add Banner Button -->
                        <a href="add_banner.php">

                            <button class="btn btn-light rounded-pill px-4 fw-semibold">

                                <i class="fa fa-plus me-2 text-primary"></i>
                                Add Banner
                            </button>

                        </a>

                    </div>

                </div>

            </div>

            <!-- Table -->
            <div class="card-body p-4 bg-white">

                <div class="table-responsive">

                    <table class="table align-middle table-hover text-center">

                        <thead>

                            <tr>
                                <th>ID</th>
                                <th>Banner Preview</th>
                                <th>Title</th>
                                <th>Status</th>
                                <!-- <th>Actions</th> -->
                            </tr>

                        </thead>

                        <tbody>

                            <!-- Row 1 -->
                            <?php if (!empty($banner_data)) {
                                foreach ($banner_data as $key => $value) {

                            ?>
                                    <tr>

                                        <td>
                                            <span class="fw-bold text-dark"><?php echo $value['banner_id']; ?></span>
                                        </td>

                                        <td>
                                            <img src="../banner_image/<?php echo $value['banner_image']; ?>" class="rounded-4 shadow-sm"
                                                width="170" height="80" style="object-fit:cover;">
                                        </td>

                                        <td>

                                            <div class="fw-semibold fs-6">
                                                <?php echo $value['title']; ?>
                                            </div>

                                        </td>

                                        <td>

                                            <div class="form-check form-switch d-flex justify-content-center">

                                                <input class="form-check-input shadow-none" type="checkbox"
                                                    style="width:55px; height:25px; cursor:pointer;"
                                                    onchange="window.location.href='dashboard.php?toggle_status=<?php echo $value['banner_id']; ?>'"
                                                    <?php
                                                    if ($value['status'] == 1) {
                                                        echo "checked";
                                                    }
                                                    ?>>

                                            </div>

                                        </td>

                                        <!-- <td>

                                            <div class="d-flex justify-content-center gap-2">

                                                <button class="btn btn-sm btn-warning rounded-circle"
                                                    style="width:40px;height:40px;">

                                                    <i class="fa fa-edit text-white"></i>

                                                </button>

                                                <button class="btn btn-sm btn-danger rounded-circle"
                                                    style="width:40px;height:40px;">

                                                    <i class="fa fa-trash"></i>

                                                </button>

                                            </div>

                                        </td> -->

                                    </tr>
                            <?php
                                }
                            }
                            ?>

                        </tbody>

                    </table>

                </div>

            </div>

        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>
</body>

</html>