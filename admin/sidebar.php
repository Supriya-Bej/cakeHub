<?php
include("../db_connect.php");
global $conn;
// session_start();
$sql = "SELECT * FROM `admin`";
$run = mysqli_query($conn, $sql);

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bakery Admin Dashboard</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        body {
            background: #f8f5f2;
            font-family: 'Poppins', sans-serif;
        }

        /* SIDEBAR */
        .sidebar {
            background: linear-gradient(180deg, #8b1e3f, #c44569);
            color: white;
            padding: 25px 18px;
            min-height: 100vh;
            box-shadow: 4px 0 20px rgba(0, 0, 0, 0.08);
            
        }


        /* LOGO / PROFILE */
        .sidebar img {
            width: 85px !important;
            height: 85px;
            object-fit: cover;
            border-radius: 50%;
            border: 2px solid rgba(11, 211, 71, 0.3);
            padding: 3px;
            background: green;
            margin-bottom: 12px;
        }

        .sidebar h3 {
            margin-top: 10px;
            font-size: 18px;
            color: #fff;
        }

        .sidebar p {
            color: #f8d7df;
            margin-bottom: 30px;
        }

        /* MENU LINKS */
        .sidebar a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 14px 16px;
            margin-bottom: 12px;
            color: #fff;
            text-decoration: none;
            border-radius: 14px;
            font-size: 15px;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        /* ICON */
        .sidebar a i {
            width: 22px;
            text-align: center;
            font-size: 16px;
        }

        /* HOVER EFFECT */
        .sidebar a:hover {
            background: rgba(255, 255, 255, 0.18);
            transform: translateX(6px);
        }

        /* ACTIVE MENU */
        .sidebar a.active {
            background: white;
            color: #8b1e3f;
            box-shadow: 0 8px 18px rgba(0, 0, 0, 0.12);
        }

        .sidebar a.active i {
            color: #8b1e3f;
        }

        /* LOGOUT BUTTON */
        .logout-btn {
            background: rgba(255, 255, 255, 0.18);
            border: 1px solid rgba(255, 255, 255, 0.2);
            margin-top: 40px;
            justify-content: center;
            font-weight: 600;
        }

        .logout-btn:hover {
            background: white !important;
            color: #8b1e3f !important;
        }

        /* MOBILE */
        .offcanvas {
            width: 270px !important;
        }

        .offcanvas-header {
            background: #8b1e3f;
            color: white;
        }

        .offcanvas .sidebar {
            min-height: 100%;
            border-radius: 0;
        }

        /* RESPONSIVE */
        @media(max-width:768px) {

            .sidebar {
                padding: 20px 15px;
            }

            .sidebar a {
                padding: 12px 14px;
                font-size: 14px;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <!-- Sidebar Desktop -->
            <!-- Sidebar Desktop -->
            <div class="col-lg-2 d-none d-lg-block sidebar">

                <div class="d-flex flex-column align-items-center justify-content-center text-center">

                    <?php while ($row = mysqli_fetch_assoc($run)) { ?>

                        <img src="../Assests/image/customers/<?php echo $row['image']; ?>"
                            name="image" alt="">

                    <?php } ?>

                    <h3 class="fw-bold">
                        <?php echo $_SESSION['admin_name']; ?>
                    </h3>

                    <p class="fw-medium small">
                        <?php echo $_SESSION['admin_email']; ?>
                    </p>

                </div>

                <a href="dashboard.php" class="active">
                    <i class="fa fa-home"></i>
                    Dashboard
                </a>

                <a href="customers.php">
                    <i class="fa fa-users"></i>
                    Customers
                </a>

                <a href="products.php">
                    <i class="fa fa-box"></i>
                    Products
                </a>

                <a href="order.php">
                    <i class="fa fa-shopping-cart"></i>
                    Orders
                </a>

                <a href="report.php">
                    <i class="fa fa-chart-line"></i>
                    Reports
                </a>

                <a href="staffList.php">
                    <i class="fa fa-user-cog"></i>
                    Staff
                </a>

                <a href="logout.php" class="logout-btn d-flex">
                    <i class="fa fa-sign-out-alt"></i>
                    Logout
                </a>

            </div>




            <!-- MOBILE SIDEBAR (FIXED) -->
            <!-- MOBILE SIDEBAR -->
            <div class="offcanvas offcanvas-start" tabindex="-1" id="mobileMenu">

                <div class="offcanvas-header">
                    <h5 class="offcanvas-title fw-bold">Bakery Admin</h5>

                    <button type="button"
                        class="btn-close btn-close-white"
                        data-bs-dismiss="offcanvas"></button>
                </div>

                <div class="offcanvas-body sidebar">

                    <a href="dashboard.php">
                        <i class="fa fa-home"></i>
                        Dashboard
                    </a>

                    <a href="customers.php">
                        <i class="fa fa-users"></i>
                        Customers
                    </a>

                    <a href="products.php">
                        <i class="fa fa-box"></i>
                        Products
                    </a>

                    <a href="order.php">
                        <i class="fa fa-shopping-cart"></i>
                        Orders
                    </a>

                    <a href="report.php">
                        <i class="fa fa-chart-line"></i>
                        Reports
                    </a>

                    <a href="staffList.php">
                        <i class="fa fa-user-cog"></i>
                        Staff
                    </a>

                    <a href="logout.php" class="logout-btn d-flex">
                        <i class="fa fa-sign-out-alt"></i>
                        Logout
                    </a>

                </div>

            </div>

            <script src="../Assests/js/bootstrap.bundle.min.js"></script>



</body>

</html>