<?php
include('init.php');
$loginFormAction = $_SERVER['PHP_SELF'];
login($_POST['username'], $_POST['password'], $_POST['accesscheck']);

$css['body']='cero bodyLogin bodyLogin-0'.rand(1,4);
include(RAIZf.'head.php'); ?>
<div class="container">
<div class="page-header" align="center">
  <h1>DUOSOFT <small>CMS Gestión Empresarial</small></h1>
</div>
<?php sLOG("a",$_REQUEST['LOG']) ?>
<div class="row">
<div class="col-md-7">
	<div class="well">
    <form action="<?php echo $loginFormAction; ?>" id="form1" name="form_autenth" method="post" class="form-horizontal" role="form">
    <input type="hidden" name="accesscheck" value="<?php echo $_REQUEST['accesscheck'] ?>">
	<legend class="text-center">Acceso al Sistema</legend>
	<div class="form-group">
		<label class="col-md-4 control-label" for="username">Nombre Usuario</label>
		<div class="col-md-8"><input name="username" type="text" id="username" placeholder="Usuario del Sistema" class="form-control input-lg" required/></div>
	</div>
	<div class="form-group">
		<label class="col-md-4 control-label" for="password">Contraseña</label>
		<div class="col-md-8"><input name="password" type="password" id="password" placeholder="Contraseña de Usuario" class="form-control input-lg" required/></div>
	</div>
	<div class="form-group">
    <div class="col-sm-offset-4 col-sm-8">
		<button type="submit" class="btn btn-lg btn-block btn-primary">Ingresar al Sistema</button>
	</div>
	</div>
	</form>
	</div>
</div>
<div class="col-md-5">
	<div class="well text-center">
        <img style="background: #303031" src="<?php echo $RAIZa ?>img/struct/logo-03.png" class="img-thumbnail">

        
        </div>
</div>
</div>
</div>
<?php include(RAIZf.'footer.php'); ?>