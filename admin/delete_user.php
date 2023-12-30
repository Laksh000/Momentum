<?php
session_start();
$con = require "includes/database.php";
$em = $_SESSION['delete_key'];
$sql1 = "DELETE FROM t_gl_bluetooth_user_master WHERE emp_id='$em'";
$sql2 = "DELETE FROM t_gl_bluetooth_employee_master WHERE emp_id= '$em'";
$con->query($sql1);
$con->query($sql2);
header("Location: users.php");
?>
