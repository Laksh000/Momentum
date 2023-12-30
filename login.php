<?php
$is_valid = true;
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = require  "includes/database.php";
    $em = $_POST['email'];
    $sql = "SELECT * FROM t_gl_bluetooth_user_master where email='$em'";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
    if ($user) {
        if ($_POST["password"] === $user["password"]) {
            echo "password matched";
            session_start();
            session_regenerate_id();
            $_SESSION["user_id"] = $user["emp_id"];
            if ($user["emp_role"] === "admin") {
                header("Location: admin/admin_page.php");
            } elseif($user["emp_role"] === "manager") {
                header("Location: manager/manager_page.php");
            }else{
                header("Location: employee_page.php");
            }
        }else {
            $is_valid = false;
        }
    } else {
        $is_valid = false;
    }
}

?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <link rel="stylesheet" href="css/login_style.css">
</head>
<body>
    <div class="container">
        <h1 style="margin: 0 auto; color: #668cff;"">Login:</h1>
        <div style="color: #F75D59; margin:0 auto;">
            <?php if (!$is_valid) : ?>
                <em>Invalid login credentials</em>
            <?php endif; ?>
        </div>
        <form method="POST" action="">
            <label>Email:</label>
            <input type="email" id="email" name="email" value="<?php $_POST["email"] ?? "" ?>">
            <label>Password:</label>
            <input type="password" id="password" name="password">
            <button type="submit" value="submit">Log in</button>
        </form>
    </div>
</body>

</html>