<?php

require '../session/session-2.php';
?>

<!doctype html>
<html lang="en">

<head>
  <link rel="icon" href="../images/fevi.png" type="image/x-icon"/>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <link rel="stylesheet" type="text/css" href="../css/background.css">
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css"
        integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">

    <!-- Datepicker -->
    <link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">

    <!-- Datatables -->
    <link rel="stylesheet" type="text/css"
        href="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.css" />

    <title>Q Site Outage | Outage</title>
</head>

<body>
    <div class="container-fluid mt-3 mb-3">
      <?php require '../navigation/navigation_report.php';
            echo $nav;

      ?>
      <div class="card">
        <div class="card-header">
          <div class="row mt-3">
              <div class="col-md-5">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-info text-white" id="basic-addon1"><i
                                  class="fas fa-calendar-alt"></i></span>
                      </div>
<!--input start_date -->         <input type="text" class="form-control" id="start_date" placeholder="Start Date" readonly>
                  </div>
              </div>
              <div class="col-md-5">
                  <div class="input-group mb-3">
                      <div class="input-group-prepend">
                          <span class="input-group-text bg-info text-white" id="basic-addon1"><i
                                  class="fas fa-calendar-alt"></i></span>
                      </div>
<!--input end_date -->         <input type="text" class="form-control" id="end_date" placeholder="End Date" readonly>
                  </div>
              </div>
              <div class="col-md-2 mt-1">

                <button id="filter" class="btn btn-outline-info btn-sm mr-2">Filter</button>
                <button id="reset" class="btn btn-outline-warning btn-sm">Reset</button>
              </div>
          </div>
        </div>
        <div class="row p-3">
            <div class="col-md-12">

                <div class="row mt-3">
                    <div class="col-md-12">
                        <!-- Table -->
                        <div class="table-responsive">
  <!--table records -->           <table class="table table-borderless display nowrap" id="records" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>Outage ID</th>
                                        <th>Type</th>
                                        <th>Site Name</th>
                                        <th>Occ Date</th>
                                        <th>Clear Date</th>
                                        <th>Duration</th>
                                        <th>Region</th>
                                        <th>Reported To</th>
                                        <th>Reported By</th>
                                        <th>Repo Date</th>
                                        <th>Reason</th>
                                        <th>TX Repo</th>
                                        <th>Reason Category</th>
                                    </tr>
                                </thead>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-white bg-dark">
          <?php require '../footer/footer.php';
                echo $footer; ?>
        </div>
      </div>

    </div>

    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://code.jquery.com/jquery-3.5.0.min.js"
        integrity="sha256-xNzN2a4ltkB44Mc/Jz3pT4iU1cmeR0FkXs4pru/JxaQ=" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"
        integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous">
    </script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"
        integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous">
    </script>
    <!-- Font Awesome -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.13.0/js/all.min.js"></script>
    <!-- Datepicker -->
    <script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
    <!-- Datatables -->
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/pdfmake.min.js"></script>
    <script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.36/vfs_fonts.js"></script>
    <script type="text/javascript"
        src="https://cdn.datatables.net/v/bs4/jszip-2.5.0/dt-1.10.20/b-1.6.1/b-flash-1.6.1/b-html5-1.6.1/b-print-1.6.1/r-2.2.3/datatables.min.js">
    </script>
    <!-- Momentjs -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.24.0/moment.min.js"></script>

    <script>
    $(function() {
        $("#start_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
        $("#end_date").datepicker({
            "dateFormat": "yy-mm-dd"
        });
    });
    </script>

    <script>
    // Fetch records

    function fetch(start_date, end_date) {
        $.ajax({
            url: "records.php",
            type: "POST",
            data: {
                start_date: start_date,
                end_date: end_date
            },
            dataType: "json",
            success: function(data) {
                // Datatables

                $('#records').DataTable({
                    "data": data,
                    // buttons
                    //  l - length changing input control
                    //  f - filtering input
                    //  t - The table!
                    //  i - Table information summary
                    //  p - pagination control
                    //  r - processing display element

                    "dom": "<'row'<'col-sm-12 col-md-4'l><'col-sm-12 col-md-4'B><'col-sm-12 col-md-4'f>>" +
                        "<'row'<'col-sm-12'tr>>" +
                        "<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7'p>>",
                    "buttons": [
                        'copy', 'csv', 'excel', 'pdf', 'print'
                    ],
                    // responsive
                    "responsive": true,
                    "columns": [{
                            "data": "outage_id"
                        },
                        {
                            "data": "type"
                        },
                        {
                            "data": "site_name",
                            "render": function(data, type, row, meta) {
                                return `${row.site_name}`;
                            }
                        },
                        {
                            "data": "occured_time",
                            "render": function(data, type, row, meta) {
                                return moment(row.occured_time).format('YYYY-MM-DD');
                            }
                        },


                          {
                              "data": "cleared_date"
                        },
                        {
                            "data": "duration",
                            "render": function(data, type, row, meta) {
                                return `${row.duration} min`;
                            }
                        },

                        {
                            "data": "region",
                            "render": function(data, type, row, meta) {
                                return `${row.region}`;
                            }
                        },
                        {
                            "data": "reported_to"
                        },
                        {
                            "data": "reported_by"
                        },
                        {
                            "data": "reported_time",
                            "render": function(data, type, row, meta) {
                                return moment(row.reported_time).format('YYYY-MM-DD');
                            }
                        },

                        {
                            "data": "reason_for_fault"
                        },
                        {
                            "data": "tx_reported_to"
                        },

                        {
                            "data": "clearedreason"
                        }
                    ]
                });
            }
        });
    }
    fetch();

    // Filter

    $(document).on("click", "#filter", function(e) {
        e.preventDefault();

        var start_date = $("#start_date").val();
        var end_date = $("#end_date").val();

        if (start_date == "" || end_date == "") {
            alert("both date required");
        } else {
            $('#records').DataTable().destroy();
            fetch(start_date, end_date);
        }
    });

    // Reset

    $(document).on("click", "#reset", function(e) {
        e.preventDefault();

        $("#start_date").val(''); // empty value
        $("#end_date").val('');

        $('#records').DataTable().destroy();
        fetch();
    });
    </script>
</body>

</html>
