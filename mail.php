<?php

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

require 'vendor/PHPMailer/src/Exception.php';
require 'vendor/PHPMailer/src/PHPMailer.php';
require 'vendor/PHPMailer/src/SMTP.php';

function sendOTP($email, $otp)
{

    $mail = new PHPMailer(true);

    $mail->isSMTP();

    $mail->Host = 'smtp.gmail.com';
    $mail->SMTPAuth = true;

    $mail->Username = 'cclmsexam@gmail.com'; // Your Gmail
    $mail->Password = 'fbjf yyre sfah kguq'; // Gmail App Password

    $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
    $mail->Port = 587;

    $mail->setFrom('cclmsexam@gmail.com', 'Sugar Bliss');

    $mail->addAddress($email);

    $mail->isHTML(true);

    $mail->Subject = "Email Verification OTP";

    $mail->Body = "
        <h2>Welcome to Sugar Bliss</h2>
        <p>Your OTP is:</p>
        <h1>$otp</h1>
        <p>Valid for 5 minutes.</p>
    ";

    return $mail->send();
}
