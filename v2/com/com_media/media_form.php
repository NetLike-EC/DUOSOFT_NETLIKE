<?php include('../../init.php');
fnc_accessnorm();
$urlcurrent=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current
$_SESSION['MODSEL']='MMED';
$rowMod=fnc_datamod($_SESSION['MODSEL']);
//Verifica si existen los parametros
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
if (($id)&&($action)&&($action=='UPDATE')){
	//SELECT SPECIFIC PRODUCT
	$detmed = fnc_media($id);
	if ($detmed){
		$med_id=$detmed['med_id'];
		$med_item=$detmed['itemview'];
		$med_tit=$detmed['med_title'];
		$med_code=$detmed['med_code'];
		$med_stat=$detmed['med_status'];
	}else $action="INSERT";
}else { $action="INSERT"; }

if($action=="INSERT"){
	$cat_nom="NEW";
	$cat_id="000";
	$classaction="btn btn-primary";
}else{
	$classaction="btn btn-success";
}

//LIST PRODS
$query_RSprods = sprintf("SELECT * FROM tbl_items WHERE item_status='1' ORDER BY item_id DESC");
$RSprods = mysql_query($query_RSprods) or die(mysql_error());
$row_RSprods = mysql_fetch_assoc($RSprods);
$totalRows_RSprods = mysql_num_rows($RSprods);

include(RAIZf.'_head.php'); ?>
<body>

<form enctype="multipart/form-data" method="post" action="_fncts.php" class="form-horizontal">
<div class="navbar navbar-fixed-top">
	<div class="navbar-inner">
	<div class="container">
		<a class="navbar-brand" href="#">MEDIA</a>
		<fieldset class="pull-right">
		  <input name="action" type="hidden" id="action" value="<?php echo $action ?>">
			<input name="form" type="hidden" id="form" value="form_media">
			<input name="id" type="hidden" id="id" value="<?php echo $id ?>" />
			<input name="url" type="hidden" id="url" value="<?php echo $urlcurrent ?>">
			<input name="btn_send" type="submit" class="<?php echo $classaction ?>" id="btn_send" onClick="return confirm('Desea Grabar?');" value="<?php echo $action ?>"/>
			<a href="media_form.php" class="btn btn-default">ADD NEW</a>
		</fieldset>
	</div>
	</div>
</div>

<div class="container">
	<div class="page-header"><h1><small>[ <strong><?php echo $med_id ?></strong> ]</small> <?php echo $med_tit ?></h1></div>
	<?php fnc_log(); ?>    
    <div class="row">
    	<div class="col-md-12">
        	<div class="row">
            	<div class="col-md-6 well well-sm">
                <fieldset>
                <div class="control-group">
                	<label class="control-label" for="txt_cod">Title</label>
					<div class="controls">
                    <input name="title" type="text" id="title" placeholder="Title for this Media" class="form-control input-block-level" value="<?php echo $med_tit ?>"></div>
				</div>
                <div class="control-group">
                  <label class="control-label" for="txt_cod">Item View</label>
					<div class="controls">
                    <span id="sprysel_cat">
          <select name="itemview" class="form-control input-block-level" id="itemview">
            <option value="-1" <?php if (!(strcmp(-1, $row_RSprods['item_id']))) {echo "selected=\"selected\"";} ?>>Select Type:</option>
            <?php
do {  
?><option value="<?php echo $row_RSprods['item_id']?>"<?php if (!(strcmp($row_RSprods['item_id'], $detmed['itemview']))) {echo "selected=\"selected\"";} ?>><?php echo $row_RSprods['item_cod'].' ['.$row_RSprods['item_id'].']'; ?></option>
            <?php
} while ($row_RSprods = mysql_fetch_assoc($RSprods));
  $rows = mysql_num_rows($RSprods);
  if($rows > 0) {
      mysql_data_seek($RSprods, 0);
	  $row_RSprods = mysql_fetch_assoc($RSprods);
  }
?>
          </select><br />
        <span class="selectInvalidMsg">Categoria No V&aacute;lida.</span>
        <span class="selectRequiredMsg">Seleccione una Categoria.</span></span>
                    </div>
				</div>
                <div class="control-group">
                	<label class="control-label">Status</label>
				  <div class="controls">
					<label class="radio inline">
                    <input type="radio" name="status" value="1" <?php if (!(strcmp(1, $med_stat))) {echo 'checked="CHECKED"';} ?>>Active</label>
					<label class="radio inline">
                    <input type="radio" name="status" value="0" <?php if (!(strcmp(0, $med_stat))) {echo 'checked="CHECKED"';} ?>>Inactive</label>
				  </div>
                </div>
                </fieldset>
                </div>
                <div class="col-md-6 well well-sm">
                <fieldset>
                      <textarea name="code" rows="8" class="form-control input-block-level" id="code" placeholder="Code Embed Here"><?php echo $med_code ?></textarea>
				</fieldset>
                </div>
            </div>
        </div>
    </div>
</div>
</form>
<script type="text/javascript">
<!--
var spryselect2 = new Spry.Widget.ValidationSelect("sprysel_cat", {invalidValue:"-1", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php mysql_free_result($RSprods); ?>