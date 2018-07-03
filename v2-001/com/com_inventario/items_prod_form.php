<?php include('../../init.php');
$rowMod=fnc_datamod($_SESSION['MODSEL']);

if(!(isset($_POST['id_sel']))) $_POST['id_sel']=$_GET['id_sel'];
if(!(isset($_POST['action']))) $_POST['action']=$_GET['action'];

$id_prod_sel_RS_prod_det = "-1";
if (isset($_GET['id_sel'])) {
  $id_prod_sel_RS_prod_det = $_GET['id_sel'];
}
$query_RS_prod_det = sprintf("SELECT * FROM tbl_productos LEFT JOIN tbl_prod_tipos  ON tbl_productos.tip_cod=tbl_prod_tipos.tip_cod LEFT JOIN tbl_prod_categorias ON tbl_prod_tipos.cat_cod=tbl_prod_categorias.cat_cod LEFT JOIN tbl_marcas ON tbl_productos.mar_id=tbl_marcas.mar_id WHERE tbl_productos.prod_id=%s", SSQL($id_prod_sel_RS_prod_det, "int"));
$RS_prod_det = mysql_query($query_RS_prod_det) or die(mysql_error());
$row_RS_prod_det = mysql_fetch_assoc($RS_prod_det);
$totalRows_RS_prod_det = mysql_num_rows($RS_prod_det);

$query_RS_mar_list = "SELECT * FROM tbl_marcas";
$RS_mar_list = mysql_query($query_RS_mar_list) or die(mysql_error());
$row_RS_mar_list = mysql_fetch_assoc($RS_mar_list);
$totalRows_RS_mar_list = mysql_num_rows($RS_mar_list);

$query_RS_tip_list = "SELECT tbl_prod_tipos.tip_cod, tbl_prod_tipos.tip_nom, tbl_prod_categorias.cat_cod, tbl_prod_categorias.cat_nom FROM tbl_prod_tipos LEFT JOIN tbl_prod_categorias ON tbl_prod_tipos.cat_cod=tbl_prod_categorias.cat_cod";
$RS_tip_list = mysql_query($query_RS_tip_list) or die(mysql_error());
$row_RS_tip_list = mysql_fetch_assoc($RS_tip_list);
$totalRows_RS_tip_list = mysql_num_rows($RS_tip_list);
?>
<?php include(RAIZf.'head.php'); ?>
<body class="cero">

<div class="container">
<div class="page-header"><h1><?php echo strtoupper($rowMod['mod_nom']); ?></h1></div>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="_fncts.php">
  <table align="center" class="bord_gray_4cornes">
	<tr>
    	<td colspan="2" class="text_sec_gray_min" align="center" bgcolor="#666666"><?php echo $_GET['action']; ?> <strong><?php echo $row_RS_prod_det['prod_id']; ?></strong></td>
    </tr>
    <tr>
    	<td class="txt_name">Codigo:</td>
        <td><label>
          <input disabled="disabled" name="txt_cod" type="text" id="txt_cod" value="<?php echo $row_RS_prod_det['prod_id']; ?>" />
        </label></td>
    </tr>
	<tr>
    	<td class="txt_name">Marca:</td>
        <td><span id="sprysel_mar">
          <label>
          <select name="id_mar_sel" class="txt_values" id="id_mar_sel">
            <option value="-1" <?php if (!(strcmp(-1, $row_RS_prod_det['mar_id']))) {echo "selected=\"selected\"";} ?>>Seleccione Marca:</option>
            <?php
