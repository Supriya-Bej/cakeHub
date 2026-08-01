<?php
include('../db_connect.php');
global $conn;
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login</title>

    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            min-height: 100vh;
            background: linear-gradient(135deg, #f8d7e3, #fce4ec, #f3c6d8);
            display: flex;
            justify-content: center;
            align-items: center;
            font-family: Arial, Helvetica, sans-serif;
        }

        .login-container {
            width: 100%;
            max-width: 430px;
            padding: 20px;
        }

        .login-card {
            background: #fff;
            border-radius: 25px;
            padding: 40px 35px;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.12);
        }

        .login-icon {
            width: 85px;
            height: 85px;
            background: #ff5c8d;
            color: white;
            font-size: 35px;
            border-radius: 50%;
            display: flex;
            justify-content: center;
            align-items: center;
            margin: auto;
            margin-bottom: 20px;
        }

        .title {
            text-align: center;
            font-weight: bold;
            color: #333;
            margin-bottom: 5px;
        }

        .subtitle {
            text-align: center;
            color: gray;
            margin-bottom: 30px;
            font-size: 15px;
        }

        .form-label {
            font-weight: 600;
            color: #444;
        }

        .form-control {
            height: 48px;
            border-radius: 12px;
            border: 1px solid #ccc;
            padding-left: 15px;
            transition: 0.3s;
        }

        .form-control:focus {
            border-color: #ff5c8d;
            box-shadow: 0 0 8px rgba(255, 92, 141, 0.3);
        }

        .login-btn {
            width: 100%;
            height: 48px;
            border: none;
            border-radius: 12px;
            background: #ff5c8d;
            color: white;
            font-weight: 600;
            font-size: 17px;
            transition: 0.3s;
        }

        .login-btn:hover {
            background: #e64b7d;
        }

        .input-group-text {
            border-radius: 12px 0 0 12px;
            background-color: #fff;
            border-right: none;
        }

        .input-group .form-control {
            border-left: none;
        }

        @media(max-width: 500px) {
            .login-card {
                padding: 30px 20px;
            }
        }
    </style>
</head>

<body>

    <div class="login-container">
        <div class="login-card">

            <div class="login-icon">
                <i class="fa-solid fa-user-shield"></i>
            </div>

            <h2 class="title">Admin Login</h2>
            <p class="subtitle">Welcome back! Please login to continue.</p>

            <form action="common_action.php" method="POST" enctype="multipart/form-data">

                <!-- Email -->
                <div class="mb-4">
                    <label class="form-label">Email Address</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-envelope"></i>
                        </span>

                        <input type="email"
                            name="email"
                            class="form-control"
                            placeholder="Enter your email"
                            required>
                    </div>
                </div>

                <!-- Password -->
                <div class="mb-4">
                    <label class="form-label">Password</label>

                    <div class="input-group">
                        <span class="input-group-text">
                            <i class="fa-solid fa-lock"></i>
                        </span>

                        <input type="password"
                            name="password"
                            class="form-control"
                            placeholder="Enter your password"
                            required>
                    </div>
                </div>

                <!-- Button -->
                <button type="submit"
                    name="adminLoginBtn"
                    value="login"
                    class="login-btn">
                    Login
                </button>

            </form>
        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

</body>

</html>