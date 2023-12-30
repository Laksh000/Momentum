<?php
session_start();
require "validation_more_user_details.php";

if (isset($_POST['submit'])) {
    $validation = new UserValidator($_POST);
    $errors = $validation->validateForm();

    if (count(array_filter($errors)) == 0) {

        // $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);

        //sql connection and injection
        $conn = require "includes/database.php";
        $sql1 = "INSERT INTO t_gl_bluetooth_user_master(emp_id,email,password,emp_role) VALUES(?,?,?,?);";

        $stmt1 = $conn->stmt_init();
        if (!$stmt1->prepare($sql1)) {
            die("SQL error" . $conn->error);
        }
        $stmt1->bind_param(
            "ssss", $_SESSION['temp_user']['emp-id'], $_SESSION['temp_user']['email'],
            $_SESSION['temp_user']['password'], $_SESSION['temp_user']['emp-role']
        );
        if ($stmt1->execute()) {
            $sql2 = "INSERT INTO t_gl_bluetooth_employee_master(emp_id,name,email,adobe_id,team,role,photo) VALUES(?,?,?,?,?,?,?);";
            $stmt2 = $conn->stmt_init();
            if (!$stmt2->prepare($sql2)) {
                die("SQL error" . $conn->error);
            }
            $photo = "default_profile_image.png";
            $stmt2->bind_param(
                "sssssss", $_POST['emp-id'], $_POST['name'], $_POST['email'],
                $_POST['adobe-id'], $_POST['team'], $_POST['team-role'],
                $photo
            );
            if ($stmt2->execute()) {
                header('Location: admin_page.php');
                exit;
            }
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="css/more_user_details.css">
</head>

<body>
    <div class="container">
        <h1 style="margin: 0 auto; color: #668cff;">Register:</h1>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <label>Employee ID:</label>
            <input type="text" name="emp-id" value="<?php echo $_SESSION['temp_user']['emp-id'] ?>" readonly>
            <label>Name:</label>
            <input type="text" name="name" value="<?php echo $_POST['name'] ?? '' ?>">
            <div class="error"><?php echo $errors['name'] ?? '' ?></div>
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $_SESSION['temp_user']['email'] ?>" readonly>
            <div class="error"><?php echo $errors['email'] ?? '' ?></div>
            <label>Adobe ID:</label>
            <input type="text" name="adobe-id" value="<?php echo $_POST['adobe-id'] ?? '' ?>">
            <label>Team:</label>
            <input type="text" name="team" value="<?php echo $_POST['team'] ?? '' ?>">
            <label>Team role:</label>
            <input type="text" name="team-role" value="<?php echo $_POST['emp-role'] ?? '' ?>">
            <input id="submit" type="submit" value="Register" name="submit">
        </form>
        <button><a style="color: white;" href="admin_page.php">Back</a></button>
    </div>
</body>

</html>