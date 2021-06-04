<?php

  require "session/session-1.php";
	require "db/connection.php";


	// require "login-check/login-check.php";
	// creating database connection

	// getting the total number of records
	$query = " SELECT COUNT(status) AS total_rows FROM current_outage_table Where status='0' ";
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

	$query = "SELECT * FROM current_outage_table WHERE status='0' ORDER BY occured_time DESC LIMIT {$start}, {$rows_per_page} ";
	$result_set = mysqli_query($connection, $query);

	$table = "<table class='table table-bordered table-striped'>";
	$table .= "
	<thead>
    <tr>
			<th>#</th>
      <th>Vendor</th>
      <th>Site ID</th>
      <th>Region</th>
			<th>Occ Time</th>
			<th>Reason</th>
      <th width='200'>Action</th>
    </tr>
		</thead>
		<tbody>";

	while ($result = mysqli_fetch_assoc($result_set)) {

    $siteid=$result['site_name'];
    $mySite = substr($siteid, 0, 6);

		$table .= "
    <tr data-toggle='collapse' data-target='#demo1' class='accordion-toggle'>
		<td><button class='btn btn-default btn-xs'><span class='fa fa-eye'></span></button></td>

      <td id='one'>{$result['type']}</td>
      <td>{$result['site_name']}</td>
      <td>{$result['region']}</td>
			<td>{$result['occured_time']}</td>
			<td>{$result['reason_for_fault']}</td>
      <td>
      <a href='clear.php?id={$result['outage_id']}' class='ml-4 mr-2' title='Clear Record' data-toggle='tooltip'><span class='fa fa-check-square'></span></a>
      <a href='update.php?id={$result['outage_id']}' class='mr-2' title='Update Record' data-toggle='tooltip'><span class='fa fa-pencil'></span></a>
      <a href='delete.php?id={$result['outage_id']}' class='mr-2' title='Delete Record' data-toggle='tooltip'><span class='fa fa-trash'></span></a>

      </td>
    </tr>

    <tr>
			<td colspan='12' class='hiddenRow'>
			<div class='accordian-body collapse' id='demo1'>

      <dl class='row ml-5'>
        <dt class='col-sm-1'>Type : </dt>
        <dd class='col-sm-2'>{$result['type']}</dd>
        <dt class='col-sm-1'>Site ID :</dt>
        <dd class='col-sm-2'>{$mySite}</dd>

        <dt class='col-sm-1'>Site Name : </dt>
        <dd class='col-sm-2'>{$result['site_name']}</dd>
        <dt class='col-sm-1'>Region :</dt>
        <dd class='col-sm-2'>{$result['region']}</dd>

        <dt class='col-sm-1'>Reported To : </dt>
        <dd class='col-sm-2'>{$result['reported_to']}</dd>
        <dt class='col-sm-1'>Reported By : </dt>
        <dd class='col-sm-2'>{$result['reported_by']}</dd>

        <dt class='col-sm-1'>Occured Time : </dt>
        <dd class='col-sm-2'>{$result['occured_time']}</dd>
        <dt class='col-sm-1'>Reported Time : </dt>
        <dd class='col-sm-2'>{$result['reported_time']}</dd>

        <dt class='col-sm-1'>Reason for Fault :</dt>
        <dd class='col-sm-2'>{$result['reason_for_fault']}</dd>
        <dt class='col-sm-1'>TX reported to : </dt>
        <dd class='col-sm-2'>{$result['tx_reported_to']}</dd>
        <dt class='col-sm-1'>SMS</dt>
        <dd class='col-sm-2'><input id='myInput'  class='text-info' value='{$result['site_name']} {$result['type']} down@{$result['occured_time']} ,Reason:{$result['reason_for_fault']} (Att:{$result['reported_to']},TX:{$result['tx_reported_to']})' data-toggle='tooltip'></dd>
      </dl>

			</div>
			</td>
    </tr>
    ";
	}

	$table .= "</tbody></table>";


	// first page
	$first = "<a class='page-link' href=\"index.php?p=1\">First</a>";

	// last page
	$last_page_no = ceil($total_rows / $rows_per_page);
	$last = "<a class='page-link' href=\"index.php?p={$last_page_no}\">Last</a>";

	// next page
	if ($page_no >= $last_page_no) {
		$next = "<a class='page-link'>Next</a>";
	} else {
		$next_page_no = $page_no + 1;
		$next = "<a class='page-link' href=\"index.php?p={$next_page_no}\">Next</a>";
	}

	// previous page
	if ($page_no <= 1) {
		$prev = "<a class='page-link'>Back</a>";
	} else {
		$prev_page_no = $page_no - 1;
		$prev = "<a class='page-link' href=\"index.php?p={$prev_page_no}\">Back</a>";
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
					<?php require 'navigation/navigation_current.php';
								echo $nav;
					?>
          <div class="card">

              <div class="card-header">
                <a href="create.php" class="btn btn-success pull-right ml-3" title="Add New Outage" data-toggle="tooltip"><i class="fa fa-plus mr-2"></i>Add New Outage</a>
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
    <!-- <script>
    $(".copy-btn").click(function() {
      let tmpElement = $('<textarea style="opacity:0;"></textarea>');
      let parent = $(this).closest('td').next().each(function(){
        tmpElement.text(tmpElement.text() + $(this).text() + '\t');
      });

      tmpElement.appendTo($('body')).focus().select();
      document.execCommand("copy");
      tmpElement.remove();
    });
      </script> -->
</body>
</html>
