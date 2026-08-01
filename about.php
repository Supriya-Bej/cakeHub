<?php
include("db_connect.php");
global $conn;

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
$total_users = countDetails('users');
$rating = "SELECT AVG(rating) AS avg_rating FROM reviews";
$run = mysqli_query($conn, $rating);
$data = mysqli_fetch_assoc($run);
$avg_rating = round($data['avg_rating'], 1);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>CakeHub About</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <style>
        /* ================= GLOBAL ================= */
        body {
            margin: 0;
            font-family: "Segoe UI", sans-serif;
            overflow-x: hidden;
            color: #222;
        }

        /* ================= PARALLAX BASE ================= */
        .parallax {
            height: 100vh;
            background-attachment: fixed;
            background-position: center;
            background-size: cover;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }

        /* dark overlay */
        .parallax::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.45);
        }

        /* content */
        .parallax-content {
            position: relative;
            z-index: 2;
            color: #fff;
            text-align: center;
            max-width: 800px;
            padding: 20px;
        }

        .parallax-content h1 {
            font-size: 3.5rem;
            font-weight: 800;
        }

        .parallax-content p {
            font-size: 1.2rem;
            opacity: 0.9;
        }

        /* ================= NORMAL SECTION ================= */
        .section {
            padding: 90px 0;
        }

        .title {
            font-weight: 800;
            margin-bottom: 20px;
            color: #2b1b1b;
        }

        /* ================= CARDS ================= */
        .feature-card {
            background: #fff;
            border-radius: 16px;
            padding: 25px;
            text-align: center;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            transition: 0.3s;
        }

        .feature-card:hover {
            transform: translateY(-6px);
        }

        .feature-card i {
            font-size: 30px;
            color: #ff4d88;
            margin-bottom: 10px;
        }

        /* ================= CTA ================= */
        .cta {
            background: linear-gradient(135deg, #ff4d88, #ff7eb3);
            color: white;
            text-align: center;
            padding: 80px 20px;
        }

        .btn-custom {
            background: white;
            color: #ff4d88;
            padding: 12px 30px;
            border: none;
            border-radius: 30px;
            font-weight: 600;
        }
    </style>

</head>

<body>

    <?php include("header.php"); ?>

    <!-- ================= HERO PARALLAX ================= -->
    <section class="parallax" style="background-image:url('Assests/image/Cake/cake21.webp');">
        <div class="parallax-content">
            <h1>We Bake Happiness 🍰</h1>
            <p>Premium handcrafted cakes made for your special moments</p>
        </div>
    </section>

    <!-- ================= ABOUT ================= -->
    <section class="section">
        <div class="container">
            <div class="row align-items-center g-5">

                <div class="col-md-6">
                    <img src="Assests/image/Cake/butterfly.png" class="img-fluid rounded shadow">
                </div>

                <div class="col-md-6">
                    <h2 class="title">Who We Are</h2>
                    <p>
                        Sugar Bliss is a premium bakery brand focused on crafting fresh, handmade cakes
                        with love and perfection. Every cake is designed to make your celebrations memorable.
                    </p>

                    <p>
                        We combine creativity, quality ingredients, and passion to deliver happiness in every bite.
                    </p>
                </div>

            </div>
        </div>
    </section>

    <!-- ================= SECOND PARALLAX ================= -->
    <section class="parallax" style="background-image:url('Assests/image/Cake/cake18.png');">
        <div class="parallax-content">
            <h1>Every Cake Tells a Story 🎂</h1>
            <p>From birthdays to weddings — we design emotions, not just desserts</p>
        </div>
    </section>

    <!-- ================= FEATURES ================= -->
    <section class="section">
        <div class="container">

            <h2 class="text-center title">Why Choose Sugar Bliss</h2>

            <div class="row g-4 mt-4">

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-cake-candles"></i>
                        <h5>Fresh Baking</h5>
                        <p>Made fresh daily with premium ingredients</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-truck"></i>
                        <h5>Fast Delivery</h5>
                        <p>On-time delivery for your special moments</p>
                    </div>
                </div>

                <div class="col-md-4">
                    <div class="feature-card">
                        <i class="fa-solid fa-heart"></i>
                        <h5>Made with Love</h5>
                        <p>Every cake crafted with emotional care</p>
                    </div>
                </div>

            </div>

        </div>
    </section>

    <!-- ================= THIRD PARALLAX ================= -->
    <section class="parallax" style="background-image:url('Assests/image/Cake/cake23.png');">
        <div class="parallax-content">
            <h1>Sweet Moments, Perfect Memories ❤️</h1>
            <p>We don’t just deliver cakes — we deliver joy</p>
        </div>
    </section>

    <!-- ================= STATS ================= -->
    <section class="section">
        <div class="container text-center">

            <h2 class="title">Our Growth</h2>

            <div class="row mt-5">

                <div class="col-md-3">
                    <h1 class="fw-bold text-danger"><?php echo $total_users ?>+</h1>
                    <p>Happy Customers</p>
                </div>

                <div class="col-md-3">
                    <h1 class="fw-bold text-danger"><?php echo $total_orders ?>+</h1>
                    <p>Cakes Delivered</p>
                </div>

                <div class="col-md-3">
                    <h1 class="fw-bold text-danger"><?= $avg_rating ?>⭐</h1>
                    <p>Customer Rating</p>
                </div>

                <div class="col-md-3">
                    <h1 class="fw-bold text-danger">24/7</h1>
                    <p>Support</p>
                </div>

            </div>

        </div>
    </section>

    <!-- ================= CTA ================= -->
    <section class="cta">
        <h2>Ready to Celebrate with Sugar Bliss?</h2>
        <p>Let’s make your moment unforgettable</p>

        <a href="product.php">
            <button class="btn-custom mt-3">Order Now</button>
        </a>
    </section>

    <script src="Assests/js/bootstrap.bundle.min.js"></script>
</body>

</html>