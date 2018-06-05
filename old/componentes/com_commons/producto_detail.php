<?php include_once('../../init.php');
$id_prod=vParam('id_prod', $_GET['id_prod'], $_POST['id_prod']);
$action=vParam('action', $_GET['action'], $_POST['action']);
$mod=vParam('mod', $_GET['mod'], $_POST['mod']);
$detPro=detInvProd($id_prod);
$detTip=detInvTip($detPro['tip_cod']);
$detCat=detInvCat($detTip['cat_cod']);
$detMar=detInvMar($detPro['mar_id']);
$pimage=fnc_image_exist('db/prod/',$detPro['prod_img'],TRUE);
	$viewImage='
	<div class="item text-center">
		<a href="'.$pimage['norm'].'" data-rel="fancybox-button" class="fancybox-button">
			<div class="zoom">
				<img src="'.$pimage['thumb'].'" class="img-small"/>
				<div class="zoom-icon"></div>
			</div>
		</a>
	</div>';


if ($action=='add'){
	$producto = $id_prod;
	$cantidad=vParam('txt_can', $_GET['txt_can'], $_POST['txt_can']);
	$precio=vParam('txt_pre', $_GET['txt_val'], $_POST['txt_val']);
	
	if($mod=="COM") $anterior = $_SESSION[$ses_id]['compra'];
	if($mod=="VEN") $anterior = $_SESSION[$ses_id]['venta'];
	
	foreach ($anterior as $keyAgregar => $v) $lastid=$keyAgregar;
	$contITM=$lastid+1;
	
	$anterior[$contITM]["id"]  = $producto;
	$anterior[$contITM]["can"]  = $cantidad;
	$anterior[$contITM]["pre"] = $precio;

	if($mod=="COM") $_SESSION[$ses_id]['compra'] = $anterior;
	if($mod=="VEN") $_SESSION[$ses_id]['venta'] = $anterior;	 
}
include_once(RAIZf.'_head.php'); ?>

<script type="text/javascript">
$(document).ready(function() {	
	//Evento cuando cambio cantidades
	$("#txt_uni").on("change keyup", cant);
	$("#txt_up").on("change keyup", cant);
	//Funcion que establece cantidad
	function cant(){
		$("#txt_can").attr('value',parseFloat($("#txt_uni").val())*parseFloat($("#txt_up").val()));
		$("#txt_valT").attr('value',parseFloat($("#txt_val").val())*parseFloat($("#txt_can").val()));
		$("#txt_pvpT").attr('value',parseFloat($("#txt_valT").val())*<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>);
	}
	
	//VALORES
	$("#txt_val").on("change keyup", function(){valVen("pvp");});
	$("#txt_pvp").on("change keyup", function(){valVen("val");});
	$("#txt_valT").on("change keyup", function(){valVen("pvpT");});
	$("#txt_pvpT").on("change keyup", function(){valVen("valT");});
	
	function valVen(mod){
		var cantidad=parseInt($("#txt_can").val());
		if(mod=="pvp"){ //Modificando VAL
			var neto = parseFloat($("#txt_val").val());
			var pvp=neto+(neto*<?php echo $_SESSION['conf']['taxes']['iva_si'] ?>);
			var pvpT=pvp*cantidad;
			var valT=neto*cantidad;
			$("#txt_pvp").attr('value',pvp.toFixed(5));
			$("#txt_pvpT").attr('value',pvpT.toFixed(5));
			$("#txt_valT").attr('value',valT.toFixed(5));
		}
		if(mod=="val"){//Modificando PVP
			var pvp = parseFloat($("#txt_pvp").val());
			var val=pvp/<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>;
			var valT=val*cantidad;
			var pvpT=pvp*cantidad;
			$("#txt_val").attr('value',val.toFixed(5));
			$("#txt_valT").attr('value',valT.toFixed(5));
			$("#txt_pvpT").attr('value',pvpT.toFixed(5));
		}
		if(mod=="pvpT"){ //Modificando VALT
			var valT = parseFloat($("#txt_valT").val());
			var pvpT=(valT+(valT*<?php echo $_SESSION['conf']['taxes']['iva_si'] ?>));
			var pvp=pvpT/cantidad;
			var val=(valT)/cantidad;
			$("#txt_pvpT").attr('value',pvpT.toFixed(5));
			$("#txt_pvp").attr('value',pvp.toFixed(5));
			$("#txt_val").attr('value',val.toFixed(5));
		}
		if(mod=="valT"){//Modificando PVPT
			var pvpT = parseFloat($("#txt_pvpT").val());
			var valT=pvpT/<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>;
			var val=valT/cantidad;
			var pvp=val*<?php echo $_SESSION['conf']['taxes']['iva_ii'] ?>;
			$("#txt_valT").attr('value',valT.toFixed(5));
			$("#txt_val").attr('value',val.toFixed(5));
			$("#txt_pvp").attr('value',pvp.toFixed(5));
		}
		
	}	
});	
</script>

