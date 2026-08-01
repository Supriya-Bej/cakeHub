<?php
include_once("../db_connect.php");
global $conn;

function countDetails($table_name)
{
    global $conn; 

    $sql = "SELECT COUNT(*) AS total FROM {$table_name}";
    $result = mysqli_query($conn, $sql);

    if (!$result) {
        die("Query Failed: " . mysqli_error($conn));
    }

    $data = mysqli_fetch_assoc($result);

    return $data['total']; 
}

function count_revenue($table_name){
    global $conn;

    $revenue = "SELECT SUM(price) AS total_revenue FROM {$table_name}";
    $run = mysqli_query($conn,$revenue);

    if(!$run){
        die("Query failed:".mysqli_error($conn));
    }
    $totalRevenue = mysqli_fetch_assoc($run);
    return $totalRevenue['total_revenue'];
}
?>