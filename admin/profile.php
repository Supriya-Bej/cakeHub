<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        .profile-img {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            object-fit: cover;
            border: 4px solid #ffe5c2;
        }

        .form-control {
            border-radius: 12px;
            padding: 10px
        }

        .btn-orange {
            background: #ff8c32;
            color: #fff;
            border: none
        }

        .btn-orange:hover {
            background: #e67620
        }

        .btn-light-custom {
            background: #f1eee8;
            border-radius: 10px
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include("profile.php") ?>

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
                            <h3 class="mb-0">Profile</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <div class="row g-4">

                        <!-- Profile Image -->
                        <div class="col-12 col-md-4 text-center">
                            <img src="https://via.placeholder.com/120" class="profile-img mb-3">
                            <div>
                                <label class="btn btn-light-custom">
                                    <i class="fa fa-upload"></i> Change Photo
                                    <input type="file" hidden>
                                </label>
                            </div>
                        </div>

                        <!-- Profile Form -->
                        <div class="col-12 col-md-8">
                            <form>
                                <div class="row g-3">

                                    <div class="col-md-6">
                                        <label class="form-label">Name</label>
                                        <input type="text" class="form-control" value="Admin Name">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Email</label>
                                        <input type="email" class="form-control" value="admin@email.com">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Phone</label>
                                        <input type="text" class="form-control" value="1234567890">
                                    </div>

                                    <div class="col-md-6">
                                        <label class="form-label">Role</label>
                                        <input type="text" class="form-control" value="Admin" disabled>
                                    </div>

                                    <div class="col-12">
                                        <label class="form-label">Address</label>
                                        <textarea class="form-control" rows="3">Kolkata, India</textarea>
                                    </div>

                                </div>

                                <div class="d-flex justify-content-end gap-2 mt-4">
                                    <button type="button" class="btn btn-light-custom">Cancel</button>
                                    <button type="submit" class="btn btn-orange">Update</button>
                                </div>

                            </form>
                        </div>

                    </div>

                </div>

            </div>
        </div>
    </div>



    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

</html>