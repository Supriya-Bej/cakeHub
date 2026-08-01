<?php
include("header.php");
global $conn;

$user_id = $_SESSION['user_id'] ?? 0;

$cartData = "SELECT cart.*, products.*,wishlist.product_id AS wish_pid FROM cart INNER JOIN products ON 
products.id = cart.product_id LEFT JOIN wishlist ON cart.product_id = wishlist.product_id 
AND cart.user_id = wishlist.user_id WHERE cart.user_id = '$user_id'";
$result = mysqli_query($conn, $cartData);
$data = mysqli_fetch_all($result, MYSQLI_ASSOC);
foreach ($data as $row => $value) {
    $category_id = $value['category_id'];
}


$sum = "SELECT SUM(products.price * cart.quantity) AS sum_price,products.id AS product_id FROM products JOIN cart WHERE 
    cart.user_id = '$user_id'";
$run = mysqli_query($conn, $sum);
$sum_res = mysqli_fetch_assoc($run);
$price = $sum_res['sum_price'];

$arr = [];

// Show related product
// $category_id = $data['category_id'];
$product_id = $sum_res['product_id'];
$relatedSql = "SELECT products.*, AVG(reviews.rating) AS avg_rating FROM products LEFT JOIN reviews ON 
    products.id = reviews.product_id WHERE products.category_id IN (SELECT DISTINCT products.category_id FROM cart
    JOIN products ON products.id = cart.product_id WHERE cart.user_id = '$user_id') GROUP BY products.id";
$relatedRun = mysqli_query($conn, $relatedSql);
$related_product_data = mysqli_fetch_all($relatedRun, MYSQLI_ASSOC);
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

        /* .badge-sale {
            position: absolute;
            top: 10px;
            left: 10px;
            background: red;
            color: white;
            padding: 5px 10px;
            border-radius: 10px;
            font-size: 12px;
        } */
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
            background: #f49bb6;
            color: white;
            transition: 0.3s;
        }

        #notify_msg {
            position: fixed;
            right: 0;
            width: 30vw;
            bottom: 10vh;
            z-index: 9999;
        }
    </style>

</head>

