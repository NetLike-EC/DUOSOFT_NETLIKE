<?php require_once('../../Connections/conn.php'); ?>
<?php

	if($_GET['id_pac']==null)
		$_GET['id_pac']=$_POST['id_pac'];
	$LOG = $_GET['LOG'];

?>
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

$id_pac_sel_RS_pac_sel = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_RS_pac_sel = $_GET['id_pac'];
}
mysql_select_db($database, $conn);
$query_RS_pac_sel = sprintf("SELECT tbl_pacientes.pac_cod, tbl_pacientes.pac_fec, tbl_pacientes.pac_nom, tbl_pacientes.pac_ape FROM tbl_pacientes WHERE tbl_pacientes.pac_cod=%s", GetSQLValueString($id_pac_sel_RS_pac_sel, "int"));
$RS_pac_sel = mysql_query($query_RS_pac_sel, $conn) or die(mysql_error());
$row_RS_pac_sel = mysql_fetch_assoc($RS_pac_sel);
$totalRows_RS_pac_sel = mysql_num_rows($RS_pac_sel);

$id_pac_sel_pen_RS_cta_deuda = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_pen_RS_cta_deuda = $_GET['id_pac'];
}
mysql_select_db($database, $conn);
$query_RS_cta_deuda = sprintf("SELECT tbl_pacientes.pac_cod,  (SELECT  SUM(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=tbl_pacientes.pac_cod) AS Deuda FROM tbl_pacientes WHERE tbl_pacientes.pac_cod=%s", GetSQLValueString($id_pac_sel_pen_RS_cta_deuda, "int"));
$RS_cta_deuda = mysql_query($query_RS_cta_deuda, $conn) or die(mysql_error());
$row_RS_cta_deuda = mysql_fetch_assoc($RS_cta_deuda);
$totalRows_RS_cta_deuda = mysql_num_rows($RS_cta_deuda);

$id_pac_sel_RS_cta_pend = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_RS_cta_pend = $_GET['id_pac'];
}
mysql_select_db($database, $conn);
$query_RS_cta_pend = sprintf("SELECT num_cta, con_num, cta_fecha, cta_detalle, cta_valor, cta_abono, cta_cantidad, (tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) AS cta_saldo FROM tbl_cta_por_cobrar WHERE tbl_cta_por_cobrar.pac_cod=%s AND tbl_cta_por_cobrar.cta_abono<tbl_cta_por_cobrar.cta_valor", GetSQLValueString($id_pac_sel_RS_cta_pend, "int"));
$RS_cta_pend = mysql_query($query_RS_cta_pend, $conn) or die(mysql_error());
$row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend);
$totalRows_RS_cta_pend = mysql_num_rows($RS_cta_pend);

$id_pac_sel_RS_pag_realiz = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_RS_pag_realiz = $_GET['id_pac'];
}
mysql_select_db($database, $conn);
$query_RS_pag_realiz = sprintf("SELECT tbl_pagopac_det.sec_pag, tbl_pagopac_det.pag_num, tbl_pagopac_det.con_num, tbl_pagopac_det.num_cta, tbl_pagopac_det.abono, tbl_pagopac_det.detalle FROM tbl_pagopac_det WHERE tbl_pagopac_det.pac_cod=%s", GetSQLValueString($id_pac_sel_RS_pag_realiz, "int"));
$RS_pag_realiz = mysql_query($query_RS_pag_realiz, $conn) or die(mysql_error());
$row_RS_pag_realiz = mysql_fetch_assoc($RS_pag_realiz);
$totalRows_RS_pag_realiz = mysql_num_rows($RS_pag_realiz);
?><!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<?php include('../../system/base/__fncts.php'); ?>
<?php include('../../system/base/__libs.php'); ?>
<?php include('../../system/base/__styles.php'); ?>
<script type="text/javascript" src="../../js/js_process_pagos.js"></script>
</head>
<body>
<div id="head_sec"><a href="#" class="link">PACIENTES PAGOS</a></div>
<div id="cont_head">
<table width="100%">
	<tr>
    <td bgcolor="#EEEEEE" style="border:1px solid #333333; margin:4px; padding:4px">
   	  <table>
      	<tr>
        	<td class="tit_min_gray">Datos Paciente</td>
            <td class="tit_sec_gray">Paciente: </td>
            <td class="sec_values"><span class="txt_values-big"><?php echo $row_RS_pac_sel['pac_nom']; ?> <?php echo $row_RS_pac_sel['pac_ape']; ?></span></td>
        	<td width="1" bgcolor="#CCCCCC">&nbsp;</td>
            <td class="tit_sec_gray">Edad: </td>
            <td class="sec_values"><strong><?php echo edad($row_RS_pac_sel['pac_fec']); ?></strong></td>
            <td width="25">&nbsp;</td>
            <td class="tit_min_gray">Deuda Pendiente: </td>
            <td class="text_sec_blue_min2"> $ <strong><?php echo $row_RS_cta_deuda['Deuda']; ?></strong></td>
        </tr>
      </table>
    </td>
    </tr>
