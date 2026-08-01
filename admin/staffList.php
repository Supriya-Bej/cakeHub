<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Manage Staff - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        .search-box {
            border-radius: 30px
        }

        .table thead {
            background: #f1eee8
        }

        .status-badge {
            padding: 6px 12px;
            border-radius: 20px;
            font-size: 13px
        }

        .active-status {
            background: #d4edda;
            color: #28a745
        }

        .inactive-status {
            background: #f8d7da;
            color: #dc3545
        }

        .action-btn {
            border: none;
            background: #ffe5c2;
            color: #ff8c32;
            border-radius: 8px;
            padding: 5px 8px
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

            <?php include("sidebar.php") ?>

            <!-- Main -->
            <div class="col-lg-10 mt-3">

                <div class="main-card">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas"
                                data-bs-target="#mobileMenu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <h3 class="mb-0">List Staff</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <!-- Controls -->
                    <div class="row g-2 mb-3">
                        <div class="col-12 col-md-5">
                            <div class="input-group">
                                <span class="input-group-text"><i class="fa fa-search"></i></span>
                                <input type="text" class="form-control search-box" placeholder="Search Staff">
                            </div>
                        </div>

                        <div class="col-6 col-md-3">
                            <select class="form-select">
                                <option>Role</option>
                                <option>Admin</option>
                                <option>Staff</option>
                            </select>
                        </div>

                        <div class="col-6 col-md-3 ms-auto  bg-warning">
                            <a href="addStaff.php"><button class="btn text-dark w-100">+ Add Staff</button></a>
                        </div>
                    </div>

                    <!-- Table -->
                    <div class="table-responsive">
                        <table class="table align-middle">
                            <thead>
                                <tr>
                                    <th>Name</th>
                                    <th>Email</th>
                                    <th>Role</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Omkar Deshamne</td>
                                    <td>omkardeshmane832@gmail.com</td>
                                    <td>Admin</td>
                                    <td><span class="status-badge active-status">Active</span></td>
                                    <td>
                                        <a href="editStaff.php"><button class="action-btn me-2"><i class="fa fa-edit"></i></button></a>
                                        <button class="action-btn"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Omkar Deshamne</td>
                                    <td>omkardeshmane832@gmail.com</td>
                                    <td>Staff</td>
                                    <td><span class="status-badge active-status">Active</span></td>
                                    <td>
                                        <a href="editStaff.php"><button class="action-btn me-2"><i class="fa fa-edit"></i></button></a>
                                        <button class="action-btn"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                                <tr>
                                    <td>Omkar Deshamne</td>
                                    <td>omkardeshmane832@gmail.com</td>
                                    <td>Staff</td>
                                    <td><span class="status-badge inactive-status">De-Active</span></td>
                                    <td>
                                        <a href="editStaff.php"><button class="action-btn me-2"><i class="fa fa-edit"></i></button></a>
                                        <button class="action-btn"><i class="fa fa-trash"></i></button>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

</html>