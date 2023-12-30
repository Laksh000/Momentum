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
    <link rel="stylesheet" href="css/admin_style.css">
</head>

<body>
    <div class="container-sub">
            <div class="tasks-overview">
                <?php require "includes/task_overview.php" ?>
            </div>
            <button><a href="admin_page.php">Back</a></button>
    </div>
</body>
</html>