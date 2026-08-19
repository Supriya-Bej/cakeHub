<?php
include("header.php");
global $conn;
if (isset($_GET['user_id'])) {
    // For filtering by button
    $user_id = $_GET['user_id'];

    $wishlistData = "SELECT wishlist.*, products.*,wishlist.product_id AS wish_pid, cart.product_id AS 
    cart_pid FROM wishlist INNER JOIN products ON products.id = wishlist.product_id LEFT JOIN cart
        ON products.id = cart.product_id AND cart.user_id = '$user_id' WHERE wishlist.user_id = '$user_id'";
    $result = mysqli_query($conn, $wishlistData);

    $data = mysqli_fetch_all($result, MYSQLI_ASSOC);
}
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
            color: red;
        }

        .wishBtn {
            color: black !important;
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
    </style>

</head>

<body>
    <!-- Navbar -->
    <div class="container py-5">

        <div class="row mt-4 g-4" id="productList">

            <?php if (!empty($data)) {
                foreach ($data as $key => $value) { ?>
                    <div class="col-lg-3 col-md-6 product">

                        <div class="card h-100 container product-card position-relative">
                            <span class="wishlist">
                                <button type="button" class="border-0 loveBtn bg-light"

                                    onclick="toggleWishlist(this, <?php echo $value['product_id']; ?>)">
                                    <i class="fa fa-heart" name="loveBtn" value="1"></i>
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

                                <p class="card-text"><?php echo $value['description']; ?></p>

                                <div class="d-flex btn-area justify-content-between mb-2">

                                    <?php if ($value['stock'] == 0) { ?>
                                        <a href="user_order.php?id=<?php echo $value['id']; ?>"
                                            class="btn btn-buy bg-danger text-light btn-sm">
                                            Out of Stock
                                        </a>

                                        <button class="btn btn-outline-dark btn-sm fw-bold">
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
                <?php } ?>
            <?php } else { ?>
                <span class="text-center fw-semibold fs-4 text-secondary pt-5">No product in your Wishlist</span>
            <?php } ?>
        </div>
    </div>

    <script src="Assests/js/bootstrap.bundle.min.js"></script>
    <script>
        async function toggleWishlist(btn, productId) {
            try {
                const res = await fetch("wishlistAction.php?product_id=" + productId);
                const data = await res.text();

                // console.log(data);
                if (data === "added") {
                    btn.classList.add("wishBtn");
                    alert("❤️ Product added to wishlist");

                } else if (data === "removed") {
                    btn.classList.remove("loveBtn");
                    alert("❤️ Product removed from wishlist");
                    // window.location.href = "wishlist.php";

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
    </script>
</body>

</html>