<?php require_once('../../init.php');
$qry=genCadSearchPac($_GET['term']);
$RSjson = mysql_query($qry) or die(mysql_error());
while($row = mysql_fetch_array($RSjson)){
	$datos[] = array(
		'code' => $row['pac_cod'],
		'value' => $row['pac_nom'].' '.$row['pac_ape'],
		'label' => $row['pac_nom'].' '.$row['pac_ape'] //Esto Muestra
	);
}
echo json_encode($datos);
?>