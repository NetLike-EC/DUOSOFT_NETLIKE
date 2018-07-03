<?php include('../../init.php');
$data=$_REQUEST;
$val=sendMail_MC_Test($data);
if($val['EST']) $est="TRUE";
else $est="FALSE";
$datos = array(
		'est' => $est,
		'res' => $val['RES']
	);
echo json_encode($datos);
?>