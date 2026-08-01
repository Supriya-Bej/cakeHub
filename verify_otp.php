<?php
session_start();

if (!isset($_SESSION['otp'])) {
    header("Location: signup.php");
    exit();
}

if (isset($_POST['verify'])) {

    $userOtp = $_POST['otp'];

    if ($userOtp == $_SESSION['otp']) {

        include("db_connect.php");
        global $conn;

        $name = $_SESSION['temp_name'];
        $email = $_SESSION['temp_email'];
        $password = $_SESSION['temp_password'];
        $image = $_SESSION['temp_image'];

        $insert = "INSERT INTO users(name,email,password,image,email_verified)VALUES('$name','$email','$password',
                    '$image',1)";
        mysqli_query($conn, $insert);

        $_SESSION['user_id'] = mysqli_insert_id($conn);
        $_SESSION['user_name'] = $name;
        $_SESSION['user_email'] = $email;

        unset($_SESSION['otp']);
        header("Location:index.php");
        exit();
    } else {
        echo "<script>alert('Invalid OTP');</script>";
    }
}
?>

<!DOCTYPE html>
<html>

<head>
    <title>Verify OTP</title>
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
</head>

<body>

    <div class="container mt-5">

        <div class="card p-4">

            <h3>Email Verification</h3>

            <form method="POST">
                <input type="text" name="otp" class="form-control mb-3" placeholder="Enter OTP">
                <button type="submit" name="verify" class="btn btn-danger">
                    Verify OTP
                </button>
            </form>

        </div>

    </div>

</body>

</html>