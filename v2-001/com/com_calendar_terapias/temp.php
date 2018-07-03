<?php include('../../init.php');
$datefc=$_POST['fecha'];
$datefe=$_POST['datefc'];

$dfc=explode("T", $datefc);
$dfe=explode("T", $datefe);	
	$dfc_fechai=$dfc[0];
	$dfc_horai=$dfc[1];
	$dfc_fechaf=$dfe[0];
	$dfc_horaf=$dfe[1];
	if(!$datefe){
		$dfc_fechaf=$dfc[0];
		if($dfc_horai){
			$dfc_horaf=strtotime ('+30 mins',strtotime($dfc_horai));
			$dfc_horaf=date('H:i:s',$dfc_horaf);
		}
	}
$_SESSION['dct']["fecha_ini"]=$dfc_fechai;
$_SESSION['dct']["hora_ini"]=$dfc_horai;
$_SESSION['dct']["fecha_fin"]=$dfc_fechaf;
$_SESSION['dct']["hora_fin"]=$dfc_horaf;
?>