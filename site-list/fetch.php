<?php

//fetch.php
require '../session/session-2.php';
require "../db/db-connect.php";

$column = array("site_index", "type", "ne_name", "site_name", "region","action");

$query = "SELECT * FROM sitelist ";

if(isset($_POST["search"]["value"]))
{
	$query .= '
	WHERE site_index LIKE "%'.$_POST["search"]["value"].'%"
	OR type LIKE "%'.$_POST["search"]["value"].'%"
	OR ne_name LIKE "%'.$_POST["search"]["value"].'%"
	OR site_name LIKE "%'.$_POST["search"]["value"].'%"
	OR region LIKE "%'.$_POST["search"]["value"].'%"
	';
}

if(isset($_POST["order"]))
{
	$query .= 'ORDER BY '.$column[$_POST['order']['0']['column']].' '.$_POST['order']['0']['dir'].' ';
}
else
{
	$query .= 'ORDER BY site_index ASC ';
}

$query1 = '';

if($_POST["length"] != -1)
{
	$query1 = 'LIMIT ' . $_POST['start'] . ', ' . $_POST['length'];
}

$statement = $connect->prepare($query);

$statement->execute();

$number_filter_row = $statement->rowCount();

$result = $connect->query($query . $query1);

$data = array();

foreach($result as $row)
{
	$sub_array = array();
	$sub_array[] = $row['site_index'];
	$sub_array[] = $row['type'];
	$sub_array[] = $row['ne_name'];
	$sub_array[] = $row['site_name'];
	$sub_array[] = $row['region'];
	$sub_array[] = "
	<a href='action/update-newsite.php?id={$row['site_index']}' class='ml-2 mr-2' title='Update Record' data-toggle='tooltip'><span class='fa fa-pencil'></span></a>
	<a href='action/delete-newsite.php?id={$row['site_index']}' class='text-danger mr-2' title='Delete Record' data-toggle='tooltip'><span class='fa fa-trash'></span></a>
	<a class='text-success mr-2' title='Location:{$row['address']}' data-toggle='tooltip'><span class='fa fa-street-view'></span></a>
	<a class='text-warning mr-2' title='Mobile: {$row['contact']}' data-toggle='tooltip'><span class='fa fa-phone-square'></span></a>
	<a class='text-info' title='Onair: {$row['onair']} {$row['reportedby']}' data-toggle='tooltip'><span class='fa fa-calendar'></span></a>
	";
	$data[] = $sub_array;
}

function count_all_data($connect)
{
	$query = "SELECT * FROM sitelist";

	$statement = $connect->prepare($query);

	$statement->execute();

	return $statement->rowCount();
}

$output = array(
	"draw"		=>	intval($_POST["draw"]),
	"recordsTotal"	=>	count_all_data($connect),
	"recordsFiltered"	=>	$number_filter_row,
	"data"	=>	$data
);

echo json_encode($output);

?>
