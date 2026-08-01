<?php
    include("db_connect.php");
    global $conn;
   include('header.php');
    if(!isset($_SESSION['user_id'])){
        header("Location:signup.php");
        exit();
    }
    $user_id = $_SESSION['user_id'];
    $select = "SELECT * FROM users WHERE id='$user_id'";
    $run = mysqli_query($conn,$select);
    $data = mysqli_fetch_assoc($run);

    if(!$data){
        echo "User not found";
        exit();
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile Page</title>
    <link rel="stylesheet" href="Assests/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/7.0.1/css/all.min.css">
    <!-- <link rel="stylesheet" href="header.css"> -->
    <style>
        .dp-wrapper {
            width: 120px;
            height: 120px;
            margin: auto;
            border-radius: 50%;
            overflow: hidden;
            border: 3px solid rgb(137, 2, 45); /* Bootstrap red */
        }

        .dp-img {
            width: 100%;
            height: 100%;
            object-fit: cover; /* keeps image perfect */
        }
        /* Camera icon */
        .edit-icon {
            position: absolute;
            bottom: 5px;
            right: 37vh;
            background: rgb(137, 2, 45);
            color: white;
            padding: 8px;
            border-radius: 50%;
            cursor: pointer;
            font-size: 14px;
        }
        .update_btn{
            background: rgb(137, 2, 45);
            color: white;
        }
    </style>
</head>

<body style="background-color: rgb(239, 210, 217);">

<?php  ?>

<div class="container" style="margin-top: 90px; max-width:600px;">
    
    <div class="card shadow p-4">
        <form action="Form_action.php?user_id=<?php echo $user_id ?>" method="POST" enctype="multipart/form-data">

            <!-- Profile Image -->
            <div class="text-center mb-3 position-relative">

                <div class="dp-wrapper ">
                    <?php if($data['image']){ ?>
                        <img src="image/<?php echo $data['image']; ?>" id="image" class="dp-img">
                    <?php }else{ ?>
                        <img src="Assests/image/customers/default_pic.jpg" class="dp-img">
                    <?php } ?>
                </div>
                <!-- Camera Icon -->
                <label for="imageUpload" class="edit-icon" name="camera">
                    <i class="fa fa-camera"></i>
                </label>
                <!-- Hidden File Input -->
                <input type="file" name="image" id="imageUpload" accept="image/*"
                 onchange="imagePreview()" hidden>
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Name</label>
                <input type="text" name="name" class="form-control fw-medium"
                       value="<?php echo $data['name']; ?>">
            </div>

            <div class="mb-3">
                <label class="fw-semibold">Email</label>
                <input type="email" name="email" class="form-control fw-medium" 
                value="<?php echo $data['email']; ?>">
            </div>

            <div class="mb-3">
                <label class="fw-semibold">password</label>
                <input type="password" name="password" id="passowrd" class="form-control fw-medium" 
                value="<?php echo $data['password']; ?>">
            </div>

            <button type="submit" name="updateProfile" 
                class="btn update_btn w-100 fw-semibold">
                Update Profile
            </button>

        </form>
    </div>
</div>

<script src="Assests/js/bootstrap.bundle.min.js"></script>
<script>
    function imagePreview(){
        const file = document.getElementById("imageUpload").files[0];
        let reader = new FileReader();
        reader.onload = function(){
            let img = document.getElementById("image");
            img.src = reader.result;
            img.style.display = "block";
        }
        reader.readAsDataURL(file);
    }
</script>
</body>
</html>