<?php
$server = "localhost";
$dbname = "db_momentum";
$username = "root";
$password = "apostles";

$conn = mysqli_connect($server,$username,$password,$dbname);
if($conn->connect_errno){
    die("Connection error:".$conn->connect_error);
}
return $conn;
?>