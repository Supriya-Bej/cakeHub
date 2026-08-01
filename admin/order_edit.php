<?php
include("../db_connect.php");
include("function.php");
global $conn;
$select = "SELECT * FROM `orderstatus`";
$run = mysqli_query($conn, $select);

if (isset($_GET['order_id'])) {
    $id = $_GET['order_id'];
    $data = get_single_details('orders', $id);
    if (!$data) {
        echo "Product not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}

$method = "SELECT * FROM `payment_type`";
$result = mysqli_query($conn, $method);
?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Order - Admin</title>

    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css">

    <style>
        body {
            background: #f8f6f3;
            font-family: 'Poppins', sans-serif;
        }

        /* GRID LAYOUT */
        .admin-layout {
            display: grid;
            grid-template-columns: 1fr 2fr;
            gap: 20px;
        }

        /* CARDS */
        .card-box {
            background: #fff;
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08);
        }

        /* ORDER SUMMARY */
        .summary img {
            width: 100%;
            max-height: 180px;
            object-fit: contain;
        }

        .summary h5 {
            margin-top: 10px;
        }

        /* FORM */
        .form-control {
            border-radius: 10px;
        }

        /* TIMELINE */


        /* BUTTONS */
        .btn-main {
            background: linear-gradient(135deg, #ff4d6d, #ff758c);
            color: white;
            border-radius: 30px;
        }
    </style>
</head>

<body>
    <div class="container py-4">
        <h3 class="mb-4">Order Management ✏️</h3>
        <div class="admin-layout">
            <!-- LEFT: ORDER SUMMARY -->
            <div class="card-box summary">
                <h5>Order Summary</h5>
                <img src="../products_image/<?php echo $data['image']; ?>" class="img-fluid">

                <p><b>Order ID:</b> <?php echo $data['id']; ?></p>
                <p><b>Customer:</b> <?php echo $data['username']; ?></p>
                <p><b>Phone:</b> <?php echo $data['phNumber']; ?></p>

                <hr>

                <p><b>Product:</b> <?php echo $data['name']; ?></p>
                <p><b>Quantity:</b> <?php echo $data['quantity']; ?></p>
                <p><b>Total:</b> <?php echo $data['price']; ?></p>
            </div>

            <!-- CENTER: EDIT FORM -->
            <div class="card-box">
                <h5>Edit Details</h5>

                <form action="order_update.php" method="POST" enctype="multipart/form-data">
                    <input type="hidden" name="order_id" value="<?php echo $id; ?>">
                    <div class="row g-3">

                        <div class="col-md-6">
                            <label>Name</label>
                            <input type="text" class="form-control" value="<?php echo $data['username']; ?>">
                        </div>

                        <div class="col-md-6">
                            <label>Phone</label>
                            <input type="text" class="form-control" value="<?php echo $data['phNumber']; ?>">
                        </div>

                        <div class="col-md-6">
                            <label>Quantity</label>
                            <input type="number" class="form-control" value="<?php echo $data['quantity']; ?>">
                        </div>

                        <div class="col-md-6">
                            <label>Delivery Date</label>
                            <input type="text" class="form-control" value="<?php echo $data['order_date']; ?>">
                        </div>

                        <div class="col-12">
                            <label>Address</label>
                            <textarea class="form-control"><?php echo $data['address']; ?></textarea>
                        </div>

                        <div class="col-12">
                            <label>Message</label>
                            <input type="text" class="form-control" value="<?php echo $data['message']; ?>">
                        </div>

                        <div class="col-md-6">
                            <label>Status</label>
                            <select class="form-control status-select" name="status">
                                <?php while ($row = mysqli_fetch_assoc($run)) { ?>
                                    <option value="<?php echo $row['status']; ?>">
                                        <?php if ($row['status'] == $data['status']) echo "selected"; ?>
                                        <?php echo $row['status']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <div class="col-md-6">
                            <label>Payment</label>
                            <select name="payment_type" id="paymentType" onchange="showMethods()">
                                <?php while ($value = mysqli_fetch_assoc($result)) { ?>
                                    <option value="<?php echo $value['method']; ?>"
                                        <?php if ($value['method'] == $data['payment_type']) echo "selected"; ?>>
                                        <?php echo $value['method']; ?>
                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                    </div>

                    <button class="btn btn-main w-100 mt-4 text-light"
                        type="submit" value="submit" name="updateOrder">Update Order</button>

                </form>
            </div>

        </div>

    </div>

    <script>
        function showMethods() {
            let value = document.getElementById("paymentType").value;
            let methods = document.getElementById("onlineMethods");

            if (value === "Online") {
                methods.style.display = "block";
            } else {
                methods.style.display = "none";
            }
        }
    </script>
</body>

</html>