<?php
global $conn;
$conn=mysqli_connect("localhost","root","","cake_db");
if(!$conn){
    "Errir:".mysqli_query_error();
}