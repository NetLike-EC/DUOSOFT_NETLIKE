<?php require_once('../../init.php');
$qry=genCadSearchPac($_GET['term']);
$RSjson = mysqli_query($conn,$qry) or die(mysqli_error($conn));
while($row = mysqli_fetch_array($RSjson)){
	$datos[] = array(
		'code' => $row['idc'],
		'ids' => md5($row['idc']),
		'value' => $row['cli_nom'].' '.$row['cli_ape'],
		'label' => $row['cli_nom'].' '.$row['cli_ape'] //Esto Muestra
	);
}
echo json_encode($datos);
?>