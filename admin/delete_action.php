<?php
    include_once("function.php");

    if($_SERVER['REQUEST_METHOD']==="GET" && $_GET['badge']=='user'){
        $id = $_GET['id'];
        $call = delete_data('users',$id);

        if($call){
            echo "<script>
            alert('User delete success');
            window.location.href='customers.php';
            </script>";
        }
        else{
            echo "<script>
            alert('User delete Unsuccess');
            window.location.href='customers.php';
            </script>";
        }
    }
?>