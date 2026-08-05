<?php
global $conn;
include("../db_connect.php");
include("function.php");
include("back_colour.php");

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addMethod'])) {
    $method = $_POST['method'];

    $insert = "INSERT INTO `payment_type`(`method`) VALUES ('$method')";
    $run = mysqli_query($conn, $insert);

    if ($run) { ?>
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
                    text: 'Payment method added successfully.',
                    confirmButtonColor: '#ff6b81',
                    background: '#fffaf7',
                    color: '#5d4037'
                }).then(() => {
                    window.location.href = 'add_paymentMethod.php';
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
                    title: 'Oops!',
                    text: 'Failed to add payment method.',
                    confirmButtonColor: '#dc3545'
                });
            </script>

        </body>

        </html>
<?php
        exit();
    }
}
