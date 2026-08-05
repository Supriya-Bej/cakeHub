<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<?php
include('../db_connect.php');
include('back_colour.php');
global $conn;
// Login Page
session_start();
if ($_SERVER['REQUEST_METHOD'] === "POST" && isset($_POST['adminLoginBtn'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $cehck = "SELECT * FROM `admin` where email_id='$email'";
    $run = mysqli_query($conn, $cehck);

    if (mysqli_num_rows($run) > 0) {
        $data = mysqli_fetch_assoc($run);
        if ($data['password'] === md5($password)) {
            $_SESSION['admmin_id'] = $data['id'];
            $_SESSION['admin_name'] = $data['name'];
            $_SESSION['admin_email'] = $data['email_id'];

            header("Location:dashboard.php");
            exit(0);
        } else {
            echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Password did not match'
                    }).then(() => {
                        window.location.href='login.php';
                    });
                </script>";
        }
    } else {
        echo "<script>
                    Swal.fire({
                        icon: 'error',
                        title: 'Login Failed',
                        text: 'Email not exist'
                    }).then(() => {
                        window.location.href='login.php';
                    });
                </script>";
    }
}
?>