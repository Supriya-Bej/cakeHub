<?php
include('function.php');
global $conn;

// Fetch Categories
$sql_category = "SELECT * FROM categories";
$result_category = mysqli_query($conn, $sql_category);

if (isset($_GET['product_id'])) {
    $id = $_GET['product_id'];
    $data = get_single_details('products', $id);

    if (!$data) {
        echo "Product not found";
        exit();
    }
} else {
    echo "Invalid request";
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Product</title>

    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
    body {
        background: linear-gradient(135deg, #fdf7f2, #f8efe6);
    }

    /* Card */
    .main-card {
        background: #fff;
        border-radius: 20px;
        padding: 25px;
        margin-top: 30px;
        box-shadow: 0 10px 30px rgba(0, 0, 0, 0.08);
    }

    /* Upload Box */
    .upload-box {
        border: 2px dashed #900330;
        border-radius: 20px;
        height: 260px;
        display: flex;
        align-items: center;
        justify-content: center;
        overflow: hidden;
        background: #fff8f1;
        transition: 0.3s;
    }

    .upload-box img {
        object-fit: cover;
        width: 100%;
        height: 100%;
    }

    /* Camera Icon */
    .edit-icon {
        position: absolute;
        bottom: 20vh;
        right: 10px;
        background: #900330;
        color: white;
        padding: 10px;
        border-radius: 50%;
        cursor: pointer;
    }

    /* Inputs */
    .form-control,
    .form-select {
        border-radius: 12px;
        padding: 12px;
    }

    /* .form-control:focus,
    .form-select:focus {
        border-color: #900330;
        box-shadow: 0 0 0 0.15rem rgba(255, 140, 50, 0.25);
    } */

    /* Buttons */
    .btn-main {
        background: #900330;
        color: white;
        border-radius: 12px;
        padding: 10px 25px;
    }

    .btn-main:hover {
        background: #900330;
    }

    .btn-cancel {
        background: #f1eee8;
        border-radius: 12px;
        padding: 10px 25px;
    }

    /* Badge */
    .category-badge {
        background: #ffc7e0;
        color: #c91d37;
        padding: 6px 12px;
        border-radius: 20px;
    }
    </style>

</head>

<body>

    <div class="container">
        <div class="main-card">

            <!-- Header -->
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h3>Edit Product</h3>
                <!-- <i class="fa fa-user fs-4"></i> -->
            </div>

            <!-- FORM -->
            <form action="update_product.php?update_id=<?php echo $id; ?>" method="POST" enctype="multipart/form-data"
                class="row g-4">

                <!-- IMAGE -->
                <div class="col-lg-4 position-relative">
                    <label class="upload-box">
                        <input type="file" name="img" id="imageUpload" accept="image/*" onchange="imagePreview()"
                            hidden>

                        <img src="../products_image/<?php echo $data['image']; ?>" id="image">
                    </label>

                    <label for="imageUpload" class="edit-icon">
                        <i class="fa fa-camera"></i>
                    </label>
                </div>

                <!-- FORM DETAILS -->
                <div class="col-lg-8">

                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label>Name</label>
                            <input type="text" name="name" class="form-control" value="<?php echo $data['name']; ?>">
                        </div>

                        <div class="col-md-6 mb-3">
                            <label>Price</label>
                            <input type="number" name="price" class="form-control"
                                value="<?php echo $data['price']; ?>">
                        </div>
                    </div>

                    <div class="mb-3">
                        <label>Description</label>
                        <textarea name="desc" class="form-control"><?php echo $data['description']; ?></textarea>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label>Stock</label>
                            <input type="number" name="stock" class="form-control"
                                value="<?php echo $data['stock']; ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Rating</label>
                            <input type="number" name="rating" step="0.5" min="0" max="5" class="form-control"
                                value="<?php echo $data['rating']; ?>">
                        </div>

                        <div class="col-md-4 mb-3">
                            <label>Category</label>
                            <select class="form-select" name="category_id">
                                <?php while ($row = mysqli_fetch_assoc($result_category)) { ?>
                                <option value="<?php echo $row['id']; ?>"
                                    <?php if ($row['id'] == $data['category_id']) echo "selected"; ?>>
                                    <?php echo $row['name']; ?>
                                </option>
                                <?php } ?>
                            </select>
                        </div>
                    </div>

                    <div class="mb-3">
                        <span class="category-badge">
                            Current: <?php echo $data['category_name']; ?>
                        </span>
                    </div>

                    <div class="d-flex gap-3 mt-3">
                        <button type="submit" name="updateProduct" class="btn btn-main text-light">
                            Update
                        </button>
                        <a href="products.php" class="btn btn-cancel">Cancel</a>
                    </div>

                </div>

            </form>
        </div>
    </div>

    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

    <script>
    function imagePreview() {
        const file = document.getElementById("imageUpload").files[0];
        let reader = new FileReader();

        reader.onload = function() {
            document.getElementById("image").src = reader.result;
        }

        if (file) {
            reader.readAsDataURL(file);
        }
    }
    </script>

</body>

</html>