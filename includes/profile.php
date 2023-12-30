<?php
if (isset($_SESSION["user_id"])) {
    $conn = require __DIR__ . "/database.php";
    $sql = "SELECT * FROM t_gl_bluetooth_employee_master WHERE emp_id = {$_SESSION["user_id"]}";
    $result = $conn->query($sql);
    $user = $result->fetch_assoc();
}
// }else{
//     header("Location: login.php");
// }
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Profile</title>
</head>

<body>
    <div class="outer-container">
        <h1 style="color:#668cff; margin-left: 5%">Profile:</h1>
        <div class="containerP">
            <div class="photo">
                 <img src="./uploads/<?php echo $user['photo']; ?>"> 
                 <a href="photo_upload.php"> <p>edit picture</p></a>
            </div>
            <div class="details">
                <h2>Name:</h2>
                <h4><?php echo $user["name"] ?></h4>
                <h2>Adobe ID:</h2>
                <h4><?php echo $user["adobe_id"] ?></h4>
                <h2>Team:</h2>
                <h4><?php echo $user["team"] ?></h4>
                <h2>Role:</h2>
                <h4><?php echo $user["role"] ?></h4>
            </div>
        </div>
    </div>
</body>

</html>