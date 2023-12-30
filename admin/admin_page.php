<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $conn = require "includes/database.php";
    $sql = "SELECT * FROM t_gl_bluetooth_user_master WHERE emp_id = {$_SESSION["user_id"]}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <div class="container">
        <?php require "includes/header.php"; ?>
        
        <?php require "includes/footer.php" ?>
    </div>
    
</body>
</html>