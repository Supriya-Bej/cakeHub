<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

include("db_connect.php");
global $conn;
$user_id = $_SESSION['user_id'] ?? 0;
if (isset($_GET['id'])) {
    $id = $_GET['id'];

    // PRODUCT DETAILS
    $sql = "SELECT products.*, cart.product_id AS cart_pid,AVG(reviews.rating) AS avg_rating,
        wishlist.product_id AS wish_pid FROM products LEFT JOIN reviews ON products.id = reviews.product_id
        LEFT JOIN wishlist ON products.id = wishlist.product_id AND wishlist.user_id = '$user_id' LEFT JOIN cart
        ON products.id = cart.product_id AND cart.user_id = '$user_id'  WHERE products.id = '$id'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
    $avg_rating = $product['avg_rating'] ?? 0;

    // Show related product
    $category_id = $product['category_id'];
    $relatedSql = "SELECT products.*, AVG(reviews.rating) AS avg_rating FROM products LEFT JOIN reviews ON 
    products.id = reviews.product_id WHERE products.category_id = '$category_id' AND products.id != '$id' GROUP BY products.id";
    $relatedRun = mysqli_query($conn, $relatedSql);
    $related_product_data = mysqli_fetch_all($relatedRun, MYSQLI_ASSOC);

    // ALL REVIEWS
    $feedbackSql = "SELECT reviews.*, users.name FROM reviews JOIN users ON reviews.user_id = users.id
        WHERE reviews.product_id = '$id' ORDER BY reviews.id DESC";
    $feedbackRun = mysqli_query($conn, $feedbackSql);
}
?>

<!DOCTYPE html>
<html lang="en">

<head>

    <meta charset="UTF-8">

    <meta name="viewport"
        content="width=device-width, initial-scale=1.0">

    <title>Product Details</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <!-- <link rel="stylesheet" href="header.css"> -->

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #fff0f6, #ffe3ec);
            min-height: 100vh;
            font-family: 'Segoe UI', sans-serif;
        }


        .img_container {
            margin: 30px;
            background: #ffd6e5;
            border-radius: 20px;
            padding: 20px;
            height: 400px;
            display: flex;
            justify-content: center;
            align-items: center;
        }

        .img_container img {
            max-height: 320px;
            width: 100%;
            object-fit: contain;
        }

        .product-title {
            font-size: 35px;
            font-weight: 700;
        }

        .product-card {
            position: relative;
            border: 2px solid #ff4f81;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.4s;
            background: white;
        }

        .product-img {
            height: 220px;
            object-fit: cover;
            display: block;
            margin: auto;
        }

        .price {
            color: #ff4f81;
            /* font-size: 30px; */
            font-weight: 700;
        }

        .review-slider {
            display: flex;
            gap: 15px;
            overflow-x: auto;
            overflow-y: hidden;
            padding-bottom: 10px;
            scroll-behavior: smooth;

            /* Hide scrollbar */
            scrollbar-width: none;
            /* Firefox */
            -ms-overflow-style: none;
            /* IE & Edge */
        }

        .review-slider::-webkit-scrollbar {
            display: none;
            /* Chrome, Safari, Opera */
        }

        .review-card {
            min-width: 280px;
            max-width: 280px;
            background: #fff;
            border-radius: 16px;
            padding: 15px;
            border-left: 4px solid #ff4f81;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.06);
            transition: 0.3s;
            flex-shrink: 0;
        }

        .review-card:hover {
            transform: translateY(-5px);
        }

        .review-feedback {
            font-size: 14px;
            color: #555;
        }

        .stock {
            padding: 5px 14px;
            border-radius: 20px;
            font-size: 14px;
            font-weight: 600;
        }

        .in-stock {
            background: #d4edda;
            color: green;
        }

        .out-stock {
            background: #f8d7da;
            color: red;
        }

        .price {
            font-weight: 700;
            color: #ff4f81;
        }

        .loveBtn {
            color: black;
        }

        .wishBtn {
            color: red !important;
        }

        .wishlist {
            position: absolute;
            top: 20px;
            right: 15px;
            cursor: pointer;
        }

        .card-body p {
            font-size: 14px;
        }

        .card-text {
            min-height: 50px;
        }

        .btn-area {
            margin-top: auto;
        }

        .btn-buy {
            background: #ff4f81;
            color: white;
            border: none;
            border-radius: 8px;
            padding: 8px 14px;
            font-weight: 500;

        }

        .btn:hover {
            background: #ea7e9e;
            color: white;
            transition: 0.3s;
        }

        #notify_msg {
            position: fixed;
            right: 0;
            width: 30vw;
            bottom: 10vh;
        }

        @media(max-width:768px) {

            .product-title {
                font-size: 28px;
                margin-top: 20px;
            }

            .img_container {
                height: 300px;
            }

            .btn-group-custom {
                flex-direction: column;
            }

            .btn-group-custom .btn {
                width: 100%;
            }

            .btn-buy {
                width: 100%;

            }
        }
    </style>

