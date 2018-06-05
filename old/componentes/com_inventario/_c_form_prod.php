<?php
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$detProd=detInvProd($id);
$rowMod=detMod($_SESSION['MODSEL']);
$iColor='blue';$btn_ico='icon-columns';
if($detProd){
	$action='UPD';
	$btnaction='<input type="submit" name="btn_grabar" value="ACTUALIZAR" class="btn red"/>';
	$pimage=fnc_image_exist('db/prod/',$detProd['prod_img'],TRUE);
	$viewImage='<div class="item text-center">
		<a href="'.$pimage['norm'].'" data-rel="fancybox-button" class="fancybox-button">
			<div class="zoom">
				<img src="'.$pimage['thumb'].'" class=""/><div class="zoom-icon"></div>
			</div>
		</a>
	</div>';
	$atribProd=listAtribProd($id);
}else{
	$action='INS';
	$btnaction='<input type="submit" name="btn_grabar" value="GRABAR" class="btn red"/>';
}
?>
<div class="container-fluid">
<h3 class="page-title"><?php echo $rowMod['mod_nom'] ?> <small><?php echo $rowMod['mod_des'] ?></small></h3>
<ul class="breadcrumb">
	<li>
		<i class="icon-home"></i>
		<a href="<?php echo $RAIZc?>com_index/">Inicio</a> 
		<span class="icon-angle-right"></span>
	</li>
	<li>
		<i class="icon-table"></i>
		<a href="<?php echo $RAIZc?>com_inventario/">Inventario</a> 
		<span class="icon-angle-right"></span>
	</li>
	<li>
		<a href="<?php echo $RAIZc?>com_inventario/inv_gest_prod.php">Productos</a>
		<span class="icon-angle-right"></span>
	</li>
	<li class="muted">Formulario</li>
</ul>
<?php sLOG('g'); ?>
<form enctype="multipart/form-data" id="form1" name="form1" method="post" action="_fncts.php">
<div class="portlet box <?php echo $iColor ?>">
<div class="portlet-title">
    <span class="badge badge-info"><h4><i class="<?php echo $btn_ico ?>"></i> <strong><?php echo $detProd['prod_id']; ?></strong></h4></span>
	<span class="badge badge-info"><h4><?php echo $detProd['prod_nom']; ?></h4></span>
    <div class="actions">
		<input name="form" type="hidden" id="form" value="form_prod">
		<input name="id" type="hidden" id="id" value="<?php echo $id; ?>" />
		<input name="action" type="hidden" id="action" value="<?php echo $action; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $rowMod['mod_ref'] ?>" />
		<input name="imagea" type="hidden" id="imagea" value="<?php echo $detProd['prod_img'] ?>">
		<div class="btn-group">
		<?php echo $btnaction ?>
		<a href="<?php echo $_SESSION['urlc'] ?>" class="btn"><i class="icon-plus"></i> Nuevo</a>
		<a href="<?php echo $RAIZc ?>com_inventario/inv_gest_prod.php" class="btn black"><i class="icon-remove icon-white"></i> Cerrar</a>
        </div>
	</div>
</div>
<div class="portlet-body">

