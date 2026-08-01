<?php
include("../db_connect.php");
include("function.php");
session_start();
global $conn;
if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $data = get_single_details('orders', $id);
    if (!$data) {
        echo "Product not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Details - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        body {
            background: #f5f3ef;
            font-family: Poppins, sans-serif;
        }

        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        .badge-status {
            padding: 6px 12px;
            border-radius: 20px
        }

        .pending {
            background: #ffe5c2;
            color: #ff8c32
        }

        .delivered {
            background: #d4edda;
            color: #28a745
        }

        .product-img {
            width: 50px;
            height: 50px;
            border-radius: 8px;
            object-fit: cover
        }

        .btn-orange {
            background: #ff8c32;
            color: #fff;
            border: none
        }
    </style>
</head>

<body>

    <div class="container-fluid ">
        <div class="row">

            <?php include("sidebar.php") ?>

            <!-- Main -->
            <div class="col-lg-10 mt-3">

                <div class="main-card">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas"
                                data-bs-target="#mobileMenu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <h3 class="mb-0 fw-bold">Order Details</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <!-- Order Info -->
                    <div class="row mb-4">
                        <div class="col-md-4">
                            <h6 class="fw-bold">Order ID</h6>
                            <p><?php echo $data['id']; ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold">Customer</h6>
                            <p><?php echo $data['username']; ?></p>
                        </div>
                        <div class="col-md-4">
                            <h6 class="fw-bold">Status</h6>
                            <span class=""><?php echo $data['status']; ?></span>
                        </div>
                    </div>

                    <!-- Products Table -->
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Image</th>
                                    <th>Product Name</th>
                                    <th>Qty</th>
                                    <th>Cake Price</th>
                                    <th>User Id</th>
                                    <th>Address</th>
                                    <th>Ph.No</th>
                                    <th>Message</th>
                                    <th>Payment Type</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td><img src="../products_image/<?php echo $data['image']; ?>" class="product-img"></td>
                                    <td><?php echo $data['name']; ?></td>
                                    <td><?php echo $data['quantity']; ?></td>
                                    <td><?php echo $data['price']; ?></td>
                                    <td><?php echo $data['user_id']; ?></td>
                                    <td><?php echo $data['address']; ?></td>
                                    <td><?php echo $data['phNumber']; ?></td>
                                    <td><?php echo $data['message']; ?></td>
                                    <td><?php echo $data['payment_type']; ?></td>
                                </tr>
                            </tbody>
                        </table>
                    </div>

                    <!-- Summary -->
                    <div class="row mt-4">
                        <div class="col-md-6">
                            <h6>Date</h6>
                            <p><?php echo $data['order_date'] ?></p>
                        </div>
                        <!-- <div class="col-md-6 text-md-end">
                            <h5>Total Amount: $55</h5>
                        </div> -->
                    </div>

                    <!-- Buttons -->
                    <div class="d-flex justify-content-end gap-2 mt-3">
                        <button class="btn btn-orange">Mark Delivered</button>
                        <a href="order.php"><button class="btn btn-outline-secondary">Back</button></a>
                    </div>

                </div>
            </div>
        </div>
    </div>


    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

</body>

</html>