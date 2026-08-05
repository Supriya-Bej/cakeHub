<?php
include("../db_connect.php");
include("back_colour.php");
global $conn;

if (isset($_GET['update_id'])) {

    $id = $_GET['update_id'];

    $sql = "SELECT * FROM products WHERE id='$id'";
    $result = mysqli_query($conn, $sql);
    $data = mysqli_fetch_assoc($result);

    $old_image = $data['image'];

    if ($_SERVER['REQUEST_METHOD'] == "POST" && isset($_POST['updateProduct'])) {

        $name = $_POST['name'];
        $desc = mysqli_real_escape_string($conn, $_POST['desc']);
        $price = $_POST['price'];
        $stock = $_POST['stock'];
        $rating = $_POST['rating'];
        $category_id = $_POST['category_id'];

        $image = $_FILES['img']['name'];
        $tempname = $_FILES['img']['tmp_name'];

        if (!empty($image)) {

            $uploads = "../products_image/" . $image;

            if (!empty($old_image) && file_exists("../products_image/" . $old_image)) {
                unlink("../products_image/" . $old_image);
            }

            move_uploaded_file($tempname, $uploads);

            $update = "UPDATE products SET
                    name='$name',
                    description='$desc',
                    price='$price',
                    stock='$stock',
                    rating='$rating',
                    image='$image',
                    category_id='$category_id'
                    WHERE id='$id'";
        } else {

            $update = "UPDATE products SET
                    name='$name',
                    description='$desc',
                    price='$price',
                    stock='$stock',
                    rating='$rating',
                    category_id='$category_id'
                    WHERE id='$id'";
        }

        $run = mysqli_query($conn, $update);

        if ($run) {
?>
            <!DOCTYPE html>
            <html>

            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>

            <body>

                <script>
                    Swal.fire({
                        icon: 'success',
                        title: 'Success!',
                        text: 'Product updated successfully.',
                        confirmButtonColor: '#ff6b81'
                    }).then(function() {
                        window.location.href = "products.php";
                    });
                </script>

            </body>

            </html>
        <?php
            exit();
        } else {

        ?>
            <!DOCTYPE html>
            <html>

            <head>
                <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
            </head>

            <body>

                <script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Oops...',
                        text: 'Update failed!',
                        confirmButtonColor: '#ff6b81'
                    });
                </script>

            </body>

            </html>
<?php
            exit();
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <style>
        body {
            background: linear-gradient(135deg, #f5f7fa, #dfe9f3);
            min-height: 100vh;
        }

        .card {
            border-radius: 20px;
        }

        .form-control,
        .form-select {
            border-radius: 12px;
        }

        .btn {
            border-radius: 10px;
        }
    </style>
</head>

<body>
    <div class="bg-dark text-white py-5 mb-5">

        <div class="container">

            <h1 class="display-5 fw-bold">

                <i class="fa fa-box"></i>

                Product Management

            </h1>

            <p class="mb-0">

                Update your product information, pricing, stock and image.

            </p>

        </div>

    </div>
</body>

</html>