do {  
?>
            <option value="<?php echo $row_RS_mar_list['mar_id']?>"<?php if (!(strcmp($row_RS_mar_list['mar_id'], $row_RS_prod_det['mar_id']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_mar_list['mar_nom'];?></option>
            <?php
} while ($row_RS_mar_list = mysql_fetch_assoc($RS_mar_list));
  $rows = mysql_num_rows($RS_mar_list);
  if($rows > 0) {
      mysql_data_seek($RS_mar_list, 0);
	  $row_RS_mar_list = mysql_fetch_assoc($RS_mar_list);
  }
?>
          </select>
          </label><br />
        <span class="selectInvalidMsg">Marca no Válida.</span>
        <span class="selectRequiredMsg">Seleccione Marca.</span></span></td>
    </tr>
	<tr>
    	<td class="txt_name">Tipo:</td>
        <td><span id="sprysel_tip">
          <label>
          <select name="id_tip_sel" class="txt_values" id="id_tip_sel">
            <option value="-1" <?php if (!(strcmp(-1, $row_RS_prod_det['tip_cod']))) {echo "selected=\"selected\"";} ?>>Seleccione Tipo:</option>
            <?php
do {  
?><option value="<?php echo $row_RS_tip_list['tip_cod']?>"<?php if (!(strcmp($row_RS_tip_list['tip_cod'], $row_RS_prod_det['tip_cod']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RS_tip_list['tip_nom']; ?></option>
            <?php
} while ($row_RS_tip_list = mysql_fetch_assoc($RS_tip_list));
  $rows = mysql_num_rows($RS_tip_list);
  if($rows > 0) {
      mysql_data_seek($RS_tip_list, 0);
	  $row_RS_tip_list = mysql_fetch_assoc($RS_tip_list);
  }
?>
          </select>
          </label><br />
        <span class="selectInvalidMsg">Categoria No V&aacute;lida.</span>
        <span class="selectRequiredMsg">Seleccione una Categoria.</span></span></td>
    </tr>
<tr>
   	  <td class="txt_name">Descrip:</td>
        <td><span id="sprytext_cat_nom">
        <label>
        <input name="txt_nom" type="text" class="txt_values-big" id="txt_nom" value="<?php echo $row_RS_prod_det['prod_nom']; ?>" size="35" />
        </label>
        <br />
        <span class="textfieldRequiredMsg">Se necesita Nombre Categoria.</span><span class="textfieldMaxCharsMsg">Se ha superado el número máximo de caracteres.</span><span class="textfieldMinCharsMsg">No se cumple el mínimo de caracteres requerido.</span></span></td>
    </tr>
    <tr>
    	<td class="txt_name">Observ:</td>
        <td><label>
          <textarea name="txt_obs" id="txt_obs" cols="35" rows="2"><?php echo $row_RS_prod_det['prod_obs']; ?></textarea>
        </label></td>
    </tr>
<tr>
		<td colspan="2">
        	<table width="100%">
            	<tr>
				<td align="center" bgcolor="#FFFFFF">
                <a href="<?php fncImgExist($pathimag_db_prod,$row_RS_prod_det['prod_img']) ; ?>" rel="shadowbox">
                <img src="<?php fncImgExist($pathimag_db_prod,$row_RS_prod_det['prod_img']) ; ?>" height="110" /></a>
                </td>
				<td align="center" bgcolor="#FFFFFF">
                	Imagen<br />
               	  <input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" />
				</td>
                </tr>
          </table>
        </td>
    </tr>
    <tr>

    	<td colspan="2" align="center"><p><label>
    	  <input name="action" type="hidden" id="action" value="<?php echo $_GET['action']; ?>">
    	  <input name="form" type="hidden" id="form" value="form_prod">
    	  <input name="id_sel" type="hidden" id="id_sel" value="<?php echo $_GET['id_sel']; ?>" />
    	  <input type="submit" name="btn_send" id="btn_send" value="<?php echo $_GET['action']; ?>" />
    	</label></p></td>
    </tr>
</table>
</form>

</div>
<?php vLOG(); ?>
<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("sprytext_cat_nom", "none", {validateOn:["blur", "change"], maxChars:40, minChars:3});
var spryselect1 = new Spry.Widget.ValidationSelect("sprysel_tip", {invalidValue:"-1", validateOn:["blur", "change"]});
var spryselect2 = new Spry.Widget.ValidationSelect("sprysel_mar", {invalidValue:"-1", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php
mysql_free_result($RS_prod_det);
mysql_free_result($RS_mar_list);
mysql_free_result($RS_tip_list);
?>