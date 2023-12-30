<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/manager_style.css">
</head>

<body>
    <div class="container-sub">
    <h2 style="color:#668cff;">Employee Details:</h2>
                <div class="registered-users-details">
                    <?php require "includes/employee_details.php" ?>
                </div>
                <button><a href="manager_page.php">Back</a></button>
    </div>
    
</body>
</html>