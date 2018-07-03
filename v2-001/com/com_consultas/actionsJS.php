<?php include('../../init.php');
$tbl=$_REQUEST['tbl'];
$field=$_REQUEST['campo'];
$param=$_REQUEST['valor'];
$id=$_REQUEST['cod'];
if($tbl=='con'){
	if($id){
	$_SESSION['tab']['con']='cCON';
	$qryUpd=sprintf('UPDATE db_consultas SET %s=%s WHERE con_num=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Consulta Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}
	}else{
		$res=FALSE;
		$LOG.='No hay Consulta, Guardar Consulta';
	}
}
if($tbl=='gin'){
	$_SESSION['tab']['con']=NULL;
	$qryUpd=sprintf('UPDATE db_ginecologia SET %s=%s WHERE gin_id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Ginecologia Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
if($tbl=='hc'){
	$_SESSION['tab']['con']=NULL;
	$qryUpd=sprintf('UPDATE db_paciente_hc SET %s=%s WHERE hc_id=%s',
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($id,'int'));
	if(mysql_query($qryUpd)){
		$LOG.='Datos Historia Guardados';
		$res=TRUE;
	}else{
		$LOG.='Error Actualizar. ';
		$LOG.=mysql_error();
		$res=FALSE;
	}	
}
echo json_encode( array( "cod"=>$id,"res"=>$res,"inf"=>$LOG) );
?>