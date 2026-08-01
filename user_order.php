<?php
include("db_connect.php");
global $conn;

session_start();
$user_id = $_SESSION['user_id'] ?? 0;

if (isset($_GET['id'])) {
    $id = $_GET['id'];
    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $product = mysqli_fetch_assoc($result);
}
$order = "SELECT * FROM orders WHERE user_id='$user_id'";
$runOrder = mysqli_query($conn, $order);
$orderData = mysqli_fetch_assoc($runOrder);

$method = "SELECT * FROM `payment_type`";
$run = mysqli_query($conn, $method);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cake</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <!-- Jquery -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>

    <!-- Payment Gateway of Razorpay -->
    <script src="https://checkout.razorpay.com/v1/checkout.js"></script>

    <style>
        body {
            background: linear-gradient(135deg, #fde2e5, #f8d3e1);
            min-height: 100vh;
        }

        /* MAIN CARD */
        .order-card {
            overflow: hidden;
            display: flex;
            justify-content: center;
        }

        /* RIGHT FORM */
        .form-area {
            background: white;
            padding: 30px;
        }

        /* FLOATING INPUT */
        .form-group {
            position: relative;
            margin-bottom: 20px;
        }

        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            border: none;
            border-bottom: 2px solid #ccc;
            padding: 10px;
            outline: none;
            background: transparent;
        }

        .form-group label {
            position: absolute;
            top: 10px;
            left: 10px;
            color: gray;
            transition: 0.3s;
        }

        .form-group input:focus+label,
        .form-group input:valid+label,
        .form-group textarea:focus+label,
        .form-group textarea:valid+label {
            top: -10px;
            font-size: 12px;
            color: #ff4d91;
        }

        /* BUTTON */
        .btn-order {
            background: linear-gradient(135deg, #ff4d94, #ff75a3);
            border-radius: 50px;
            padding: 12px;
            font-weight: bold;
            transition: 0.3s;
        }

        .btn-order:hover {
            transform: scale(1.05);
        }

        /* Payment button */
        .payment-card {
            cursor: pointer;
            border: 2px solid #eee;
            transition: 0.3s;
            border-radius: 15px;
        }

        .payment-card:hover {
            border-color: #ff4d94;
            transform: translateY(-5px);
            box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
        }

        .payment-card input[type="radio"] {
            transform: scale(1.3);
        }

        /* TOTAL BOX */
        .total-box {
            background: #fff0f5;
            padding: 10px;
            border-radius: 10px;
            text-align: center;
            font-weight: bold;
            color: #700237;
        }
    </style>
</head>

<body>

    <div class="container py-2">
        <div class="row order-card">

            <!-- RIGHT -->
            <div class="col-md-6 form-area">

                <h4 class="mb-4 text-center">Place Your Order ✨</h4>

                <form action="Form_action.php" method="POST" enctype="multipart/form-data">

                    <input type="hidden" name="user_id" value="<?php echo $user_id ?>">
                    <input type="hidden" name="product_ids"
                        value="<?php echo isset($_GET['product_ids']) ? $_GET['product_ids'] : ''; ?>">

                    <input type="hidden" name="product_id"
                        value="<?php echo isset($product['id']) ? $product['id'] : ''; ?>">

                    <input type="hidden" id="price"
                        value="<?php echo isset($product['price']) ? $product['price'] : 0; ?>">

                    <div class="row">

                        <div class="col-md-6 form-group">
                            <input type="text" name="name" value="<?php if (!empty($orderData['username'])) {
                                                                        echo $orderData['username'];
                                                                    } else {
                                                                        echo $_SESSION['user_name'];
                                                                    } ?>" required>
                            <label>Name</label>
                        </div>

                        <div class="col-md-6 form-group">
                            <input type="text" name="phone" value="<?php if (!empty($orderData['phNumber'])) {
                                                                        echo $orderData['phNumber'];
                                                                    } ?>" required>
                            <label>Phone</label>
                        </div>

                        <?php
                        if (!isset($_GET['product_ids'])) { ?>
                            <div class="col-md-6 form-group">
                                <input type="number" min="1" id="qty" name="quantity" oninput="totalAmount()">
                                <label>Quantity (Kg)</label>
                            </div>
                        <?php } ?>

                        <div class="col-md-6 form-group">
                            <input type="date" name="date" min="<?php echo date('Y-m-d'); ?>" required>
                        </div>

                        <div class="col-12 form-group">
                            <textarea name="address"><?php
                                                        if (!empty($orderData['address'])) {
                                                            echo $orderData['address'];
                                                        } ?>
                            </textarea>
                            <label>Delivery Address</label>
                        </div>

                        <div class="col-12 form-group">
                            <input type="text" name="message">
                            <label>Message on Cake</label>
                        </div>

                        <div class="col-12 form-group">
                            <select name="payment_type" id="paymentType" onchange="showMethods()">
                                <?php while ($data = mysqli_fetch_assoc($run)) { ?>
                                    <option value="<?php echo $data['method']; ?>">
                                        <?php echo $data['method']; ?>

                                    </option>
                                <?php } ?>
                            </select>
                        </div>

                        <!-- ONLINE METHODS -->

                        <!-- PAYMENT METHODS -->
                        <div id="onlineMethods" class="mt-3" style="display:none;">

                            <label class="fw-bold mb-2">Choose Payment Method</label>

                            <div class="row g-3">

                                <div class="col-md-4">
                                    <div class="card payment-card h-100">
                                        <div class="card-body text-center">
                                            <input class="form-check-input mb-2"
                                                type="radio"
                                                name="payment_method"
                                                value="UPI"
                                                onchange="showPayButton()">

                                            <h6 class="mb-0">UPI</h6>
                                            <small class="text-muted">Google Pay, PhonePe, Paytm</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card payment-card h-100">
                                        <div class="card-body text-center">
                                            <input class="form-check-input mb-2" type="radio" name="payment_method"
                                                value="Card" onchange="showPayButton()">

                                            <h6 class="mb-0">Debit/Credit Card</h6>
                                            <small class="text-muted">Visa, MasterCard</small>
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-4">
                                    <div class="card payment-card h-100">
                                        <div class="card-body text-center">
                                            <input class="form-check-input mb-2" type="radio" name="payment_method"
                                                value="Net Banking" onchange="showPayButton()">

                                            <h6 class="mb-0">Net Banking</h6>
                                            <small class="text-muted">All Major Banks</small>
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <!-- Hidden price -->
                            <input type="hidden" id="price"
                                value="<?php echo isset($product['price']) ? $product['price'] : 0; ?>">

                            <!-- Pay Button -->
                            <div class="mt-4 text-center" id="payBtnArea" style="display:none;">
                                <button type="button" class="btn btn-success px-5 py-2" id="payNow">
                                    Pay Now ₹<span id="payAmount"></span>
                                </button>
                            </div>

                        </div>

                        <!-- TOTAL -->
                        <?php
                        $totalPrice = 0;

                        if (isset($_GET['price'])) {
                            $totalPrice = $_GET['price'];
                        }
                        ?>

                        <?php if (isset($_GET['product_ids'])) { ?>
                            <div class="col-12 mt-3">
                                <div class="total-box">
                                    Total: ₹ <span id="total"><?php echo $totalPrice; ?></span>
                                </div>
                            </div>
                        <?php } else { ?>
                            <div class="col-12 mt-3">
                                <div class="total-box">
                                    Total: ₹ <span id="total"></span>
                                </div>
                            </div>
                        <?php } ?>

                    </div>

                    <button type="button" class="btn btn-order w-100 mt-3 text-light" name="orderBtn"
                        onclick="order()">
                        Place Order 🚀
                    </button>

                    <p id="notify_msg" class="z-3 rounded-3 container"></p>
                </form>
            </div>
        </div>
    </div>

    <script>
        function totalAmount() {
            let productPrice = document.getElementById("price").value;
            let productQut = document.getElementById("qty").value;
            let total = productPrice * productQut || 0;
            document.getElementById("total").innerText = total;
        }

        // function showMethods() {
        //     let value = document.getElementById("paymentType").value;
        //     let methods = document.getElementById("onlineMethods");

        //     if (value === "Online") {
        //         methods.style.display = "block";
        //     } else {
        //         methods.style.display = "none";
        //     }
        // }

        function showMethods() {

            let value = document.getElementById("paymentType").value;
            let methods = document.getElementById("onlineMethods");
            let payBtn = document.getElementById("payBtnArea");

            if (value === "Online") {
                methods.style.display = "block";
            } else {
                methods.style.display = "none";
                payBtn.style.display = "none";
            }
        }

        function showPayButton() {

            let total =
                document.getElementById("total").innerText || 0;

            document.getElementById("payAmount").innerText = total;

            document.getElementById("payBtnArea").style.display = "block";
        }

        async function order() {

            let form = document.querySelector("form");
            let formData = new FormData(form);

            try {

                const res = await fetch("Form_action.php", {
                    method: "POST",
                    body: formData
                });

                const data = await res.text();

                if (data == "success") {
                    setTimeout(() => {
                        window.location.href = "order_success.php";
                    }, 1500);

                } else if (data == "error") {

                    document.getElementById("notify_msg").innerHTML = `

                <div class="alert alert-danger alert-dismissible fade show" role="alert">

                    <strong>Error!</strong> Order failed.

                    <button type="button"
                        class="btn-close"
                        data-bs-dismiss="alert">
                    </button>

                </div>

                `;

                }

            } catch (error) {
                console.log(error);
            }
        }

        // Payment
        $(document).ready(function() {

            $("#payNow").click(function() {

                let amount = $("#total").text();

                if (amount == "" || amount == 0) {

                    alert("Please enter quantity first");

                    return;
                }

                let method =
                    $("input[name='payment_method']:checked").val();

                if (!method) {
                    alert("Please select payment method");
                    return;
                }

                $.ajax({
                    type: "POST",
                    url: "order.php",
                    data: {
                        amount: amount,
                        method: method
                    },
                    success: function(res) {

                        console.log(res);

                        let data = JSON.parse(res);

                        startPayment(
                            data.order_id,
                            data.amount
                        );

                    }
                });

            });

        });


        function startPayment(order_id, amount) {

            var options = {

                key: "rzp_test_SwduJqQoBHlgqj",

                amount: amount,

                currency: "INR",

                name: "Cake Shop",

                description: "Cake Order",

                order_id: order_id,

                prefill: {
                    name: "<?php echo $orderData['username'] ?? ''; ?>",
                    email: "<?php echo $_SESSION['user_email'] ?? ''; ?>",
                    contact: "<?php echo $orderData['phNumber'] ?? ''; ?>"
                },

                // Transaction success
                handler: function(response) {
                    console.log(response);
                    document.querySelector(".btn-order").click();

                }
            };

            var rzp = new Razorpay(options);

            rzp.open();

            // transaction failure
            rzp.on('payment.failed', function(response) {

                alert(response.error.description);

                console.log(response);
            });
        }
    </script>

</body>

</html>