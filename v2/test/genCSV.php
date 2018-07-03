<?php require('../init.php');
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=data.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

// output the column headings
fputcsv($output, array('Column 1', 'Column 2', 'Column 3'));

// fetch the data
unset($rows);
$rows[0][0]='ID-1';
$rows[0][1]='NOM-1';
$rows[0][2]='VAL-1';
$rows[1][0]='ID-2';
$rows[1][1]='NOM-2';
$rows[1][2]='VAL-2';
//$rows = mysql_query('SELECT item_id,item_cod,brand_id FROM tbl_items LIMIT 50');

// loop over the rows, outputting them
//while ($row = mysql_fetch_assoc($rows)) fputcsv($output, $row);

foreach($rows as $row){
	fputcsv($output, $row);
}
?>