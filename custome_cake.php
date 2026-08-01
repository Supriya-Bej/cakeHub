<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customize Cake</title>

    <!-- Bootstrap -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.2/css/all.min.css">

    <style>
        body {
            background: #fff7fa;
            font-family: sans-serif;
        }

        /* Top Header */
        .top_heading {
            background: #ffe6f0;
            border-radius: 15px;
            padding: 25px;
        }

        .top_heading h2 {
            color: #e91e63;
            font-weight: 700;
        }

        /* Sidebar */
        .step_sidebar {
            background: white;
            border-radius: 15px;
            padding: 20px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
        }

        .step_item {
            display: flex;
            gap: 15px;
            margin-bottom: 25px;
        }

        .step_number {
            width: 35px;
            height: 35px;
            background: #ffe0eb;
            color: #e91e63;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-weight: bold;
        }

        /* Main Card */
        .custom_card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
        }

        /* Option Box */
        .option_box {
            border: 2px solid #f1d3df;
            border-radius: 12px;
            padding: 15px;
            text-align: center;
            cursor: pointer;
            transition: .3s;
            height: 100%;
        }

        .option_box img {
            width: 100%;
            height: 90px;
            object-fit: contain;
        }

        .option_box:hover,
        .active_box {
            border-color: #e91e63;
            background: #fff0f5;
        }

        /* Shape Box */
        .shape_box {
            border: 2px solid #f1d3df;
            border-radius: 10px;
            padding: 15px;
            text-align: center;
            transition: .3s;
        }

        .shape_box:hover {
            border-color: #e91e63;
            background: #fff0f5;
        }

        /* Toppings */
        .topping_box {
            border: 1px solid #f3c8d8;
            border-radius: 10px;
            padding: 12px;
            background: #fff8fb;
        }

        /* Upload */
        .upload_box {
            border: 2px dashed #f3a5c2;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            background: #fff9fc;
        }

        /* Preview */
        .preview_card {
            background: white;
            border-radius: 15px;
            padding: 25px;
            box-shadow: 0 2px 10px rgba(0, 0, 0, 0.05);
            position: sticky;
            top: 20px;
        }

        .preview_card img {
            width: 100%;
            border-radius: 15px;
        }

        /* Summary */
        .summary_row {
            display: flex;
            justify-content: space-between;
            margin-bottom: 12px;
        }

        .price_total {
            color: #e91e63;
            font-size: 30px;
            font-weight: bold;
        }

        /* Buttons */
        .btn_pink {
            background: #e91e63;
            color: white;
            border: none;
            padding: 12px;
            border-radius: 10px;
            transition: .3s;
        }

        .btn_pink:hover {
            background: #d81b60;
        }

        .btn_outline {
            border: 2px solid #e91e63;
            color: #e91e63;
            padding: 12px;
            border-radius: 10px;
            background: transparent;
            transition: .3s;
        }

        .btn_outline:hover {
            background: #e91e63;
            color: white;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <!-- Top Banner -->
        <div class="top_heading mb-4 d-flex justify-content-between align-items-center flex-wrap">
            <div>
                <h2>Customize Your Cake</h2>
                <p class="mb-0">Design your perfect cake for any occasion</p>
            </div>

            <div class="bg-white px-4 py-2 rounded-pill">
                🌱 100% Eggless Available
            </div>
        </div>

        <div class="row g-4">

            <!-- Sidebar -->
            <div class="col-lg-2">
                <div class="step_sidebar">

                    <div class="step_item">
                        <div class="step_number">1</div>
                        <div>
                            <h6>Cake Type</h6>
                            <small>Choose cake type</small>
                        </div>
                    </div>

                    <div class="step_item">
                        <div class="step_number">2</div>
                        <div>
                            <h6>Size</h6>
                            <small>Select cake size</small>
                        </div>
                    </div>

                    <div class="step_item">
                        <div class="step_number">3</div>
                        <div>
                            <h6>Flavor</h6>
                            <small>Choose flavor</small>
                        </div>
                    </div>

                    <div class="step_item">
                        <div class="step_number">4</div>
                        <div>
                            <h6>Toppings</h6>
                            <small>Add toppings</small>
                        </div>
                    </div>

                </div>
            </div>

            <!-- Main Content -->
            <div class="col-lg-7">

                <div class="custom_card">

                    <!-- Cake Type -->
                    <h4 class="mb-4">1. Choose Cake Type</h4>

                    <div class="row g-3 mb-5">

                        <div class="col-md-3">
                            <div class="option_box active_box">
                                <img src="cake1.png">
                                <h6>Chocolate</h6>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box">
                                <img src="cake2.png">
                                <h6>Vanilla</h6>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box">
                                <img src="cake3.png">
                                <h6>Red Velvet</h6>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box">
                                <img src="cake4.png">
                                <h6>Fruit Cake</h6>
                            </div>
                        </div>

                    </div>

                    <!-- Cake Size -->
                    <h4 class="mb-4">2. Select Size</h4>

                    <div class="row g-3 mb-5">

                        <div class="col-md-3">
                            <div class="option_box">
                                <h5>500g</h5>
                                <p>₹499</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box active_box">
                                <h5>1kg</h5>
                                <p>₹899</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box">
                                <h5>2kg</h5>
                                <p>₹1599</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="option_box">
                                <h5>3kg</h5>
                                <p>₹2199</p>
                            </div>
                        </div>

                    </div>

                    <!-- Flavor -->
                    <h4 class="mb-4">3. Choose Flavor</h4>

                    <div class="d-flex gap-3 flex-wrap mb-5">

                        <button class="btn btn-outline-danger active">Chocolate</button>
                        <button class="btn btn-outline-danger">Strawberry</button>
                        <button class="btn btn-outline-danger">Butterscotch</button>
                        <button class="btn btn-outline-danger">Pineapple</button>

                    </div>

                    <!-- Shape -->
                    <h4 class="mb-4">4. Pick Shape</h4>

                    <div class="row g-3 mb-5">

                        <div class="col-md-3">
                            <div class="shape_box">
                                ⭕
                                <p class="mt-2 mb-0">Round</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="shape_box">
                                ❤️
                                <p class="mt-2 mb-0">Heart</p>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="shape_box">
                                ◼️
                                <p class="mt-2 mb-0">Square</p>
                            </div>
                        </div>

                    </div>

                    <!-- Toppings -->
                    <h4 class="mb-4">5. Add Toppings</h4>

                    <div class="row g-3 mb-5">

                        <div class="col-md-4">
                            <div class="topping_box">
                                <input type="checkbox"> Choco Chips (+₹50)
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="topping_box">
                                <input type="checkbox"> Fruits (+₹80)
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="topping_box">
                                <input type="checkbox"> Oreo (+₹60)
                            </div>
                        </div>

                    </div>

                    <!-- Upload -->
                    <h4 class="mb-4">6. Upload Image</h4>

                    <div class="upload_box mb-5">
                        <i class="fa-solid fa-cloud-arrow-up fs-1 text-danger"></i>
                        <p class="mt-3">Click to Upload Image</p>
                    </div>

                    <!-- Message -->
                    <h4 class="mb-4">7. Cake Message</h4>

                    <textarea class="form-control mb-5" rows="4"
                        placeholder="Write your message..."></textarea>

                    <!-- Delivery -->
                    <h4 class="mb-4">8. Delivery Date & Time</h4>

                    <div class="row g-3 mb-5">

                        <div class="col-md-6">
                            <input type="date" class="form-control">
                        </div>

                        <div class="col-md-6">
                            <select class="form-select">
                                <option>10AM - 12PM</option>
                                <option>1PM - 3PM</option>
                                <option>4PM - 6PM</option>
                            </select>
                        </div>

                    </div>

                    <!-- Buttons -->
                    <div class="d-flex gap-3">

                        <button class="btn_outline w-100">
                            Reset
                        </button>

                        <button class="btn_pink w-100">
                            Preview & Continue
                        </button>

                    </div>

                </div>

            </div>

            <!-- Right Preview -->
            <div class="col-lg-3">

                <div class="preview_card">

                    <h4 class="mb-4 text-center">Preview Your Cake</h4>

                    <img src="cake-preview.jpg">

                    <hr>

                    <h5 class="mb-4">Order Summary</h5>

                    <div class="summary_row">
                        <span>Cake Type</span>
                        <strong>₹899</strong>
                    </div>

                    <div class="summary_row">
                        <span>Toppings</span>
                        <strong>₹130</strong>
                    </div>

                    <div class="summary_row">
                        <span>Delivery</span>
                        <strong>₹50</strong>
                    </div>

                    <hr>

                    <div class="summary_row">
                        <h5>Total</h5>
                        <div class="price_total">₹1,279</div>
                    </div>

                    <button class="btn_pink w-100 mt-3">
                        <i class="fa-solid fa-cart-shopping"></i>
                        Add To Cart
                    </button>

                    <button class="btn_outline w-100 mt-3">
                        Buy Now
                    </button>

                </div>

            </div>

        </div>

    </div>

</body>

</html>