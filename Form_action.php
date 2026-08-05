<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('db_connect.php');
include("admin/back_colour.php");
global $conn;
session_start();


// Signup
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['register'])) {

    include("mail.php");

    $name = mysqli_real_escape_string($conn, $_POST['userName']);
    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = $_POST['Password'];

    $image = $_FILES['img']['name'];
    $temp_name = $_FILES['img']['tmp_name'];
    $upload = "image/" . $image;

    if (!empty($image)) {
        move_uploaded_file($temp_name, $upload);
    }

    // Check email already exists
    $checkEmail = "SELECT * FROM users WHERE email='$email'";
    $check = mysqli_query($conn, $checkEmail);

    if (mysqli_num_rows($check) > 0) {

        echo "
        <script>
        Swal.fire({
            icon: 'warning',
            title: 'Email Already Exists',
            text: 'Please login or use another email.',
            confirmButtonColor: '#ff6b81',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href = 'signup.php';
        });
        </script>";

        exit();
    }

    // Generate OTP
    $otp = rand(100000, 999999);

    $_SESSION['otp'] = $otp;
    $_SESSION['temp_name'] = $name;
    $_SESSION['temp_email'] = $email;
    $_SESSION['temp_password'] = $password;
    $_SESSION['temp_image'] = $image;

    // Send OTP
    if (sendOTP($email, $otp)) {

        header("Location: verify_otp.php");
        exit();
    } else {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'OTP Failed',
            text: 'Unable to send OTP. Please try again.',
            confirmButtonColor: '#dc3545',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href = 'signup.php';
        });
        </script>";

        exit();
    }
}

// Login
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['login'])) {

    $email = mysqli_real_escape_string($conn, $_POST['Email']);
    $password = $_POST['Password'];

    $check = "SELECT * FROM users WHERE email='$email'";
    $run = mysqli_query($conn, $check);

    if (mysqli_num_rows($run) > 0) {

        $data = mysqli_fetch_assoc($run);

        // Email Verification Check
        if ($data['email_verified'] == 0) {

            echo "
            <script>
            Swal.fire({
                icon: 'warning',
                title: 'Email Not Verified',
                text: 'Please verify your email first.',
                confirmButtonColor: '#ff6b81',
                background: '#fffaf7',
                color: '#5d4037'
            }).then(() => {
                window.location.href='signup.php';
            });
            </script>";

            exit();
        }

        // Password Check
        if ($data['password'] == $password) {

            $_SESSION['user_id'] = $data['id'];
            $_SESSION['user_name'] = $data['name'];
            $_SESSION['user_email'] = $data['email'];
            $_SESSION['user_password'] = $data['password'];
            $_SESSION['user_image'] = $data['image'];

            header("Location:index.php");
            exit();

        } else {

            echo "
            <script>
            Swal.fire({
                icon: 'error',
                title: 'Login Failed',
                text: 'Incorrect password. Please try again.',
                confirmButtonColor: '#ff6b81',
                background: '#fffaf7',
                color: '#5d4037'
            }).then(() => {
                window.location.href='signup.php';
            });
            </script>";

            exit();
        }

    } else {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Email Not Found',
            text: 'Please sign up first or enter the correct email.',
            confirmButtonColor: '#ff6b81',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href='signup.php';
        });
        </script>";

        exit();
    }
}

// Update Profile
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['updateProfile'])) {

    $user_id = $_SESSION['user_id'];

    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);

    $image = $_FILES['image']['name'];
    $tempname = $_FILES['image']['tmp_name'];
    $store = "image/" . $image;

    // Get old image
    $old = mysqli_fetch_assoc(mysqli_query($conn, "SELECT image FROM users WHERE id='$user_id'"));
    $old_image = $old['image'];

    if (!empty($image)) {

        if (!empty($old_image) && file_exists("image/" . $old_image)) {
            unlink("image/" . $old_image);
        }

        move_uploaded_file($tempname, $store);

        $update = "UPDATE users
                   SET name='$name',
                       email='$email',
                       image='$image'
                   WHERE id='$user_id'";

    } else {

        $update = "UPDATE users
                   SET name='$name',
                       email='$email'
                   WHERE id='$user_id'";
    }

    $result = mysqli_query($conn, $update);

    if ($result) {

        // Update session values
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        if (!empty($image)) {
            $_SESSION['user_image'] = $image;
        }

        echo "
        <script>
        Swal.fire({
            icon: 'success',
            title: 'Profile Updated!',
            text: 'Your profile has been updated successfully.',
            confirmButtonColor: '#ff6b81',
            background: '#fffaf7',
            color: '#5d4037'
        }).then(() => {
            window.location.href = 'profile.php';
        });
        </script>";

        exit();

    } else {

        echo "
        <script>
        Swal.fire({
            icon: 'error',
            title: 'Update Failed!',
            text: 'Something went wrong. Please try again.',
            confirmButtonColor: '#dc3545',
            background: '#fffaf7',
            color: '#5d4037'
        });
        </script>";

        exit();
    }
}

