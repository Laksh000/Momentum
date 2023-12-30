<?php
$con = require __DIR__ . "/database.php";
?>
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

		.button1 {
			background-color: white;
			color: #668cff;
			border: 2px solid #668cff;
		}

		.button1:hover {
			background-color: #668cff;
			color: white;
		}
	</style>
</head>

<body>
	<div style="margin:0 auto;">
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Employee ID</th>
                    <th>Name</th>
					<th>Email</th>
					<th>Adobe ID</th>
					<th>Team</th>
					<th>Team role</th>
				</tr>
			</thead>
			<tbody>
				<?php

				if (isset($_GET['page_no_ud']) && $_GET['page_no_ud'] != "") {
					$page_no_ud = $_GET['page_no_ud'];
				} else {
					$page_no_ud = 1;
				}

				$total_records_per_page = 5;
				$offset = ($page_no_ud - 1) * $total_records_per_page;
				$previous_page = $page_no_ud - 1;
				$next_page = $page_no_ud + 1;
				$adjacents = "2";

				$eid = $_SESSION['user_id'];
				$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM t_gl_bluetooth_employee_master");
				$total_records = mysqli_fetch_array($result_count);
				$total_records = $total_records['total_records'];
				$total_no_of_pages = ceil($total_records / $total_records_per_page);
				$second_last = $total_no_of_pages - 1; // total page minus 1

				$result = mysqli_query($con, "SELECT * FROM t_gl_bluetooth_employee_master  ORDER BY emp_id DESC LIMIT $offset, $total_records_per_page");
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>
					   <td>{$row["emp_id"]}</td>
					   <td>{$row["name"]}</td>
                	   <td>{$row["email"]}</td>
                	   <td>{$row["adobe_id"]}</td>
					   <td>{$row["team"]}</td>
					   <td>{$row["role"]}</td>
		   	  		</tr>";
				}
				mysqli_close($con);
				?>
			</tbody>
		</table>

		<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
			<strong>Page <?php echo $page_no_ud . " of " . $total_no_of_pages; ?></strong>
		</div>

		<ul class="pagination">
			<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
			?>

			<li <?php if ($page_no_ud <= 1) {
					echo "class='disabled'";
				} ?>>
				<a <?php if ($page_no_ud > 1) {
						echo "href='?page_no_ud=$previous_page'";
					} ?>>Previous</a>
			</li>

			<?php
			if ($total_no_of_pages <= 10) {
				for ($counter_ud = 1; $counter_ud <= $total_no_of_pages; $counter_ud++) {
					if ($counter_ud == $page_no_ud) {
						echo "<li class='active'><a>$counter_ud</a></li>";
					} else {
						echo "<li><a href='?page_no_ud=$counter_ud'>$counter_ud</a></li>";
					}
				}
			} elseif ($total_no_of_pages > 10) {

				if ($page_no_ud <= 4) {
					for ($counter_ud = 1; $counter_ud < 8; $counter_ud++) {
						if ($counter_ud == $page_no_ud) {
							echo "<li class='active'><a>$counter_ud</a></li>";
						} else {
							echo "<li><a href='?page_no_ud=$counter_ud'>$counter_ud</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no_ud=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no_ud=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} elseif ($page_no_ud > 4 && $page_no_ud < $total_no_of_pages - 4) {
					echo "<li><a href='?page_no_ud=1'>1</a></li>";
					echo "<li><a href='?page_no_ud=2'>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter_ud = $page_no_ud - $adjacents; $counter_ud <= $page_no_ud + $adjacents; $counter_ud++) {
						if ($counter_ud == $page_no_ud) {
							echo "<li class='active'><a>$counter_ud</a></li>";
						} else {
							echo "<li><a href='?page_no_ud=$counter_ud'>$counter_ud</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no_ud=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no_ud=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} else {
					echo "<li><a href='?page_no_ud=1'>1</a></li>";
					echo "<li><a href='?page_no_ud=2'>2</a></li>";
					echo "<li><a>...</a></li>";

					for ($counter_ud = $total_no_of_pages - 6; $counter_ud <= $total_no_of_pages; $counter_ud++) {
						if ($counter_ud == $page_no_ud) {
							echo "<li class='active'><a>$counter_ud</a></li>";
						} else {
							echo "<li><a href='?page_no_ud=$counter_ud'>$counter_ud</a></li>";
						}
					}
				}
			}
			?>

			<li <?php if ($page_no_ud >= $total_no_of_pages) {
					echo "class='disabled'";
				} ?>>
				<a <?php if ($page_no_ud < $total_no_of_pages) {
						echo "href='?page_no_ud=$next_page'";
					} ?>>Next</a>
			</li>
			<?php if ($page_no_ud < $total_no_of_pages) {
				echo "<li><a href='?page_no_ud=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
			} ?>
		</ul>

	</div>

</body>

</html>