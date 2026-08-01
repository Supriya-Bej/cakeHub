<?php

include('db_connect.php');
global $conn;
include("header.php");
$user_id = $_SESSION['user_id'] ?? 0;

// Search
if (isset($_GET['search'])) {

    $search_item = $_GET['search'];

    $sql_product_category = "SELECT products.*, AVG(reviews.rating) AS avg_rating, wishlist.product_id AS wish_pid, cart.product_id AS cart_pid
        FROM products LEFT JOIN reviews ON products.id = reviews.product_id LEFT JOIN wishlist
        ON products.id = wishlist.product_id AND wishlist.user_id = '$user_id' LEFT JOIN cart
        ON products.id = cart.product_id AND cart.user_id = '$user_id' WHERE products.name LIKE '%$search_item%'
           OR products.description LIKE '%$search_item%' GROUP BY products.id";
} elseif (isset($_GET['category_id'])) {

    $category_id = $_GET['category_id'];

    $sql_product_category = "SELECT products.*, categories.name AS category_name, AVG(reviews.rating) AS avg_rating,
        wishlist.product_id AS wish_pid, cart.product_id AS cart_pid FROM products INNER JOIN categories
        ON products.category_id = categories.id LEFT JOIN reviews ON products.id = reviews.product_id
        LEFT JOIN wishlist ON products.id = wishlist.product_id AND wishlist.user_id = '$user_id'
        LEFT JOIN cart ON products.id = cart.product_id AND cart.user_id = '$user_id'
        WHERE products.category_id = '$category_id' GROUP BY products.id";
} else {

    $sql_product_category = "SELECT products.*, AVG(reviews.rating) AS avg_rating, wishlist.product_id AS wish_pid,
        cart.product_id AS cart_pid FROM products LEFT JOIN reviews ON products.id = reviews.product_id
        LEFT JOIN wishlist ON products.id = wishlist.product_id AND wishlist.user_id = '$user_id'
        LEFT JOIN cart ON products.id = cart.product_id AND cart.user_id = '$user_id' GROUP BY products.id";
}
$result_product_category = mysqli_query($conn, $sql_product_category);

// Category fetch
$sql_category = "SELECT * FROM `categories`";
$result_category = mysqli_query($conn, $sql_category);

?>



<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="header.css"> -->
    <!-- <link rel="stylesheet" href="product.css"> -->

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: system-ui, -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif;
        }


        .title {
            font-weight: 700;
            margin-top: 40px;
            text-align: center;
        }

        .product-card {
            border: 2px solid #ff4f81;
            border-radius: 15px;
            overflow: hidden;
            transition: 0.4s;
            background: white;
        }

        .product-card:hover {
            transform: translateY(-10px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.2);
        }

        .product-img {
            height: 220px;
            object-fit: cover;
            display: block;
            margin: auto;
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
            /* adjust if needed */
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
        }
    </style>

</head>
<?php  ?>

<body class="position-relative">
    <div id="loader">
        Loading...
    </div>

    <div id="main-content" style="display:none;">


        <div class="container py-5">

            <h2 class="title">💜 Select Your Cake 🌸</h2>

            <!-- FILTER BUTTONS -->

            <div class="text-center mt-4">

                <a href="product.php" class="btn">All</a>

                <!-- CATEGORY BUTTONS -->
                <?php while ($data = mysqli_fetch_assoc($result_category)) { ?>
                    <a href="product.php?category_id=<?php echo $data['id'] ?>" class="btn">
                        <?php echo $data['name'] ?>
                    </a>
                <?php } ?>

            </div>



            <div class="row mt-4 g-4" id="productList">

                <?php while ($row_product_category = mysqli_fetch_assoc($result_product_category)) {  ?>
                    <div class="col-lg-3 col-md-6 product">

                        <div class="card h-100 container product-card position-relative">
                            <span class="wishlist">
                                <button type="button" class="border-0 loveBtn bg-light 
                            <?php echo !empty($row_product_category['wish_pid']) ? 'wishBtn' : ''; ?>"
                                    onclick="toggleWishlist(this, <?php echo $row_product_category['id']; ?>)">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </span>

                            <a href="product_details.php?id=<?php echo $row_product_category['id']; ?>">
                                <img src="Assests/image/Cake/<?php echo $row_product_category['image']; ?>" class="img-fluid product-img">
                            </a>

                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between">

                                    <h5><?php echo $row_product_category['name']; ?></h5>
                                    <span class="price">₹<?php echo $row_product_category['price']; ?>/kg</span>

                                </div>

                                <div class="text-warning mb-2">
                                    <?php
                                    $rating = round($row_product_category['avg_rating'] ?? 0);

                                    for ($i = 1; $i <= 5; $i++) {

                                        if ($rating >= $i) {

                                            echo '<i class="fa fa-star text-warning"></i>';
                                        } else {

                                            echo '<i class="fa fa-star text-secondary"></i>';
                                        }
                                    }
                                    ?>

                                </div>

                                <p class="card-text"><?php echo $row_product_category['description']; ?></p>

                                <div class="d-flex btn-area justify-content-between mb-2">

                                    <?php if ($row_product_category['stock'] == 0) { ?>
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
                                            <a href="user_order.php?id=<?php echo $row_product_category['id']; ?>"
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
                                                onclick="cartOption(this, <?php echo $row_product_category['id']; ?>)">

                                                <?php if (!empty($row_product_category['cart_pid'])) { ?>
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
                <?php } ?>
                <p id="notify_msg" class="z-3 rounded-3 container"></p>
            </div>
        </div>


        <script src="Assests/js/bootstrap.bundle.min.js"></script>
        <script>
window.onload = function() {
    document.getElementById("loader").style.display = "none";
    document.getElementById("main-content").style.display = "block";
};
</script>
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