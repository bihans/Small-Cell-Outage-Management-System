<?php
//index.php
require "../db/connection.php";

$query = "SELECT * FROM current_outage_table WHERE status='1'";
$result = mysqli_query($connection, $query);
$donut_data = '';
$chart_data = '';
$line_data = '';
while($row = mysqli_fetch_array($result))
{
  $donut_data .= "{label:'".$row["clearedreason"]."', value:".$row["duration"]."},";
  $chart_data .= "{ Region:'".$row["region"]."', Duration:".$row["duration"]."},";
  $line_data .= "{ y: '".$row["occured_time"]."', a:".$row["duration"].", b:".$row["duration"]."},";

}



?>


<!DOCTYPE html>
<html>
 <head>
  <title>Small Cell Outage | Analysis</title>
  <link rel="icon" href="../images/fevi.png" type="image/x-icon"/>
  <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css" integrity="sha384-Vkoo8x4CGsO3+Hhxv8T/Q5PaXtkKtu6ug5TOeNV6gBiFeWPGFN9MuhOf23Q9Ifjh" crossorigin="anonymous">
  <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.css">
  <script src="//ajax.googleapis.com/ajax/libs/jquery/1.9.0/jquery.min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/raphael/2.1.0/raphael-min.js"></script>
  <script src="//cdnjs.cloudflare.com/ajax/libs/morris.js/0.5.1/morris.min.js"></script>

  <script src="https://code.jquery.com/jquery-3.4.1.slim.min.js" integrity="sha384-J6qa4849blE2+poT4WnyKhv5vZF5SrPo0iEjwBvKU7imGFAV0wwj1yYfoRSJoZ+n" crossorigin="anonymous"></script>
  <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js" integrity="sha384-Q6E9RHvbIyZFJoft+2mJbHaEWldlvI9IOYy5n3zV9zzTtmI3UksdQRVvoxMfooAo" crossorigin="anonymous"></script>
  <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js" integrity="sha384-wfSDF2E50Y2D1uUdj0O3uMBJnjuUD4Ih7YwaYd1iqfktj0Uod8GCExl3Og8ifwB6" crossorigin="anonymous"></script>

 </head>
 <body>
  <div class="container">
    <div class="row">
      <div class="col-md-6" id="donut1"></div>
      <div class="col-md-6" id="chart"></div>
      <div class="col-md-6" id="line"></div>
    </div>
  </div>
 </body>
</html>

<script>

Morris.Donut({
  element: 'donut1',
  data: [
    <?php echo $donut_data; ?>
  ]
});


Morris.Bar({
 element : 'chart',
 data:[<?php echo $chart_data; ?>],
 xkey:'Region',
 ykeys:['Duration'],
 labels:['Duration'],
 hideHover:'auto',
 stacked:true
});

Morris.Line({
  element: 'line',
  data: [
    <?php echo $line_data; ?>
  ],
  xkey: 'y',
  ykeys: ['a','b'],
  labels: ['Series A','Series B']
});



</script>
