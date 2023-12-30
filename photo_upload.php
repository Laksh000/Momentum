<?php
session_start();
$is_empty = false;
if (isset($_POST['submit'])) {
    if (!empty($_FILES["fileToUpload"]["name"])) {
        $con = require "includes/database.php";
        $temp = explode(".", $_FILES["fileToUpload"]["name"]);
        $filename = round(microtime(true)) . '.' . end($temp);
        $tempname = $_FILES["fileToUpload"]["tmp_name"];
        $folder = "./uploads/" . $filename;
        $sql = "UPDATE t_gl_bluetooth_employee_master SET photo = '$filename' WHERE emp_id = {$_SESSION['user_id']}";
        $confm = $con->query($sql);
        if ($confm) {
            if (move_uploaded_file($tempname, $folder)) {
                header("Location: employee_page.php");
            }
        }
    }else{
        $is_empty = true;
    }
}
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upload</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/water.css@2/out/light.css">
    <style>
        .photo-upload{
            border:solid #668cff 5px;
            display: flex;
            flex-direction: column;
            justify-content: center;
            margin-top: 30%;
            padding: 5% 5%;
        }
        #btn {
            background-color: #668cff;
            color: white;
            margin: 0 auto;
        }
        form {
            margin: 0 auto;
        }
        h2{
            color: #668cff;
            margin-left: 2%;
        }
    </style>
</head>
<body>
    <div class="photo-upload">
        <h2>Change profile picture:</h2>
        <p style="color: #F75D59; margin:0 auto;"><?php echo $is_empty? "field is empty":""; ?></p>
        <form action="" method="post" enctype="multipart/form-data">
              edit picture:
              <input type="file" name="fileToUpload" id="fileToUpload">
            <input type="submit" id="btn" value="Done" name="submit">
        </form>
        <button style="margin: 1% auto" id="btn" ><a style="color: white;" href="employee_page.php">Back</a></button>
    </div>
</body>
</html>