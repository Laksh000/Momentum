<?php
session_start();
require "validation_add_user.php";
if (isset($_POST['submit'])) {
    $validation = new UserValidator($_POST);
    $errors = $validation->validateForm();

    if (count(array_filter($errors)) == 0) {
        // $password_hash = password_hash($_POST["password"], PASSWORD_DEFAULT);
        $_SESSION['temp_user'] = $_POST;
        header("Location: more_user_details.php");
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="css/add_user_style.css">
</head>

<body>
    <div class="container">
        <h1 style="margin: 0 auto; color: #668cff;">Register:</h1>
        <form method="POST" action="">
            <label>Employee ID:</label>
            <input type="text" name="emp-id" value="<?php echo $_POST['emp-id'] ?? '' ?>">
            <div class="error"><?php echo $errors['emp-id'] ?? '' ?></div>
            <label>Email:</label>
            <input type="text" name="email" value="<?php echo $_POST['email'] ?? '' ?>">
            <div class="error"><?php echo $errors['email'] ?? '' ?></div>
            <label>User role:</label>
            <select name="emp-role" value="">
                <option selected="selected">Choose one</option>
                <?php
                $roles = array("admin","manager","user");
                foreach ($roles as $role) {
                    echo "<option value='$role'>$role</option>";
                }
                ?>
            </select>
            <label>Password:</label>
            <input type="password" name="password">
            <div class="error"><?php echo $errors['password'] ?? '' ?></div>
            <label>Confirm Password:</label>
            <input type="password" name="cpassword">
            <div class="error"><?php echo $errors['cpassword'] ?? '' ?></div>
            <input id="submit" type="submit" value="Next" name="submit">
        </form>
        <button><a style="color: white;" href="admin_page.php">Back</a></button>
    </div>
</body>

</html>