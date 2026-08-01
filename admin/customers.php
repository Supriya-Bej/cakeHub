<?php
include("../db_connect.php");
global $conn;
session_start();
include('function.php');

/* PAGINATION */
$limit = 5;

$page = isset($_GET['page']) ? $_GET['page'] : 1;

$start = ($page - 1) * $limit;

/* TOTAL RECORDS */
$total_query = mysqli_query($conn, "SELECT COUNT(*) as total FROM users");
$total_row = mysqli_fetch_assoc($total_query);
$total_records = $total_row['total'];

$total_pages = ceil($total_records / $limit);

/* FETCH USERS */
$query = "SELECT * FROM users ORDER BY id DESC LIMIT $start, $limit";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customers List</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">

    <!-- Fontawesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

    <!-- Google Font -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap"
        rel="stylesheet">

    <style>
        body {
            background: #f5f6fa;
            font-family: 'Poppins', sans-serif;
        }

        .main-content {
            padding: 25px;
        }

        /* HEADER */
        .page-header {
            background: linear-gradient(135deg, #c44569, #8b1e3f);
            padding: 22px 28px;
            border-radius: 18px;
            color: white;
            margin-bottom: 25px;
            box-shadow: 0 10px 25px rgba(196, 69, 105, 0.2);
        }

        .page-header h3 {
            margin: 0;
            font-weight: 600;
        }

        /* CARD */
        .customer-card {
            border: none;
            border-radius: 20px;
            overflow: hidden;
            background: white;
            box-shadow: 0 10px 25px rgba(0,0,0,0.06);
        }

        .card-top {
            background: #fff0f4;
            padding: 18px 25px;
            border-bottom: 1px solid #f1d6de;
        }

        .card-top h4 {
            margin: 0;
            color: #8b1e3f;
            font-weight: 600;
        }

        /* TABLE */
        .table {
            margin-bottom: 0;
        }

        .table thead {
            background: #fff5f7;
        }

        .table thead th {
            border: none;
            color: #8b1e3f;
            font-size: 14px;
            font-weight: 600;
            padding: 18px;
            white-space: nowrap;
        }

        .table tbody td {
            vertical-align: middle;
            padding: 18px;
            border-color: #f3f3f3;
            font-size: 14px;
        }

        .table tbody tr {
            transition: 0.3s;
        }

        .table tbody tr:hover {
            background: #fff8fa;
        }

        /* USER IMAGE */
        .user-img {
            width: 70px;
            height: 70px;
            border-radius: 16px;
            object-fit: cover;
            border: 3px solid #ffe0e8;
        }

        /* ACTION BUTTONS */
        .action-btn {
            width: 38px;
            height: 38px;
            border-radius: 10px;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            text-decoration: none;
            transition: 0.3s;
        }

        .delete-btn {
            background: #ffdde2;
            color: #dc3545;
        }

        .delete-btn:hover {
            background: #dc3545;
            color: white;
            transform: translateY(-2px);
        }

        /* PASSWORD */
        .password-box {
            background: #f8f9fa;
            padding: 8px 12px;
            border-radius: 10px;
            font-size: 13px;
        }

        /* PAGINATION */
        .pagination .page-link {
            border: none;
            margin: 0 4px;
            border-radius: 10px;
            color: #8b1e3f;
            font-weight: 500;
        }

        .pagination .active .page-link {
            background: #c44569;
            color: white;
        }

        .pagination .page-link:hover {
            background: #f8d7df;
            color: #8b1e3f;
        }

        /* MOBILE */
        @media(max-width:768px) {

            .main-content {
                padding: 15px;
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
                background: white;
                border-radius: 16px;
                overflow: hidden;
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
                color: #8b1e3f;
                text-align: left;
            }
        }
    </style>
</head>

<body>

    <?php include("sidebar.php"); ?>

    <div class="col-lg-10 main-content">

        <!-- PAGE HEADER -->
        <div class="page-header d-flex justify-content-between align-items-center flex-wrap">

            <div class="d-flex align-items-center gap-3">

                <button class="btn btn-light d-lg-none"
                    data-bs-toggle="offcanvas"
                    data-bs-target="#mobileMenu">

                    <i class="fa fa-bars"></i>

                </button>

                <div>
                    <h3>
                        <i class="fa fa-users me-2"></i>
                        Customers List
                    </h3>

                    <small class="opacity-75">
                        Manage all registered customers
                    </small>
                </div>

            </div>

        </div>

        <!-- CUSTOMER CARD -->
        <div class="customer-card">

            <div class="card-top d-flex justify-content-between align-items-center">

                <h4>
                    <i class="fa fa-user-group me-2"></i>
                    All Customers
                </h4>

                <span class="badge bg-danger rounded-pill px-3 py-2">
                    Total :
                    <?php echo $total_records; ?>
                </span>

            </div>

            <div class="table-responsive">

                <table class="table align-middle">

                    <thead>
                        <tr>
                            <th>Id</th>
                            <th>Customer</th>
                            <th>Email</th>
                            <th>Password</th>
                            <th>Image</th>
                            <th class="text-center">Action</th>
                        </tr>
                    </thead>

                    <tbody>

                        <?php
                        if (mysqli_num_rows($result) > 0) {

                            $count = $start + 1;

                            while ($row = mysqli_fetch_assoc($result)) {
                        ?>

                                <tr>

                                    <td data-label="Id">
                                        <?php echo $count++; ?>
                                    </td>

                                    <td data-label="Customer">

                                        <div class="fw-semibold">
                                            <?php echo $row['name']; ?>
                                        </div>

                                    </td>

                                    <td data-label="Email">
                                        <?php echo $row['email']; ?>
                                    </td>

                                    <td data-label="Password">

                                        <span class="password-box">
                                            <?php echo $row['password']; ?>
                                        </span>

                                    </td>

                                    <td data-label="Image">

                                        <img class="user-img"
                                            src="<?php echo (!empty($row['image'])
                                                                ? '../image/' . $row['image']
                                                                : '../Assests/image/customers/default_pic.jpg') ?>">

                                    </td>

                                    <td data-label="Action" class="text-center">

                                        <a href="delete_action.php?id=<?php echo $row['id']; ?>&badge=user"
                                            class="action-btn delete-btn"
                                            onclick="return confirm('Are you sure?')">

                                            <i class="fa fa-trash"></i>

                                        </a>

                                    </td>

                                </tr>

                        <?php
                            }
                        }
                        ?>

                    </tbody>

                </table>

            </div>

            <!-- PAGINATION -->
            <div class="d-flex justify-content-center py-4">

                <nav>

                    <ul class="pagination">

                        <?php if ($page > 1) { ?>

                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?php echo $page - 1; ?>">

                                    <i class="fa fa-angle-left"></i>

                                </a>
                            </li>

                        <?php } ?>

                        <?php
                        for ($i = 1; $i <= $total_pages; $i++) {
                        ?>

                            <li class="page-item <?php if ($page == $i) echo 'active'; ?>">

                                <a class="page-link"
                                    href="?page=<?php echo $i; ?>">

                                    <?php echo $i; ?>

                                </a>

                            </li>

                        <?php } ?>

                        <?php if ($page < $total_pages) { ?>

                            <li class="page-item">
                                <a class="page-link"
                                    href="?page=<?php echo $page + 1; ?>">

                                    <i class="fa fa-angle-right"></i>

                                </a>
                            </li>

                        <?php } ?>

                    </ul>

                </nav>

            </div>

        </div>

    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

</body>

</html>