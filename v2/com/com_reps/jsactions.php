<?php include('../../init.php');
$tbl=$_REQUEST['tbl'];
$field=$_REQUEST['campo'];
$param=$_REQUEST['valor'];
$id=$_REQUEST['cod'];

if($tbl=='repObs'){
	$qryInsRepDet=sprintf('UPDATE db_rep_obs_detalle SET %s=%s WHERE id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryInsRepDet)){
		$LOG.='Datos Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}
}
if($tbl=='repEco'){
	if($id){
	$qryInsRepDet=sprintf('UPDATE db_rep_eco SET %s=%s WHERE id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryInsRepDet)){
		$LOG.='Datos Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}
	}else{
		$LOG.='No Olvide GUARDAR->';
	}
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>