<?php
include("../db_connect.php");
global $conn;
include("function.php");
include("count_function.php");
session_start();

if (!isset($_SESSION['admmin_id'])) {
    header("Location:login.php");
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Messages</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">

    <!-- Fontawesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f6f7fb;
            font-family: 'Poppins', sans-serif;
        }

        .message-wrapper {
            padding: 40px 20px;
        }

        .message-card {
            border: none;
            border-radius: 22px;
            overflow: hidden;
            background: #fff;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.07);
        }

        .message-header {
            background: linear-gradient(135deg, #c44569, #8b1e3f);
            padding: 22px 30px;
            color: white;
        }

        .message-header h3 {
            margin: 0;
            font-size: 24px;
            font-weight: 600;
        }

        .message-header p {
            margin: 4px 0 0;
            opacity: 0.85;
            font-size: 14px;
        }

        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #fff0f4;
        }

        .table thead th {
            border: none;
            color: #8b1e3f;
            font-size: 14px;
            font-weight: 600;
            padding: 18px;
            white-space: nowrap;
        }

        .table tbody tr {
            transition: 0.3s;
            border-bottom: 1px solid #f1f1f1;
        }

        .table tbody tr:hover {
            background: #fff7f9;
            transform: scale(1.005);
        }

        .table tbody td {
            padding: 18px;
            vertical-align: middle;
            font-size: 14px;
            color: #555;
        }

        .user-box {
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .user-icon {
            width: 45px;
            height: 45px;
            border-radius: 50%;
            background: linear-gradient(135deg, #d991a3, #b76e79);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 16px;
        }

        .subject-badge {
            background: #ffe4ec;
            color: #b03052;
            padding: 7px 14px;
            border-radius: 30px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }

        .message-text {
            max-width: 320px;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
        }

        .time-box {
            color: #888;
            font-size: 13px;
            white-space: nowrap;
        }

        .empty-box {
            padding: 60px 20px;
            text-align: center;
        }

        .empty-box i {
            font-size: 60px;
            color: #d991a3;
            margin-bottom: 15px;
        }

        .empty-box h4 {
            color: #8b1e3f;
            font-weight: 600;
        }

        @media(max-width:768px) {

            .message-header {
                text-align: center;
            }

            .table thead {
                display: none;
            }

            .table,
            .table tbody,
            .table tr,
            .table td {
                display: block;
                width: 100%;
            }

            .table tr {
                margin-bottom: 20px;
                border-radius: 16px;
                overflow: hidden;
                background: white;
                box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            }

            .table td {
                text-align: right;
                padding-left: 50%;
                position: relative;
                border: none;
            }

            .table td::before {
                content: attr(data-label);
                position: absolute;
                left: 18px;
                width: 45%;
                font-weight: 600;
                text-align: left;
                color: #8b1e3f;
            }

            .message-text {
                max-width: 100%;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid message-wrapper">

        <div class="message-card">

            <!-- Header -->
            <div class="message-header d-flex justify-content-between align-items-center flex-wrap">

                <div>
                    <h3>
                        <i class="fa-solid fa-envelope-circle-check me-2"></i>
                        Recent Messages
                    </h3>

                    <p>Manage and view all customer messages</p>
                </div>

                <div class="mt-3 mt-md-0">

                    <span class="badge bg-light text-dark px-4 py-3 rounded-pill fs-6">
                        Total :
                        <?php
                        $count = countDetails('contact');
                        echo $count;
                        ?>
                    </span>

                </div>

            </div>

            <!-- Table -->
            <div class="card-body table-responsive p-0">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Subject</th>
                            <th>Message</th>
                            <th>Time</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        $data = allDetails('contact');

                        if (!empty($data)) {

                            foreach ($data as $value) {
                        ?>

                                <tr>

                                    <td data-label="Customer">

                                        <div class="user-box">

                                            <div class="user-icon">
                                                <i class="fa fa-user"></i>
                                            </div>

                                            <div>
                                                <div class="fw-semibold">
                                                    <?= $value['name']; ?>
                                                </div>
                                            </div>

                                        </div>

                                    </td>

                                    <td data-label="Email">
                                        <?= $value['email']; ?>
                                    </td>

                                    <td data-label="Subject">

                                        <span class="subject-badge">
                                            <?= $value['subject']; ?>
                                        </span>

                                    </td>

                                    <td data-label="Message">

                                        <div class="message-text">
                                            <?= $value['message']; ?>
                                        </div>

                                    </td>

                                    <td data-label="Time">

                                        <div class="time-box">
                                            <i class="fa-regular fa-clock me-1"></i>
                                            <?= $value['time']; ?>
                                        </div>

                                    </td>

                                </tr>

                        <?php
                            }
                        } else {
                        ?>

                            <tr>
                                <td colspan="5">

                                    <div class="empty-box">

                                        <i class="fa-regular fa-envelope-open"></i>

                                        <h4>No Messages Found</h4>

                                        <p class="text-muted">
                                            Customer messages will appear here.
                                        </p>

                                    </div>

                                </td>
                            </tr>

                        <?php } ?>

                    </tbody>

                </table>

            </div>

        </div>

    </div>

</body>

</html>