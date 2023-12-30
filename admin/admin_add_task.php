<?php
session_start();
if ($conn = require "includes/database.php") {
   

    if (isset($_POST['submit'])) {
        $sql = "SELECT * FROM t_gl_bluetooth_employee_master WHERE emp_id = {$_POST["name"]}";
        $result = $conn->query($sql);
        $user = $result->fetch_assoc();

        $sql = "INSERT INTO t_gl_bluetooth_task_master(date,name,git_issue,task_category,task_details,emp_id) VALUES(?,?,?,?,?,?);";
        $stmt = $conn->stmt_init();
        if (!$stmt->prepare($sql)) {
            die("SQL error" . $conn->error);
        }
        $date = $_POST['date'];
        $name =$user['name'];
        $issue = $_POST['issue'];
        $category = $_POST['category'];
        $details = $_POST['details'];
        $emp_id=$user['emp_id'];
        $stmt->bind_param("ssssss", $date, $name, $issue, $category, $details, $emp_id);
        if ($stmt->execute()) {
            header('Location: admin_page.php');
            exit;
        }
    }
} else {
    echo "<script>alert('DB Connection error');</script>";
    echo "<script>window.location.href='add_task.php'</script>";
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://formden.com/static/cdn/bootstrap-iso.css" />
    <link rel="stylesheet" href="https://formden.com/static/cdn/font-awesome/4.4.0/css/font-awesome.min.css" />
    <style>
        .bootstrap-iso .formden_header h2,
        .bootstrap-iso .formden_header p,
        .bootstrap-iso form {
            font-family: Arial, Helvetica, sans-serif;
            color: black
        }

        .bootstrap-iso form button,
        .bootstrap-iso form button:hover {
            color: white !important;
        }

        .bootstrap-iso .btn-custom {
            background: #668cff
        }

        .bootstrap-iso .btn-custom:hover {
            background: #5278eb;
        }

        .asteriskField {
            color: red;
        }

        .bootstrap-iso form .input-group-addon {
            color: #555555;
            background-color: #ffffff;
            border-radius: 4px;
            padding-left: 12px
        }
    </style>
    <style>
        .bootstrap-iso .formden_header h2,
        .bootstrap-iso .formden_header p,
        .bootstrap-iso form {
            font-family: Arial, Helvetica, sans-serif;
            color: #668cff
        }

        .bootstrap-iso form button,
        .bootstrap-iso form button:hover {
            color: white !important;
        }

        .bootstrap-iso .btn-custom {
            background: #668cff
        }

        .bootstrap-iso .btn-custom:hover {
            background: #5278eb;
        }

        .asteriskField {
            color: red;
        }

        .bootstrap-iso form .input-group-addon {
            color: #555555;
            background-color: #ffffff;
            border-radius: 4px;
            padding-left: 12px
        }
    </style>


</head>

<body>

</body>
<h1 style="font-family:Arial,Helvetica,sans-serif; color:#668cff; padding-left:20%">Add New task</h1>
<div class="bootstrap-iso">
    <div class="container-fluid">
        <div class="row">
            <div class="col-md-6 col-sm-6 col-xs-12">
                <form class="form-horizontal" method="post" action="<?php echo $_SERVER['PHP_SELF'] ?>">
                    <div class="form-group ">
                        <label class="control-label col-sm-2 requiredField" for="date">
                            Date
                            <span class="asteriskField">
                                *
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <div class="input-group">
                                <div class="input-group-addon">
                                    <i class="fa fa-calendar">
                                    </i>
                                </div>
                                <input class="form-control" id="date" name="date" placeholder="YYYY/MM/DD" type="text" />
                            </div>
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-sm-2 requiredField" for="name">
                            Name
                            <span class="asteriskField">
                                *
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <select name="name" id="name" class="form-control" required>
                                <option value="">Select Name</option>
                                <?php $query = "SELECT t_gl_bluetooth_employee_master.emp_id, t_gl_bluetooth_employee_master.name, 
                                t_gl_bluetooth_user_master.emp_role FROM t_gl_bluetooth_employee_master JOIN t_gl_bluetooth_user_master 
                                ON t_gl_bluetooth_employee_master.emp_id=t_gl_bluetooth_user_master.emp_id WHERE t_gl_bluetooth_user_master.emp_role='user'";
                                $stmt2 = $conn->prepare($query);
                                $stmt2->execute();
                                $res = $stmt2->get_result();
                                while ($row = $res->fetch_object()) {
                                ?>
                                    <option value="<?php echo  $row->emp_id; ?>"><?php echo "$row->emp_id : $row->name"; ?></option>
                                <?php } ?>
                            </select>
                            <!-- <input class="form-control" value="<?php echo $user["name"];  ?>" id="name" name="name" type="text" readonly /> -->
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-sm-2 requiredField" for="issue">
                            Git Issue
                            <span class="asteriskField">
                                *
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <input class="form-control" id="issue" name="issue" type="text" />
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-sm-2 requiredField" for="category">
                            Task Category
                            <span class="asteriskField">
                                *
                            </span>
                        </label>
                        <div class="col-sm-10">
                            <select name="category" id="category" class="form-control" required>
                                <option value="">Select category</option>
                                <?php $query = "SELECT * FROM t_gl_bluetooth_task_category";
                                $stmt2 = $conn->prepare($query);
                                $stmt2->execute();
                                $res = $stmt2->get_result();
                                while ($row = $res->fetch_object()) {
                                ?>
                                    <option value="<?php echo $row->category; ?>"><?php echo $row->category; ?></option>
                                <?php } ?>
                            </select>
                            <!-- <input class="form-control" id="category" name="category" type="text" /> -->
                        </div>
                    </div>
                    <div class="form-group ">
                        <label class="control-label col-sm-2" for="details">
                            Task Details
                        </label>
                        <div class="col-sm-10">
                            <textarea class="form-control" cols="40" id="details" name="details" rows="10"></textarea>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button class="btn btn-custom " name="submit" type="submit">
                                Submit
                            </button>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-sm-10 col-sm-offset-2">
                            <button class="btn btn-custom " name="Back">
                                <a style="color: white;" href="tasks.php">Back</a>
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript" src="https://code.jquery.com/jquery-1.11.3.min.js"></script>
<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/js/bootstrap-datepicker.min.js"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.4.1/css/bootstrap-datepicker3.css" />
<script>
    $(document).ready(function() {
        var date_input = $('input[name="date"]'); //our date input has the name "date"
        var container = $('.bootstrap-iso form').length > 0 ? $('.bootstrap-iso form').parent() : "body";
        date_input.datepicker({
            format: 'yyyy/mm/dd',
            container: container,
            todayHighlight: true,
            autoclose: true,
        })
    })
</script>

</html>