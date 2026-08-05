<?php
global $conn;
include("../db_connect.php");
include("function.php");
include("back_colour.php");

if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['addStatus'])) {

    $status_name = mysqli_real_escape_string($conn, $_POST['status']);

    $insert = "INSERT INTO `orderstatus`(`status`) VALUES ('$status_name')";
    $run = mysqli_query($conn, $insert);

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
                    text: 'Status added successfully.',
                    confirmButtonColor: '#ff6b81',
                    background: '#fffaf7',
                    color: '#5d4037'
                }).then(() => {
                    window.location.href = 'add_status.php';
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
                    text: 'Failed to add status.',
                    confirmButtonColor: '#dc3545'
                });
            </script>

        </body>

        </html>
<?php
        exit();
    }
}
?>