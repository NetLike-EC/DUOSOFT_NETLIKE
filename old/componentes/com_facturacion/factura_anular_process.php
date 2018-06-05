<?php require_once('Connections/conn_servisoft.php'); ?>
<?php 
	session_start();
	include('_fncts.php');
	$fac_sel=$_POST['txt_fact_id'];
	$obs=$_POST['txt_obs'];
	$fac_seld = explode("-", $fac_sel);
	$fac_num = $fac_seld[0]; //echo 'Factura #: '.$fac_num.'<br />';
	$fac_cic_id = $fac_seld[1]; //echo 'Ciclo Facturacion #: '.$fac_cic_id.'<br />';
	$id_emp = $_SESSION['MM_UserId'];//Empleado Responsable
	$fec_sys=date("Y-m-d H:i:s");//Fecha de Compra

?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}

$fac_num_sel_RS_fac_det_anul = "-1";
if (isset($fac_num)) {
  $fac_num_sel_RS_fac_det_anul = $fac_num;
}
$fac_cic_id_sel_RS_fac_det_anul = "-1";
if (isset($fac_cic_id)) {
  $fac_cic_id_sel_RS_fac_det_anul = $fac_cic_id;
}
mysql_select_db($database);
$query_RS_fac_det_anul = sprintf("SELECT * FROM tbl_factura_det WHERE fac_num = %s AND fac_cic_id=%s", GetSQLValueString($fac_num_sel_RS_fac_det_anul, "int"),GetSQLValueString($fac_cic_id_sel_RS_fac_det_anul, "int"));
$RS_fac_det_anul = mysql_query($query_RS_fac_det_anul, $conn_servisoft) or die(mysql_error());
$row_RS_fac_det_anul = mysql_fetch_assoc($RS_fac_det_anul);
$totalRows_RS_fac_det_anul = mysql_num_rows($RS_fac_det_anul);

$fac_num_sel_RS_cta_x_cobrar = "-1";
if (isset($fac_num)) {
  $fac_num_sel_RS_cta_x_cobrar = $fac_num;
}
$fac_cic_id_sel_RS_cta_x_cobrar = "-1";
if (isset($fac_cic_id)) {
  $fac_cic_id_sel_RS_cta_x_cobrar = $fac_cic_id;
}
mysql_select_db($database);
$query_RS_cta_x_cobrar = sprintf("SELECT * FROM tbl_cta_x_cob WHERE fac_num = %s AND fac_cic_id=%s", GetSQLValueString($fac_num_sel_RS_cta_x_cobrar, "int"),GetSQLValueString($fac_cic_id_sel_RS_cta_x_cobrar, "int"));
$RS_cta_x_cobrar = mysql_query($query_RS_cta_x_cobrar, $conn_servisoft) or die(mysql_error());
$row_RS_cta_x_cobrar = mysql_fetch_assoc($RS_cta_x_cobrar);
$totalRows_RS_cta_x_cobrar = mysql_num_rows($RS_cta_x_cobrar);

$fac_num_sel_RS_fac_cab_det = "-1";
if (isset($fac_num)) {
  $fac_num_sel_RS_fac_cab_det = $fac_num;
}
$fac_cic_id_sel_RS_fac_cab_det = "-1";
if (isset($fac_cic_id)) {
  $fac_cic_id_sel_RS_fac_cab_det = $fac_cic_id;
}
mysql_select_db($database);
$query_RS_fac_cab_det = sprintf("SELECT * FROM tbl_factura_cab WHERE tbl_factura_cab.fac_num=%s AND tbl_factura_cab.fac_cic_id=%s", GetSQLValueString($fac_num_sel_RS_fac_cab_det, "int"),GetSQLValueString($fac_cic_id_sel_RS_fac_cab_det, "int"));
$RS_fac_cab_det = mysql_query($query_RS_fac_cab_det, $conn_servisoft) or die(mysql_error());
$row_RS_fac_cab_det = mysql_fetch_assoc($RS_fac_cab_det);
$totalRows_RS_fac_cab_det = mysql_num_rows($RS_fac_cab_det);

mysql_select_db($database);
$query_RS_caja_chica = "SELECT * FROM tbl_caja_chica ORDER BY tbl_caja_chica.caj_chi_id DESC LIMIT 1";
$RS_caja_chica = mysql_query($query_RS_caja_chica, $conn_servisoft) or die(mysql_error());
$row_RS_caja_chica = mysql_fetch_assoc($RS_caja_chica);
$totalRows_RS_caja_chica = mysql_num_rows($RS_caja_chica);
?>
<?php

