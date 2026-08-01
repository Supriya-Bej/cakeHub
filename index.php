<?php
include("db_connect.php");
global $conn;
// session_start();
include('header.php');
$user_id = $_SESSION['user_id'] ?? 0;
$top_order = "SELECT products.*, orders.product_id, reviews.rating AS avg_rating, wishlist.product_id AS wish_pid,
        cart.product_id AS cart_pid, COUNT(orders.product_id) AS total_sell FROM products INNER JOIN orders 
        ON products.id = orders.product_id INNER JOIN reviews ON reviews.product_id = products.id LEFT JOIN wishlist ON
        wishlist.product_id = products.id AND wishlist.user_id = '$user_id' LEFT JOIN cart ON products.id = cart.product_id
        AND cart.user_id = '$user_id' GROUP BY products.id ORDER BY total_sell DESC LIMIT 6";

$run = mysqli_query($conn, $top_order);
$product_data = mysqli_fetch_all($run, MYSQLI_ASSOC);

$cus_review = $cus_review = "SELECT r.*, users.*, r.rating AS avg_rating FROM reviews r
INNER JOIN (SELECT user_id, MAX(created_at) AS latest_time FROM reviews WHERE rating >= 4 GROUP BY user_id) 
latest_review ON latest_review.latest_time = r.created_at JOIN users ON users.id = r.user_id 
ORDER BY r.created_at DESC";

$res = mysqli_query($conn, $cus_review);
$cus_feedback = mysqli_fetch_all($res, MYSQLI_ASSOC);

$banner = "SELECT * FROM banner WHERE status=1";
$banner_run = mysqli_query($conn, $banner);
$banner_data = mysqli_fetch_assoc($banner_run);

