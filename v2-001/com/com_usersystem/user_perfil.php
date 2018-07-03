<?php include('../../init.php');
$dM=vLOGIN('MUSERINF');
$detU=detRow('tbl_user_system','user_id',$_SESSION['MM_UserID']);
include(RAIZf."_head.php");?>
<?php sLOG('g') ?>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo genPageHead($dM['mod_cod']) ?>
    <?php if($detU){ ?>
	<form action="actions.php" method="post" role="form">
    <input type="hidden" name="form" value="formPerfil">
    <div class="row">
    	<div class="col-sm-6">
        	<div class="panel panel-default">
            	<div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información del Empleado</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3 control-label">Email</label>
						<div class="col-sm-9">
							<input type="iMail" name="emp_mail" value="<?php echo $detU['user_email'] ?>" class="form-control" placeholder="Email">
						</div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombres</label>
						<div class="col-sm-9">
							<input name="iNom" type="text" class="form-control" placeholder="Nombres" value="<?php echo $detU['user_name'] ?>">
						</div>
					</div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Level</label>
                     <div class="col-sm-9">
                     <input type="text" value="<?php echo $detU['user_level'] ?>" class="form-control" readonly>
                     </div>
                </div>
                <div class="form-group">
						<label class="col-sm-3 control-label">Tema</label>
						<div class="col-sm-9">
							<input list="themes" name="inpTheme" value="<?php echo $detU['user_theme'] ?>" class="form-control">
							<datalist id="themes">
							<option value="yeti">bootstrap-yeti.min.css</option>
							<option value="darkly">bootstrap-darkly.min.css</option>
							<option value="cerulean">bootstrap-cerulean.min.css</option>
							<option value="flatly">bootstrap-flatly.min.css</option>
							<option value="cosmo">bootstrap-cosmo.min.css</option>
							<option value="united">bootstrap-united.min.css</option>
							<option value="superHero">bootstrap-superhero.min.css</option>
							<option value="readable">bootstrap-readable.min.css</option>
							<option value="lumen">bootstrap-lumen.min.css</option>
							<option value="journal">bootstrap-journal.min.css</option>
							<option value="simplex">bootstrap-simplex.min.css</option>
							</datalist>
						 </div>
					</div>
                
                </fieldset>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
                <div class="panel-body">
                <fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="col-sm-3 control-label">Usuario</label>
                     <div class="col-sm-9">
                     <input type="text" name="usr_nombre" value="<?php echo $detU['usr_nombre'] ?>" class="form-control" placeholder="Nombre de usuario" required>
                     </div>
                </div>
                <div class="form-group">
                	<label class="col-sm-3 control-label">Contraseña</label>
                     <div class="col-sm-9">
                     <a href="<?php echo $RAIZc?>com_usersystem/changePass.php" class="btn btn-warning fancybox fancybox.iframe"><i class="fa fa-key"></i> Cambiar Contraseña</a>
                     </div>
                </div>
                
                <div class="form-group">
                	<label class="col-sm-3 control-label">Tema</label>
                   	<div class="col-sm-9">
                        <input list="themes" name="user_theme" value="<?php echo $detU['usr_theme'] ?>" class="form-control">
                        <datalist id="themes">
                        <option value="yeti">bootstrap-yeti.min.css</option>
                        <option value="darkly">bootstrap-darkly.min.css</option>
                        <option value="cerulean">bootstrap-cerulean.min.css</option>
                        <option value="flatly">bootstrap-flatly.min.css</option>
                        <option value="cosmo">bootstrap-cosmo.min.css</option>
                        <option value="united">bootstrap-united.min.css</option>
                        <option value="superHero">bootstrap-superhero.min.css</option>
                        <option value="readable">bootstrap-readable.min.css</option>
                        <option value="lumen">bootstrap-lumen.min.css</option>
                        <option value="journal">bootstrap-journal.min.css</option>
                        <option value="simplex">bootstrap-simplex.min.css</option>
                    	</datalist>
                     </div>
                </div>
                </fieldset>
                </div>
            </div>
        </div>
    </div>
    <button type="submit" class="btn btn-block btn-primary"><i class="fa fa-floppy-o fa-lg"></i> GUARDAR</button>
	</form>
	<?php }else{ ?>
		<div class="alert alert-danger"><h4>No se ha seleccionado un Usuario</h4></div>	
	<?php } ?>
</div>
<?php include(RAIZf.'_foot.php')?>