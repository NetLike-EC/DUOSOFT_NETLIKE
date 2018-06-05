<?php include('../_config.php'); ?>
<?php session_start();
	  if (($_GET['id_emp']==null)&&($_GET["action_form"]!="INSERT"))
		$_GET['id_emp']=$_SESSION['id_emp'];
	  $accion =$_GET["action_form"];?>
<?php include('../_config.php'); ?>
<?php require_once(RAIZ.'/Connections/conn.php'); ?>
<?php include(RAIZ.'frames/_head.php'); ?>
<?php 
$query_empleado ='SELECT * FROM tbl_empleados INNER JOIN tbl_types ON tbl_empleados.typ_cod = tbl_types.typ_cod WHERE tbl_empleados.emp_cod="'.$_GET['id_emp'].'"';
$RS_empleado = mysql_query($query_empleado);
$row_RS_empleado = mysql_fetch_assoc($RS_empleado);
$query_typ ="SELECT * FROM tbl_types WHERE typ_ref='TIPEMP' ORDER BY typ_val ASC";
$RS_typ = mysql_query($query_typ);
$row_RS_typ = mysql_fetch_assoc($RS_typ);?>
<body>
<div id="generalcont">
<div id="formcont">
	<div id="head_sec"></div>
    <div id="log"><?php fnc_log(); ?></div>
    <div id="form_sec">
    <form enctype="multipart/form-data" id="form_emp" action="_fncts.php" method="post">
    		<input name="action_form" type="hidden" id="action_form" value="<?php echo $accion;?>" />
            <input name="txt_cod_emp" type="hidden" id="txt_cod_emp" value="<?php echo $row_RS_empleado['emp_cod'];?>"/>
            <table class="bord_gray_4cornes" align="center">  
            	<tr>
                 <div id="seccf_data" align="center">
                    <td rowspan="8"><a href="<?php fnc_image_exist($pathimag_db_emp,$row_RS_empleado['emp_img']);?>" rel="shadowbox"><img src="<?php fnc_image_exist($pathimag_db_emp,$row_RS_empleado['emp_img']);?>" height="130" class="img_form_emp"/></a>
                    <input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" /></td>
                 </div>
                </tr>  
                <tr>
                  <td>Cedula/RUC</td>
                  <td><span id="sprytextfield1"><input type="text" name="txt_ced_emp" value="<?php echo $row_RS_empleado['emp_ced'];?>"/></span></td>
                </tr>
                <tr>     
                  <td>Nombres</td>
                  <td><span id="sprytextfield2"><input type="text" name="txt_nom_emp" value="<?php echo $row_RS_empleado['emp_nom'];?>"/></span></td>
                </tr>
                <tr>
                  <td>Apellidos</td>
                  <td><span id="sprytextfield3"><input type="text" name="txt_ape_emp" value="<?php echo $row_RS_empleado['emp_ape'];?>"/></span></td>
                </tr> 
                <tr>  
                  <td>Direccion</td>
                  <td><span id="sprytextfield6"><input type="text" name="txt_dir_emp" value="<?php echo $row_RS_empleado['emp_dir'];?>"/></span></td>
                </tr>
                <tr>   
                  <td>Telefono 1</td>
                  <td><input type="text" name="txt_tel1_emp" value="<?php echo $row_RS_empleado['emp_tel1'];?>"/></td>
                </tr> 
                <tr>  
                  <td>Telefono 2</td>
                  <td><input type="text" name="txt_tel2_emp" value="<?php echo $row_RS_empleado['emp_tel2'];?>"/></td>
                </tr>
                <tr> 
                  <td>Tipo</td>
                  <td>
                    <select name="txt_tip_emp" id="txt_tip_emp">
                      <option value="-1" <?php if (!(strcmp(-1, $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>>Seleccione Tipo Empleado</option>
                      <option value="0" <?php if (!(strcmp(0, $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>>No Determinado</option>
					<?php
					do { ?>
                      <option value="<?php echo $row_RS_typ['typ_cod']?>"<?php if (!(strcmp($row_RS_typ['typ_val'], $row_RS_empleado['typ_val']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_typ['typ_val']?></option>
                            <?php
} while ($row_RS_typ = mysql_fetch_assoc($RS_typ));
  $rows = mysql_num_rows($RS_typ);
  if($rows > 0) {
      mysql_data_seek($RS_typ, 0);
	  $row_RS_typ = mysql_fetch_assoc($RS_typ);
  }
?>                  </select></td>
                </tr>
                <tr> 
            	  <td></td>    
                  <td><input type="submit" value="<?php if($accion=='UPDATE') 											{echo 'Actualizar';}else {if($accion=='INSERT') echo 'Ingresar';}?>"/></td>
                </tr>
            </table>
            </form>
    </div>
    <div></div>
</div>
</div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytextfield1", "none", {maxChars:13, minChars:10, validateOn:["blur", "change"], hint:"0000000000"});
var sprytextfield2 = new Spry.Widget.ValidationTextField("sprytextfield2", "none", {validateOn:["blur"]});
var sprytextfield3 = new Spry.Widget.ValidationTextField("sprytextfield3", "none", {validateOn:["blur", "change"]});
var sprytextfield6 = new Spry.Widget.ValidationTextField("sprytextfield6", "none", {isRequired:false, maxChars:60, validateOn:["change"]});
//-->
</script>
</body>
</html>