<?php if ($mod=="COM") { ?>
<div id="contReload">
	<div class="portlet box blue">
    	<div class="portlet-title">
			<span class="label label-info"><h4><strong> <?php echo $id_prod ?> </strong></h4></span> 
			<span class="label label-info"><h4><?php echo $detPro['prod_nom']?></h4></span>
		</div>
        <div class="portlet-body">
			<div class="row-fluid">
            	<div class="span8">
                	<div class="btn-group">
                    <a class="btn green mini tooltips" data-placement="top" data-original-title="TIPO">
                    <strong><?php echo $detTip['tip_nom']?></strong></a>
                    <a class="btn purple mini tooltips" data-placement="top" data-original-title="CATEGORIA">
                    <strong><?php echo $detCat['cat_nom']?></strong></a>
                    <a class="btn yellow mini tooltips" data-placement="top" data-original-title="MARCA">
                    <strong><?php echo $detMar['mar_nom']?></strong></a>
                </div>
                	<div class="row-fluid">
						<a href="#" class="btn span6">
							<p>Stock Existente</p>
                            <div><span class="badge badge-info"><?php echo stock_existente_producto($id_prod);//$stock_inventario_find; ?></span></div>
						</a>
						<a href="#" class="btn span6">
							<p>Valor Inventario</p>
                            <div><span class="badge badge-important">
                            <abbr title="PVP: <?php echo valPVP(valInvUCom($id_prod,'N'));?>">Neto: <?php echo valInvUCom($id_prod,'N');?></abbr>
                            </span>
                            </div>
						</a>
					</div>
                </div>
                <div class="span4"><?php echo $viewImage ?></div>
            </div>
        </div>
    </div>
	<div class="row-fluid">
		<fieldset>
            <div class="row-fluid">
           	  <div class="span3">Cantidad
                <input type="number" name="txt_uni" id="txt_uni" max="100000" min="1" value="1" class="input-block-level" autofocus/>
              </div>
              <div class="span3">Paquete
                <?php echo generarselect("typ_cod",listatipos("PAQ"),"93",'input-block-level', 'required'); ?>
              </div>
                <div class="span3">Cant*Paq
                <input type="number" name="txt_up" id="txt_up" max="100000" min="1" value="1" class="input-block-level"/>
                </div>
              <div class="span3">Unidades
                <input type="number" name="txt_can" id="txt_can" max="100000" min="1" value="1" class="input-block-level" disabled/>
              </div>
            </div>
            </fieldset>
		<fieldset class="form-horizontal">
			<div class="row-fluid">
			<div class="span6">
            <div class="control-group">
					<label class="control-label">Precio (Neto) Unitario</label>
					<div class="controls">
                    	<input type="number" step="any" name="txt_val" id="txt_val" value="<?php echo $txt_val; ?>" class="input-block-level"/>
					</div>
				</div>
			<div class="control-group info">
					<label class="control-label"><strong>P.V.P. Unitario</strong></label>
					<div class="controls">
                    	<input type="number" step="0.001" name="txt_pvp" id="txt_pvp" value="" class="input-block-level"/>
				  </div>
				</div>
            </div>
            <div class="span6">
            <div class="control-group">
					<label class="control-label">Precio (Neto) Total</label>
					<div class="controls">
                    	<input type="number" step="any" name="txt_valT" id="txt_valT" value="<?php echo $txt_val; ?>" class="input-block-level"/>
					</div>
			  </div>
			<div class="control-group info">
			  <label class="control-label"><strong>P.V.P. Total</strong></label>
					<div class="controls">
                    	<input type="number" step="0.001" name="txt_pvpT" id="txt_pvpT" value="" class="input-block-level"/>
				  </div>
			  </div>
            </div>
			</div>
            </fieldset>
		<fieldset>
			<input name="IndiceSES" type="hidden" id="IndiceSES" value="<?php echo $IndiceSES; ?>">
			<input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>" />
			<input name="mod" type="hidden" id="mod" value="<?php echo $mod; ?>" />
			</fieldset>
	</div>

</div>
<?php }
if ($mod=="VEN") {
?>
<script type="text/javascript">
$(document).ready(function() {
});	
</script>
<div id="contReload">
	<div class="portlet box blue">
    	<div class="portlet-title">
			<span class="label label-info"><h4><strong> <?php echo $id_prod ?> </strong></h4></span> 
			<span class="label label-info"><h4><?php echo $detPro['prod_nom']?></h4></span>
		</div>
        <div class="portlet-body">
			<div class="row-fluid">
            	<div class="span8">
                	<div class="btn-group">
                    <a class="btn green mini tooltips" data-placement="top" data-original-title="TIPO">
                    <strong><?php echo $detTip['tip_nom']?></strong></a>
                    <a class="btn purple mini tooltips" data-placement="top" data-original-title="CATEGORIA">
                    <strong><?php echo $detCat['cat_nom']?></strong></a>
                    <a class="btn yellow mini tooltips" data-placement="top" data-original-title="MARCA">
                    <strong><?php echo $detMar['mar_nom']?></strong></a>
                	</div>
                	<div class="row-fluid">
                    	<a href="#" class="btn blue span5">
                            <div>Stock <span class="badge badge-info"><?php echo stock_existente_producto($id_prod);//$stock_inventario_find; ?></span></div>
						</a>
                        <a href="#" class="btn blue span7">
                            <div>Compra <span class="badge badge-info">
                            <abbr title="PVP Compra: <?php echo valPVP(valInvUCom($id_prod,'N')); ?>">Neto: <?php echo valInvUCom($id_prod,'N'); ?>
                            </abbr>
                            </span></div>
						</a>
					</div>
                    <div class="row-fluid">
                    	<a class="btn span4"><div>P1 <span class="badge badge-info"><?php echo valInvUCom($id_prod,1) ?></span></div></a>
						<a class="btn span4"><div>P2 <span class="badge badge-info"><?php echo valInvUCom($id_prod,2) ?></span></div></a>
                        <a class="btn span4"><div>P3 <span class="badge badge-info"><?php echo valInvUCom($id_prod,3) ?></span></div></a>
					</div>
                </div>
                <div class="span4"><?php echo $viewImage ?></div>
            </div>
        </div>
    </div>
	<div>
	<fieldset>
		<input name="IndiceSES" type="hidden" id="IndiceSES" value="<?php echo $IndiceSES; ?>">
		<input name="id_prod" type="hidden" id="id_prod" value="<?php echo $id_prod; ?>" />
		<input name="mod" type="hidden" id="mod" value="<?php echo $mod; ?>" />
		<input type="hidden" name="can_max" id="can_max" value="<?php echo stock_existente_producto($id_prod);?>">
	</fieldset>
	<fieldset>
		<div class="row-fluid">
			<div class="span3">Cantidad
				<input type="number" name="txt_uni" id="txt_uni" max="100000" min="1" value="1" class="input-block-level" autofocus/>
			</div>
			<div class="span3">Paquete
				<?php echo generarselect("typ_cod",listatipos("PAQ"),"93",'input-block-level', 'required'); ?>
			</div>
			<div class="span3">Cant*Paq
				<input type="number" name="txt_up" id="txt_up" max="100000" min="1" value="1" class="input-block-level"/>
			</div>
			<div class="span3">
				<div class="control-group info">
				<label class="control-label"><strong>Unidades</strong></label>
				<input type="number" name="txt_can" id="txt_can" max="100000" min="1" value="1" class="input-block-level" disabled/></div>
			</div>
		</div>
	</fieldset>
	<fieldset class="form-horizontal">
		<div class="row-fluid">
			<div class="span6">
				<div class="control-group"><label class="control-label">Precio (Neto) Unitario</label>
					<div class="controls"><input type="number" step="any" name="txt_val" id="txt_val" value="<?php echo $txt_val; ?>" class="input-block-level"/></div>
				</div>
				<div class="control-group info"><label class="control-label"><strong>P.V.P. Unitario</strong></label>
					<div class="controls"><input type="number" step="0.001" name="txt_pvp" id="txt_pvp" value="" class="input-block-level"/></div>
				</div>
            </div>
            <div class="span6">
				<div class="control-group"><label class="control-label">Precio (Neto) Total</label>
					<div class="controls"><input type="number" step="any" name="txt_valT" id="txt_valT" value="<?php echo $txt_val; ?>" class="input-block-level"/></div>
				</div>
				<div class="control-group info"><label class="control-label"><strong>P.V.P. Total</strong></label>
					<div class="controls"><input type="number" step="0.001" name="txt_pvpT" id="txt_pvpT" value="" class="input-block-level"/></div>
				</div>
			</div>
		</div>
	</fieldset>
	</div>
</div>
<?php } ?>