<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Reports - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

    <style>
        /* Card */
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        .card-custom {
            border: none;
            border-radius: 15px;
            box-shadow: 0 6px 15px rgba(0, 0, 0, 0.06)
        }

        .btn-orange {
            background: #ff8c32;
            color: #fff;
            border: none
        }

        .btn-orange:hover {
            background: #e67620
        }

        .chart-container {
            height: 250px
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
                            <h3 class="mb-0">Reports</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <!-- Filters -->
                    <div class="row g-2 mb-4">
                        <div class="col-6 col-md-3">
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-6 col-md-3">
                            <input type="date" class="form-control">
                        </div>
                        <div class="col-6 col-md-3">
                            <button class="btn btn-orange w-100">Generate</button>
                        </div>
                    </div>

                    <!-- Stats -->
                    <div class="row g-3 mb-4">
                        <div class="col-md-4">
                            <div class="card card-custom p-3 text-center">
                                <h6>Total Orders</h6>
                                <h4>120</h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-custom p-3 text-center">
                                <h6>Total Revenue</h6>
                                <h4>$2500</h4>
                            </div>
                        </div>

                        <div class="col-md-4">
                            <div class="card card-custom p-3 text-center">
                                <h6>Top Product</h6>
                                <h5 class="text-warning">Chocolate Cake</h5>
                            </div>
                        </div>
                    </div>

                    <!-- Charts -->
                    <div class="row g-3">

                        <div class="col-lg-6">
                            <div class="card card-custom p-3">
                                <h6>Sales Overview</h6>
                                <div class="chart-container">
                                    <canvas id="lineChart"></canvas>
                                </div>
                            </div>
                        </div>

                        <div class="col-lg-6">
                            <div class="card card-custom p-3">
                                <h6>Orders Distribution</h6>
                                <div class="chart-container">
                                    <canvas id="pieChart"></canvas>
                                </div>
                            </div>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>


    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

    <script>
        new Chart(document.getElementById('lineChart'), {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun'],
                datasets: [{ data: [100, 200, 150, 300, 250, 400] }]
            }
        });

        new Chart(document.getElementById('pieChart'), {
            type: 'pie',
            data: {
                labels: ['Cake', 'Bread', 'Pastry'],
                datasets: [{ data: [60, 25, 15] }]
            }
        });
    </script>

</body>

</html>