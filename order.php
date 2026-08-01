<?php

require("payment/Razorpay.php");

use Razorpay\Api\Api;

$api_key = "rzp_test_SwduJqQoBHlgqj";
$api_secret = "ksb7Mq688TZKQoK13LU4t0DK";

if (!isset($_POST['amount']) || !isset($_POST['method'])) {

    echo json_encode([
        "status" => false,
        "message" => "Invalid Request"
    ]);
    exit;
}

$amount = (float)$_POST['amount'];
$method = $_POST['method'];

$amountInPaise = $amount * 100;

try {

    $api = new Api($api_key, $api_secret);

    $order = $api->order->create([
        'receipt' => 'receipt_' . time(),
        'amount' => $amountInPaise,
        'currency' => 'INR',
        'notes' => [
            'payment_method' => $method
        ]
    ]);
    // print_r($order);

    // Message pass to the user_order.php
    echo json_encode([
        "status" => true,
        "order_id" => $order['id'],
        "amount" => $amountInPaise,
        "method" => $method
    ]);
} catch (Exception $e) {

    echo json_encode([
        "status" => false,
        "message" => $e->getMessage()
    ]);
}
