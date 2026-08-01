<?php
    include('function.php');
    global $conn;

    // Fetch data
    if(isset($_GET['edit_id'])){
        $id = $_GET['edit_id'];
        // Function Call
        $data = get_single_details('users',$id);
        if(!$data){
            echo "User not found";
            exit();
        }
    }
    else{
        echo "Invalid request";
        exit();
    }

    // $old_image = $data['image'];

    // Update
    if($_SERVER['REQUEST_METHOD']==="POST" && isset($_POST['updateBtn'])){
        $username = $_POST['username'];
        
        // $image =$_FILES['img']['name'];
        // $tempname = $_FILES['img']['tmp_name'];
        // $upload = "../image/".$image;

        // if($image){
        //     if(!empty($old_image)){
        //         unlink("../image/".$old_image);
        //     }
        //     move_uploaded_file($tempname,$upload);
            $update = "UPDATE `users` SET `name`='$username' WHERE id='$id'";
        // }
        // else{
        //     $update = "UPDATE `users` SET `name`='$username' WHERE id='$id'";
        // }
        $result = mysqli_query($conn, $update);
        if($result){
            
            header("Location:customers.php");
        }
        else{
            echo "Error:".mysqli_error($conn);
        }
    }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Staff - Bakery Admin</title>
    <link rel="stylesheet" href="../Assests/css/bootstrap.min.css">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css" rel="stylesheet">

    <style>
        .main-card {
            background: #fdfaf5;
            border-radius: 20px;
            padding: 25px;
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.08)
        }

        /* Upload Box */
        .upload-box {
            border: 2px dashed #e5c9a8;
            border-radius: 15px;
            height: 200px;
            width: auto;
            display: flex;
            flex-direction: column;
            align-items: center;
            justify-content: center;
            color: #c89b6d;
            cursor: pointer;
        }

        .upload-box i {
            font-size: 40px;
            margin-bottom: 10px
        }

        .form-control,
        .form-select {
            border-radius: 12px;
            padding: 10px;
        }

        .btn-orange {
            background: #ff8c32;
            color: #fff;
            border: none;
            padding: 10px 25px;
            border-radius: 10px;
        }

        .btn-orange:hover {
            background: #e67620
        }

        .btn-light-custom {
            background: #f1eee8;
            border-radius: 10px;
        }
        @media(max-width:768px) {
            form {
                display: flex;
                flex-direction: column;
            }
        }

    </style>
</head>

<body>

    <div class="container-fluid">
        <div class="row">

           <?php include("sidebar.php") ?>

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
                            <h3 class="mb-0">Edit Customers Details</h3>
                        </div>
                        <button class="btn btn-light rounded-circle"><i class="fa fa-user"></i></button>
                    </div>

                    <!-- Form -->
                    <form method="POST" enctype="multipart/form-data" class="d-flex justify-content-around gap-5">
                        <div class="row g-5">
                            <input type="hidden" name="id" value="<?php echo $id; ?>">
                            <div class="col-12 col-lg-4">
                                <label class="upload-box w-100">
                                    <!-- <i class="fa fa-image"></i>
                                     <span>Upload Image</span> -->
                                    <input type="file" name="img" id="image" accept="image/*" hidden onchange="imagePreview()"/>
                                    <img src="../image/<?php echo $data['image']; ?>" id="imgpreview" name="img" class="w-75 h-75" alt="">
                                </label>
                            </div>

                            <div class="d-flex flex-column col-12 col-lg-8">
                                <div class="mb-3">
                                    <label class="form-label">Name</label>
                                    <input type="text" name="username" class="form-control" value="<?php echo $data['name']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Email</label>
                                    <input type="email" name="email" class="form-control" value="<?php echo $data['email']; ?>">
                                </div>

                                <div class="mb-3">
                                    <label class="form-label">Password</label>
                                    <input type="password" name="password" class="form-control" value="<?php echo $data['password']; ?>">
                                </div>

                                <!-- Buttons -->
                                <div class="d-flex justify-content-between mt-4">
                                    <a href="customers.php"><button type="button" class="btn btn-danger px-4">Cancel</button></a>
                                    <button type="submit" name="updateBtn" class="btn btn-warning px-4">Update</button>
                                </div>
                                
                            </div>

                        </div>

                    </form>

                </div>

            </div>
        </div>
    </div>


    <script src="../Assests/js/bootstrap.bundle.min.js"></script>

    <script>
        // Image
        // const fileinput = document.getElementById('image');
        // const imgpreview = document.getElementById('imgpreview');

        // fileinput.addEventListener("change", function () {
        //     const file = this.files[0];

        //     if (file && file.type.startsWith('image/')) {
        //         const reader = new FileReader();

        //         reader.addEventListener("load", function () {
        //             imgpreview.src = reader.result;
        //             imgpreview.style.display = 'block';
        //         });

        //         reader.readAsDataURL(file);
        //     } else {
        //         alert("Please select an image file");
        //         imgpreview.src = "../Assests/image/customers/default_pic.jpg";
        //     }
        // });

        // function imagePreview(){
            
		// 	const file = document.getElementById("image").files[0];
		// 	let reader = new FileReader();
		// 	reader.onload = function(){
		// 		let img = document.getElementById("imgpreview");
		// 		img.src = reader.result;
		// 		img.style.display = "block";
		// 	}

		// 	reader.readAsDataURL(file);
		// }
        
    </script>


</body>

</html>