<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Successful</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">

    <style>
        body{
            min-height:100vh;
            display:flex;
            justify-content:center;
            align-items:center;
            background:linear-gradient(135deg,#ffe6ee,#ffd6e8);
        }

        .success-card{
            background:#fff;
            padding:50px;
            border-radius:25px;
            text-align:center;
            box-shadow:0 15px 40px rgba(0,0,0,.1);
            max-width:600px;
            width:100%;
        }

        .success-icon{
            width:100px;
            height:100px;
            background:#28a745;
            border-radius:50%;
            display:flex;
            justify-content:center;
            align-items:center;
            margin:auto;
            margin-bottom:20px;
        }

        .success-icon i{
            color:#fff;
            font-size:45px;
        }

        .success-title{
            color:#c14277;
            font-weight:700;
        }

        .btn-home{
            background:#c14277;
            color:white;
            padding:12px 30px;
            border-radius:50px;
            text-decoration:none;
        }

        .btn-home:hover{
            background:#a83263;
            color:white;
        }
    </style>
</head>

<body>

    <div class="success-card">

        <div class="success-icon">
            <i class="fa-solid fa-check"></i>
        </div>

        <h2 class="success-title">
            Order Confirmed 🎂
        </h2>

        <p class="text-muted mt-3">
            Thank you for ordering from Sugar Bliss.
            Your order has been placed successfully and
            is now being prepared by our bakers.
        </p>

        <div class="mt-4">
            <a href="user_order_detail.php" class="btn btn-success px-4">
                Track Order
            </a>

            <a href="index.php" class="btn-home ms-2">
                Back Home
            </a>
        </div>

    </div>

</body>
</html>