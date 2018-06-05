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
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<script src="SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
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
        height:     450,
        width:      575
    });
}
</script>

</head>

<body bgcolor="#FFFFFF">
<div id="head_sec" align="center"><a href="#" class="link">CICLOS FACTURACIÓN</a></div>
<div id="cont_head" style="background-color:#FFFFFF;" align="center">
<table class="main" align="center">
	<tr>
	<td class="tit_blue_min_big">Ciclo Actual:</td>
    <td>
    	<table>
        	<tr>
            	<td class="tit_sec_gray">ID</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_id']; ?></td>
                <td rowspan="4" style="padding-left:20px; padding-right:5px;" align="center">
                	<a onclick="load_form_ciclo()"><img src="img_est/png/publish_x.png" border="0" /><br />
                	Cerrar Ciclo</a>
                </td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Factura Inicio</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_ini']; ?></td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Contador Facturas</td>
                <td class="text_sec_blue_min"><?php echo $row_RS_fact_act['fac_cic_cont']; ?></td>
            </tr>
        	<tr>
            	<td class="tit_sec_gray">Ultima Factura Creada</td>
                <?php $last_fact=$row_RS_fact_act['fac_cic_ini']+$row_RS_fact_act['fac_cic_cont']; ?>
                <td class="text_sec_blue_min"><?php echo $row_RS_last_fact_fisica['fac_num']; ?> :: Ciclo: (<?php echo $row_RS_last_fact_fisica['fac_cic_id']; ?>)</td>
            </tr>

        </table>
    </td>
	</tr>
</table>
</div>
<div class="log">
<?php echo $_SESSION["LOG"];  $_SESSION["LOG"]=NULL;?>
</div>
<div id="cont_head" style="background-color:#FFFFFF;" align="center">
<table width="80%">
<tr>
<td align="center">
<table class="main" align="center" width="100%">
       	  <tr>
           	<td align="center"><a id="box_cont_btn">Listado de Secuencias</a>
              <input name="id" type="hidden" disabled="disabled" class="id_pac_list" id="id" value="<?php echo $_POST['id_pac']; ?>" size="3" border="0"/></td>
          </tr>
                <tr>
               	  <td><div id="box_cont"><!--Listado Consultas--></div>
              </tr>
        </table>
</td>
</tr>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($RS_fact_act);

mysql_free_result($RS_last_fact_fisica);
?>