<body>

    <div class="container py-5">

        <div class="row mt-4 g-4" id="productList">

            <?php if (!empty($data)) {

                foreach ($data as $key => $value) {

                    $newArr = array_push($arr, $value['product_id']);

            ?>

                    <div class="col-lg-3 col-md-6 product">

                        <div class="card h-100 container product-card position-relative">
                            <span class="wishlist">
                                <button type="button" class="border-0 loveBtn bg-light 
                            <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                    onclick="toggleWishlist(this, <?php echo $value['product_id']; ?>)">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </span>


                            <a href="product_details.php?id=<?php echo $value['id']; ?>">
                                <img src="Assests/image/Cake/<?php echo $value['image']; ?>" class="img-fluid product-img">
                            </a>

                            <div class="card-body d-flex flex-column">

                                <div class="d-flex justify-content-between">
                                    <h5><?php echo $value['name']; ?></h5>
                                    <span class="price">₹<?php echo $value['price']; ?>/kg</span>
                                </div>

                                <div class="d-flex justify-content-between">
                                    <div class="text-warning mb-2">
                                        <?php
                                        $rating = $value['rating'];
                                        for ($i = 1; $i <= 5; $i++) {
                                            // Full star
                                            if ($rating >= $i) {
                                                echo '<i class="fa fa-star text-warning"></i>';
                                            } else if ($rating >= ($i - 0.5)) {
                                                // Half star
                                                echo '<i class="fa fa-star-half-alt text-warning"></i>';
                                            } else {
                                                // Empty star
                                                echo '<i class="fa fa-star text-secondary"></i>';
                                            }
                                        }
                                        ?>
                                    </div>

                                    <div class="d-flex align-items-center gap-2">

                                        <button class="btn btn-danger btn-sm"
                                            onclick="minus(<?php echo $value['product_id']; ?>,<?php echo $value['price']; ?>)">
                                            -</button>

                                        <span class="fw-bold quantity" id="<?php echo $value['product_id']; ?>">
                                            <?php echo $value['quantity']; ?>
                                        </span>

                                        <button class="btn btn-danger btn-sm"
                                            onclick="plus(<?php echo $value['product_id']; ?>,<?php echo $value['price']; ?>)">
                                            +</button>
                                    </div>
                                </div>

                                <p class="card-text"><?php echo $value['description']; ?></p>

                                <div class="d-flex btn-area justify-content-between mb-2">

                                    <?php if ($value['stock'] == 0) { ?>
                                        <a href="user_order.php?id=<?php echo $value['id']; ?>"
                                            class="btn btn-buy bg-danger text-light btn-sm">
                                            Out of Stock
                                        </a>

                                        <button class="btn btn-outline-dark btn-sm fw-bold"
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
                                            <!-- <a href="cart_action.php?product_id=<?php echo $value['product_id']; ?>&badge=cart"> -->
                                            <button class="btn btn-outline-dark btn-sm text-danger fw-medium"
                                                onclick="cartOption(this, <?php echo $value['product_id']; ?>)">
                                                <i class="fa fa-cart-plus text-danger"></i> Remove
                                            </button>
                                            </a>
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
            <?php } else { ?>
                <div class="container py-5">

                    <div class="row justify-content-center">

                        <div class="col-lg-6">

                            <div class="card border-0 shadow-lg text-center p-5 rounded-4">

                                <div class="mb-4">
                                    <i class="fa-solid fa-cart-shopping"
                                        style="font-size:70px;color:#ff4f81;"></i>
                                </div>

                                <h2 class="fw-bold mb-3">
                                    Your Cart Feels Lonely 🛒
                                </h2>

                                <p class="text-muted fs-5 mb-4">
                                    Looks like you haven’t added anything yet.
                                    Discover delicious cakes and sweet treats made specially for you.
                                </p>

                                <div class="d-flex justify-content-center gap-3">

                                    <a href="product.php"
                                        class="btn px-4 py-2 rounded-pill fw-semibold text-light"
                                        style="background-color:#ff4f81;">

                                        <i class="fa fa-bag-shopping"></i>
                                        Start Shopping

                                    </a>

                                    <a href="wishlist.php?user_id=<?php echo $_SESSION['user_id']; ?>"
                                        class="btn btn-outline-dark px-4 py-2 rounded-pill fw-semibold">

                                        <i class="fa fa-heart"></i>
                                        Wishlist

                                    </a>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>
            <?php } ?>

            <!-- RIGHT SIDE SUMMARY -->
            <?php if (!empty($data)) { ?>
                <div class="col-lg-4">

                    <div class="card shadow border-0 p-4 "
                        style="top:90px; border-radius:20px;">

                        <h4 class="fw-bold mb-4">
                            Cart Summary
                        </h4>

                        <div class="d-flex justify-content-between mb-3">

                            <span>Total Items</span>

                            <span class="fw-bold">
                                <?php echo count($data); ?>
                            </span>

                        </div>

                        <div class="d-flex justify-content-between mb-3">

                            <span>Delivery</span>
                            <?php if ($price > 500) { ?>
                                <span class="text-success fw-bold">
                                    Free
                                </span>
                            <?php } else { ?>
                                <span class="text-success fw-bold">
                                    Delivery charge 55
                                </span>
                            <?php } ?>

                        </div>

                        <hr>

                        <div class="d-flex justify-content-between mb-4">

                            <span class="fw-bold">Total Price</span>

                            <span class="fw-bold text-danger" id="totalPrice">

                                ₹<?php
                                    $total = 0;

                                    if ($value['stock'] > 0) {
                                        foreach ($data as $item) {
                                            $total += $item['price'] * $item['quantity'];
                                        }
                                    }
                                    echo $total;
                                    ?>
                            </span>
                        </div>
                        <?php $product_ids = implode(", ", $arr);  ?>

                        <a href="user_order.php?product_ids=<?php echo $product_ids; ?>&price=<?php echo $total; ?>"
                            class="btn btn-danger w-100 py-2 fw-semibold" style="border-radius:10px; text-decoration:none;">
                            Proceed To Checkout
                        </a>

                        <p class="text-muted small mt-3 text-center mb-0">
                            Free delivery on orders above ₹499
                        </p>
                    </div>

                </div>
            <?php } ?>


        </div>

        <p id="notify_msg" class=" rounded-3 container "></p>

        <?php if (!empty($data)) { ?>
            <div class="mt-5">
                <h1 class="fw-semibold fs-4 text-warning">You can continue your shopping...</h1>
            </div>
        <?php } ?>
        <div class="row mt-4 g-4" id="productList">

            <?php if (!empty($related_product_data)) {
                foreach ($related_product_data as $key => $value) {
            ?>
                    <div class="col-lg-3 col-md-6 product">

                        <div class="card h-100 container product-card position-relative">
                            <span class="wishlist">
                                <button type="button" class="border-0 loveBtn bg-light 
                            <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                    onclick="toggleWishlist(this, <?php echo $value['id']; ?>)">
                                    <i class="fa fa-heart"></i>
                                </button>
                            </span>

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
                                        <a href="user_order.php?id=<?php echo $value['id']; ?>"
                                            class="btn btn-buy bg-danger text-light btn-sm">
                                            Out of Stock
                                        </a>

                                        <button class="btn btn-outline-dark btn-sm fw-bold"
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

        </div>
    </div>



    <script src="Assests/js/bootstrap.bundle.min.js"></script>
    <script>
        async function toggleWishlist(btn, productId) {
            try {
                const res = await fetch("wishlistAction.php?product_id=" + productId + "&badge=cart");
                const data = await res.text();

                // console.log(data);
                if (data === "added") {
                    btn.classList.add("wishBtn");
                    alert("❤️ Product added to wishlist");

                } else if (data === "removed") {
                    btn.classList.remove("wishBtn");
                    alert("❤️ Product removed from wishlist");
                    // window.location.href = "product.php";

                } else if (data === "login_required") {
                    header("Location:signup.php");
                    alert("Please login first");
                }

            } catch (error) {
                console.error("Error:", error);
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

            <div class="alert alert-success alert-dismissible fade show shadow" role="alert">

                <strong>Success!</strong> You will be notified when it is available.

                <button type="button"
                    class="btn-close"
                    data-bs-dismiss="alert"
                    aria-label="Close">
                </button>

            </div>
            `;
        }

        let total = <?php echo $total; ?>;
        // console.log(total);

        async function minus(productId, price) {
            let minus = document.getElementById(productId);
            let value = parseInt(minus.innerText);
            if (value > 1) {
                const res = await fetch("update_cart_quantity.php?product_id=" + productId + "&type=minus");
                minus.innerText = value - 1;
                total -= price;
                document.getElementById("totalPrice").innerText = "₹" + total;
            }
        }

        async function plus(productId, price) {
            let plus = document.getElementById(productId);
            let value = parseInt(plus.innerText);
            const res = await fetch("update_cart_quantity.php?product_id=" + productId + "&type=plus");
            plus.innerText = value + 1;
            total += price;
            document.getElementById("totalPrice").innerText = "₹" + total;
        }
    </script>
</body>

</html>