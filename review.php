<?php
include("db_connect.php");
global $conn;

include("header.php");
$user_id = $_SESSION['user_id'];

$product_id = $_GET['product_id'];
$order_id = $_GET['order_id'];

if (isset($_POST['submitReview'])) {

    $rating = $_POST['rating'];
    $feedback = $_POST['feedback'];
    $check = "SELECT * FROM reviews WHERE user_id = '$user_id' AND product_id ='$product_id' AND order_id ='$order_id'";
    $res = mysqli_query($conn, $check);
    if (mysqli_num_rows($res) > 0) {
        $update = "UPDATE reviews SET rating='$rating', feedback='$feedback' WHERE user_id='$user_id'
                   AND product_id='$product_id' AND order_id='$order_id'";
        $runUpdate = mysqli_query($conn, $update);
        if ($runUpdate) {
            echo "<script>
                window.location.href='user_order_detail.php';
                </script>";
            exit();
        }
    } else {
        $sql = "INSERT INTO reviews(user_id, product_id, order_id, rating, feedback)
            VALUES('$user_id','$product_id','$order_id','$rating','$feedback')";

        $runInsert = mysqli_query($conn, $sql);
        if ($runInsert) {
            echo "<script>
            window.location.href='user_order_detail.php';
            </script>";
            exit();
        }
    }
}

$review = "SELECT * FROM reviews WHERE product_id ='$product_id' AND order_id ='$order_id'";
$run = mysqli_query($conn, $review);
$data = mysqli_fetch_assoc($run);
$rating = $data['rating'];
?>

<!DOCTYPE html>
<html>

<head>
    <title>Give Review</title>

    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">
    <style>
        .star-rating .star {
            font-size: 35px;
            color: #ccc;
            cursor: pointer;
            transition: 0.3s;
        }

        .star-rating .star.active {
            color: gold;
        }
    </style>
</head>

<body>

    <div class="container py-5 mt-5">
        <div class="card p-4">
            <h3 class="mb-4">Give Your Feedback</h3>
            <form method="POST">
                <div class="mb-3">

                    <label class="mb-2">Give Rating</label>

                    <div class="star-rating">

                        <?php if (!empty($data)) {
                            $currentRating = $data['rating'] ?? 0;

                            for ($i = 1; $i <= 5; $i++) {
                        ?>
                                <i class="fa fa-star star <?= ($i <= $currentRating) ? 'active' : '' ?>"
                                    data-value="<?= $i ?>"></i>

                            <?php }
                        } else { ?>
                            <i class="fa fa-star star" data-value="1"></i>
                            <i class="fa fa-star star" data-value="2"></i>
                            <i class="fa fa-star star" data-value="3"></i>
                            <i class="fa fa-star star" data-value="4"></i>
                            <i class="fa fa-star star" data-value="5"></i>
                        <?php } ?>
                    </div>
                    <input type="hidden" name="rating" id="ratingValue" value="<?= $currentRating ?>">

                </div>

                <div class="mb-3">
                    <textarea name="feedback"
                        class="form-control"
                        placeholder="Write your feedback">
                        <?php if (!empty($data)) {
                            echo $data['feedback'];
                        } ?></textarea>
                </div>

                <button class="btn btn-danger"
                    name="submitReview">
                    Submit Review
                </button>

            </form>
        </div>
    </div>

    <script>
        let stars = document.querySelectorAll(".star");
        let ratingInput = document.getElementById("ratingValue");

        stars.forEach((star) => {

            star.addEventListener("click", () => {

                let rating = star.dataset.value;

                ratingInput.value = rating;

                stars.forEach((s) => {

                    if (s.dataset.value <= rating) {
                        s.classList.add("active");
                    } else {
                        s.classList.remove("active");
                    }

                });

            });

        });
    </script>
</body>

</html>