<div class="row-fluid">
	<div class="span6"><div class="well">
    <fieldset class="form-horizontal">
    <div class="control-group">
    	<label class="control-label">Nombre</label>
    	<div class="controls">
        <input name="txt_nom" type="text" class="input-block-level" id="txt_nom" value="<?php echo $detProd['prod_nom']; ?>" size="35" required/>
    </div>
  	</div>
    <div class="control-group">
    	<label class="control-label">Codigo</label>
    	<div class="controls">
      	<input name="txt_cod" type="text" id="txt_cod" value="<?php echo $detProd['prod_cod']; ?>" class="input-medium"/>
        <img src="<?php echo $RAIZidb.'barcode_prod/'.$detProd['prod_cod'].'.jpg'; ?>" class="img-polaroid" />
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">Marca</label>
    	<div class="controls">
      	<?php echo generarselect("id_mar_sel",listInvMar(),$detProd['mar_id'],'input-block-level','required'); ?>
    	</div>
  	</div>
    <div class="control-group">
    	<label class="control-label">Tipo</label>
    	<div class="controls">
      	<?php echo generarselect("id_tip_sel",listInvTip(),$detProd['tip_cod'],'input-block-level','required'); ?>
    	</div>
  	</div>
    
    <div class="row-fluid">
		<div class="span2"></div>
        <div class="span4"><h4>Precio 1</h4></div>
		<div class="span3"><h4>Precio 2</h4></div>
		<div class="span3"><h4>Precio 3</h4></div>
	</div>
    
    <div class="row-fluid">
		<div class="span2"><h4>%</h4></div>
        <div class="span4">
			<input type="number" name="pri_1" id="pri_1" value="<?php echo $detProd['pri_1'] ?>" class="span12" step="0.00001" min="0.00001">
		</div>
		<div class="span3">
			<input type="number" name="pri_2" id="pri_2" value="<?php echo $detProd['pri_2'] ?>" class="span12" step="0.00001" min="0.00001">
		</div>
		<div class="span3">
			<input type="number" name="pri_3" id="pri_3" value="<?php echo $detProd['pri_3'] ?>" class="span12" step="0.00001" min="0.00001">
		</div>
	</div>
    
    <div class="row-fluid">
		<div class="span2"><h4>$ NETO</h4></div>
        <div class="span4">
			  <input type="number" name="net_1" id="net_1" value="<?php if($detProd['pri_1']>0) echo valNETO(valInvUCom($detProd['prod_id'],1)) ?>" class="span12" step="0.00001" disabled>
		</div>
		<div class="span3">
			  <input type="number" name="net_2" id="net_2" value="<?php if($detProd['pri_2']>0) echo valNETO(valInvUCom($detProd['prod_id'],2)) ?>" class="span12" step="0.00001" disabled>
		</div>
		<div class="span3">
			  <input type="number" name="net_3" id="net_3" value="<?php if($detProd['pri_3']>0) echo valNETO(valInvUCom($detProd['prod_id'],3)) ?>" class="span12" step="0.00001" disabled>
		</div>
	</div>
    
    <div class="row-fluid">
		<div class="span2"><h4>$ PVP</h4></div>
        <div class="span4">
			  <input type="number" name="val_1" id="val_1" value="<?php if($detProd['pri_1']>0) echo valInvUCom($detProd['prod_id'],1) ?>" class="span12" step="0.00001">
		</div>
		<div class="span3">
			  <input type="number" name="val_2" id="val_2" value="<?php if($detProd['pri_2']>0) echo valInvUCom($detProd['prod_id'],2) ?>" class="span12" step="0.00001">
		</div>
		<div class="span3">
			  <input type="number" name="val_3" id="val_3" value="<?php if($detProd['pri_3']>0) echo valInvUCom($detProd['prod_id'],3) ?>" class="span12" step="0.00001">
		</div>
	</div>
    
    <div class="well well-small">
    <?php
	$vPVP=valInvUCom($id,'N');
	$vNETO=valNETO($vPVP);
	?>
    
	<div class="input-prepend row-fluid">
	<span class="add-on span6">ULTIMA COMPRA NETO</span>
	<input class="span6" id="vinv" type="text" value="<?php echo $vNETO;?>" disabled>
	</div>
    <div class="input-prepend row-fluid">
	<span class="add-on span6">ULTIMA COMPRA PVP</span>
	<input class="span6" type="text" value="<?php echo $vPVP?>" disabled>
	</div>
    
	</div>
    
    <div class="control-group">
    	<label class="control-label">Notas</label>
    	<div class="controls">
      	<textarea name="txt_obs" id="txt_obs" rows="2" class="input-block-level"><?php echo $detProd['prod_obs']; ?></textarea>
    	</div>
  	</div>
    </fieldset>
	</div></div>
	<div class="span6">
		<div class="well">
			<div class="text-center">
            <?php echo $viewImage ?><br>
			<input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" />
            </div>
		</div>
        <div class="well">
        	<div class="row-fluid">
            	<div class="span12">
                <a class="btn btn-block disabled">ATRIBUTOS</a>
                <?php echo generarselect("atribSel[]",listTypesMod('ATRIB'),$atribProd,'input-block-level', 'multiple', 'chosCat'); ?>
                </div>
            </div>
        </div>
	</div>
</div>
</div>
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {	
	$('#chosCat').chosen();
	$('#id_mar_sel').chosen();
	$('#id_tip_sel').chosen();

	valInv=parseFloat($("#vinv").val());


$("#pri_1").on("change keyup", function(){genTot(1,"pri");});
$("#val_1").on("change keyup", function(){genTot(1,"val");});
$("#pri_2").on("change keyup", function(){genTot(2,"pri");});
$("#val_2").on("change keyup", function(){genTot(2,"val");});
$("#pri_3").on("change keyup", function(){genTot(3,"pri");});
$("#val_3").on("change keyup", function(){genTot(3,"val");});

	function genTot(val,mod){
		if(mod=="pri"){ //PVP
			var totNet=valInv+(valInv*parseFloat($("#pri_"+val).val())/100);
			var tot=totNet*<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>;
			$("#val_"+val).attr('value',parseFloat(tot).toFixed(5));
			$("#net_"+val).attr('value',parseFloat(totNet).toFixed(5));
		}
		if(mod=="val"){//PORC
			var totNet=parseFloat($("#val_"+val).val())/<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>;
			var tot=(totNet/valInv)*100-100;
			$("#pri_"+val).attr('value',parseFloat(tot).toFixed(5));
			$("#net_"+val).attr('value',parseFloat(totNet).toFixed(5));
		}
	}
});	
	
</script>