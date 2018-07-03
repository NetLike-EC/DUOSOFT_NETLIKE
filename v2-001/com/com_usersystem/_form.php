<?php
$ids=vParam('ids', $_GET['ids'], $_POST['ids'], FALSE);
$det=detRow('tbl_user_system','md5(user_id)',$ids);
//var_dump($_SESSION['form']);
//echo '<hr>';
if($det){
	$id=$det[user_id];
	$acc=md5('UPDu');
	$btnAcc='<button type="button" class="btn btn-success" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}else{
	$det=$_SESSION['form'];
	unset($_SESSION['form']);
	$acc=md5('INSu');
	$btnAcc='<button type="button" class="btn btn-primary" id="vAcc">'.$cfg[i][upd].$cfg[b][upd].'</button>';
}
$btnNew='<a class="btn btn-default" href="form.php">'.$cfg[i]['new'].$cfg[b]['new'].'</a>';
?>
<form action="actions.php" method="post" role="form">
	<input type="hidden" name="form" value="<?php echo md5('formUsr') ?>">
	<input type="hidden" name="ids" value="<?php echo $ids ?>">
	<input type="hidden" name="acc" value="<?php echo $acc ?>">
	<input type="hidden" name="url" value="<?php echo $urlc ?>">
	<?php echo genPageHeader($dM['mod_cod'],'navbar') ?>
	<?php echo genPageHeader(NULL,'header','h2',array('nom'=>$det['user_name'],'id'=>$id),NULL,$btnAcc.$btnNew) ?>
	<div class="row">
		<div class="col-sm-6">
			<div class="panel panel-primary">
				<div class="panel-heading"><i class="fa fa-sign-in fa-lg"></i> Datos de Usuario</div>
				<div class="panel-body">
				<fieldset class="form-horizontal">
					<div class="form-group">
						<label class="col-sm-3 control-label">Nombre Usuario</label>
						 <div class="col-sm-9">
						 <input name="inpUserName" class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $det['user_username'] ?>" autocomplete="off">
						 </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Password</label>
						 <div class="col-sm-9">
						 <input name="formPassNew1" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
						 </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Confirmar Password</label>
						 <div class="col-sm-9">
						 <input name="formPassNew2" class="form-control" type="password" placeholder="Contraseña de usuario" autocomplete="off">
						 </div>
					</div>
					<div class="form-group">
						<label class="col-sm-3 control-label">Password Hint</label>
						 <div class="col-sm-9">
						 <input name="inpPassHint" type="text" value="<?php echo $det['user_password_hint'] ?>" class="form-control" placeholder="">
						 </div>
					</div>
				</fieldset>
				</div>
			</div>
		</div>
		<div class="col-sm-6">
			<div class="panel panel-info">
				<div class="panel-heading"><i class="fa fa-info-circle fa-lg"></i> Información Personal</div>
				<div class="panel-body">
					<fieldset class="form-horizontal">
						<div class="form-group">
							<label class="col-sm-3 control-label">Email</label>
							 <div class="col-sm-9">
							 <input name="inpEmail" type="text" value="<?php echo $det['user_email'] ?>" class="form-control" placeholder="">
							 </div>
						</div>
						<div class="form-group">
							<label class="col-sm-3 control-label">Nombres Completos</label>
							 <div class="col-sm-9">
							 <input name="inpName" class="form-control" type="text" placeholder="nombre de usuario" value="<?php echo $det['user_name'] ?>" autocomplete="off">
							 </div>
						</div>

						<div class="form-group">
							<label class="col-sm-3 control-label">Level</label>
							 <div class="col-sm-9">
							 <input list="levels" name="inpLev" value="<?php echo $det['user_level'] ?>" class="form-control" required>
								<datalist id="levels">
								<option value="0">Super Administrator</option>
								<option value="1">Administrator</option>
								<option value="2">Content Creator</option>
								<option value="3">Moderator</option>
								</datalist>
							 </div>
						</div>

						<div class="form-group">
						<label class="col-sm-3 control-label" for="txt_brand">Language</label>
						<div class="col-sm-9">
						<?php echo genSelect('inpLang', detRowGSel('db_lang','min','min','est','1'), $det['user_lang'], 'form-control',NULL,NULL,NULL,FALSE);?> 
						</div>
						</div>

						<div class="form-group">
						<label class="col-sm-3 control-label">Tema</label>
						<div class="col-sm-9">
							<input list="themes" name="inpTheme" value="<?php echo $det['user_theme'] ?>" class="form-control">
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
</form>