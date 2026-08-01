<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <link rel="stylesheet" href="media.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
</head>

<body class="sign_up_body">
    <!-- MAKE A Login -->

    <div class="main">
        <div class="curved-shape animation"></div>
        <div class="curved-shape2"></div>

        <!-- Login -->
        <div class="form-box Login">
            <h2 class="animation" style="--D:0; --S:21">Login</h2>
            <form action="Form_action.php" method="POST" enctype="multipart/form-data">
                <div class="input-box animation" style="--D:1; --S:22">
                    <input type="email" name="Email" required>
                    <label for="" class="fw-semibold">Email</label>
                    <i class="fa-solid fa-user"></i>
                </div>

                <div class="input-box animation" style="--D:2; --S:23">
                    <input type="password" name="Password" required>
                    <label for="" class="fw-semibold">Password</label>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="input-box animation" style="--D:3; --S:24">
                    <button class="btn" type="submit" name="login">Login</button>
                </div>

                <div class="regi-link animation" style="--D:4; --S:25">
                    <p class="fw-medium">Don't have any account ? <a href="#" class="signUpLink">Sign Up</a></p>
                    <a href="#"><i class="fa-brands fa-google"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                </div>
            </form>
        </div>

        <div class="info-content Login text-light">
            <h2 class="animation" style="--D:0; --S:20">WELCOME BACK!</h2>
            <!-- <p class="animation" style="--D:1; --S:21">Lorem ipsum dolor sit amet.</p> -->
        </div>

        <!-- Register -->
        <div class="form-box Register">
            <h2 class="animation" style="--li:17;  --S:0;">Register</h2>
            <form action="Form_action.php" method="POST" enctype="multipart/form-data">
                <div class="input-box animation" style="--li:18; --S:1;">
                    <input type="text" name="userName" required>
                    <label for="" class="fw-semibold">Name</label>
                    <i class="fa-solid fa-user"></i>
                </div>
                <div class="input-box animation" style="--li:19; --S:2;">
                    <input type="email" name="Email" required>
                    <label for="" class="fw-semibold">Email</label>
                    <i class="fa-solid fa-envelope"></i>
                </div>
                <div class="input-box animation" style="--li:19; --S:2;">
                    <input type="password" name="Password" required>
                    <label for="" class="fw-semibold">Password</label>
                    <i class="fa-solid fa-lock"></i>
                </div>

                <div class="input-box animation" style="--li:19; --S:2;">
                    <input type="file" name="img">
                </div>

                <div class="input-box animation" style="--li:20; --S:3;">
                    <button class="btn" type="submit" name="register">Register</button>
                </div>

                <div class="regi-link animation" style="--li:21; --S:4;">
                    <p class="fw-medium">Don't have any account ? <a href="#" class="signInLink">Sign In</a></p>
                    <a href="#"><i class="fa-brands fa-google"></i></a>
                    <a href="#"><i class="fa-brands fa-facebook-f"></i></a>
                </div>

            </form>
        </div>

        <div class="info-content Register text-light">
            <h2 class="animation" style="--li:17; --S:0;">WELCOME BACK!</h2>
            <!-- <p class="animation" style="--li:18; --S:1;">Lorem ipsum dolor sit amet.</p> -->
        </div>
    </div>

    <script src="signup.js"></script>
    <script src="Assests/js/bootstrap.bundle.min.js"></script>
</body>

</html>