<?php include('../_config.php'); ?>
<?php
	session_start();
	if (($_GET['id_pac']==null)&&($_GET["action_form"]!="INSERT"))
		$_GET['id_pac']=$_SESSION['id_pac'];
	$accion =$_GET["action_form"];	
?>
<?php require_once(RAIZ.'/Connections/conn.php'); ?>
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

mysql_select_db($database, $conn);
$query_RS_empleados_list = "SELECT * FROM tbl_empleados WHERE emp_status = '1'";
$RS_empleados_list = mysql_query($query_RS_empleados_list, $conn) or die(mysql_error());
$row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list);
$totalRows_RS_empleados_list = mysql_num_rows($RS_empleados_list);

$id_pac_sel_RS_paciente_Sel = "-1";
if (isset($_GET['id_pac'])) {
  $id_pac_sel_RS_paciente_Sel = $_GET['id_pac'];
}
$query_RS_paciente_Sel = sprintf("SELECT * FROM tbl_pacientes WHERE tbl_pacientes.pac_cod=%s", GetSQLValueString($id_pac_sel_RS_paciente_Sel, "int"));
$RS_paciente_Sel = mysql_query($query_RS_paciente_Sel, $conn) or die(mysql_error());
$row_RS_paciente_Sel = mysql_fetch_assoc($RS_paciente_Sel);
$totalRows_RS_paciente_Sel = mysql_num_rows($RS_paciente_Sel);

$query_RS_types_tipsan = "SELECT * FROM tbl_types WHERE typ_ref = 'TIPSAN' ORDER BY typ_nom ASC";
$RS_types_tipsan = mysql_query($query_RS_types_tipsan, $conn) or die(mysql_error());
$row_RS_types_tipsan = mysql_fetch_assoc($RS_types_tipsan);
$totalRows_RS_types_tipsan = mysql_num_rows($RS_types_tipsan);
?>
<?php include(RAIZ.'frames/_head.php'); ?>
<?php $rowMod=detMod($_SESSION['MODSEL']); ?>
<script src="<?php echo $RAIZ; ?>SpryAssets/SpryValidationTextField.js" type="text/javascript"></script>
<link href="<?php echo $RAIZ; ?>SpryAssets/SpryValidationTextField.css" rel="stylesheet" type="text/css">
<script src="<?php echo $RAIZ; ?>SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="<?php echo $RAIZ; ?>SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css">
<body>
<div id="generalcont">
    <div id="formcont">
        <div id="head_sec"><a href="#"><?php echo strtoupper($rowMod['mod_des']); ?></a></div>
        <div id="log"><?php fnc_log(); ?></div>
        <div id="form_sec">
        <form enctype="multipart/form-data" method="post" action="_fncts.php" name="form_grabar" id="form_grabar">
		<div style="clear:both;">
			
			<div class="form_sec_style">
            <ul>
            	<li><label for="empleado"></label>
                <span id="spryselect2">
            	  <select name="empleado" id="empleado">
          	    </select>
           	    <span class="selectRequiredMsg">Seleccione un elemento.</span></span></li>
            </ul>
            
<div id="seccf_data">
   	    <p>Empleado</p><div><span id="spryselect1">
                	  <select name="idemp" id="idemp">
                	    <option value="-1" <?php if (!(strcmp(-1, $_GET['emp_cod']))) {echo "selected=\"selected\"";} ?>>Seleccione Empleado</option>
                	    <?php
do {  
?>
                	    <option value="<?php echo $row_RS_empleados_list['emp_cod']?>"<?php if (!(strcmp($row_RS_empleados_list['emp_cod'], $_GET['emp_cod']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_empleados_list['emp_nom']?></option>
                	    <?php
} while ($row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list));
  $rows = mysql_num_rows($RS_empleados_list);
  if($rows > 0) {
      mysql_data_seek($RS_empleados_list, 0);
	  $row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list);
  }
?>
              	    </select>
                	  <span class="selectInvalidMsg">Seleccione un elemento válido.</span><span class="selectRequiredMsg">Seleccione un elemento.</span></span></div>
                </div>
                <div id="seccf_data">
                	<p>Nombre Usuario</p>
                    <div><span id="sprytextfield1">
                      <input type="text" name="emp_username" id="emp_username">
                    <span class="textfieldRequiredMsg">Debe escribir un nombre de usuario.</span></span></div>
                </div>
                <div id="seccf_data">
                <p>Contraseña</p>
                    <div><span id="sprytextfield3">
                      <input type="password" name="emp_password" id="emp_password">
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div>
                </div>
              <div id="seccf_data">
                <p>Confirmar</p>
                    <div><span id="sprytextfield4">
                      <input type="password" name="emp_verify" id="emp_verify">
                    <span class="textfieldRequiredMsg">Se necesita un valor.</span></span></div>
                </div>
</div>
			<div style="width:18%" class="form_sec_style">
            	<div id="seccf_data">
            	<input name="action_form" type="hidden" id="action_form" value="<?php echo $_GET['action_form']; ?>" />
                            <input name="mod" type="hidden" id="mod" value="form_paciente" />
<input name="id_pac" type="hidden" id="id_pac" value="<?php echo $row_RS_paciente_Sel['pac_cod']; ?>" />
                            <input type="submit" name="btn_grabar" value="" class="btn_<?php echo $accion;?>"/>
                </div>
			</div>
		</div>
		</form>
        </div>
    </div>
</div>
<script type="text/javascript">
<!--
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield5 = new Spry.Widget.ValidationTextField("sprytextfield5", "none", {maxChars:20, isRequired:false, validateOn:["change"]});
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {invalidValue:"-1"});
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1");
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3");
var sprytextfield4 = new Spry.Widget.ValidationTextField("sprytextfield4");
var spryselect2 = new Spry.Widget.ValidationSelect("spryselect2");
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_empleados_list);

mysql_free_result($RS_paciente_Sel);
mysql_free_result($RS_types_tipsan);
?>