//Verifico el Estado de la Factura antes de Anular
if ($row_RS_fac_cab_det['fac_stat']=='V')
{
//ACTUALIZAR ESTADO FACTURA (ENCABEZADO) ANULADO (A)
$query_upd_fac_cab="UPDATE tbl_factura_cab SET fac_stat='A', fac_obs='".$obs."' WHERE fac_num=".$fac_num." AND fac_cic_id=".$fac_cic_id;
if(@mysql_query($query_upd_fac_cab)or($LOG.=mysql_error()))//GRABAR CABECERA FACTURA
{
	//actualización de inventarios relacionados a la factura anulada
	do {
	//echo 'Factura: '.$row_RS_fac_det_anul['fac_num'].'<br />'; echo 'Ciclo: '.$row_RS_fac_det_anul['fac_cic_id'].'<br />'; 
	//echo 'Producto: '.$row_RS_fac_det_anul['prod_cod'].'<br />'; echo 'Inventario: '.$row_RS_fac_det_anul['inv_id'].'<br />'; 
	//echo 'Cantidad Ingresa: '.$row_RS_fac_det_anul['fac_prod_can'].'<br />'; echo '-------------------<br />';
	$qry_update_num_fac="UPDATE tbl_inventario SET inv_sal=inv_sal-".$row_RS_fac_det_anul['fac_prod_can']." WHERE inv_id=".$row_RS_fac_det_anul['inv_id'];
	if(@mysql_query("$qry_update_num_fac")or($LOG.=mysql_error()))
	
	$LOG.="Inventario ID: ".$row_RS_fac_det_anul['inv_id'].". Actualizado <br />";
	
	} while ($row_RS_fac_det_anul = mysql_fetch_assoc($RS_fac_det_anul));
	
	$LOG.="Factura Anulada Correctamente <br />";
}
$LOG.="Se encontraron: ".$totalRows_RS_cta_x_cobrar." Cuentas por Cobrar.<br />";
$LOG.="Cuenta por cobrar encontrada: ".$row_RS_cta_x_cobrar['cta_num']." Valor: ".$row_RS_cta_x_cobrar['cta_valor']." - Abono: ".$row_RS_cta_x_cobrar['cta_abono']."<br />";

//BUSCO INCIDENCIAS DE LA FACTURA ANULADA PARA NEUTRALIZAR
//BUSCO CTA X COBRAR
if ($totalRows_RS_cta_x_cobrar>0)
{
	if ($row_RS_cta_x_cobrar['cta_abono']==0)
	{
		$LOG.="Cta x Cobrar Sin Abonos<br />";
		//Actualización Cuenta x Cobrar sin Abonos cta_stat='A'
		$qry_upd_stat_cta="UPDATE tbl_cta_x_cob SET cta_stat='A' WHERE cta_num=".$row_RS_cta_x_cobrar['cta_num'];
		if(@mysql_query("$qry_upd_stat_cta")or($LOG.=mysql_error()));
	}else{
		$LOG.="Cta x Cobrar con Abonos Realizados<br />";
		//Insertar Egreso Cuenta Caja x el Abono
$qry_ins_egr_caja="INSERT INTO tbl_caja (caja_val, caja_des, caja_fec, emp_cod) VALUES (-".$row_RS_cta_x_cobrar['cta_abono'].", 'Egreso Caja (Anulacion Factura ".$row_RS_cta_x_cobrar['fac_num'].")', '$fec_sys', '$id_emp')";
		if(@mysql_query("$qry_ins_egr_caja")or($LOG.=mysql_error()))
		//Actualización Cuenta x Cobrar cta_stat='A'
		$qry_upd_stat_cta="UPDATE tbl_cta_x_cob SET cta_stat='A' WHERE cta_num=".$row_RS_cta_x_cobrar['cta_num'];
		if(@mysql_query("$qry_upd_stat_cta")or($LOG.=mysql_error()))
		//Actualizar Caja Chica - Restar Valor Abonado
		$val_act_caja=$row_RS_caja_chica['caj_chi_val_act']-$row_RS_cta_x_cobrar['cta_abono'];
		$qry_add_caja_chica="UPDATE tbl_caja_chica SET caj_chi_val_act=".$val_act_caja." WHERE caj_chi_id=".$row_RS_caja_chica['caj_chi_id'];
		if(@mysql_query("$qry_add_caja_chica")or($LOG.=mysql_error()))
		$LOG.="Caja Chica Actualizada. Actualmente: ".$val_act_caja.". <br />";
	}
}else{
		$valor_factura=valor_factura($fac_num, $fac_cic_id);
		$LOG.="No Existe Cuenta x Cobrar - Factura Pagada.<br />Se Devolvera al Cliente: ".$valor_factura."<br />";
		//Insertar Egreso Cuenta Caja x Valor Factura
		$qry_ins_egr_caja="INSERT INTO tbl_caja (caja_val, caja_des, caja_fec, emp_cod) VALUES (-".$valor_factura.", 'Egreso Caja (Anulacion Factura)' ".$row_RS_cta_x_cobrar['fac_num'].", '$fec_sys', '$id_emp')";
		if(@mysql_query("$qry_ins_egr_caja")or($LOG.=mysql_error()))
		//Actualizar Caja Chica - Restar Valor Factura
		$val_act_caja=$row_RS_caja_chica['caj_chi_val_act']-$valor_factura;
		$qry_add_caja_chica="UPDATE tbl_caja_chica SET caj_chi_val_act=".$val_act_caja." WHERE caj_chi_id=".$row_RS_caja_chica['caj_chi_id'];
		if(@mysql_query("$qry_add_caja_chica")or($LOG.=mysql_error()))
		$LOG.="Caja Chica Actualizada. Actualmente: ".$val_act_caja.". <br />";
}

$LOG.="***** Anulacion Correctamente *****";
}else{
	$LOG.="Factura Ya esta Anulada";
}
$_SESSION['LOG']=$LOG;
header("Location:factura_anular_gest.php");
?>
<?php
mysql_free_result($RS_fac_det_anul);
mysql_free_result($RS_cta_x_cobrar);
mysql_free_result($RS_fac_cab_det);
mysql_free_result($RS_caja_chica);
?>