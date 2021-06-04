<?php

  require "session/session-3.php";
	require "db/connection.php";


	// require "login-check/login-check.php";
	// creating database connection

	// getting the total number of records
	$query = " SELECT COUNT(username) AS total_rows FROM users ";
	$result_set = mysqli_query($connection, $query);
	$result = mysqli_fetch_assoc($result_set);

	$total_rows = $result['total_rows'];

	$rows_per_page = 5;

	if (isset($_GET['p'])) {
		$page_no = $_GET['p'];
	} else {
		$page_no = 1;
	}


	$start = ($page_no - 1) * $rows_per_page;

	$query = "SELECT * FROM users ORDER BY created_at DESC LIMIT {$start}, {$rows_per_page} ";
	$result_set = mysqli_query($connection, $query);

	$table = "<table class='table table-bordered table-striped'>";
	$table .= "
	<thead>
    <tr>
      <th>ID</th>
      <th>User Name</th>
      <th>Created At</th>
			<th>User Status</th>
			<th>Action</th>
    </tr>
		</thead>
		<tbody>";

	while ($result = mysqli_fetch_assoc($result_set)) {

		$table .= "
    <tr data-toggle='collapse' data-target='#demo1' class='accordion-toggle'>

      <td>{$result['id']}</td>
      <td>{$result['username']}</td>
			<td>{$result['created_at']}</td>
      <td>{$result['user_status']}</td>
      <td>
      <a href='admin-update.php?id={$result['id']}' class='mr-3' title='Update Record' data-toggle='tooltip'><span class='fa fa-pencil'></span></a>
      </td>
    </tr>

    ";
	}

	$table .= "</tbody></table>";


	// first page
	$first = "<a class='page-link' href=\"admin-dashboard.php?p=1\">First</a>";

	// last page
	$last_page_no = ceil($total_rows / $rows_per_page);
	$last = "<a class='page-link' href=\"admin-dashboard.php?p={$last_page_no}\">Last</a>";

	// next page
	if ($page_no >= $last_page_no) {
		$next = "<a class='page-link'>Next</a>";
	} else {
		$next_page_no = $page_no + 1;
		$next = "<a class='page-link' href=\"admin-dashboard.php?p={$next_page_no}\">Next</a>";
	}

	// previous page
	if ($page_no <= 1) {
		$prev = "<a class='page-link'>Back</a>";
	} else {
		$prev_page_no = $page_no - 1;
		$prev = "<a class='page-link' href=\"admin-dashboard.php?p={$prev_page_no}\">Back</a>";
	}

$page_nav ="

<nav aria-label='Page navigation example'>
	<ul class='pagination'>
		<li class='page-item'>{$first}</li>
		<li class='page-item'>{$prev}</li>
		<li class='page-item'><a class='page-link' href='#'> Page {$page_no} of {$last_page_no}</a></li>
		<li class='page-item'>{$next}</li>
		<li class='page-item'>{$last}</li>
	</ul>
</nav>


"


 ?>



<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Dashboard</title>
		<link rel="icon" href="images/fevi.png" type="image/x-icon"/>
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <link rel="stylesheet" type="text/css" href="css/custom.css">
    <link rel="stylesheet" type="text/css" href="css/background.css">
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
    <style>
        .wrapper{
            width: 1000px;
            margin: 0 auto;
        }
        table tr td:last-child{
            width: 120px;
        }
    </style>
    <script>
        $(document).ready(function(){
            $('[data-toggle="tooltip"]').tooltip();
        });
    </script>
</head>
<body>
        <div class="container-fluid mt-3 mb-3">
					<?php require 'navigation/navigation_admin.php';
								echo $nav;
					?>
          <div class="card">

              <div class="card-header">
                <h2>User Management</h2>
              </div>
              <div class="content">
              <div class="row p-2">
                  <div class="col-md-12 ">
                      <?php echo $table; ?>

  											<div class="page_nav">
  													<?php echo $page_nav; ?>
  											</div>

                  </div>
              </div>
            </div>
            <div class="card-footer text-white bg-dark">
              <?php require 'footer/footer.php';
    								echo $footer; ?>
            </div>
          </div>

        </div>
    <script type="text/javascript" src="js/expand.js"></script>

</body>
</html>
