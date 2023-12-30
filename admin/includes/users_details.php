<?php
$con = require __DIR__ . "/database.php";
if(isset($_POST['delete'])){
	$_SESSION['delete_key'] = $_POST['emp-id'];
	header("Location: delete_user.php");
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

		#button2 {
			background-color: white;
			color: #668cff;
			border: 2px solid #668cff;
			padding: 8px 10px;
			border-radius: 5px;
		}
	</style>
</head>

<body>
	<div style="margin:0 auto;">

		<h2 style="font-family:Arial,Helvetica,sans-serif; color:#668cff;">Users:</h2>
		</br>
		<button id="myButton" style=float:right; class="button button1">Add</button>
		<script type="text/javascript">
			document.getElementById("myButton").onclick = function() {
				location.href = "add_user.php";
			};
		</script>

		</script>
		</br>
		<table class="table table-striped table-bordered">
			<thead>
				<tr>
					<th>Employee ID</th>
					<th>Email</th>
					<th>User role</th>
					<th>Operations:</th>
				</tr>
			</thead>
			<tbody>
				<?php

				if (isset($_GET['page_no_u']) && $_GET['page_no_u'] != "") {
					$page_no_u = $_GET['page_no_u'];
				} else {
					$page_no_u = 1;
				}

				$total_records_per_page = 5;
				$offset = ($page_no_u - 1) * $total_records_per_page;
				$previous_page = $page_no_u - 1;
				$next_page = $page_no_u + 1;
				$adjacents = "2";

				$eid = $_SESSION['user_id'];
				$result_count = mysqli_query($con, "SELECT COUNT(*) As total_records FROM t_gl_bluetooth_user_master");
				$total_records = mysqli_fetch_array($result_count);
				$total_records = $total_records['total_records'];
				$total_no_of_pages = ceil($total_records / $total_records_per_page);
				$second_last = $total_no_of_pages - 1; // total page minus 1

				$result = mysqli_query($con, "SELECT * FROM t_gl_bluetooth_user_master  ORDER BY emp_id DESC LIMIT $offset, $total_records_per_page");
				while ($row = mysqli_fetch_array($result)) {
					echo "<tr>
					   <td>{$row["emp_id"]}</td>
                	   <td>{$row["email"]}</td>
                	   <td>{$row["emp_role"]}</td>
					   <td>
							<form method='post'> 
							<input id = button2 type='submit' name='delete' value='Delete'>
							<input type='hidden' name='emp-id' value={$row['emp_id']}>
				  	   		</form>
					   </td>
		   	  		   </tr>";
				}
				mysqli_close($con);
				?>
			</tbody>
		</table>

		<div style='padding: 10px 20px 0px; border-top: dotted 1px #CCC;'>
			<strong>Page <?php echo $page_no_u . " of " . $total_no_of_pages; ?></strong>
		</div>

		<ul class="pagination">
			<?php // if($page_no_u > 1){ echo "<li><a href='?page_no_u=1'>First Page</a></li>"; } 
			?>

			<li <?php if ($page_no_u <= 1) {
					echo "class='disabled'";
				} ?>>
				<a <?php if ($page_no_u > 1) {
						echo "href='?page_no_u=$previous_page'";
					} ?>>Previous</a>
			</li>

			<?php
			if ($total_no_of_pages <= 10) {
				for ($counter = 1; $counter <= $total_no_of_pages; $counter++) {
					if ($counter == $page_no_u) {
						echo "<li class='active'><a>$counter</a></li>";
					} else {
						echo "<li><a href='?page_no_u=$counter'>$counter</a></li>";
					}
				}
			} elseif ($total_no_of_pages > 10) {

				if ($page_no_u <= 4) {
					for ($counter = 1; $counter < 8; $counter++) {
						if ($counter == $page_no_u) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no_u=$counter'>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no_u=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no_u=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} elseif ($page_no_u > 4 && $page_no_u < $total_no_of_pages - 4) {
					echo "<li><a href='?page_no_u=1'>1</a></li>";
					echo "<li><a href='?page_no_u=2'>2</a></li>";
					echo "<li><a>...</a></li>";
					for ($counter = $page_no_u - $adjacents; $counter <= $page_no_u + $adjacents; $counter++) {
						if ($counter == $page_no_u) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no_u=$counter'>$counter</a></li>";
						}
					}
					echo "<li><a>...</a></li>";
					echo "<li><a href='?page_no_u=$second_last'>$second_last</a></li>";
					echo "<li><a href='?page_no_u=$total_no_of_pages'>$total_no_of_pages</a></li>";
				} else {
					echo "<li><a href='?page_no_u=1'>1</a></li>";
					echo "<li><a href='?page_no_u=2'>2</a></li>";
					echo "<li><a>...</a></li>";

					for ($counter = $total_no_of_pages - 6; $counter <= $total_no_of_pages; $counter++) {
						if ($counter == $page_no_u) {
							echo "<li class='active'><a>$counter</a></li>";
						} else {
							echo "<li><a href='?page_no_u=$counter'>$counter</a></li>";
						}
					}
				}
			}
			?>

			<li <?php if ($page_no_u >= $total_no_of_pages) {
					echo "class='disabled'";
				} ?>>
				<a <?php if ($page_no_u < $total_no_of_pages) {
						echo "href='?page_no_u=$next_page'";
					} ?>>Next</a>
			</li>
			<?php if ($page_no_u < $total_no_of_pages) {
				echo "<li><a href='?page_no_u=$total_no_of_pages'>Last &rsaquo;&rsaquo;</a></li>";
			} ?>
		</ul>

	</div>

</body>

</html>