<?php
include("header.php");
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <!-- <link rel="stylesheet" href="header.css"> -->
    <link rel="stylesheet" href="media.css">
    <style>
        /* HERO */
        .hero_img {
            height: 55vh;
            background:
                linear-gradient(rgba(132, 130, 130, 0.7),
                    rgba(121, 109, 109, 0.7)),
                url("Assests/image/Cake/about.jpg");
            background-size: cover;
            background-position: center;
        }

        /* LEFT SIDE */
        .contact_left_box {
            background: #fff;
            border-radius: 35px;
            padding: 40px;
            box-shadow: 0 15px 45px rgba(255, 77, 136, 0.12);
        }

        .contact_tag {
            background: #ffe5ee;
            color: #ff4d88;
            padding: 10px 18px;
            border-radius: 30px;
            font-weight: 600;
            font-size: 14px;
        }

        .circle_one {
            position: absolute;
            width: 180px;
            height: 180px;
            background: #ffe5ee;
            border-radius: 50%;
            top: -60px;
            right: -60px;
        }

        .circle_two {
            position: absolute;
            width: 120px;
            height: 120px;
            background: #fff0f5;
            border-radius: 50%;
            bottom: -30px;
            left: -30px;
        }

        /* CONTACT CARD */
        .contact_card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            background: #fff7fa;
            padding: 18px 20px;
            border-radius: 20px;
            transition: 0.4s ease;
            border: 1px solid transparent;
        }

        .contact_card:hover {
            transform: translateY(-5px);
            background: #fff;
            border-color: #ffb6ca;
            box-shadow: 0 10px 25px rgba(255, 77, 136, 0.12);
        }

        .icon_box {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, #ff4d88, #ff7ca8);
            border-radius: 18px;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 22px;
        }

        .whatsapp {
            background: linear-gradient(135deg, #22c55e, #16a34a);
        }

        .email {
            background: linear-gradient(135deg, #7c3aed, #9333ea);
        }

        .contact_card h5 {
            margin: 0;
            font-weight: 700;
        }

        .contact_card p {
            margin: 0;
            color: gray;
        }

        .arrow_icon {
            color: #ff4d88;
            font-size: 18px;
        }

        /* MAP */
        .map iframe {
            width: 100%;
            height: 250px;
            border-radius: 25px;
        }

        /* RIGHT FORM */
        .contact_form_box {
            background: white;
            padding: 45px;
            border-radius: 35px;
            box-shadow: 0 15px 45px rgba(0, 0, 0, 0.08);
        }

        .custom_input {
            border-radius: 15px;
            padding: 14px 18px;
            border: 1px solid #eee;
            background: #fafafa;
        }

        .custom_input:focus {
            box-shadow: none;
            border-color: #ff4d88;
            background: #fff;
        }

        .send_btn {
            background: linear-gradient(135deg, #ff4d88, #ff7ca8);
            border: none;
            color: white;
            padding: 14px 35px;
            border-radius: 15px;
            font-weight: 600;
            transition: 0.4s ease;
        }

        .send_btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(255, 77, 136, 0.3);
        }

        /* MOBILE */
        @media(max-width:768px) {

            .hero_img p {
                width: 90% !important;
            }

            .contact_left_box,
            .contact_form_box {
                padding: 25px;
            }

        }
    </style>
</head>

<body style="background-color: #f5e7ec;">


    <!-- Body Part -->
    <section class="contact_body_part ">
    </section>

    <!-- Contact Us Page -->
    <!-- Contact Us Page -->
    <section class="contact_section">

        <!-- Hero -->
        <!-- <div class="hero_img d-flex flex-column align-items-center justify-content-center text-center">
            <h1 class="fw-bold text-white display-4">Contact Us</h1>
            <p class="w-50 text-white fw-medium">
                We would love to hear from you. Connect with us anytime for orders,
                support, or custom cake enquiries.
            </p>
        </div> -->

        <!-- Wave -->
        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320">
            <path fill="#fff" fill-opacity="1"
                d="M0,256L48,240C96,224,192,192,288,176C384,160,480,160,576,170.7C672,181,768,203,864,208C960,213,1056,203,1152,176C1248,149,1344,107,1392,85.3L1440,64L1440,0L0,0Z">
            </path>
        </svg>

        <div class="contact_main pb-5">

            <section class="contact_us container">

                <div class="row g-5 align-items-start">

                    <!-- LEFT SIDE -->
                    <div class="col-lg-5">

                        <!-- Fancy Contact Card -->
                        <div class="contact_left_box position-relative overflow-hidden">

                            <!-- Background Circle -->
                            <div class="circle_one"></div>
                            <div class="circle_two"></div>

                            <div class="position-relative z-1">

                                <span class="contact_tag">Let's Talk ✨</span>

                                <h2 class="fw-bold mt-3 mb-3">
                                    Get closer with our sweet bakery team
                                </h2>

                                <p class="text-muted mb-4">
                                    Whether you want custom cakes, birthday orders,
                                    or quick delivery support — we are always here for you.
                                </p>

                                <!-- Contact Cards -->
                                <div class="d-flex flex-column gap-4">

                                    <!-- Phone -->
                                    <a href="tel:+9153079959"
                                        class="contact_card text-decoration-none text-dark">

                                        <div class="icon_box">
                                            <i class="fa-solid fa-phone"></i>
                                        </div>

                                        <div>
                                            <h5>Call Us</h5>
                                            <p>+91 53079959</p>
                                        </div>

                                        <i class="fa-solid fa-arrow-right arrow_icon"></i>

                                    </a>

                                    <!-- WhatsApp -->
                                    <a href="https://wa.me/9153079959" target="_blank"
                                        class="contact_card text-decoration-none text-dark">

                                        <div class="icon_box whatsapp">
                                            <i class="fa-brands fa-whatsapp"></i>
                                        </div>

                                        <div>
                                            <h5>Whatsapp</h5>
                                            <p>Chat with us instantly</p>
                                        </div>

                                        <i class="fa-solid fa-arrow-right arrow_icon"></i>

                                    </a>

                                    <!-- Email -->
                                    <a href="mailto:supriyabej95@gmail.com"
                                        class="contact_card text-decoration-none text-dark">

                                        <div class="icon_box email">
                                            <i class="fa-solid fa-envelope"></i>
                                        </div>

                                        <div>
                                            <h5>Email Us</h5>
                                            <p>support@yoursite.com</p>
                                        </div>

                                        <i class="fa-solid fa-arrow-right arrow_icon"></i>

                                    </a>

                                </div>

                                <!-- Map -->
                                <div class="map mt-5">
                                    <iframe
                                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d59281.25162104794!2d87.70866250346903!3d21.777233254561605!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x3a0326e5394d8237%3A0x7bb6b4d525857f71!2sContai%2C%20West%20Bengal!5e0!3m2!1sen!2sin!4v1761114242956!5m2!1sen!2sin"
                                        style="border:0;"
                                        allowfullscreen=""
                                        loading="lazy">
                                    </iframe>
                                </div>

                            </div>
                        </div>
                    </div>

                    <!-- RIGHT SIDE -->
                    <div class="col-lg-7">

                        <div class="contact_form_box">

                            <h2 class="fw-bold mb-2">Send Message 💌</h2>

                            <p class="text-muted mb-4">
                                Fill out the form below and we’ll contact you shortly.
                            </p>

                            <form method="POST" action="contact_action.php">

                                <div class="row">

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            Full Name
                                        </label>

                                        <input type="text"
                                            name="name"
                                            class="form-control custom_input"
                                            placeholder="Enter your name">
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <label class="form-label fw-semibold">
                                            Email
                                        </label>

                                        <input type="email"
                                            name="email"
                                            class="form-control custom_input"
                                            placeholder="Enter your email">
                                    </div>

                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Subject
                                    </label>

                                    <input type="text"
                                        name="subject"
                                        class="form-control custom_input"
                                        placeholder="Enter subject">
                                </div>

                                <div class="mb-4">
                                    <label class="form-label fw-semibold">
                                        Message
                                    </label>

                                    <textarea class="form-control custom_input"
                                        name="message"
                                        rows="5"
                                        placeholder="Write your message..."></textarea>
                                </div>

                                <button type="submit"
                                    name="sendMessage"
                                    class="send_btn">
                                    Send Message
                                    <i class="fa-solid fa-paper-plane ms-2"></i>
                                </button>

                            </form>

                        </div>

                    </div>

                </div>
            </section>
        </div>
    </section>

    <script src="script.js"></script>
    <script src="Assests/js/bootstrap.bundle.min.js"></script>
</body>

</html>