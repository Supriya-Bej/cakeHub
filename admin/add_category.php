<?php
include("function.php");
$data = allDetails('categories');
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Category Manager</title>

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: linear-gradient(135deg, #fff0f5, #ffe4ec);
            font-family: 'Segoe UI', sans-serif;
        }

        /* Title */
        .title-main {
            text-align: center;
            font-weight: 700;
            color: #ff4f81;
            margin-bottom: 25px;
        }

        /* Card */
        .card-ui {
            background: rgba(255, 255, 255, 0.7);
            backdrop-filter: blur(12px);
            border-radius: 20px;
            padding: 20px;
            box-shadow: 0 15px 40px rgba(0, 0, 0, 0.1);
        }

        /* Gradient Header */
        .top-bar {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            color: white;
            padding: 10px;
            border-radius: 10px;
            font-weight: 600;
            margin-bottom: 15px;
        }

        /* Input */
        .form-control {
            border-radius: 12px;
        }

        .form-control:focus {
            border-color: #ff4f81;
            box-shadow: 0 0 0 0.15rem rgba(255, 79, 129, 0.25);
        }

        /* Button */
        .btn-main {
            background: #ff4f81;
            color: white;
            border-radius: 12px;
        }

        .btn-main:hover {
            background: #e63b6f;
        }

        /* Table */
        .table thead {
            background: linear-gradient(45deg, #ff4f81, #ff7a18);
            color: white;
        }

        .table tbody tr:hover {
            background: #fff3f7;
        }

        /* Status */
        .status-active {
            background: #28a745;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
        }

        .status-inactive {
            background: #dc3545;
            color: white;
            padding: 5px 12px;
            border-radius: 20px;
        }

        /* Delete Button */
        .btn-delete {
            background: #dc3545;
            color: white;
            padding: 6px 12px;
            border-radius: 8px;
            transition: 0.3s;
        }

        .btn-delete:hover {
            background: #bb2d3b;
            transform: scale(1.1);
        }
    </style>

</head>

<body>

    <div class="container mt-5">

        <h2 class="title-main">✨ Category Manager</h2>

        <div class="row g-4">

            <!-- ADD CATEGORY -->
            <div class="col-md-4">
                <div class="card-ui">
                    <div class="top-bar">➕ Add Category</div>

                    <form action="category_action.php" method="POST">

                        <div class="mb-3">
                            <label>Category Name</label>
                            <input type="text" name="name" class="form-control" required>
                        </div>

                        <!-- Toggle Switch -->
                        <div class="form-check form-switch mb-3">
                            <input class="form-check-input" type="checkbox" name="status" value="1" checked>
                            <label class="form-check-label">Active</label>
                        </div>

                        <button type="submit" name="addCategory" class="btn btn-main w-100">
                            Add Category
                        </button>

                    </form>
                </div>
            </div>

            <!-- CATEGORY TABLE -->
            <div class="col-md-8">
                <div class="card-ui">
                    <div class="top-bar">📋 Category List</div>

                    <div class="table-responsive">
                        <table class="table align-middle text-center">
                            <thead>
                                <tr>
                                    <th>ID</th>
                                    <th>Name</th>
                                    <th>Status</th>
                                    <th>Action</th>
                                </tr>
                            </thead>

                            <tbody>
                                <?php if (!empty($data)) {
                                    foreach ($data as $value) { ?>

                                        <tr>
                                            <td><?php echo $value['id']; ?></td>

                                            <td class="fw-semibold">
                                                <!-- <i class="fa fa-tag text-primary"></i> -->
                                                <?php echo $value['name']; ?>
                                            </td>

                                            <td>
                                                <?php if ($value['status'] == 1) { ?>
                                                    <span class="status-active">Active</span>
                                                <?php } else { ?>
                                                    <span class="status-inactive">Inactive</span>
                                                <?php } ?>
                                            </td>

                                            <td>
                                                <a href="category_action.php?delete_id=<?php echo $value['id']; ?>" style="text-decoration:none;">
                                                    <span class="btn-delete" onclick="return confirm('Do you want to Delete this category ?')">
                                                        🗑 Delete
                                                    </span>
                                                </a>
                                            </td>
                                        </tr>

                                <?php }
                                } ?>
                            </tbody>

                        </table>
                    </div>

                </div>
            </div>

        </div>

    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>

</body>

</html>