function countDetails($table_name)
{
    global $conn;
    $sql = "SELECT COUNT(*) AS total FROM {$table_name}";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($result);

    return $data['total'];
}
$total_orders = countDetails('orders');
$total_products = countDetails('products');
$total_users = countDetails('users');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media.css">

    <!--OWL Carousel -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.theme.default.min.css"
        integrity="sha512-sMXtMNL1zRzolHYKEujM2AqCLUR9F2C4/05cdbxjjLSRvMQIciEPCQZo++nk7go3BtSuK9kfa/s+a4f4i5pLkw=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/assets/owl.carousel.min.css"
        integrity="sha512-tS3S5qG0BlhnQROyJXvNjeEM4UpMXHrQfTGmbQ1gKmelCxlSEBUaxhRBj/EFTzpbP4RVSrpEikbmdJobCvhE3g=="
        crossorigin="anonymous" referrerpolicy="no-referrer" />
    <title>Document</title>
    <style>
        @media (max-width: 1029px) {

            .two,
            .three,
            .one {
                display: none;
            }
        }
        
        #cake1 {
            top: -74%;
            position: absolute;
            width: 100%;
        }

        #cake3 {
            position: absolute;
            width: 100%;
            top: -42%;
        }

        .loveBtn {
            color: black;
        }

        .wishBtn {
            color: red !important;
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


        /* Customer Review */
        .customer_reviews {
            padding: 20px 0;
            background: linear-gradient(135deg, #fff5f7, #fff);
        }

        .review-card {
            border: none;
            border-radius: 24px;
            background: linear-gradient(145deg, #ffffff, #fff7fa);
            padding: 28px;
            position: relative;
            overflow: hidden;
            height: 90%;
            min-height: 280px;
            display: flex;
            flex-direction: column;
            justify-content: space-between;
            box-shadow: 0 10px 30px rgba(255, 77, 136, 0.10);
            transition: 0.3s ease;
        }

        .review-card:hover {
            transform: translateY(-8px);
            box-shadow: 0 18px 45px rgba(255, 77, 136, 0.18);
        }

        /* Quote icon */
        .quote-icon {
            position: absolute;
            top: 18px;
            right: 20px;
            font-size: 40px;
            color: rgba(255, 77, 136, 0.15);
        }

        /* Review text */
        .review-text {
            font-size: 15px;
            color: #555;
            line-height: 1.7;
            margin-bottom: 20px;
            font-family: 'Times New Roman', Times, serif;
            /* font-style: italic; */
        }

        /* bottom layout */
        .customer_box {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 15px;
        }

        /* left user info */
        .customer-left {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .customer-avatar {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            background: linear-gradient(135deg, #ff4d88, #ff8fab);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 18px;
            box-shadow: 0 6px 15px rgba(255, 77, 136, 0.25);
        }

        /* name */
        .customer-name {
            margin: 0;
            font-size: 16px;
            font-weight: 700;
            color: #222;
        }

        /* verified text */
        .verified {
            font-size: 12px;
            color: #28a745;
            font-weight: 600;
        }

        /* rating */
        .rating-box i {
            font-size: 14px;
        }

        .rating-number {
            font-size: 12px;
            color: #444;
            text-align: right;
            margin-top: 2px;
        }

        /* Banner Part */
        .modern-banner {
            position: relative;
            width: 100%;
            height: 700px;
            border-radius: 30px;
            overflow: hidden;
        }

        .modern-banner img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            border-radius: 30px;
        }

        /* Center Content */
        .banner-center-content {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            text-align: center;
            width: 90%;
            max-width: 850px;
            z-index: 2;
        }

        .top-tag {
            display: inline-block;
            background: rgba(247, 181, 218, 0.25);
            backdrop-filter: blur(10px);
            color: #fff;
            padding: 10px 25px;
            border-radius: 50px;
            font-size: 15px;
            font-weight: 600;
            margin-bottom: 25px;
        }

        .banner-center-content h2 {
            font-size: 62px;
            font-weight: 800;
            color: #fff;
            line-height: 1.2;
            margin-bottom: 20px;
            text-shadow: 0 5px 20px rgba(0, 0, 0, 0.25);
        }

        .banner-btn {
            display: inline-block;
            padding: 15px 38px;
            background: #fff;
            color: #ff7b00;
            text-decoration: none;
            border-radius: 50px;
            font-size: 16px;
            font-weight: 700;
            transition: 0.3s;
        }

        .banner-btn:hover {
            background: #ff7b00;
            color: #fff;
            transform: translateY(-3px);
        }

        /* Stats */
        .banner-stats {
            position: absolute;
            bottom: 35px;
            left: 50%;
            transform: translateX(-50%);
            width: 90%;
            display: flex;
            justify-content: center;
            gap: 25px;
            flex-wrap: wrap;
            z-index: 2;
        }

        .single-stat {
            background: rgba(255, 255, 255, 0.95);
            padding: 20px 28px;
            border-radius: 20px;
            display: flex;
            align-items: center;
            gap: 18px;
            min-width: 240px;

            box-shadow: 0 10px 35px rgba(0, 0, 0, 0.08);

            transition: 0.3s;
        }

        .single-stat:hover {
            transform: translateY(-6px);
        }

        .single-stat i {
            width: 58px;
            height: 58px;

            background: #fff2e8;
            color: #ff6b00;

            border-radius: 16px;

            display: flex;
            align-items: center;
            justify-content: center;

            font-size: 22px;
        }

        .single-stat h3 {
            margin: 0;
            font-size: 28px;
            font-weight: 800;
            color: #222;
        }

        .single-stat p {
            margin: 0;
            font-size: 14px;
            color: #666;
        }

        /* ================= FOOTER ================= */
        .footer-logo {
            width: 88px;
            height: 50px;
            object-fit: cover;
            border-radius: 50%;
        }

        .custom_footer {
            background: linear-gradient(135deg, #ff4f81, #ff7eb3, #ffb6c1);
            position: relative;
            overflow: hidden;
            color: white;
        }

        /* top wave effect */
        .custom_footer::before {
            content: "";
            position: absolute;
            top: -60px;
            left: -50px;
            width: 250px;
            height: 250px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        .custom_footer::after {
            content: "";
            position: absolute;
            bottom: -80px;
            right: -50px;
            width: 300px;
            height: 300px;
            background: rgba(255, 255, 255, 0.1);
            border-radius: 50%;
        }

        /* paragraph */
        .footer_text {
            color: #fff5f7;
            line-height: 1.8;
        }

        /* titles */
        .footer_title {
            font-size: 1.3rem;
            margin-bottom: 25px;
            position: relative;
            font-weight: 600;
        }

        .footer_title::after {
            content: "";
            position: absolute;
            left: 0;
            bottom: -8px;
            width: 50px;
            height: 3px;
            background: white;
            border-radius: 10px;
        }

        /* links */
        .footer_links li {
            margin-bottom: 15px;
        }

        .footer_links a {
            color: white;
            text-decoration: none;
            transition: 0.3s;
            position: relative;
        }

        .footer_links a:hover {
            color: #e4b311;
            padding-left: 8px;
        }

        /* contact */
        .footer_contact li {
            margin-bottom: 18px;
            display: flex;
            align-items: center;
            gap: 12px;
        }

        /* services */
        .footer_service {
            background: rgba(255, 255, 255, 0.15);
            padding: 12px 15px;
            border-radius: 12px;
            margin-bottom: 15px;
            backdrop-filter: blur(5px);
            transition: 0.3s;
        }

        .footer_service:hover {
            transform: translateX(8px);
            background: rgba(255, 255, 255, 0.25);
        }

        /* social icons */
        .footer_social a {
            width: 45px;
            height: 45px;
            background: rgba(255, 255, 255, 0.2);
            color: white;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            text-decoration: none;
            font-size: 18px;
            transition: 0.3s;
        }

        .footer_social a:hover {
            background: white;
            color: #ff4f81;
            transform: translateY(-6px) rotate(10deg);
        }

        /* bottom */
        .footer_bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.2);
        }

        .footer_bottom p {
            margin: 0;
            color: #fff;
            letter-spacing: 1px;
        }

        /* Responsive */
        @media(max-width:991px) {

            .modern-banner {
                height: 850px;
            }

            .banner-center-content h2 {
                font-size: 50px;
            }

            .banner-center-content p {
                font-size: 17px;
            }
        }

        @media(max-width:576px) {

            .modern-banner {
                height: 950px;
            }

            .banner-center-content h2 {
                font-size: 34px;
            }

            .banner-center-content p {
                font-size: 15px;
            }

            .single-stat {
                min-width: 100%;
            }
        }


        @media(max-width:768px) {
            .review-card {
                min-height: 280px;
            }

            .review-text {
                min-height: auto;
            }

            .customer_box {
                flex-direction: column;
                align-items: flex-start;
            }
        }
    </style>
</head>

<body style="overflow-x: hidden;">

    <!-- Hero section for Mobile devices -->
    <div id="carouselExampleAutoplaying" class="carousel slide d-block d-lg-none" data-bs-ride="carousel">
        <div class="carousel-inner">
            <div class="carousel-item active">
                <img src="Assests/image/Cake/banner_slider.jpg" class="d-block w-100" alt="...">

            </div>
            <div class="carousel-item">
                <img src="Assests/image/Cake/banner_slider2.jpg" class="d-block w-100" alt="...">
            </div>
            <div class="carousel-item">
                <img src="Assests/image/Cake/banner_slider3.jpg" class="d-block w-100" alt="...">
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExampleAutoplaying" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <!-- Hero Section -->
    <div id="main">

        <div class="one">
            <h1>CAKE</h1>
            <img id="slice" src="Assests/image/Cake/slice-strawberries.png" width="15%" alt="">
            <img id="cake" src="Assests/image/Cake/cake23.png" alt="">
            <img id="cherry" src="Assests/image/Cake/cherry-3.png" alt="">
            <img id="leaf1" src="Assests/image/Cake/leaf-2.webp" alt="">
            <img id="gems" src="Assests/image/Cake/gems.png" alt="">
            <img id="sprinkle" src="Assests/image/Cake/sprinkle3.png" alt="">
            <img id="sprinkle2" src="Assests/image/Cake/sprinkle.png" alt="">

        </div>

        <div class="two">
            <div class="lft-two">
                <svg viewBox="0 0 200 200" xmlns="http://www.w3.org/2000/svg">
                    <path fill="#fff"
                        d="M52.6,-37.1C60.4,-32.2,53.5,-10.8,48.7,11.5C44,33.8,41.3,57,26.8,69.2C12.3,81.4,-14.1,82.7,-36.6,73C-59.1,63.3,-77.9,42.7,-74.5,26C-71.2,9.3,-45.7,-3.5,-29.6,-10.3C-13.5,-17.1,-6.8,-17.9,7.8,-24.2C22.4,-30.4,44.8,-42,52.6,-37.1Z"
                        transform="translate(100 100)" />
                </svg>
            </div>
            <div class="rght-two">
                <h1>Flavour Updated</h1>
                <p>Lorem ipsum, dolor sit amet consectetur adipisicing elit. Magni labore ex sint voluptatum itaque
                    veniam distinctio ut officiis.
                    Hic quaerat architecto illo ipsa ab praesentium error facilis dignissimos placeat? Quis perferendis
                    error reprehenderit itaque
                    obcaecati eaque maiores impedit vel! Dicta, placeat labore maxime atque animi alias impedit
                    accusamus quis provident ullam
                    tempora fuga iure cumque repellendus, Nulla sint minima, ea laboriosam provident alias similique
                    ipsam
                    totam, voluptates quaerat dolorum animi, accusamus amet. Aliquam mollitia, autem accusantium iure
                    doloremque neque. Dolorem?</p>
            </div>
        </div>

        <div class="three">
            <div class="card">

                <img id="cake1" src="Assests/image/Cake/cake21.webp" alt="">
                <h1>Cake</h1>
                <!-- <button class="fw-semibold fs-6 text-light rounded-5 border-0 bg-warning px-4 py-3">BUY Now</button>
                <p></p> -->
            </div>

            <div class="card">
                <h1>Pineapple Cake</h1>
                <!-- <button class="fw-semibold fs-6 text-light rounded-5 border-0 bg-warning px-4 py-3">BUY Now</button>
                <p></p> -->
            </div>

            <div class="card">

                <img id="cake3" src="Assests/image/Cake/cake18.png" alt="">
                <h1>Cake</h1>
                <!-- <button class="fw-semibold fs-6 text-light rounded-5 border-0 bg-warning px-4 py-3">BUY Now</button> -->
            </div>


        </div>
    </div>

    <!-- Product Section -->
    <section class="product_section">
        <div class="container">
            <div class="row">
                <div class="col-sm-12 d-flex align-items-center justify-content-center  sectio-title"
                    style="margin-top: 15vh;">
                    <h2 class="section-title">Top Products 🍒</h2>
                    <!-- <img src="Assests/image/Cake/cherry-3.png" class="img-fluid " alt=""> -->
                </div>
            </div>

            <div class="row g-4">
                <?php if (!empty($product_data)) {

                    foreach ($product_data as $key => $value) {
                ?>

                        <div class="col-lg-4 col-md-6">

                            <div class="card border-0 product-card h-100 position-relative overflow-hidden"
                                style="
                        border-radius: 28px;
                        background: #fff;
                        box-shadow: 0 12px 35px rgba(255, 105, 135, 0.12);
                        transition: 0.4s ease;
                    "
                                onmouseover="this.style.transform='translateY(-10px)'"
                                onmouseout="this.style.transform='translateY(0px)'">

                                <!-- Top Background -->
                                <div style="height: 170px;background: linear-gradient(135deg,#ffe0e9,#fff4f6);
                                border-radius: 0 0 45px 45px; position: relative;">

                                    <!-- Wishlist -->
                                    <?php
                                    if (isset($_SESSION['user_id'])) { ?>
                                        <button style=" position:absolute;top:15px;left:55vh;width:45px;height:45px;
                                            border:none;border-radius:50%; background:white;font-size:18px;
                                            box-shadow:0 5px 15px rgba(0,0,0,0.08);"
                                            class="loveBtn <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                            onclick="toggleWishlist(this, <?php echo $value['id']; ?>)">
                                            <i class="fa-solid fa-heart"></i>
                                        </button>
                                    <?php } else { ?>
                                        <a href="signup.php">
                                            <button style=" position:absolute;top:15px;left:55vh;width:45px;height:45px;
                                            border:none;border-radius:50%; background:white;font-size:18px;
                                            box-shadow:0 5px 15px rgba(0,0,0,0.08);"
                                                class="loveBtn <?php echo !empty($value['wish_pid']) ? 'wishBtn' : ''; ?>"
                                                onclick="toggleWishlist(this, <?php echo $value['id']; ?>)">
                                                <i class="fa-solid fa-heart"></i>
                                            </button>
                                        </a>
                                    <?php } ?>


                                </div>

                                <!-- Product Image -->
                                <div class="text-center position-relative">
                                    <a href="product_details.php?id=<?php echo $value['id']; ?>">
                                        <img src="Assests/image/Cake/<?php echo $value['image']; ?>" class="img-fluid product-img"
                                            style="width:220px;height:220px;object-fit:cover;border-radius:50%;
                                                margin-top:-110px;border:10px solid #fff; box-shadow:0 10px 30px rgba(0,0,0,0.12);
                                                transition:0.5s;"
                                            onmouseover="this.style.transform='scale(1.08)'"
                                            onmouseout="this.style.transform='scale(1)'">
                                    </a>

                                </div>

                                <!-- Card Body -->
                                <div class="card-body text-center px-4 pb-4">

                                    <!-- Cake Name -->
                                    <h3 style="font-size:28px;font-weight:700; color:#ff4d88; margin-top:10px;">
                                        <?php echo $value['name']; ?>
                                    </h3>

                                    <!-- Description -->
                                    <p style="color:#777;font-size:14px;">
                                        <?php echo substr($value['description'], 0, 75); ?>...
                                    </p>

                                    <!-- Rating -->
                                    <div class="mb-3">

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
                                        <span class="fw-semibold ms-2 text-dark">
                                            <?php echo number_format($rating, 1); ?>
                                        </span>

                                    </div>

                                    <!-- Price -->
                                    <h2 style="
                            color:#222;
                            font-weight:800;
                            margin-bottom:25px;
                        ">
                                        ₹<?php echo $value['price']; ?>
                                    </h2>


                                    <!-- Buttons -->
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
                                        <?php }
                                        if (isset($_SESSION['user_id'])) { ?>
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

                                <!-- Bottom Decoration -->
                                <div style="
                        position:absolute;
                        bottom:-40px;
                        right:-40px;
                        width:120px;
                        height:120px;
                        background:#ffe3ec;
                        border-radius:50%;
                    ">
                                </div>

                            </div>

                        </div>

                <?php }
                } ?>
            </div>
            <p id="notify_msg" class="z-3 rounded-3 container"></p>
        </div>
    </section>

    <!-- Brand Story Section -->
    <section class="brand-story mt-4">

        <div class="modern-banner">

            <?php if ($banner_data['status'] == 1) { ?>
                <img src="banner_image/<?php echo $banner_data['banner_image']; ?>" alt="">
            <?php } ?>

            <!-- Center Text -->
            <div class="banner-center-content">

                <span class="top-tag">
                    Fresh & Delicious
                </span>

                <h2>
                    <?php echo $banner_data['title']; ?>
                </h2>

                <a href="product.php" class="banner-btn">
                    Explore Menu
                </a>

            </div>

            <!-- Bottom Floating Stats -->
            <div class="banner-stats">

                <div class="single-stat">
                    <i class="fa-solid fa-bag-shopping"></i>

                    <div>
                        <h3><?= $total_orders; ?>+</h3>
                        <p>Orders</p>
                    </div>
                </div>

                <div class="single-stat">
                    <i class="fa-solid fa-users"></i>

                    <div>
                        <h3><?= $total_users; ?>+</h3>
                        <p>Customers</p>
                    </div>
                </div>

                <div class="single-stat">
                    <i class="fa-solid fa-cake-candles"></i>

                    <div>
                        <h3><?= $total_products; ?>+</h3>
                        <p>Products</p>
                    </div>
                </div>

            </div>

        </div>

    </section>

    <!-- Offer Section -->
    <section class="offer_section my-5 container">

        <div class="row g-4">

            <!-- Offer Card 1 -->
            <div class="col-lg-6">

                <div class="offer-card offer-pink">

                    <div class="offer-content">

                        <span class="offer-tag">
                            Birthday Special 🎉
                        </span>

                        <h2>15% OFF</h2>

                        <p>
                            Make every celebration sweeter with our handcrafted cakes.
                        </p>

                        <div class="coupon-box">
                            CODE: CAKE15
                        </div>

                        <a href="product.php" class="offer-btn">
                            Order Now
                        </a>

                    </div>

                    <div class="offer-image">

                        <img src="Assests/image/Cake/cake-N-2-removebg-preview.png" alt="Cake">

                    </div>

                </div>

            </div>

            <!-- Offer Card 2 -->
            <div class="col-lg-6">

                <div class="offer-card offer-dark">

                    <div class="offer-content">

                        <span class="offer-tag">
                            Weekend Delight 🍰
                        </span>

                        <h2>10% OFF</h2>

                        <p>
                            Treat yourself and your loved ones with premium cakes.
                        </p>

                        <div class="coupon-box">
                            CODE: SWEET10
                        </div>

                        <a href="product.php" class="offer-btn">
                            Shop Now
                        </a>

                    </div>

                    <div class="offer-image">

                        <img src="Assests/image/Cake/NutellaCheesecakeTub-removebg-preview.png" alt="Cake">

                    </div>

                </div>

            </div>

        </div>

    </section>

    <!-- Customer Reviews -->
    <section class="customer_reviews">
        <div class="container">

            <h1 class="text-center py-5 section-title">
                Customer Reviews 😀
            </h1>

            <div class="row">
                <div class="owl-carousel owl-theme">

                    <?php if (!empty($cus_feedback)) {
                        foreach ($cus_feedback as $key => $row) {
                    ?>

                            <div class="item">

                                <div class="card review-card">

                                    <!-- Review Text -->
                                    <p class="review-text fs-5">
                                        "<?php echo $row['feedback']; ?>"
                                    </p>

                                    <!-- Customer -->
                                    <div class="customer_box">

                                        <div class="customer-left">

                                            <!-- Avatar -->
                                            <div class="customer-avatar">
                                                <?php echo strtoupper(substr($row['name'], 0, 1)); ?>
                                            </div>

                                            <!-- Name -->
                                            <div>
                                                <h3 class="customer-name">
                                                    <?php echo $row['name']; ?>
                                                </h3>

                                                <small class="text-muted">
                                                    Verified Customer
                                                </small>
                                            </div>

                                        </div>

                                        <!-- Rating -->
                                        <div class="rating-box">

                                            <?php
                                            $rating = round($row['avg_rating'] ?? 0);

                                            for ($i = 1; $i <= 5; $i++) {

                                                if ($rating >= $i) {

                                                    echo '<i class="fa fa-star text-warning"></i>';
                                                } else {

                                                    echo '<i class="fa fa-star text-secondary"></i>';
                                                }
                                            }
                                            ?>

                                            <div class="rating-number mt-1">
                                                <?php echo number_format($rating, 1); ?>
                                            </div>

                                        </div>

                                    </div>

                                    <!-- Quote Icon -->
                                    <div class="quote-icon">
                                        <i class="fa-solid fa-quote-right"></i>
                                    </div>

                                </div>

                            </div>

                    <?php
                        }
                    } ?>

                </div>
            </div>

        </div>
    </section>

    <!-- FAQ -->
    <div class="container">
        <h1 class="text-center fw-bold">Have Any Question </h1>
        <div class="row mt-5">
            <div class="col-md-6">
                <div class="accordion accordion-flush" id="accordionFlushExample">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseOne" aria-expanded="false"
                                aria-controls="flush-collapseOne">
                                How I can give Order ?
                            </button>
                        </h2>
                        <div id="flush-collapseOne" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">To find a car or bike for your trip, visit our rental platform
                                and enter your pickup location, travel dates, and preferred vehicle type. Browse the
                                available options, compare prices and features, and review eligibility requirements such
                                as age and valid driving license.
                                Once you select a suitable vehicle, complete the booking online and receive instant
                                confirmation.</div>
                        </div>
                    </div>

                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseTwo" aria-expanded="false"
                                aria-controls="flush-collapseTwo">
                                Is delivery become quickly ?
                            </button>
                        </h2>
                        <div id="flush-collapseTwo" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Basic insurance is included with every rental.
                                Additional coverage options may be available at extra cost for better protection.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush-collapseThree" aria-expanded="false"
                                aria-controls="flush-collapseThree">
                                Can I return the cake ?
                            </button>
                        </h2>
                        <div id="flush-collapseThree" class="accordion-collapse collapse"
                            data-bs-parent="#accordionFlushExample">
                            <div class="accordion-body">Late returns may result in additional charges.
                                Please inform us in advance if you expect a delay.</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-6">
                <div class="accordion accordion-flush" id="accordionFlush">
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#flush" aria-expanded="false" aria-controls="flush">
                                Is there need any extra delivery charge ?
                            </button>
                        </h2>
                        <div id="flush" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                            <div class="accordion-body">Fuel is usually not included unless clearly mentioned.
                                Cars are typically provided with a certain fuel level and must be returned with the same
                                level.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseTwo" aria-expanded="false" aria-controls="collapseTwo">
                                Is there a mileage limit ?
                            </button>
                        </h2>
                        <div id="collapseTwo" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                            <div class="accordion-body">Some rentals have a daily mileage limit,
                                while others offer unlimited mileage. This will be clearly shown before booking.</div>
                        </div>
                    </div>
                    <div class="accordion-item">
                        <h2 class="accordion-header">
                            <button class="accordion-button collapsed" type="button" data-bs-toggle="collapse"
                                data-bs-target="#collapseThree" aria-expanded="false" aria-controls="collapseThree">
                                Can I cancel or modify my booking ?
                            </button>
                        </h2>
                        <div id="collapseThree" class="accordion-collapse collapse" data-bs-parent="#accordionFlush">
                            <div class="accordion-body">Yes, bookings can be modified or canceled as per our
                                cancellation policy.
                                Free cancellation may be available if done within the allowed time window.</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Footer -->
    <footer class="custom_footer mt-5">

        <div class="container py-5">

            <div class="row gy-5">

                <!-- Brand Content -->
                <div class="col-lg-4 col-md-6">

                    <a href="index.php" class="navbar-brand m-0">
                        <img src="Assests/image/Cake/logo2.png" class="footer-logo" alt="Sugar Bliss Logo">
                    </a>

                    <p class="footer_text mt-3">
                        Bringing sweetness to every celebration with freshly baked cakes,
                        pastries, and customized special orders made with love.
                    </p>

                    <div class="footer_social d-flex gap-3 mt-4">
                        <a href="">
                            <i class="fa-brands fa-facebook-f"></i>
                        </a>

                        <a href="">
                            <i class="fa-brands fa-x-twitter"></i>
                        </a>

                        <a href="">
                            <i class="fa-brands fa-instagram"></i>
                        </a>

                        <a href="">
                            <i class="fa-brands fa-linkedin-in"></i>
                        </a>
                    </div>
                </div>

                <!-- Quick Links -->
                <div class="col-lg-2 col-md-6">
                    <h4 class="footer_title">Quick Links</h4>

                    <ul class="list-unstyled footer_links">
                        <li><a href="index.php">Home</a></li>
                        <li><a href="about.php">About</a></li>
                        <li><a href="product.php">Products</a></li>
                        <li><a href="">Special Orders</a></li>
                    </ul>
                </div>

                <!-- Contact -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer_title">Contact Us</h4>

                    <ul class="list-unstyled footer_contact">
                        <li>
                            <i class="fa-solid fa-phone"></i>
                            +94 12 3456 769
                        </li>

                        <li>
                            <i class="fa-solid fa-envelope"></i>
                            johncake@gmail.com
                        </li>

                        <li>
                            <i class="fa-solid fa-location-dot"></i>
                            Sweet Street, Cake City
                        </li>
                    </ul>
                </div>

                <!-- Services -->
                <div class="col-lg-3 col-md-6">
                    <h4 class="footer_title">Our Services</h4>

                    <div class="footer_service">
                        <i class="fa-solid fa-truck-fast"></i>
                        Fast Delivery
                    </div>

                    <div class="footer_service">
                        <i class="fa-solid fa-credit-card"></i>
                        Easy Payment
                    </div>

                    <div class="footer_service">
                        <i class="fa-solid fa-headset"></i>
                        24×7 Support
                    </div>
                </div>

            </div>

            <!-- Bottom -->
            <div class="footer_bottom text-center mt-5 pt-4">
                <p>
                    © 2026 All Rights Reserved | Designed By
                    <span class="fw-semibold">Supriya Bej</span>
                </p>
            </div>

        </div>

    </footer>

    <!-- JQUERY cdn Link for OWL Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Bootstrap -->
    <script src="Assests/js/bootstrap.bundle.min.js"></script>

    <!-- OWL Carousel -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/OwlCarousel2/2.3.4/owl.carousel.min.js"></script>

    <script>
        $('.owl-carousel').owlCarousel({
            loop: false,
            margin: 10,
            nav: true,
            responsive: {
                0: {
                    items: 1
                },
                600: {
                    items: 3
                },
                1000: {
                    items: 3
                }
            }
        })
    </script>

    <!-- Gsap -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/gsap.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.13.0/ScrollTrigger.min.js"></script>
    <script src="script.js"></script>

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