</head>

<body>
    <?php include("header.php"); ?>
    <div class="container py-5 " style="margin-top: 8vh;">

        <div class="product-card">
            <div class="row g-5">

                <!-- IMAGE -->
                <div class="col-lg-5">

                    <div class="img_container">

                        <img src="Assests/image/Cake/<?php echo $product['image']; ?>">

                    </div>

                </div>

                <!-- DETAILS -->
                <div class="col-lg-7">

                    <h2 class="product-title" style="padding-left: 20px;">
                        <?php echo $product['name']; ?>
                    </h2>

                    <div class="justify-content-between" style="padding-left: 20px;">
                        <!-- RATING -->
                        <div class="rating mb-3">

                            <?php
                            for ($i = 1; $i <= 5; $i++) {

                                if ($avg_rating >= $i) {

                                    echo '<i class="fa fa-star text-warning"></i>';
                                } elseif ($avg_rating >= ($i - 0.5)) {

                                    echo '<i class="fa fa-star-half-alt text-warning"></i>';
                                } else {

                                    echo '<i class="fa fa-star text-secondary"></i>';
                                }
                            }
                            ?>

                            <span class="ms-2 text-muted">
                                <?php echo number_format($avg_rating, 1); ?>
                            </span>

                        </div>

                        <!-- Wishlist -->
                        <?php if (isset($_SESSION['user_id'])) {  ?>
                            <span class="wishlist">
                                <button type="button" class="border-0 loveBtn bg-light 
                            <?php echo !empty($product['wish_pid']) ? 'wishBtn' : ''; ?>"
                                    onclick="toggleWishlist(this, <?php echo $product['id']; ?>)">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </span>
                        <?php } else { ?>
                            <a href="signup.php">
                                <span class="wishlist">
                                    <button type="button" class="border-0 loveBtn bg-light 
                            <?php echo !empty($product['wish_pid']) ? 'wishBtn' : ''; ?>"
                                        onclick="toggleWishlist(this, <?php echo $product['id']; ?>)">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </span>
                            </a>
                        <?php } ?>
                    </div>

                    <p class="text-muted" style="padding-left: 20px;">
                        <?php echo $product['description']; ?>
                    </p>

                    <h3 class="price" style="padding-left: 20px;">
                        ₹<?php echo $product['price']; ?>/kg
                    </h3>

                    <div class="mb-3" style="padding-left: 20px;">

                        <span class="fw-bold">Availability:</span>

                        <?php if ($product['stock'] > 0) { ?>

                            <span class="stock in-stock">
                                In Stock
                            </span>

                        <?php } else { ?>

                            <span class="stock out-stock">
                                Out of Stock
                            </span>

                        <?php } ?>

                    </div>

                    <!-- BUTTONS -->
                    <div class="d-flex flex-column flex-sm-row gap-2 mt-3 px-3">

                        <?php if ($product['stock'] == 0) { ?>
                            <a href=""
                                class="btn btn-buy bg-danger text-light btn-sm">
                                Out of Stock
                            </a>

                            <button class="btn btn-outline-dark btn-sm fw-bold position-relative"
                                onclick="notifyBtn()">
                                Notify Me

                            </button>


                        <?php } else { ?>

                            <?php if (isset($_SESSION['user_id'])) { ?>
                                <a href="user_order.php?id=<?php echo $product['id']; ?>"
                                    class="btn btn-buy btn-sm">
                                    <i class="fa fa-bolt"></i> Buy Now
                                </a>
                            <?php } else { ?>
                                <a href="signup.php" class="btn btn-buy btn-sm">
                                    <i class="fa fa-bolt"></i> Buy Now
                                </a>
                            <?php }
                            if (isset($_SESSION['user_id'])) { ?>
                                <button class="btn btn-outline-dark btn-sm"
                                    onclick="cartOption(this, <?php echo $product['id']; ?>)">

                                    <?php if (!empty($product['cart_pid'])) { ?>
                                        <i class="fa fa-cart-plus text-danger"></i> Remove
                                    <?php } else { ?>
                                        <i class="fa fa-cart-plus"></i> Add
                                    <?php } ?>

                                </button>
                            <?php } else { ?>
                                <a href="signup.php"><button class="btn btn-outline-dark btn-sm">
                                        <i class="fa fa-cart-plus"></i> Add
                                    </button>
                                </a>
                        <?php }
                        } ?>
                    </div>

                    <!-- REVIEWS -->
                    <div class="mt-5" style="padding: 0 20px;">

                        <div class="d-flex justify-content-between align-items-center mb-3">

                            <h4 class="fw-bold">Customer Reviews</h4>

                            <span class="badge bg-danger rounded-pill">
                                <?php echo mysqli_num_rows($feedbackRun); ?> Reviews
                            </span>

                        </div>

                        <?php if (mysqli_num_rows($feedbackRun) > 0) { ?>

                            <div class="review-slider">

                                <?php while ($review = mysqli_fetch_assoc($feedbackRun)) { ?>

                                    <div class="review-card">

                                        <div class="d-flex justify-content-between mb-2">

                                            <div>
                                                <h6 class="fw-bold mb-1">
                                                    <i class="fa fa-user-circle text-danger"></i>
                                                    <?php echo $review['name']; ?>
                                                </h6>

                                                <small class="text-muted">
                                                    <?php echo date("d M Y", strtotime($review['created_at'])); ?>
                                                </small>
                                            </div>

                                            <div class="text-warning">
                                                <?php
                                                for ($i = 1; $i <= 5; $i++) {
                                                    if ($review['rating'] >= $i) {
                                                        echo '<i class="fa fa-star"></i>';
                                                    } else {
                                                        echo '<i class="fa fa-star text-secondary"></i>';
                                                    }
                                                }
                                                ?>
                                            </div>

                                        </div>

                                        <p class="mb-0 review-feedback">
                                            "<?php echo $review['feedback']; ?>"
                                        </p>

                                    </div>

                                <?php } ?>

                            </div>

                        <?php } else { ?>

                            <div class="alert alert-light border text-center">
                                No reviews yet
                            </div>

                        <?php } ?>

                    </div>
                </div>

            </div>
        </div>

        <p id="notify_msg" class="z-3 rounded-3 container "></p>

        <div class="row mt-4 g-4" id="productList">

            <?php if (!empty($related_product_data)) {
                foreach ($related_product_data as $key => $value) {
            ?>
                    <div class="col-lg-3 col-md-6 product">

                        <div class="card h-100 container product-card position-relative">
                            <?php if (isset($_SESSION['user_id'])) {  ?>
                                <span class="wishlist">
                                    <button type="button" class="border-0 loveBtn bg-light 
                                <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                        onclick="toggleWishlist(this, <?php echo $value['id']; ?>)">
                                        <i class="fa fa-heart"></i>
                                    </button>
                                </span>
                            <?php } else { ?>
                                <a href="signup.php">
                                    <span class="wishlist">
                                        <button type="button" class="border-0 loveBtn bg-light 
                                <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                            onclick="toggleWishlist(this, <?php echo $value['id']; ?>)">
                                            <i class="fa fa-heart"></i>
                                        </button>
                                    </span>
                                </a>
                            <?php } ?>

                            <a href="product_details.php?id=<?php echo $value['id']; ?>">
                                <img src="Assests/image/Cake/<?php echo $value['image']; ?>" class="img-fluid product-img">
                            </a>

                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between">

                                    <h5><?php echo $value['name']; ?></h5>
                                    <span class="price">₹<?php echo $value['price']; ?>/kg</span>

                                </div>

                                <div class="text-warning mb-2">
                                    <?php
                                    $rating = round($value['avg_rating'] ?? 0);

                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($rating >= $i) {

                                            echo '<i class="fa fa-star text-warning"></i>';
                                        } else {

                                            echo '<i class="fa fa-star text-secondary"></i>';
                                        }
                                    }
                                    ?>

                                </div>

                                <p class="card-text"><?php echo $value['description']; ?></p>

                                <div class="d-flex btn-area justify-content-between mb-2">

                                    <?php if ($value['stock'] == 0) { ?>
                                        <a href=""
                                            class="btn btn-buy bg-danger text-light btn-sm">
                                            Out of Stock
                                        </a>

                                        <button class="btn btn-outline-dark btn-sm fw-bold position-relative"
                                            onclick="notifyBtn()">
                                            Notify Me

                                        </button>


                                    <?php } else { ?>

                                        <?php if (isset($_SESSION['user_id'])) { ?>
                                            <a href="user_order.php?id=<?php echo $value['id']; ?>"
                                                class="btn btn-buy btn-sm">
                                                <i class="fa fa-bolt"></i> Buy Now
                                            </a>
                                        <?php } else { ?>
                                            <a href="signup.php" class="btn btn-buy btn-sm">
                                                <i class="fa fa-bolt"></i> Buy Now
                                            </a>
                                        <?php } ?>

                                        <?php if (isset($_SESSION['user_id'])) { ?>
                                            <button class="btn btn-outline-dark btn-sm"
                                                onclick="cartOption(this, <?php echo $value['id']; ?>)">

                                                <?php if (!empty($value['cart_pid'])) { ?>
                                                    <i class="fa fa-cart-plus text-danger"></i> Remove
                                                <?php } else { ?>
                                                    <i class="fa fa-cart-plus"></i> Add
                                                <?php } ?>

                                            </button>
                                        <?php } else { ?>
                                            <a href="signup.php"><button class="btn btn-outline-dark btn-sm">
                                                    <i class="fa fa-cart-plus"></i> Add
                                                </button>
                                            </a>
                                    <?php }
                                    } ?>
                                </div>

                            </div>
                        </div>
                    </div>
            <?php }
            } ?>
            <!-- <p id="notify_msg" class="z-3 rounded-3 container"></p> -->
        </div>
    </div>

    <script src="Assests/js/bootstrap.bundle.min.js"></script>
    <script>
        async function toggleWishlist(btn, productId) {

            try {

                const res = await fetch(
                    "wishlistAction.php?product_id=" + productId
                );

                const data = (await res.text()).trim();
                // console.log(data);

                if (data === "added") {

                    btn.classList.add("wishBtn");

                    alert("❤️ Product added to wishlist");

                } else if (data === "removed") {

                    btn.classList.remove("wishBtn");

                    alert("💔 Product removed from wishlist");

                } else if (data === "login_required") {

                    window.location.href = "signup.php";
                }

            } catch (error) {

                console.error(error);

                alert("Something went wrong!");
            }
        }

        async function cartOption(btn, productId) {

            try {

                const result = await fetch("cart_action.php?product_id=" + productId + "&badge=cart");

                const data = (await result.text()).trim();

                let count = document.getElementById("cartCount");

                if (data === "add") {

                    count.innerText++;

                    btn.innerHTML = `<i class="fa fa-cart-plus text-danger"></i> Remove`;

                } else if (data === "remove") {

                    count.innerText--;

                    btn.innerHTML = `<i class="fa fa-cart-plus"></i> Add`;
                }

            } catch (error) {

                console.error(error);

            }
        }

        function notifyBtn() {

            document.getElementById("notify_msg").innerHTML = `

            <div class="alert alert-success alert-dismissible fade show" role="alert">

                <strong>Success!</strong> You will be notified when it is available.

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>

            `;
        }
    </script>

</body>

</html>