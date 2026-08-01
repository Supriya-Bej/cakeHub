<?php
include("../db_connect.php");
global $conn;

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
    <title>Add Banner</title>

    <!-- Bootstrap -->
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">

    <!-- Font Awesome -->
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

    <style>
        body {
            background: #f5f6fa;
            font-family: 'Segoe UI', sans-serif;
        }

        .banner-card {
            border: none;
            border-radius: 25px;
            overflow: hidden;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
            background: white;
        }

        .banner-header {
            background: linear-gradient(135deg, #d991a3, #b76e79);
            padding: 30px;
            color: white;
        }

        .banner-header h2 {
            font-weight: 700;
            margin-bottom: 5px;
        }

        .banner-body {
            padding: 40px;
        }

        .form-label {
            font-weight: 600;
            margin-bottom: 10px;
            color: #444;
        }

        .form-control,
        .form-select {
            height: 52px;
            border-radius: 14px;
            border: 1px solid #ddd;
            padding-left: 15px;
            box-shadow: none !important;
        }

        .form-control:focus,
        .form-select:focus {
            border-color: #d991a3;
        }

        .upload-box {
            border: 2px dashed #d991a3;
            border-radius: 20px;
            padding: 40px;
            text-align: center;
            background: #fff7f9;
            transition: 0.3s;
        }

        .upload-box:hover {
            background: #fff0f4;
        }

        .upload-icon {
            font-size: 60px;
            color: #d991a3;
            margin-bottom: 15px;
        }

        .btn-banner {
            background: linear-gradient(135deg, #d991a3, #b76e79);
            border: none;
            height: 52px;
            border-radius: 14px;
            color: white;
            font-weight: 600;
            transition: 0.3s;
        }

        .btn-banner:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 18px rgba(183, 110, 121, 0.3);
        }

        .preview-img {
            width: 100%;
            height: 240px;
            object-fit: cover;
            border-radius: 18px;
            margin-top: 20px;
            display: none;
        }
    </style>
</head>

<body>

    <div class="container py-5">

        <div class="row justify-content-center">

            <div class="col-lg-8">

                <div class="banner-card">

                    <!-- Header -->
                    <div class="banner-header">

                        <h2>
                            <i class="fa fa-image me-2"></i>
                            Add New Banner
                        </h2>

                        <p class="mb-0">
                            Upload beautiful homepage banners for your website
                        </p>

                    </div>

                    <!-- Body -->
                    <div class="banner-body">

                        <form action="add_banner_action.php" method="POST" enctype="multipart/form-data">

                            <!-- Banner Title -->
                            <div class="mb-4">

                                <label class="form-label">
                                    Banner Title
                                </label>

                                <input type="text" name="title" class="form-control" placeholder="Enter banner title"
                                    required>

                            </div>

                            <!-- Banner Status -->
                            <div class="mb-4">

                                <label class="form-label">
                                    Banner Status
                                </label>

                                <select name="status"
                                    class="form-select"
                                    required>

                                    <option value="">Select Status</option>
                                    <option value="1">Active</option>
                                    <option value="0">Inactive</option>

                                </select>

                            </div>

                            <!-- Upload Image -->
                            <div class="mb-4">

                                <label class="form-label">
                                    Upload Banner Image
                                </label>

                                <div class="upload-box">

                                    <i class="fa fa-cloud-upload-alt upload-icon"></i>
                                    <!-- Preview -->
                                    <img id="preview"
                                        class="preview-img">

                                    <h5 class="fw-bold">
                                        Choose Banner Image
                                    </h5>
                                    <input type="file" name="banner_image" class="form-control mt-3"
                                        accept="image/*" onchange="previewImage(event)" required>
                                </div>
                            </div>

                            <!-- Submit Button -->
                            <div class="d-grid">

                                <button type="submit" name="add_banner" class="btn btn-banner">
                                    <i class="fa fa-plus-circle me-2"></i>
                                    Add Banner
                                </button>

                            </div>

                        </form>

                    </div>

                </div>

            </div>

        </div>

    </div>

    <script>
        function previewImage(event) {

            const preview = document.getElementById('preview');

            preview.src = URL.createObjectURL(event.target.files[0]);

            preview.style.display = "block";
        }
    </script>

</body>

</html>