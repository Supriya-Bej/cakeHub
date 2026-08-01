<?php
include("db_connect.php");
global $conn;
include("header.php");
// $user_id = $_SESSION['user_id'] ?? 0;
if (!isset($_SESSION['user_id'])) {
    echo "Please login first";
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT orders.*, products.name AS product_name, products.image FROM orders LEFT JOIN products
         ON orders.product_id = products.id WHERE orders.user_id = '$user_id' ORDER BY orders.id DESC";

$result = mysqli_query($conn, $sql);
$row = mysqli_fetch_all($result, MYSQLI_ASSOC);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <title>My Orders</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">

    <!-- Bootstrap Icons -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="header.css"> -->


    <style>
        :root {
            --primary: #c14277;
            --secondary: #f8f9fa;
            --accent: #ff6b9a;
        }

        body {
            background: var(--secondary);
            font-family: 'Segoe UI', sans-serif;
        }

        /* Title */
        .page-title {
            color: var(--primary);
            font-weight: 700;
        }

        /* Order Card */
        .order-box {
            background: #fff;
            width: 100%;
            max-width: 1000px;
            border-radius: 15px;
            padding: 20px;
            border-left: 5px solid var(--primary);
            box-shadow: 0 5px 20px rgba(0, 0, 0, 0.05);
            transition: 0.3s;
        }

        .order-box:hover {
            transform: translateY(-5px);
        }

        /* Image */
        .product-img {
            width: 70px;
            height: 70px;
            border-radius: 12px;
            object-fit: cover;
        }

        /* ➡️ Details Arrow */
        .details-btn {
            margin-left: 10px;
            font-size: 20px;
            color: var(--primary);
            text-decoration: none;
            transition: 0.3s;
        }

        .details-btn:hover {
            color: var(--accent);
            transform: translateX(5px);
        }

        .review-box {
            min-width: 220px;
        }

        .review-btn {
            background: linear-gradient(135deg, #ff5f8f, #ff8fb1);
            color: white;
            border-radius: 30px;
            padding: 6px 16px;
            border: none;
            transition: 0.3s;
            font-weight: 500;
        }

        .review-btn:hover {
            transform: translateY(-2px);
            color: white;
            box-shadow: 0 5px 15px rgba(255, 95, 143, 0.3);
        }

        .feedback-box {
            background: #fff4f7;
            border-left: 4px solid #ff5f8f;
            padding: 10px 14px;
            border-radius: 10px;
            font-size: 14px;
            color: #555;
            max-width: 220px;
            margin-top: 5px;
        }

        .track-box {
            display: flex;
            gap: 15px;
            margin-top: 10px;
        }

        .track-step {
            text-align: center;
            position: relative;
        }

        .track-step span {
            width: 18px;
            height: 18px;
            border-radius: 50%;
            background: #d3d3d3;
            display: block;
            margin: auto;
        }

        .track-step p {
            font-size: 12px;
            margin-top: 5px;
        }

        .track-step.active span {
            background: #28a745;
        }

        .track-step::after {
            content: "";
            position: absolute;
            width: 40px;
            height: 3px;
            background: #d3d3d3;
            top: 8px;
            left: 25px;
        }

        .track-step:last-child::after {
            display: none;
        }

        .track-step.active::after {
            background: #28a745;
        }
    </style>
</head>

<body class="my-5">
    <div id="loader">
        Loading...
    </div>

    <div id="main-content" style="display:none;">

        <!-- 🔙 Back Button -->
        <a href="product.php" class="back-btn my-5">
            <i class="bi bi-arrow-left"></i>
        </a>

        <div class="container py-5 d-flex flex-column align-items-center">

            <h2 class="text-center mb-4 page-title">My Orders</h2>

            <?php if (!empty($row)) {
                foreach ($row as $value) { ?>

                    <div class="order-box mb-3 d-flex align-items-center justify-content-between flex-wrap">

                        <!-- Left -->
                        <div class="d-flex align-items-center gap-3">
                            <img src="products_image/<?= $value['image']; ?>" class="product-img">

                            <div>
                                <h6 class="mb-1"><?= $value['product_name']; ?></h6>
                                <small class="text-muted">Order Id<?= $value['id']; ?></small><br>
                                <div class="d-flex">
                                    <small class="text-muted"><?= date("d M Y", strtotime($value['order_date'])); ?></small>
                                    <ul>
                                        <li><small>Qty: <?php echo $value['quantity']; ?></small></li>
                                    </ul>
                                </div>
                                <small class="text-muted fw-bold">Total Price: <?= $value['price']; ?></small><br>
                            </div>
                        </div>

                        <!-- Middle -->
                        <!-- REVIEW SECTION -->
                        <?php
                        $orderId = $value['id'];
                        $review = "SELECT * FROM reviews WHERE user_id = '$user_id' AND order_id = '$orderId'";
                        $run = mysqli_query($conn, $review);
                        $data = mysqli_fetch_assoc($run);

                        $rating = $data['rating'] ?? 0;
                        ?>

                        <?php
                        if ($value['status'] == "Deliverd") { ?>
                            <div class="review-box d-flex flex-column align-items-center">

                                <!-- STARS -->
                                <div class="mb-2">

                                    <?php
                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($rating >= $i) {

                                            if ($rating >= 4) {

                                                echo '<i class="fa fa-star text-success fs-5"></i>';
                                            } elseif ($rating == 3) {

                                                echo '<i class="fa fa-star text-warning fs-5"></i>';
                                            } else {

                                                echo '<i class="fa fa-star text-danger fs-5"></i>';
                                            }
                                        } else {

                                            echo '<i class="fa fa-star text-secondary fs-5"></i>';
                                        }
                                    }
                                    ?>

                                </div>

                                <!-- REVIEW BUTTON -->
                                <a href="review.php?product_id=<?= $value['product_id']; ?>&order_id=<?= $value['id']; ?>"
                                    class="btn btn-sm review-btn mb-2">

                                    <i class="fa fa-pen"></i> Review

                                </a>

                                <!-- FEEDBACK -->
                                <?php if (!empty($data['feedback'])) { ?>

                                    <div class="feedback-box">

                                        <i class="fa fa-quote-left text-danger me-1"></i>

                                        <?= $data['feedback']; ?>

                                    </div>

                                <?php } ?>

                            </div>
                            <?php } else {
                            if ($value['status'] == "Pending") { ?>
                                <a href="Form_action.php?product_id=<?php echo $value['product_id']; ?>&value=cancel">

                                    <button type="button" class="p-2 bg-danger text-light fw-medium rounded-5 border-0">
                                        Cancel Order
                                    </button>

                                </a>



                                <?php } else {
                                $updateStatus = $value['status'];

                                if ($updateStatus == "cancel") { ?>

                                    <span class="fw-medium text-danger">
                                        Cancelled
                                    </span>

                            <?php }
                            } ?>

                        <?php
                        } ?>


                        <!-- Right -->
                        <div class="d-flex flex-column align-items-end">
                            <?php
                            $status = $value['status'];

                            $step1 = "active";
                            $step2 = "";
                            $step3 = "";
                            $step4 = "";

                            if ($status == "Preparing") {
                                $step2 = "active";
                            } elseif ($status == "Shipped") {
                                $step2 = "active";
                                $step3 = "active";
                            } elseif ($status == "Deliverd") {
                                $step2 = "active";
                                $step3 = "active";
                                $step4 = "active";
                            }
                            ?>

                            <!-- TRACK ORDER -->

                            <div class="d-flex justify-content-around gap-5">
                                <div class="track-box">

                                    <div class="track-step <?php echo $step1; ?>">
                                        <span></span>
                                        <p>Placed</p>
                                    </div>

                                    <div class="track-step <?php echo $step2; ?>">
                                        <span></span>
                                        <p>Preparing</p>
                                    </div>

                                    <div class="track-step <?php echo $step3; ?>">
                                        <span></span>
                                        <p>Shipped</p>
                                    </div>

                                    <div class="track-step <?php echo $step4; ?>">
                                        <span></span>
                                        <p>Delivered</p>
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                <?php }
            } else { ?>
                <div class="text-center text-muted">No orders found</div>
            <?php } ?>

        </div>

        <script src="Assests/js/bootstrap.bundle.min.js"></script>
        <script>
            window.onload = function() {
                document.getElementById("loader").style.display = "none";
                document.getElementById("main-content").style.display = "block";
            };
        </script>
</body>

</html>