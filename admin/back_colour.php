<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cake Shop</title>

    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">

    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {

            min-height: 100vh;

            background:
                linear-gradient(rgba(40, 20, 10, .55), rgba(40, 20, 10, .55)),
                url("https://images.unsplash.com/photo-1578985545062-69928b1d9587?auto=format&fit=crop&w=1600&q=80");

            background-size: cover;
            background-position: center;
            background-attachment: fixed;

            display: flex;
            justify-content: center;
            align-items: center;

            font-family: Poppins, sans-serif;

        }

        .content {

            width: 90%;
            max-width: 900px;

            background: rgba(255, 255, 255, .15);

            backdrop-filter: blur(15px);

            border-radius: 25px;

            padding: 50px;

            color: white;

            border: 1px solid rgba(255, 255, 255, .2);

            box-shadow: 0 15px 40px rgba(0, 0, 0, .4);

        }

        h1 {

            font-size: 52px;

            font-weight: 700;

            margin-bottom: 20px;

        }

        p {

            font-size: 18px;

            line-height: 1.8;

            color: #f8f8f8;

        }

        .badge-box {

            display: inline-block;

            background: #ffb703;

            color: #222;

            padding: 10px 22px;

            border-radius: 50px;

            margin-bottom: 25px;

            font-weight: bold;

        }

        .btn-custom {

            margin-top: 35px;

            padding: 14px 40px;

            border: none;

            border-radius: 50px;

            background: #ff6b6b;

            color: white;

            font-weight: bold;

            transition: .3s;

        }

        .btn-custom:hover {

            background: #ff4757;

            transform: translateY(-4px);

        }
    </style>

</head>

<body>

    <div class="content">

        <span class="badge-box">
            🍰 Welcome to Cake Shop
        </span>

        <h1>
            Fresh Cakes Made With Love
        </h1>

        <p>

            Every cake tells a story. From birthdays and weddings to special
            celebrations, we create delicious handcrafted cakes using premium
            ingredients. Manage your products easily while enjoying a beautiful
            cake-themed workspace.

        </p>

    </div>

</body>

</html>