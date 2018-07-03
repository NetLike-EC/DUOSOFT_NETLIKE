<?php include('../../init.php');
$dM=vLogin('MENU ITEMS');

$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$det=detRow('tbl_menus_items','md5(men_id)',$ids);
if ($det){
	$id=$det['men_id'];
	$acc=md5(UPDmi);
	$btnAction='<button type="button" class="btn btn-success" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> ACTUALIZAR</button>';
}else {
	$acc=md5(INSmi);
	$btnAction='<button type="button" class="btn btn-primary" id="vAcc"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>';
}
$css['body']='cero';
include(RAIZf.'_head.php'); ?>
<div class="container">
<form enctype="multipart/form-data" method="post" action="fncts.php" class="form-horizontal">
<fieldset>
<input name="acc" type="hidden" value="<?php echo $acc ?>">
<input name="form" type="hidden" value="<?php echo md5(formMI) ?>">
<input name="ids" type="hidden" value="<?php echo $ids ?>" />
<input name="url" type="hidden" value="<?php echo $urlc ?>" />
</fieldset>
<?php echo genPageNavbar($dM['mod_cod']) ?>
<div class="btn-group pull-right">
      <?php echo $btnAction ?>
      <a href="<?php echo $_SESSION['urlc'] ?>" class="btn btn-default"><i class="fa fa-plus"></i> NUEVO</a>
    </div>
<?php echo genPageHead(NULL,$det['men_nombre'],'h2', $det['men_id']) ?>
<?php sLog('g'); ?>
<div class="row">
	<div class="col-sm-5">
    <div class="panel panel-primary">
    <div class="panel-heading">Estructura del Menu</div>
    <div class="panel-body">
    <fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="control-label col-sm-4" for="dNom">Nombre</label>
			<div class="col-sm-8">
		  <input name="dNom" id="dNom" type="text" placeholder="Nombre / REFERENCIA" value="<?php echo $det['men_nombre']; ?>" class="form-control" required autofocus></div>
		</div>
        <div class="form-group">
			<label class="control-label col-sm-4" for="menu_id">MENU CONTENEDOR</label>
			<div class="col-sm-8">
				<?php genSelect('dIDC',detRowGSel('tbl_menus','id','CONCAT(sec," | ",nom)','stat','1'),$det['men_idc'],'form-control','required onChange="loadMI(this.value,0)"'); ?>
            </div>
		</div>
        <div class="form-group">
		  <label class="control-label col-sm-4">MENU PADRE</label>
			<div class="col-sm-8">
            	<select name="dIDP" id="LMI" class="form-control" required></select>
            </div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4" for="men_orden">Orden</label>
			<div class="col-sm-8">
		  <input name="dOrd" type="number" min="0" step="1" id="men_orden" placeholder="Nombre del Menú" value="<?php echo $det['men_orden']; ?>" class="form-control"></div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4" for="menu_id">COMPONENTE</label>
			<div class="col-sm-8">
				<?php genSelect('dMod',detRowGSel('db_componentes','mod_cod','mod_ref','mod_stat','1'),$det['mod_cod'],'form-control'); ?>
            </div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4">Estado</label>
			<div class="col-sm-8">		  
            <div class="btn-group" data-toggle="buttons">
            <label class="btn btn-primary btn-sm <?php if($det['men_stat']=='1') echo 'active' ?>">
            <input type="radio" name="dStat" id="stat0" value="1" autocomplete="off" <?php if($det['men_stat']=='1') echo 'checked' ?>> Activo
            </label>
            <label class="btn btn-primary btn-sm <?php if($det['men_stat']=='0') echo 'active' ?>">
            <input type="radio" name="dStat" id="stat1" value="0" autocomplete="off" <?php if($det['men_stat']=='0') echo 'checked' ?>> Inactivo
            </label>
            </div>
          </div>
		</div>
        
        
        
    </fieldset>
    </div>
    </div>
    </div>
    <div class="col-sm-7">
    <div class="panel panel-default">
    <div class="panel-heading">Opciones Visuales del Menu</div>
    <div class="panel-body">
    <fieldset class="form-horizontal">
    	<div class="form-group">
			<label class="control-label col-sm-4" for="men_link">Link</label>
			<div class="col-sm-8">
		  <input name="dLnk" type="text" id="men_link" placeholder="Enlace al Archivo" value="<?php echo $det['men_link']; ?>" class="form-control"></div>
		</div>
		<div class="well">
		<?php $contMenTit=genFormControlLang('col-sm-8','text','men_tit',NULL,'form-control','Visible text in front-end','Visible title','col-sm-4','tbl_menus_items','men_tit',$id);
		echo $contMenTit[log];
		echo $contMenTit[val];
		?>
		</div>
		<!--
		<div class="form-group">
			<label class="control-label col-sm-4" for="men_tit">Titulo Visible</label>
			<div class="col-sm-8">
		  <input name="dTit" type="text" id="men_tit" placeholder="Titulo" value="<?php echo $det['men_tit']; ?>" class="form-control"></div>
		</div>
		-->
		
        <div class="form-group">
			<label class="control-label col-sm-4" for="txtIcon">Icono</label>
			<div class="col-sm-8">
		  <div class="input-group">
          <input name="dIco" type="text" id="txtIcon" placeholder="Icono" value="<?php echo $det['men_icon']; ?>" class="form-control">
          <div class="input-group-addon"><i id="iconRes"></i></div>
          </div>
          </div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4" for="men_css">Clase CSS</label>
			<div class="col-sm-8">
		  <input name="dCss" type="text" id="men_css" placeholder="Estilo" value="<?php echo $det['men_css']; ?>" class="form-control"></div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4" for="men_precode">Pre Codigo</label>
			<div class="col-sm-8">
			<textarea name="dPreCode" id="men_precode" placeholder="Codigo para mostrar antes del Menu" class="form-control"><?php echo $det['men_precode']; ?></textarea>
			</div>
		</div>
        
        <div class="form-group">
			<label class="control-label col-sm-4" for="men_poscode">Post Codigo</label>
			<div class="col-sm-8">
		  	<textarea name="dPostCode" id="men_poscode" placeholder="Codigo para mostrar despues del Menu" class="form-control"><?php echo $det['men_postcode']; ?></textarea>
			</div>
		</div>
        
    </fieldset>
    </div>
    </div>
    </div>
</div>
</form>
</div>
<script type="text/javascript">
$(document).ready(function() {
	$('#txtProv').chosen();
	var idmc=<?php echo intval($det['men_idc']); ?>;
	var idmp=<?php echo intval($det['men_padre']); ?>;
	loadMI(idmc,idmp);
	var txtIcon=$("#txtIcon");
	txtIcon.on('keypress keyup focusout', function(evt, params) {
		iconClass(txtIcon.val());
	});
});
function iconClass(clase){
	$("#iconRes").removeClass();
	$("#iconRes").addClass(clase);
}
function loadMI(id,sel){
	sel = sel || '0';
	var miselect=$("#LMI");
	$.post( "jsonMI.php", { id: id}, function( data ) {
		miselect.empty();
		for (var i=0; i<data.length; i++) {
			if(sel==data[i].id) miselect.append('<option value="' + data[i].id + '" selected>'+ data[i].literal + '</option>');
			else miselect.append('<option value="' + data[i].id + '">'+ data[i].literal + '</option>');
		}
	}, "json");
}
</script>
<?php include(RAIZf.'_foot.php'); ?>