<?php
include("../db_connect.php");
global $conn;
session_start();
if (isset($_SESSION['admmin_id'])) {
    // Fetch all category before submited
    $sql1 = "SELECT * FROM `categories`";
    $result = mysqli_query($conn, $sql1);

    if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addProduct'])) {
        $name = $_POST['name'];
        $description = mysqli_real_escape_string($conn, $_POST['desc']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $rating = $_POST['rating'];
        $image = $_FILES['img']['name'];
        $temp_location = $_FILES['img']['tmp_name'];
        $upload = "../products_image/" . $image;
        $category_id = $_POST['category_id'];
        // $category_name=$_POST['category_name'];

        $sql = "INSERT INTO `products`(`name`, `description`, `price`, `stock`,rating, `image`, `category_id`) 
            VALUES ('$name','$description','$price','$stock','$rating','$image','$category_id')";
        $run = mysqli_query($conn, $sql);

        if (!$run) {
            echo "Error:" . mysqli_error($conn);
        } else {
            echo "Product added succesfully";
            // Move image file to image folder
            move_uploaded_file($temp_location, $upload);
        }
    }
} else {
    header("Location:../index.php");
}

?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Product - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        /* Main Card */
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 30px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        /* Upload Box */
        .upload-box {
            border: 2px dashed #900330;
            border-radius: 15px;
            height: 200px;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #900330;
            cursor: pointer;
        }

        .upload-box i {
            font-size: 40px;
            margin-bottom: 10px
        }

        /* Camera Icon */
        .edit-icon {
            position: absolute;
            top: 30vh;
            right: 1px;
            background: #900330;
            color: white;
            padding: 10px;
            border-radius: 50%;
            cursor: pointer;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 10px;
        }

        @media(max-width:768px) {
            form {
                display: flex;
                flex-direction: column;
                gap: 20px;
            }
        }
    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">
            <?php include("sidebar.php") ?>
            <!-- Main -->
            <div class="col-lg-10">

                <div class="main-card">

                    <!-- Header -->
                    <div class="d-flex justify-content-between align-items-center mb-4">
                        <div class="d-flex align-items-center gap-2">
                            <button class="btn btn-light d-lg-none" data-bs-toggle="offcanvas"
                                data-bs-target="#mobileMenu">
                                <i class="fa fa-bars"></i>
                            </button>
                            <h3 class="mb-0">Add Products</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <div class="row g-4">

                        <form action="add.php" method="POST" enctype="multipart/form-data" class="d-flex justify-content-around">
                            <div class="col-12 col-lg-4 position-relative">
                                <label class="upload-box w-100">

                                    <input type="file" name="img" id="imageUpload" accept="image/*"
                                        onchange="imagePreview()" hidden>

                                    <img src="" id="image" class="w-100 h-100" style="display:none;">

                                </label>

                                <label for="imageUpload" class="edit-icon">
                                    <i class="fa fa-camera"></i>
                                </label>
                            </div>

                            <div>
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="name" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Description</label>
                                    <input type="text" name="desc" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Price</label>
                                    <input type="number" name="price" class="form-control" required>
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <input type="number" name="stock" class="form-control" required>
                                </div>
                                <div class="mb-3">
                                    <label class="form-label">Stock</label>
                                    <label>Rating</label>
                                    <input type="number" name="rating" step="0.5" min="0" max="5" class="form-control">
                                </div>

                                <select name="category_id" class="form-select mb-2">
                                    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                                        <option value="<?php echo $row['id']; ?>">
                                            <?php echo $row['name']; ?>
                                        </option>
                                    <?php } ?>
                                </select>

                                <div class="d-flex gap-3 mt-4">
                                    <button type="submit" name="addProduct" value="submit"
                                        class="btn bg-warning">Add</button>
                                    <button type="button" class="btn bg-warning">Cancel</button>
                                </div>

                            </div>

                        </form>

                    </div>

                </div>

            </div>
        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>
    <script>
        function imagePreview() {
            const file = document.getElementById("imageUpload").files[0]; // ✅ FIXED

            if (file) {
                let reader = new FileReader();

                reader.onload = function() {
                    let image = document.getElementById("image");
                    image.src = reader.result;
                    image.style.display = "block";
                }

                reader.readAsDataURL(file);
            }
        }
    </script>
</body>

</html>