<?php
$con = require __DIR__ . "/database.php";
if (!isset($_SESSION['load'])) {
	$_SESSION["load"] = 3;
}
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

		<h2 style="font-family:Arial,Helvetica,sans-serif; color:#668cff;">Task Details:</h2>
		</br>
		</br>
		<button id="myButton" style=float:right; class="button button1">Add</button>
		<script type="text/javascript">
			document.getElementById("myButton").onclick = function() {
				location.href = "manager_add_task.php";
			};
		</script>
		</br>
		<?php
		if (isset($_GET['page_no']) && $_GET['page_no'] != "") {
			$page_no = $_GET['page_no'];
		} else {
			$page_no = 1;
		}

		$total_records_per_page = 5;
		$offset = ($page_no - 1) * $total_records_per_page;
		$previous_page = $page_no - 1;
		$next_page = $page_no + 1;
		$adjacents = "2";
		$load_more = (int) $_SESSION["load"];
		$load_more_value = $_GET['load'] ?? null;
		// var_dump($load_more_value);
		if (isset($load_more_value)) {
			$load_more += (int) $load_more_value;
			$_SESSION["load"] = $load_more . "";
			// var_dump($_SESSION["load"]);
			// unset($load_more_value, $_GET['load']);
		}
		// echo "$load_more   ";
		$eid = $_SESSION['user_id'];
		$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM t_gl_bluetooth_task_master where  date >= DATE_ADD(NOW(), INTERVAL -$load_more MONTH)");
		$total_records = mysqli_fetch_array($result_count);
		$total_records = $total_records['total_records'];
		// echo "$total_records   ";
		$total_no_of_pages = ceil($total_records / $total_records_per_page);
		// echo "$total_no_of_pages   ";
		$second_last = $total_no_of_pages - 1; // total page minus 1

		// to get last 3 months data- date >= DATE_ADD(NOW(), INTERVAL -3 MONTH)   or    DATE_ADD(NOW(),INTERVAL -90 DAY) 
		$result = mysqli_query($con, "SELECT * FROM t_gl_bluetooth_task_master where  date >= DATE_ADD(NOW(), INTERVAL -$load_more MONTH) ORDER BY date DESC LIMIT $offset, $total_records_per_page");
		?>
		<table id="taskTable" class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Date</th>
					<th>Name</th>
					<th>Git Issue</th>
					<th>Task Category</th>
					<th>Task Details</th>
				</tr>
			</thead>
			<tbody>
				<?php
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>
					   <td>{$row["date"]}</td>
                	   <td>{$row["name"]}</td>
                	   <td>{$row["git_issue"]}</td>
                	   <td>{$row["task_category"]}</td>
                	   <td>{$row["task_details"]}</td>
		   	  		</tr>";
				}
				mysqli_close($con);
				?>
			</tbody>
		</table>

		<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
			<strong>Page <?php echo $page_no . " of " . $total_no_of_pages; ?></strong>
		</div>

		<ul class="pagination">
			<?php // if($page_no > 1){ echo "<li><a href='?page_no=1'>First Page</a></li>"; } 
			?>

			<li <?php if ($page_no <= 1) {
					echo "class='disabled'";
				} ?>>
				<a <?php if ($page_no > 1) {
						echo "href='?page_no=$previous_page'";
					} ?>>Previous</a>
			</li>

			<?php
			if ($total_no_of_pages <= 10) {
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
					if ($counter == $page_no) {
						echo "<li class='active'><a>$counter</a></li>";
					} else {
						echo "<li><a href='?page_no=$counter'>$counter</a></li>";
					}
				}
			} elseif ($total_no_of_pages > 10) {

				if ($page_no <= 4) {
					for ($counter = 1; $counter < 8; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no=$counter'>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} elseif ($page_no > 4 && $page_no < $total_no_of_pages - 4) {
					echo "<li><a href='?page_no=1'>1</a></li>";
					echo "<li><a href='?page_no=2'>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $page_no - $adjacents; $counter <= $page_no + $adjacents; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no=$counter'>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} else {
					echo "<li><a href='?page_no=1'>1</a></li>";
					echo "<li><a href='?page_no=2'>2</a></li>";
					echo "<li><a>...</a></li>";

					for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
						if ($counter == $page_no) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no=$counter'>$counter</a></li>";
						}
					}
				}
			}
			?>
			<li <?php if ($page_no >= $total_no_of_pages) {
					echo "class='disabled'";
				} ?>>

				<a <?php if ($page_no < $total_no_of_pages) {
						echo "href='?page_no=$next_page'";
					} ?>>Next</a>

			</li>
			<?php if ($page_no < $total_no_of_pages) {
				echo "<li><a href='?page_no=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
			} ?>

			<?php if ($page_no >= $total_no_of_pages && $total_records > 1) {
				$load = $load_more + 3;
				echo "<li><a href='?load=3&page_no=$page_no'> Load More &rsaquo;&rsaquo; </a> </li>";
			} ?>
		</ul>

	</div>

</body>

</html>