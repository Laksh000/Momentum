<?php
$con = require __DIR__ . "/database.php";

?>
<!DOCTYPE html>
<html lang="en">
<html>

<head>
	<title>Task Details</title>
	<style>
		.table-striped>tbody>tr:nth-child(odd)>td,
		.table-striped>tbody>tr:nth-child(odd)>th {
			background-color: #668cff;
			color: white;
		}

		.pagination>li>a {
			background-color: white;
			color: #668cff;
		}

		.pagination>li>a:focus,
		.pagination>li>a:hover,
		.pagination>li>span:focus,
		.pagination>li>span:hover {
			color: white;
			background-color: #668cff;
			border-color: #668cff;
		}

		.pagination>.active>a {
			color: white;
			background-color: #668cff;
			border: solid 1px #668cff;
		}

		.pagination>.active>a:hover {
			background-color: #668cff;
			border: solid 1px #668cff;
		}

		.button {
			background-color: #668cff;
			border: none;
			border-radius: 4px;
			color: white;
			padding: 4px 20px;
			text-align: center;
			text-decoration: none;
			display: inline-block;
			font-size: 16px;
			margin: 4px 2px;
			transition-duration: 0.4s;
			cursor: pointer;
			display: flex;


		}
	</style>
</head>

<body>
<h2 class="c-head">Categories:</h2>
	<div style="margin:0 auto;">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
                    <th>Sl.no</th>
					<th>Category name</th>
				</tr>
			</thead>
			<tbody>
                <?php
				$count = 1;
               $result = mysqli_query($con, "SELECT * FROM t_gl_bluetooth_task_category");
               while ($row = mysqli_fetch_array($result)) {
                    echo "<tr>
                        <td> {$count}</td>
                        <td>{$row['category']}</td>
                      </tr>";
					$count++;
                }
                ?>
            </tbody>
        </table>
    </div>
    
</body>
</html>