<?php
if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $conn = require "includes/database.php";

    if (isset($_POST['submit'])) {
        $category = $_POST['task-category'];
        $result = "SELECT count(*) FROM t_gl_bluetooth_task_category WHERE category=?";
        $stmt = $conn->prepare($result);
        $stmt->bind_param('s',$category);
        $stmt->execute();
        $stmt->bind_result($count);
        $stmt->fetch();
        $stmt->close();
        if ($count > 0) {
            echo "<script>alert('Category already exists.');</script>";
        } else {

            $query = "insert into t_gl_bluetooth_task_category(category) values(?)";
            $stmt = $conn->prepare($query);
            $rc = $stmt->bind_param('s', $category);
            $stmt->execute();
            echo "<script>alert('Category Succssfully added');</script>";
            echo "<script>window.location.href='catagories.php'</script>";

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
    <link rel="stylesheet" href="css/add_user_style.css">
</head>

<body>
    <div class="container-c">
        <h2 class="c-head">Add Category:</h2>
        <form method="POST" action="<?php echo $_SERVER['PHP_SELF'] ?>">
            <label>Task Category Name:</label>
            <input type="text" name="task-category" value="<?php echo $_POST['task-category'] ?? '' ?>">

            <input id="submit" type="submit" value="Add" name="submit">
        </form>
    </div>
</body>

</html>