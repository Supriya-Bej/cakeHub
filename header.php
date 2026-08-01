<?php
include('db_connect.php');
global $conn;
session_start();
$userid = $_SESSION['user_id'] ?? 0;
$sql = "SELECT * FROM `users` WHERE id='$userid'";
$result = mysqli_query($conn, $sql);
$data = mysqli_fetch_assoc($result);
if (!$result) {
    echo "Error:" . mysqli_error($conn);
}
$count = "SELECT COUNT(*) AS total FROM `cart` WHERE user_id='$userid'";
$run = mysqli_query($conn, $count);
$cartCount = mysqli_fetch_assoc($run);
?>

<style>
    /* =========================
   RESET ========================= */
    * {
        margin: 0;
        padding: 0;
        box-sizing: border-box;
    }

    /* =========================
   NAVBAR BASE ========================= */
    nav.navbar {
        background: linear-gradient(150deg, rgb(202, 127, 145), rgb(137, 2, 45));
        z-index: 1000;
    }

    /* Search Option */
    .mobile-search {
        flex: 1;
        max-width: 220px;
    }

    .mobile-search input {
        border-radius: 20px;
        border: none;
        font-size: 14px;
        height: 38px;
    }

    @media(min-width:992px) {
        .mobile-search {
            display: none;
        }
    }

    /* =========================
   LOGO ========================= */
    .navbar-logo {
        width: 88px;
        height: 50px;
        object-fit: cover;
        border-radius: 50%;
    }

    /* =========================
   NAV LINKS ========================= */
    .navbar-nav .nav-link {
        color: #fff !important;
        font-weight: 500;
        transition: 0.3s;
    }

    .navbar-nav .nav-link:hover {
        color: #fddbe3 !important;
    }

    /* =========================
   DROPDOWN ========================= */
    .dropdown-menu {
        z-index: 9999;
        border-radius: 8px;
        overflow: hidden;
    }

    .dropdown-item:hover {
        background: #f8f9fa;
        color: rgb(203, 62, 111);
    }

    /* =========================
   SIDEBAR (OFFCANVAS) ========================= */
    .offcanvas.sidebar {
        background: rgba(255, 255, 255, 0.1);
        backdrop-filter: blur(12px);
    }

    /* =========================
   SEARCH BOX ========================= */
    #searchBox {
        min-width: 250px;
        z-index: 1050;
    }

    /* =========================
   CART BADGE ========================= */
    #cartCount {
        font-size: 12px;
        height: 18px;
        min-width: 18px;
        border-radius: 50%;
        background: linear-gradient(135deg, #ff4d6d, #ff758f);
        display: flex;
        align-items: center;
        justify-content: center;
    }

    /* =========================
   PROFILE DP ========================= */
    .dp {
        width: 35px;
        height: 35px;
        border-radius: 50%;
        overflow: hidden;
        cursor: pointer;
    }

    /* =========================
   MOBILE FIXES ========================= */
    @media (max-width: 768px) {
        .navbar-logo {
            width: 40px;
            height: 40px;
        }

        #searchBox {
            right: 10px;
            left: auto;
        }
    }
</style>

