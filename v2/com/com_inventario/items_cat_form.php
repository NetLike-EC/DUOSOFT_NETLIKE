<?php include('../_config.php'); ?>
<?php require_once(RAIZ.'Connections/conn.php'); ?>
<?php
session_start();
	if($_POST['id_sel']==null)
		$_POST['id_sel']=$_GET['id_sel'];
	if($_POST['action_form']==null)
		$_POST['action_form']=$_GET['action_form'];
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

$id_cat_sel_RS_cat_detail = "-1";
if (isset($_GET['id_sel'])) {
  $id_cat_sel_RS_cat_detail = $_GET['id_sel'];
}
$query_RS_cat_detail = sprintf("SELECT * FROM tbl_prod_categorias WHERE tbl_prod_categorias.cat_cod=%s", SSQL($id_cat_sel_RS_cat_detail, "int"));
$RS_cat_detail = mysql_query($query_RS_cat_detail) or die(mysql_error());
$row_RS_cat_detail = mysql_fetch_assoc($RS_cat_detail);
$totalRows_RS_cat_detail = mysql_num_rows($RS_cat_detail);

$id_cattip_sel_RS_cat_tip_detail = "-1";
if (isset($_GET['id_sel'])) {
  $id_cattip_sel_RS_cat_tip_detail = $_GET['id_sel'];
}
$query_RS_cat_tip_detail = sprintf("SELECT * FROM tbl_prod_tipos WHERE tbl_prod_tipos.cat_cod=%s", SSQL($id_cattip_sel_RS_cat_tip_detail, "int"));
$RS_cat_tip_detail = mysql_query($query_RS_cat_tip_detail) or die(mysql_error());
$row_RS_cat_tip_detail = mysql_fetch_assoc($RS_cat_tip_detail);
$totalRows_RS_cat_tip_detail = mysql_num_rows($RS_cat_tip_detail);
?>
<?php include(RAIZf.'head.php'); ?>
<?php include('_libs.php'); ?>
<body>
<div id="head_sec"><a href="#" class="link">GESTION CATEGORIA</a></div>
<div>
<form id="form_cat" name="form" method="post" action="_fncts.php?action=<?php echo $_GET['action_form'];?>">
  <table align="center" class="bord_gray_4cornes">
	<tr>
    	<td colspan="2" class="text_sec_gray_min" align="center" bgcolor="#666666"><?php echo $_GET['action']; ?> <strong><?php echo $_GET['id_sel']; ?></strong></td>
    </tr>
    <tr>
   	  <td class="txt_name">Nombre:</td>
        <td><span id="sprytext_cat_nom">
        <label>
        <input name="txt_cat_nom" type="text" class="txt_values-big" id="txt_cat_nom" value="<?php echo $row_RS_cat_detail['cat_nom']; ?>" size="25" />
        </label>
        <br />
        <span class="textfieldRequiredMsg">Se necesita Nombre Categoria.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
    </tr>
	<tr>
    	<td class="txt_name">Descripcion:</td>
        <td><label>
          <textarea name="txt_cat_des" id="txt_cat_des" cols="25" rows="3"><?php echo $row_RS_cat_detail['cat_des']; ?></textarea>
        </label></td>
    </tr>
	<tr>
    	<td class="txt_name">Tipos Relacionados:</td>
        <td><label>
          <select disabled="disabled" name="list_tip" size="<?php echo $totalRows_RS_cat_tip_detail; ?>" class="txt_name" id="list_tip">
            <?php
do {  
?>
            <option value="<?php echo $row_RS_cat_tip_detail['tip_cod']?>"><?php echo htmlentities($row_RS_cat_tip_detail['tip_nom'])?></option>
            <?php
} while ($row_RS_cat_tip_detail = mysql_fetch_assoc($RS_cat_tip_detail));
  $rows = mysql_num_rows($RS_cat_tip_detail);
  if($rows > 0) {
      mysql_data_seek($RS_cat_tip_detail, 0);
	  $row_RS_cat_tip_detail = mysql_fetch_assoc($RS_cat_tip_detail);
  }
?>
          </select>
        </label></td>
    </tr>
    <tr>
    	<td colspan="2" align="center"><label>
    	  <input name="form" type="hidden" id="form" value="form_cat">
    	  <input name="action" type="hidden" id="action" value="<?php echo $_GET['action']; ?>">
    	  <input name="id_sel" type="hidden" id="id_sel" value="<?php echo $_GET['id_sel']; ?>" />
    	  <input type="submit" name="btn_send" id="btn_send" value="<?php echo $_GET['action']; ?>" />
    	</label></td>
    </tr>
</table>
</form>
</div>
<div id="log" style="bottom:0; position: fixed; width:100%;"><?php vLOG(); ?></div>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytext_cat_nom", "none", {validateOn:["blur", "change"], maxChars:40, minChars:3});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_cat_detail);

mysql_free_result($RS_cat_tip_detail);
?>