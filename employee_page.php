<?php
session_start();

if (isset($_SESSION["user_id"])) {
    $conn = require "includes/database.php";
    $sql = "SELECT * FROM t_gl_bluetooth_employee_master WHERE emp_id = {$_SESSION["user_id"]}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
} else {
    header("Location: login.php");
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Employee</title>
    <link rel="stylesheet" href="css/bootstrap.min.css">
    <link rel="stylesheet" href="css/employee_style.css">
    <link rel="stylesheet" href="css/profile_style.css">
</head>

<body>
    <div class="container">
        <?php require "includes/header.php"; ?>
        <div class="dashboard">
            <div class="profile">
                <?php require "includes/profile.php"; ?>
            </div>
            <div class="tasks-overview">
                <?php require "includes/emp_task_overview.php" ?>
            </div>
        </div>
        <?php require "includes/footer.php" ?>
    </div>

</body>

</html>