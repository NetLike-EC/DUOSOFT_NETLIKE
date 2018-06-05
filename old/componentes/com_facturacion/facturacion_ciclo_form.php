<?php require_once('Connections/conn_servisoft.php'); ?>
<?php session_start(); ?>
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

mysql_select_db($database_conn_servisoft, $conn_servisoft);
$query_RS_last_fact_fisica = "SELECT * FROM tbl_factura_cab ORDER BY fac_cic_id, fac_num DESC LIMIT 1";
$RS_last_fact_fisica = mysql_query($query_RS_last_fact_fisica, $conn_servisoft) or die(mysql_error());
$row_RS_last_fact_fisica = mysql_fetch_assoc($RS_last_fact_fisica);
$totalRows_RS_last_fact_fisica = mysql_num_rows($RS_last_fact_fisica);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
<?php include('_libs2.php'); ?>
<?php include('_styles.php'); ?>
<?php include('_fncts.php'); ?>
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextarea.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<script type="text/javascript">
	$(function() {		
		$("#mytable").tablesorter({widgets: ['zebra']});
	});
</script>
<script type="text/javascript" src="js/js_carga_ciclos-fac.js"></script>

<script type="text/javascript">
function load_form_ciclo(){
Shadowbox.open({
		content:    'facturacion_ciclo_form.php',
        player:     "iframe",
        title:      "<strong>CIERRE CICLO FACTURACIÓN</strong>",
        options: 	{relOnClose:true},
        height:     400,
        width:      350
    });
}
</script>
<link href="SpryAssets/SpryValidationTextarea.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>
<body bgcolor="#FFFFFF">
<div id="head_sec" align="center"><a href="#" class="link">CICLOS FACTURACIÓN</a></div>
<div id="cont_head" style="background-color:#FFFFFF;" align="center">
<form id="form_ciclof" name="form_ciclof" method="post" action="facturacion_ciclo_close.php">
<table class="main" align="center" width="90%">
        	<tr>
            	<td rowspan="5" class="text_sec_blue_min2" align="center">Ciclo Anterior:</td>
            	<td class="tit_sec_gray">ID</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_id']; ?></td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Factura Inicio</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_ini']; ?></td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Facturas Creadas</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_cont']; ?></td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Ultima Factura</td>
                <?php $last_fact=$row_RS_fact_act['fac_cic_ini']+$row_RS_fact_act['fac_cic_cont']; ?>
              <td class="text_sec_blue_min"><?php echo $row_RS_last_fact_fisica['fac_num']; ?> :: Ciclo: [<?php echo $row_RS_last_fact_fisica['fac_cic_id']; ?>]</td>
            </tr>
            <tr>
            	<td class="tit_sec_gray">Observaciones Cierre</td>
              <td class="text_sec_blue_min"><span id="spry_txt_obs">
              <label>
                <textarea name="txt_obs2" id="txt_obs2" cols="20" rows="3"></textarea>
              <span id="countspry_txt_obs">&nbsp;</span></label><br />
              <span class="textareaRequiredMsg">Se necesita un valor.</span><span class="textareaMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textareaMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span></td>
            </tr>
            <tr>
            	<td rowspan="3" class="text_sec_blue_min2" align="center"><span style="font-weight:bold;">Ciclo Nuevo:</span></td>
            	<td class="tit_sec_gray">Factura Inicial</td>
              <td class="text_sec_blue_min"><span id="spry_txt_ini">
              <label>
                <input name="txt_fac_ini" type="text" id="txt_fac_ini" size="20" maxlength="7" />
              </label><br />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldInvalidFormatMsg">Formato no válido.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span><span class="textfieldMinValueMsg">El valor introducido es inferior al mínimo permitido.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMaxValueMsg">El valor introducido es superior al máximo permitido.</span></span></td>
            </tr>
            <tr>
            	<td class="tit_sec_gray">Serie Facturacion</td>
              <td class="text_sec_blue_min"><span id="sprytextfield2">
              <label>
                <input name="txt_serie" type="text" id="txt_serie" size="20" maxlength="15" />
              </label><br />
              <span class="textfieldRequiredMsg">Se necesita un valor.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span></span></td>
            </tr>
            <tr>
            	<td class="tit_sec_gray">Responsable</td>
              <td class="text_sec_blue_min"><input name="id_emp" type="hidden" id="id_emp" value="<?php echo $_SESSION['MM_UserId']; ?>" />                <?php echo detalle_empleado($_SESSION['MM_UserId']);//Empleado Responsable ?></td>
            </tr>
			<tr>
            	<td colspan="3" style="padding:10px;" align="center"><label>
           	      <input style="padding:5px; height:40px;" type="submit" name="btn_fin_ciclo" id="btn_fin_ciclo" value="Cerrar Ciclo y Crear Nuevo" />
          	    </label></td>
            </tr>

</table>
</form>
</div>
<div id="cont_head" style="background-color:#FFFFFF;" align="center">
</div>
<script type="text/javascript">
<!--
var sprytextarea1 = new Spry.Widget.ValidationTextarea("spry_txt_obs", {minChars:1, maxChars:100, validateOn:["blur"], counterId:"countspry_txt_obs", counterType:"chars_remaining"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_txt_ini", "integer", {useCharacterMasking:true, validateOn:["blur"], minChars:1, minValue:1, maxChars:7, maxValue:9999999});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {maxChars:15, validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_fact_act);

mysql_free_result($RS_last_fact_fisica);
?>
