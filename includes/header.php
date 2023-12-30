<?php
$conn = require __DIR__."/database.php";
$em = $_SESSION['user_id'];
$sql = "SELECT * FROM t_gl_bluetooth_user_master where emp_id='$em'";
$result = $conn->query($sql);
$user = $result->fetch_assoc();

if($user){
    $sql = "SELECT * FROM t_gl_bluetooth_employee_master where emp_id='$em'";
    $result = $conn->query($sql);
    $user_data = $result->fetch_assoc();
}
?>
<ul class="navbar">
    <li style=" float: left;">
        <h2 style="font-family: Copperplate, Papyrus, fantasy; color: white;">Momentum</h2>
    </li>
    <?php if($user['emp_role']==="admin"): ?>   
    <li><a href="users.php">Users</a></li>
    <li><a href="employees.php">Employee</a></li>
    <li><a href="tasks.php">Tasks</a></li>
    <?php endif ?>
    <li style="float:right; margin-right: 2%">
        <?php if (isset($user)) : ?>
            <img src="https://img.icons8.com/windows/32/null/user.png"/>
            <h4 style="display: inline; color: white">Welcome, <?php echo $user['emp_role']==='user'? $user_data["name"]: "Admin"; ?></h4>
            <a style="margin-bottom:5%;" href="logout.php">Log out</a>
        <?php else : ?>
            <?php header('Location: login.php'); ?>
        <?php endif; ?>
    </li>
</ul>