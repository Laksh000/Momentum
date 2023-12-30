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
    <div class="catagories-table">
        <?php require "includes/catagories_overview.php" ?>
    </div>
    <div class="add-catagories">
        <?php require "includes/add_category.php" ?>
    </div>
            <button class="btn"><a style="color: white;" href="manager_page.php">Back</a></button>
    </div>
</body>
</html>