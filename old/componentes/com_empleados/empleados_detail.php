<?php include('../_config.php'); ?>
<?php require_once('../../Connections/conn.php'); ?>
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

$colname_RS_emp_sel = "-1";
if (isset($_POST['emp_sel_find'])) {
  $colname_RS_emp_sel = $_POST['emp_sel_find'];
}
mysql_select_db($database, $conn);
$query_RS_emp_sel = sprintf("SELECT * FROM tbl_empleados WHERE emp_cod = %s", GetSQLValueString($colname_RS_emp_sel, "int"));
$RS_emp_sel = mysql_query($query_RS_emp_sel, $conn) or die(mysql_error());
$row_RS_emp_sel = mysql_fetch_assoc($RS_emp_sel);
$totalRows_RS_emp_sel = mysql_num_rows($RS_emp_sel);
?>
<?php
session_start();
$_SESSION['id_emp']=null;
$_SESSION['id_emp']=$row_RS_emp_sel['emp_cod'];
?>
<table class="bord_gray_4cornes" align="center">
  <tr>
    <td rowspan="3" style="padding-right:6px;"><img src="<?php fnc_image_exist($pathimag_db_emp,$row_RS_emp_sel['emp_img']) ; ?>" height="110" class="img_form_pac_min" /></td>
   	  <td>Nombre:</td>
        <td><?php echo $row_RS_emp_sel['emp_nom']; ?> <?php echo $row_RS_emp_sel['emp_ape']; ?></td>
        <td rowspan="5" valign="bottom"><a onclick="$('#cont_emp').slideUp();"><img src="<?php echo $RAIZ; ?>images/struct/Close-32.png" width="22" /></a></td>

  </tr>
    <tr>
   	  <td>Dirección:</td>
        <td><?php echo $row_RS_emp_sel['emp_dir']; ?></td>
  </tr>
    <tr>
   	  <td>Teléfono:</td>
        <td><?php echo $row_RS_emp_sel['emp_tel1']; ?>. <?php echo $row_RS_emp_sel['emp_tel2']; ?></td>
  </tr>
</table>
<?php
mysql_free_result($RS_emp_sel);
?>