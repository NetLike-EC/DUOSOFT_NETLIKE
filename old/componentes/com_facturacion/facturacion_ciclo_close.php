<?php require_once('Connections/conn_servisoft.php'); ?>
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

mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_fact_act = "SELECT * FROM tbl_factura_ciclosf ORDER BY fac_cic_id DESC LIMIT 1";
$RS_fact_act = mysql_query($query_RS_fact_act, $conn_servisoft) or die(mysql_error());
$row_RS_fact_act = mysql_fetch_assoc($RS_fact_act);
$totalRows_RS_fact_act = mysql_num_rows($RS_fact_act);
?>
<?php include('_libs2.php'); ?>
<?php include('_styles.php'); ?>
<?php include('_fncts.php'); ?>
<!-- BEGIN ACTIONS -->

<?php
	$id_emp = $_POST['id_emp'];//Empleado Responsable
	$fec_sys=date("Y-m-d H:i:s");//Fecha de Compra
	$obs=$_POST['txt_obs'];
	$fac_ini=$_POST['txt_fac_ini'];
	$fac_serie=$_POST['txt_serie'];
	$id_cic_act=$row_RS_fact_act['fac_cic_id'];
	
	$qry_update_sec_ant="UPDATE tbl_factura_ciclosf SET fac_cic_observ='".$obs."', fac_cic_emp_cod_fin=".$id_emp." WHERE fac_cic_id=".$id_cic_act;
	if(@mysql_query("$qry_update_sec_ant")or($LOG.=mysql_error()))
	{
		$LOG.="Secuencia Anterior Cerrada ID: ".$id_cic_act.". <br />";
	}else{
		$LOG.="Secuencia Anterior *** ERROR *** ".$id_cic_act.". <br />";
	}
	
	if(@mysql_query("INSERT INTO tbl_factura_ciclosf (fac_cic_ini, fac_cic_cont, fac_cic_serie, fac_cic_emp_cod_ini) VALUES ('$fac_ini', '0', '$fac_serie', '$id_emp')")or($LOG.=mysql_error()))//GRABAR CABECERA FACTURA
	{
		$LOG.="Nueva Secuencia Creada <br />";
	}else{
		$LOG.="Nueva Secuencia No CREADA *** ERROR *** <br />";
	}

		$LOG.="Proceso Satisfactorio";
		$_SESSION['LOG']=$LOG;
		
		//echo $LOG;
	echo '<script type="text/javascript">
	parent.Shadowbox.close();
	</script>';
	
		//header("Location:facturacion.php?LOG=".$LOG."&fac_num=".$fac_num);
?>

<!-- END ACTIONS -->

<?php
mysql_free_result($RS_fact_act);
?>
