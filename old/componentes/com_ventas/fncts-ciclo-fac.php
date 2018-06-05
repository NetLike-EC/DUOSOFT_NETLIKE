<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$action=vParam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
if((isset($_POST['form']))&&($_POST['form']=='form_cf')){
	if((isset($action))&&($action=='CIERRE')){
			//ACTUALIZA Y CIERRA CICLO ANTERIOR
			$aud=AUD('Cierre Ciclo Facturacion');
			$qry_fc=sprintf('UPDATE tbl_factura_ciclosf SET faccic_observ=%s, aud_id_fin=%s WHERE faccic_id=%s',
			GetSQLValueString($_POST['txt_fac_obs'],'text'),
			GetSQLValueString($aud,'int'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry_fc)){ 
				$LOG.="<h4>Ciclo Anterior Cerrado Correctamente.</h4>";
			}else $LOG.=mysql_error().'<h4>Error al Grabar</h4>';
			//CREA NUEVO CICLO
			$aud=AUD('Crea Nuevo Ciclo');
			$qry_ic=sprintf('INSERT INTO tbl_factura_ciclosf (faccic_ini, faccic_observ, faccic_serie, aud_id_ini) VALUES (%s,%s,%s,%s)',
			GetSQLValueString($_POST['txt_fac_ini'],'text'),
			GetSQLValueString($_POST['txt_fac_obs'],'text'),
			GetSQLValueString($_POST['txt_fac_ser'],'text'),
			GetSQLValueString($aud,'int'));
			if(@mysql_query($qry_ic)){ 
				$id=@mysql_insert_id(); 
				$LOG.="<h4>Creado Correctamente.</h4>";
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
}


$LOG.=mysql_error();
//COMMIT OR ROLLBACK

if(!(mysql_error())){
	mysql_query("COMMIT;")or(mysql_error());
	$LOG.="<h4>Ciclo COrrecto</h4>";
	$GoTo=$RAIZc."com_compras/compra_detail.php?com_num=".$com_num;
}else{
	mysql_query("ROLLBACK;")or(mysql_error());
	$LOG.="<h4>No se ha podido cerrar el ciclo, <strong>intente nuevamente</strong></h4>";
	$GoTo=$RAIZc.'com_compras/compra_form.php';
}

$_SESSION['LOG']=$LOG;

if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$insertGoTo=urlr($insertGoTo);
header(sprintf("Location: %s", $insertGoTo));
?>