// Insert into order table
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['user_id'])) {

    $user_id = $_POST['user_id'];
    $userName = $_POST['name'];
    $userPhone = $_POST['phone'];
    $date = $_POST['date'];
    $address = $_POST['address'];
    $message = $_POST['message'];
    $payment = $_POST['payment_type'];

    // =========================
    // MULTIPLE PRODUCT ORDER
    // =========================

    if (!empty($_POST['product_ids'])) {

        $product_ids = explode(",", $_POST['product_ids']);

        foreach ($product_ids as $product_id) {
            $product_id = trim($product_id);

            // GET PRODUCT PRICE
            $sql = "SELECT * FROM products WHERE id='$product_id'";
            $result = mysqli_query($conn, $sql);
            $product = mysqli_fetch_assoc($result);
            $product_stock = $product['stock'];

            // CART QUANTITY
            $cartQuery = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
            $cartRun = mysqli_query($conn, $cartQuery);
            $cartData = mysqli_fetch_assoc($cartRun);
            $quantity = $cartData['quantity'];
            $update_stock = $product_stock - $quantity;

            // TOTAL PRICE
            $totalPrice = $product['price'] * $quantity;

            // INSERT ORDER
            $insert = "INSERT INTO orders(user_id, username, phNumber, product_id, quantity, price, order_date, 
            address, message, payment_type, status) VALUES ('$user_id','$userName','$userPhone','$product_id',
            '$quantity','$totalPrice','$date','$address','$message','$payment','Pending')";

            $run = mysqli_query($conn, $insert);
            if ($run) {
                $update1 = "UPDATE `products` SET `stock`='$update_stock' WHERE id = '$product_id'";
                $res1 = mysqli_query($conn, $update1);
            }

            // REMOVE FROM CART
            mysqli_query($conn, "DELETE FROM cart 
            WHERE user_id='$user_id' 
            AND product_id='$product_id'");
        }

        echo "success";
    }

    // SINGLE PRODUCT ORDER
    else {

        $product_id = $_POST['product_id'];
        $userQuantity = $_POST['quantity'];
        $sql = "SELECT * FROM products WHERE id='$product_id'";
        $result = mysqli_query($conn, $sql);
        $product = mysqli_fetch_assoc($result);
        $product_stock = $product['stock'];
        $update_stock = $product_stock - $userQuantity;

        $totalPrice = $product['price'] * $userQuantity;

        $insert = "INSERT INTO orders(user_id, username, phNumber, product_id, quantity, price, order_date, address, message, payment_type, status)
        VALUES('$user_id','$userName','$userPhone','$product_id','$userQuantity','$totalPrice','$date','$address','$message','$payment','Pending')";

        $run = mysqli_query($conn, $insert);

        if ($run) {
            $update = "UPDATE `products` SET `stock`='$update_stock' WHERE id = '$product_id'";
            $res = mysqli_query($conn, $update);
            echo "success";
        } else {

            echo "error";
        }
    }
}

// Cancel product
$user_id = $_SESSION['user_id'];
if (isset($_GET['product_id'])) {
    $productId = $_GET['product_id'];
    $order = "SELECT * FROM orders WHERE user_id = '$user_id' AND product_id = '$productId'";
    $runOrder = mysqli_query($conn, $order);
    $status = $_GET['value'];

    $updateOrder = "UPDATE `orders` SET `status`='$status' WHERE user_id = '$user_id' AND product_id = '$productId'";
    $runUpdateOrder = mysqli_query($conn, $updateOrder);
    if ($runUpdateOrder) {
        echo "cancel";
        header("Location:user_order_detail.php");
    } else {
        echo "error";
    }
}
