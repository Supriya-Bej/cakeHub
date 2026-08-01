<?php
include("db_connect.php");
global $conn;

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST["sendMessage"])) {
    $name = $_POST['name'];
    $email = $_POST['email'];
    $subject = $_POST['subject'];
    $message = $_POST['message'];

    $insert = "INSERT INTO `contact`(`name`, `email`, `subject`, `message`)
            VALUES ('$name','$email','$subject','$message')";
    $sql = mysqli_query($conn, $insert);
    if ($sql) {
        echo "<script>
            alert('Contact form insert succesfully');
            </script>";
        header("Location:contact.php");
    } else {
        echo "Error:" . mysqli_error($conn);
    }
}
