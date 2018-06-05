<?php require_once('Connections/conn_servisoft.php'); ?>
<?php
if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;

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
      $theValue = ($theValue != "") ? "'" . doubleval($theValue) . "'" : "NULL";
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

mysql_select_db($database);
$query_RS_caja_chica = "SELECT * FROM tbl_caja_chica ORDER BY tbl_caja_chica.caj_chi_id DESC LIMIT 1";
$RS_caja_chica = mysql_query($query_RS_caja_chica, $conn_servisoft) or die(mysql_error());
$row_RS_caja_chica = mysql_fetch_assoc($RS_caja_chica);
$totalRows_RS_caja_chica = mysql_num_rows($RS_caja_chica);

mysql_select_db($database);
$query_RS_fact_act = "SELECT * FROM tbl_factura_ciclosf ORDER BY fac_cic_id DESC LIMIT 1";
$RS_fact_act = mysql_query($query_RS_fact_act, $conn_servisoft) or die(mysql_error());
$row_RS_fact_act = mysql_fetch_assoc($RS_fact_act);
$totalRows_RS_fact_act = mysql_num_rows($RS_fact_act);
 session_start(); ?>
<?php
include('_fncts.php');
if($_SESSION['stat_proc']=='PROCESS')
{
	$fac_num=$row_RS_fact_act['fac_cic_ini']+$row_RS_fact_act['fac_cic_cont'];
	$fac_cic_id=$row_RS_fact_act['fac_cic_id'];
	$fac_serie=$row_RS_fact_act['fac_cic_serie'];
	$id_cli = $_SESSION['id_pac'];//Proveedor a Grabar
	$id_emp = $_SESSION['MM_UserId'];//Empleado Responsable
	$dias_cred = $_POST['dias_cred'];
	$productos = $_SESSION[$ses_id]['compra'];//Lista de Productos a Comprar
	$fec_sys=date("Y-m-d H:i:s");//Fecha de Compra
	$tip_pag = $_POST['tip_pag'];//Tipo de Pago
	
	if(@mysql_query("INSERT INTO tbl_factura_cab (fac_num, fac_cic_id, fac_fec, fac_tip, cli_cod, emp_cod) VALUES ('$fac_num', '$fac_cic_id', '$fec_sys', '1', '$id_cli', '$id_emp')")or($LOG.=mysql_error()))//GRABAR CABECERA FACTURA
	{
		//$fac_num=mysql_insert_id();//ID Compra Insertada
		$subtotal=0;
		foreach ($productos as $v)//GRABAR DETALLES FACTURA
		{
			$id_prod_det=$v["id"];
			$id_prod_can=$v["can"];
			$id_prod_pre=$v["pre"];
			$subtotal=$subtotal+($id_prod_can*$id_prod_pre);
			@mysql_query("INSERT INTO tbl_factura_det (fac_num, fac_cic_id, prod_cod, fac_prod_can, fac_prod_pre) VALUES ('$fac_num', '$fac_cic_id', '$id_prod_det', '$id_prod_can', '$id_prod_pre')")
			or($LOG.=mysql_error());

			//ACTUALIZAR INVENTARIO
			$LOG.=actualizacion_inventario_venta($id_prod_det, $id_prod_can);
		}
		$iva=$subtotal*$_SESSION['conf']['taxes']['iva_si'];
		$tot_fac=$subtotal+$iva;
		$tot_fac=number_format($tot_fac,2,".","");//CALCULAR
		
		/*TIPOS DE PAGO      $tip_pag:  -1 = NO VALE	 1 = CONTADO  2 = CHEQUE  3 = CREDITO  */
		if($tip_pag=='1')//Pago de Contado
		{
			//REGISTRAR VALOR EN CAJA
			$qry_add_caja="INSERT INTO tbl_caja ( caja_val , caja_des , caja_fec , emp_cod )
			VALUES ( '$tot_fac', 'Factura Venta $fac_serie $fac_num', '$fec_sys', '$id_emp')";
			@mysql_query($qry_add_caja);
			$LOG.="Caja Actualizada [OK]<br />";
			
			//ACTUALIZAR VALOR CAJA CHICA
			$val_act_caja=$row_RS_caja_chica['caj_chi_val_act']+$tot_fac;
			$qry_add_caja_chica="UPDATE tbl_caja_chica SET caj_chi_val_act=".$val_act_caja." WHERE caj_chi_id=".$row_RS_caja_chica['caj_chi_id'];
			if(@mysql_query("$qry_add_caja_chica")or($LOG.=mysql_error()))
				$LOG.="Caja Chica Actualizada. Actualmente: ".$val_act_caja.". <br />";
		}else{
			if($tip_pag=='2')//Pago con Cheque
			{
				if(@mysql_query("INSERT INTO tbl_cta_x_cob (fac_num, fac_cic_id, fec_ini, cta_plazo, cta_valor, cta_abono, emp_cod) 
				VALUES ('$fac_num', '$fac_cic_id', '$fec_sys', '0', '$tot_fac', 0, '$id_emp')")or($LOG.=mysql_error()))
					$LOG.="Creada Cuenta X Cobrar [OK]<br />";
			}else{
				if($tip_pag=='3')//Pago Credito
				{
					//CREACION CUENTA POR COBRAR
					if(@mysql_query("INSERT INTO tbl_cta_x_cob (fac_num, fac_cic_id, fec_ini, cta_plazo, cta_valor, cta_abono, emp_cod) 
					VALUES ('$fac_num', '$fac_cic_id', '$fec_sys', '$dias_cred', '$tot_fac', 0, '$id_emp')")or($LOG.=mysql_error()))
						$LOG.="Creada Cuenta X Cobrar [OK]<br />";
				}
			}
		}
		
		$qry_update_num_fac="UPDATE tbl_factura_ciclosf SET fac_cic_cont=fac_cic_cont+1 WHERE fac_cic_id=".$row_RS_fact_act['fac_cic_id'];
			if(@mysql_query("$qry_update_num_fac")or($LOG.=mysql_error()))
				$LOG.="Secuencia Facturación Actualizada <br />";
		
		$_SESSION['stat_proc']='SAVED'; // Para Evitar Duplicar Registros
		$LOG.="FACTURA Grabada Correctamente";
		header("Location:factura_detail.php?LOG=".$LOG."&fac_num=".$fac_num);
	}
}else{

	$LOG.='FACTURA No Grabada';
	header("Location:factura_form.php?LOG=".$LOG);
}
?>
<?php
mysql_free_result($RS_caja_chica);

mysql_free_result($RS_fact_act);
?>