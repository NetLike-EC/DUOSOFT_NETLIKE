<?php 
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$det=detRow('db_componentes','md5(mod_cod)',$ids);
if ($det){
	$id=$det[mod_cod];
	$acc=md5(UPDm);
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}else {
	$acc=md5(INSm);
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i][ins].$cfg[b][ins].'</button>';
}
$btnNew=genLink($urlc,$cfg[i]['new'].$cfg[b]['new'],$css='btn btn-default');
?>
<form enctype="multipart/form-data" method="post" action="_fnc.php" class="form-horizontal">
	<fieldset>
		<input name="form" type="hidden" value="<?php echo md5(formMod) ?>">
		<input name="ids" type="hidden" value="<?php echo $ids ?>" />
		<input name="acc" type="hidden" value="<?php echo $acc ?>">
		<input name="url" type="hidden" value="<?php echo $urlc ?>" />
	</fieldset>
	<?php echo genPageHeader($dM[id],'navbar') ?>
	<?php echo genPageHeader(NULL,'header','h2',array('nom'=>$det['mod_ref'],'id'=>$id),NULL, $btnAcc.$btnNew) ?>
	<div class="row">
		<div class="col-sm-7">
			<div class="well well-sm">
			<fieldset class="form-horizontal">
			<div class="form-group">
				<label class="control-label col-sm-4" for="mod_ref"><?php echo $cfg[com_modF][f_ref] ?></label>
				<div class="col-sm-8">
			  <input name="mod_ref" type="text" id="mod_ref" placeholder="<?php echo $cfg[com_modF][f_Lref] ?>" value="<?php echo $det['mod_ref']; ?>" class="form-control" required></div>
			</div>
			<div class="panel panel-default"><div class="panel-body">
			<?php $contMenTit=genFormControlLang('col-sm-8','text','mod_nom',NULL,'form-control',NULL,'Title','col-sm-4','db_componentes','mod_nom',$id);
			echo $contMenTit[log];
			echo $contMenTit[val];
			?>
			</div></div>
			<!--
			<div class="form-group">
				<label class="control-label col-sm-4" for="mod_ref">Nombre / Titulo</label>
				<div class="col-sm-8">
			  <input name="mod_nom" type="text" id="mod_nom" placeholder="Nombre del módulo" value="<?php echo $det['mod_nom']; ?>" class="form-control" required></div>
			</div>
			-->
			<div class="panel panel-default"><div class="panel-body">
			<?php $contMenTit=genFormControlLang('col-sm-8','text','mod_des',NULL,'form-control',NULL,'Description','col-sm-4','db_componentes','mod_des',$id);
			echo $contMenTit[log];
			echo $contMenTit[val];
			?>
			</div>
			</div>
			<!--
			<div class="form-group">
				<label class="control-label col-sm-4" for="mod_des">Descripcion</label>
				<div class="col-sm-8">
			  <input name="mod_des" type="text" id="mod_des" placeholder="Descripcion del módulo" value="<?php echo $det['mod_des']; ?>" class="form-control"></div>
			</div>
			-->
			<div class="form-group">
				<label class="control-label col-sm-4" for="txtIcon">Icono</label>
				<div class="col-sm-8">
			  <div class="input-group">
			  <input name="mod_icon" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $det['mod_icon']; ?>" class="form-control">
			  <div class="input-group-addon"><i class="<?php echo $det['mod_icon']; ?>" id="iconRes"></i></div>
			  </div>
			  </div>
			</div>
			<div class="form-group">
				<label class="control-label col-sm-4" for="mod_des">Status</label>
			  <div class="col-sm-8">
			  <p>
				<label>
				  <input name="mod_stat" type="radio" id="mod_stat_0" value="1" checked="checked">
				  Activo</label>
				<br>
				<label>
				  <input type="radio" name="mod_stat" value="0" id="mod_stat_1">
				  Inactivo</label>
				<br>
				</p>
			  </div>
			</div>

			</fieldset>
			</div>
		</div>
		<div class="col-sm-5">
			<div class="panel panel-default">
				<div class="panel-heading">Menus Items Relacionados</div>
				<div class="panel-body">menus</div>
			</div>
		</div>

	</div>
</form>