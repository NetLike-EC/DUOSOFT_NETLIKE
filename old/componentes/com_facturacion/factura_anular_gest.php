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

mysql_select_db($database);
$query_RS_lista_facturas = "SELECT tbl_factura_ciclosf.fac_cic_serie, tbl_factura_cab.fac_num, tbl_factura_ciclosf.fac_cic_id FROM tbl_factura_cab inner join tbl_factura_ciclosf on tbl_factura_cab.fac_cic_id=tbl_factura_ciclosf.fac_cic_id WHERE tbl_factura_cab.fac_stat='V' ORDER BY tbl_factura_cab.fac_num DESC, tbl_factura_ciclosf.fac_cic_id ASC";
$RS_lista_facturas = mysql_query($query_RS_lista_facturas, $conn_servisoft) or die(mysql_error());
$row_RS_lista_facturas = mysql_fetch_assoc($RS_lista_facturas);
$totalRows_RS_lista_facturas = mysql_num_rows($RS_lista_facturas);

mysql_select_db($database);
$query_RS_cic_fac = "SELECT * FROM tbl_factura_ciclosf";
$RS_cic_fac = mysql_query($query_RS_cic_fac, $conn_servisoft) or die(mysql_error());
$row_RS_cic_fac = mysql_fetch_assoc($RS_cic_fac);
$totalRows_RS_cic_fac = mysql_num_rows($RS_cic_fac);

	session_start();
	if($_POST['id_sel']==null)
		$_POST['id_sel']=$_GET['id_sel'];
	if($_POST['action_form']==null)
		$_POST['action_form']=$_GET['action_form'];

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin t&iacute;tulo</title>
<?php include('_styles.php'); ?>
<?php include('_fncts.php'); ?>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<script src="SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />
<link href="SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css" />
</head>

<body bgcolor="#FFFFFF">
<div id="head_sec">
<a href="#" class="link">ANULACIÓN FACTURA</a></div>
<div id="cont_head">
<form id="form1" name="form1" method="post" action="factura_anular_process.php">
  <table align="center" class="bord_gray_4cornes">
    <tr>
   	  <td class="txt_name">Responsable:</td>
        <td><?php echo detalle_empleado($_SESSION['MM_UserId']); ?></td>
    </tr>
	<tr>
    	<td class="txt_name">Factura #:</td>
        <td><span id="spry_fact_id">
          <label>
            <select name="txt_fact_id" id="txt_fact_id">
              <option value="-1">Seleccione Factura para ANULAR</option>
              <?php
do {  
?>
              <option value="<?php echo $row_RS_lista_facturas['fac_num'].'-'.$row_RS_lista_facturas['fac_cic_id']?>"><?php echo $row_RS_lista_facturas['fac_cic_serie'].' [ '.$row_RS_lista_facturas['fac_num'].' ]';?></option>
              <?php
} while ($row_RS_lista_facturas = mysql_fetch_assoc($RS_lista_facturas));
  $rows = mysql_num_rows($RS_lista_facturas);
  if($rows > 0) {
      mysql_data_seek($RS_lista_facturas, 0);
	  $row_RS_lista_facturas = mysql_fetch_assoc($RS_lista_facturas);
  }
?>
            </select>
          </label>
          <br />
        <span class="selectInvalidMsg">Seleccione un elemento válido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></td>
    </tr>
	<tr>
    	<td class="txt_name">Observaciones:</td>
        <td><span id="spry_obs">
          <label>
            <input name="txt_obs" type="text" id="txt_obs" size="30" />
          </label><br />
        <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><label>
    	  <input type="submit" name="btn_anular" id="btn_anular" value="Anular Factura" onclick="return confirm('Desea Anular la Factura?');"/>
  	  </label></td>
    </tr>
</table>
</form>
</div>
<table align="center" class="bord_gray_4cornes">
	<tr>
    	<td class="log" align="center"><?php echo $_SESSION['LOG']; $_SESSION['LOG']=null; ?></td>
    </tr>
</table>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spry_fact_id", {invalidValue:"-1", validateOn:["blur"]});
var sprytextfield1 = new Spry.Widget.ValidationTextField("spry_obs", "none", {validateOn:["blur"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_lista_facturas);

mysql_free_result($RS_cic_fac);
?>