</table>
<table width="100%">
	<tr>
    <td class="bord_gray_4cornes" style="border-bottom-color:#000000;">
   	  <table width="100%">
      	<tr>
        	<td class="tit_min_gray" align="center">Pago #: </td>
        </tr>
        <tr>
            <td>
            	<?php include('pagos_find.php'); ?>
            </td>
        </tr>
      </table>    </td>
    </tr>
</table>
<br />
<table width="100%" class="bord_gray_4cornes">
	<tr>
    	<td width="48%" valign="top">
        	<table width="100%">
            	<tr>
                	<td class="text_sec_blue_min">Pagos Pendientes:</td>
                </tr>
                <tr>
                	<td>
                    <!--BEG - TABLE PAGOS PENDIENTES-->
                    <table class="tablesorter">
                    	<thead>
                        <tr>
                        	<th width="55">Consulta</th>
                            <th width="50">Cuenta</th>
                            <th>Detalle</th>
                            <th>Valor</th>
                            <th>Abono</th>
                            <th>Saldo</th>
                            <th>Fecha</th>
						<tr>
                        </thead>
                      <tbody>
                          <?php do { ?>
                            <tr>
                              <td align="center"><?php echo $row_RS_cta_pend['con_num']; ?></td>
                              <td align="center"><?php echo $row_RS_cta_pend['num_cta']; ?></td>
                              <td><?php echo $row_RS_cta_pend['cta_detalle']; ?></td>
                              <td><?php echo $row_RS_cta_pend['cta_valor']; ?></td>
                              <td><?php echo $row_RS_cta_pend['cta_abono']; ?></td>
                              <td><?php echo $row_RS_cta_pend['cta_saldo']; ?></td>
                              <td><?php echo $row_RS_cta_pend['cta_fecha']; ?></td>
                            </tr>
                            <?php } while ($row_RS_cta_pend = mysql_fetch_assoc($RS_cta_pend)); ?>
                      </tbody>
                    </table>
                    <!--END - TABLE PAGOS PENDIENTES-->                    </td>
                </tr>
          </table>      </td>
        <td width="4%">&nbsp;</td>
        <td width="48%" valign="top">
        	<table width="100%">
            	<tr>
                	<td style="text-decoration:none; color:#FFFFFF; font-weight:bold; background-color:#999999; padding:5px 15px 5px 15px;">Pagos Realizados:</td>
                </tr>
                <tr>
                	<td>
                    <!--BEG - TABLE PAGOS PENDIENTES-->
                    <table class="tablesorter">
                    	<thead>
                        <tr>
                        	<th>Pago</th>
                            <th>ID</th>
                            <th>Valor</th>
                            <th>Detalle</th>
                            <th>Cuenta</th>
                            <th>Consulta</th>
						<tr>
                        </thead>
                      <tbody>
                        <?php do { ?>
                            <tr>
                              <td><?php echo $row_RS_pag_realiz['pag_num']; ?></td>
                              <td><?php echo $row_RS_pag_realiz['sec_pag']; ?></td>
                              <td><?php echo $row_RS_pag_realiz['abono']; ?></td>
                              <td><?php echo $row_RS_pag_realiz['detalle']; ?></td>
                              <td><?php echo $row_RS_pag_realiz['num_cta']; ?></td>
                              <td><?php echo $row_RS_pag_realiz['con_num']; ?></td>
                        </tr>
                            <?php } while ($row_RS_pag_realiz = mysql_fetch_assoc($RS_pag_realiz)); ?>
                      </tbody>
                    </table>
                    <!--END - TABLE PAGOS PENDIENTES-->                    </td>
                </tr>
          </table>      </td>
    </tr>
</table>
</div>
<table align="center" class="bord_gray_4cornes">
	<tr>
   	  <td class="log"><?php echo $LOG; ?></td>
    </tr>
</table>
</body>
</html>
<?php
mysql_free_result($RS_pac_sel);

mysql_free_result($RS_cta_deuda);

mysql_free_result($RS_cta_pend);

mysql_free_result($RS_pag_realiz);
?>
