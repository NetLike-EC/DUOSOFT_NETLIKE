<?php include('../_config.php'); ?>
<?php require_once(RAIZ.'Connections/conn.php'); ?>
<?php
	session_start();
	if(!isset($_POST['id_sel'])) $_POST['id_sel']=$_GET['id_sel'];
	if(!isset($_POST['action'])) $_POST['action']=$_GET['action'];
?>
<?php
if (!function_exists("SSQL")) {
function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
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

$id_tip_sel_RS_TIP_detail = "-1";
if (isset($_GET['id_sel'])) {
  $id_tip_sel_RS_TIP_detail = $_GET['id_sel'];
}
$query_RS_TIP_detail = sprintf("SELECT * FROM tbl_prod_tipos WHERE tbl_prod_tipos.tip_cod=%s", SSQL($id_tip_sel_RS_TIP_detail, "int"));
$RS_TIP_detail = mysql_query($query_RS_TIP_detail) or die(mysql_error());
$row_RS_TIP_detail = mysql_fetch_assoc($RS_TIP_detail);
$totalRows_RS_TIP_detail = mysql_num_rows($RS_TIP_detail);

$query_RS_cat_list = "SELECT * FROM tbl_prod_categorias";
$RS_cat_list = mysql_query($query_RS_cat_list) or die(mysql_error());
$row_RS_cat_list = mysql_fetch_assoc($RS_cat_list);
$totalRows_RS_cat_list = mysql_num_rows($RS_cat_list);
?>
<?php include(RAIZf.'head.php'); ?>
<?php include('_libs.php'); ?>
<body>
<div id="head_sec">
<a href="#" class="link">GESTION TIPOS</a></div>
<div id="cont_head">
<form id="form1" name="form1" method="post" action="_fncts.php">
  <table align="center" class="bord_gray_4cornes">
	<tr>
    	<td colspan="2" class="text_sec_gray_min" align="center" bgcolor="#666666"><?php echo $_GET['action']; ?> <strong><?php echo $_GET['id_sel']; ?></strong></td>
    </tr>
    <tr>
   	  <td class="txt_name">Nombre:</td>
        <td><span id="sprytext_cat_nom">
        <label>
        <input name="txt_tip_nom" type="text" class="txt_values-big" id="txt_tip_nom" value="<?php echo $row_RS_TIP_detail['tip_nom']; ?>" size="25" />
        </label>
        <br />
        <span class="textfieldRequiredMsg">Se necesita Nombre Categoria.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
    </tr>
	<tr>
    	<td class="txt_name">Descripcion:</td>
        <td><label>
          <textarea name="txt_tip_des" id="txt_tip_des" cols="25" rows="3"><?php echo $row_RS_TIP_detail['tip_des']; ?></textarea>
        </label></td>
    </tr>
	<tr>
    	<td class="txt_name">Categoria:</td>
        <td><span id="sprysel_cat">
          <label>
          <select name="id_cat_sel" id="id_cat_sel">
            <option value="-1" <?php if (!(strcmp(-1, $row_RS_TIP_detail['cat_cod']))) {echo "selected=\"selected\"";} ?>>Seleccione Categoria</option>
            <?php
do {  
?>
            <option value="<?php echo $row_RS_cat_list['cat_cod']?>"<?php if (!(strcmp($row_RS_cat_list['cat_cod'], $row_RS_TIP_detail['cat_cod']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_cat_list['cat_nom']?></option>
            <?php
} while ($row_RS_cat_list = mysql_fetch_assoc($RS_cat_list));
  $rows = mysql_num_rows($RS_cat_list);
  if($rows > 0) {
      mysql_data_seek($RS_cat_list, 0);
	  $row_RS_cat_list = mysql_fetch_assoc($RS_cat_list);
  }
?>
          </select>
          </label><br />
        <span class="selectInvalidMsg">Categoria No V&aacute;lida.</span>
        <span class="selectRequiredMsg">Seleccione una Categoria.</span></span></td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><p><label>
    	  <input name="form" type="hidden" id="form" value="form_tip">
    	  <input name="action" type="hidden" id="action" value="<?php echo $_GET['action']; ?>">
    	  <input name="id_sel" type="hidden" id="id_sel" value="<?php echo $_GET['id_sel']; ?>" />
    	  <input type="submit" name="btn_send" id="btn_send" value="<?php echo $_GET['action']; ?>" />
    	</label></p></td>
    </tr>
</table>
</form>
</div>
<div id="log" style="bottom:0; position: fixed; width:100%;"><?php vLOG(); ?></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytext_cat_nom", "none", {validateOn:["blur", "change"], maxChars:30, minChars:3});
var spryselect1 = new Spry.Widget.ValidationSelect("sprysel_cat", {invalidValue:"-1", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_TIP_detail);

mysql_free_result($RS_cat_list);
?>