<!-- Nav-Bar -->
<nav class="navbar navbar-expand-lg navbar-dark d-flex fixed-top">
    <div class="container-fluid px-5">
        <div class="d-flex d-lg-none align-items-center justify-content-between w-100">

            <!-- Logo -->
            <a href="index.php" class="navbar-brand m-0">
                <img src="Assests/image/Cake/logo2.png" class="navbar-logo" alt="Sugar Bliss Logo">
            </a>

            <!-- Search Box -->
            <form action="product.php" method="GET" class="mobile-search mx-2">

                <input type="text"
                    name="search"
                    class="form-control form-control-sm"
                    placeholder="Search cakes..."
                    value="<?php echo $_GET['search'] ?? ''; ?>">

            </form>

            <!-- Toggle -->
            <button class="navbar-toggler shadow-none border-0"
                type="button"
                data-bs-toggle="offcanvas"
                data-bs-target="#offcanvasNavbar">

                <span class="navbar-toggler-icon"></span>

            </button>

        </div>

        <!-- Desktop Logo -->
        <a href="index.php" class="navbar-brand d-none d-lg-block">
            <img src="Assests/image/Cake/logo2.png" class="navbar-logo" alt="Sugar Bliss Logo">
        </a>

        <div class="sidebar   offcanvas offcanvas-end " tabindex="-1" id="offcanvasNavbar"
            aria-labelledby="offcanvasNavbarLabel">

            <div class="offcanvas-header text-light">
                <a href="index.php" class="offcanvas-title fw-bold" id="offcanvasNavbarLabel">
                    <img src="Assests/image/Cake/logo2.png" class="navbar-logo" alt="Sugar Bliss Logo">
                </a>

                <button type="button" class="btn-close btn-close-white shadow-none border-0"
                    data-bs-dismiss="offcanvas" aria-label="Close">
                </button>
            </div>

            <div class="offcanvas-body d-flex align-items-center flex-column flex-lg-row p-lg-0">

                <div
                    class="navbar-nav justify-content-center align-items-center gap-3 fw-medium fs-6 flex-grow-1 pe-3">

                    <a class="nav-link text-light" href="about.php" role="button">About Us</a>
                    <a class="nav-link text-light" href="product.php" role="button">Products</a>

                    <li class="nav-item dropdown mx-2">

                        <a class="nav-link dropdown-toggle text-light" href="#" role="button"
                            data-bs-toggle="dropdown" aria-expanded="false">
                            Special Orders
                        </a>
                        <ul class="dropdown-menu">
                            <li><a class="dropdown-item fw-semibold" href="">Design Your Own</a></li>
                            <li><a class="dropdown-item fw-semibold" href="product.php">Choose From Collection</a></li>
                        </ul>
                    </li>
                    <a class="nav-link text-light" href="contact.php" role="button">Contact</a>

                </div>

                <!-- Login/Signup -->
                <div class="d-flex flex-column align-items-center flex-lg-row gap-3 fw-medium fs-6 ms-auto">

                    <!-- Search Button -->
                    <button class="btn border-0 text-light"
                        type="button"
                        data-bs-toggle="collapse"
                        data-bs-target="#searchBox">
                        <i class="fa-solid fa-magnifying-glass"></i>
                    </button>

                    <!-- Search Form -->
                    <div class="collapse position-absolute top-100 end-0 mt-2" id="searchBox">

                        <form action="product.php" method="GET" class="d-flex">
                            <input type="text" name="search"
                                value="<?php if (isset($_GET['search'])) {
                                            echo $_GET['search'];
                                        } ?>"
                                class="form-control" placeholder="Search cakes..." required>

                            <button type="submit" class="btn btn-danger ms-2">
                                <i class="fa fa-search"></i>
                            </button>
                        </form>
                    </div>

                    <?php if (isset($_SESSION['user_id'])) { ?>

                        <div style="position: relative; display: inline-block; margin-right: 10px;">
                            <!-- Cart -->
                            <a href="cart.php?user_id=<?php echo $_SESSION['user_id']; ?>"
                                style="font-size: 17px; color: white; text-decoration: none; display: inline-block;">

                                <i class="fa-solid fa-cart-shopping"></i>
                            </a>


                            <?php if ($cartCount['total'] > 0) { ?>
                                <span id="cartCount" min="0" style=" position: absolute; top: -6px; right: -10px; background: linear-gradient(135deg, #ff4d6d, #ff758f);
                                    color: white; font-size: 12px; height: 18px; min-width: 18px; padding: 2px; border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center; font-weight: bold;
                                ">
                                    <?php echo $cartCount['total']; ?>
                                </span>
                            <?php } else { ?>
                                <span id="cartCount" style=" position: absolute; top: -6px; right: -10px; background: linear-gradient(135deg, #ff4d6d, #ff758f);
                                    color: white; font-size: 12px; height: 18px; min-width: 18px; padding: 2px; border-radius: 50%;
                                    display: flex; align-items: center; justify-content: center; font-weight: bold;
                                ">
                                    <?php echo 0 ?>
                                </span>
                            <?php } ?>

                        </div>

                        <!-- Wishlist -->
                        <a href="wishlist.php?user_id=<?php echo $_SESSION['user_id']; ?>">
                            <i class="fa fa-heart text-light "></i>
                        </a>

                        <div class="dropdown">
                            <!-- DP acts as toggle -->
                            <div class="dp bg-light d-flex align-items-center justify-content-center" id="profileDropdown"
                                data-bs-toggle="dropdown" aria-expanded="false" style="cursor:pointer;">

                                <?php if (!empty($data['image'])) { ?>
                                    <img src="image/<?php echo $data['image']; ?>"
                                        class="img-fluid h-100 w-100 object-fit-cover" style="border-radius:50%;">
                                <?php } else { ?>
                                    <h4 class="text-danger m-0 fs-6 fw-semibold">
                                        <?php
                                        $name = $_SESSION['user_name'];
                                        $words = explode(" ", $name);
                                        $first = $words[0][0];
                                        $second = isset($words[1]) ? $words[1][0] : '';
                                        echo strtoupper($first . $second);
                                        ?>
                                    </h4>
                                <?php } ?>
                            </div>
                            <ul class="dropdown-menu dropdown-menu-end">
                                <li><a class="dropdown-item fw-semibold" href="profile.php">Profile</a></li>
                                <li><a class="dropdown-item fw-semibold"
                                        href="user_order_detail.php">Orders</a></li>
                                <li><a class="dropdown-item fw-semibold text-danger" href="logout.php">Logout</a></li>
                            </ul>
                        </div>

                    <?php } else { ?>
                        <a href="signup.php"><button class="fw-semibold border border-none px-3 py-2 rounded"
                                type="button">Sign Up</button></a>
                        <a href="signup.php"><button class="fw-semibold border border-none px-3 py-2 rounded"
                                type="button">Sign In</button></a>
                    <?php } ?>

                </div>
            </div>
        </div>

    </div>
</nav>