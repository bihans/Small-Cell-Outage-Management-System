<?php

require '../session/session-2.php';

?>

<!DOCTYPE html>
<html lang="en">
	<head>
		<title>All Site List</title>
		<link rel="icon" href="../images/fevi.png" type="image/x-icon"/>
    <link rel="stylesheet" type="text/css" href="../css/background.css">
		<!-- JS, Popper.js, and jQuery -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.7.0/css/font-awesome.min.css">
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.1/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

    <script src="https://cdn.datatables.net/1.10.22/js/jquery.dataTables.min.js"></script>
		<script src="https://cdn.datatables.net/1.10.22/js/dataTables.bootstrap4.min.js"></script>

    <link rel="stylesheet" href="https://cdn.datatables.net/1.10.22/css/dataTables.bootstrap4.min.css" />
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/css/bootstrap-select.min.css">
  	<script src="https://cdn.jsdelivr.net/npm/bootstrap-select@1.13.14/dist/js/bootstrap-select.min.js"></script>

	</head>
	<body>
		<div class="container-fluid mt-3 mb-3" >
			<?php require '../navigation/navigation_allsite.php';
						echo $nav;
			?>
			<div class="card">

				<div class="card-header">
                  <a href="../site-list/createsite.php" class="btn btn-success pull-right" title="Add New Site" data-toggle="tooltip"><i class="fa fa-plus mr-2"></i>Add New Site</a>

					<div class="row">

						<div class="col-lg-3">
							<select name="column_name" id="column_name" class="form-control selectpicker" multiple>
								<option value="0">Site Index</option>
						      	<option value="1">Type</option>
						      	<option value="2">NE Name</option>
						      	<option value="3">Site Name</option>
						      	<option value="4">Region</option>
                    <option value="5">Action</option>
							</select>
						</div>
					</div>
				</div>
				<div class="card-body">
					<div class="table-responsive">
						<table id="sample_data" class="table table-bordered table-striped">
							<thead>
								<tr>
									<th>Site Index</th>
									<th>Type</th>
									<th>NE</th>
									<th>Site</th>
									<th>Region</th>
                  <th>Action</th>
								</tr>
							</thead>
						</table>
					</div>
				</div>
        <div class="card-footer text-white bg-dark">
          <?php require '../footer/footer.php';
                echo $footer; ?>
        </div>
			</div>
		</div>
		<br />
		<br />
	</body>

	<script type="text/javascript">
  $('body').tooltip({selector: '[data-toggle="tooltip"]'});

	$(document).ready(function(){

		var dataTable = $('#sample_data').DataTable({
			"processing" : true,
			"serverSide" : true,
			"order" : [],
			"ajax" : {
				url:"fetch.php",
				type:"POST"
			}
		});

		$('#column_name').selectpicker();

		$('#column_name').change(function(){

			var all_column = ["0", "1", "2", "3", "4","5"];

			var remove_column = $('#column_name').val();

			var remaining_column = all_column.filter(function(obj) { return remove_column.indexOf(obj) == -1; });

			dataTable.columns(remove_column).visible(false);

			dataTable.columns(remaining_column).visible(true);

		});

	});
	</script>



</html>
