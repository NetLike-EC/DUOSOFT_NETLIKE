<?php require_once('init.php');
$loginFormAction = $_SERVER['PHP_SELF'];
login($_POST['username'], $_POST['password'], $_GET['accesscheck']);
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
	<?php include(RAIZf.'_fra_top_home.php'); ?>
	<div class="row">
	<div class="col-lg-8 col-lg-offset-2">
		<div class="panel panel-default">
			<div class="panel-heading">LOGIN SYSTEM</div>
			<div class="panel-body">
				<form action="<?php echo $loginFormAction; ?>" id="form1" name="form_autenth" method="post" class="form-horizontal" role="form">
				<div class="form-group"><label class="col-lg-4 control-label" for="username">Username</label>
					<div class="col-lg-8">
					<input name="username" type="text" id="username" placeholder="username" class="form-control" required/>
					</div>
				</div>
				<div class="form-group"><label class="col-lg-4 control-label" for="password">Password</label>
					<div class="col-lg-8">
					<input name="password" type="password" id="password" placeholder="password" class="form-control" required/>
					</div>
				</div>
				
				<div class="form-group">
				<div class="col-lg-offset-4 col-lg-8">
					<button type="submit" class="btn btn-primary btn-lg btn-block">SIGN IN</button>
				</div>
				</div>
					
				<!--<div class="text-center"><a href="<?php echo $RAIZ ?>ResetPassword.php">Forgotten your password?</a></div>-->
				</form>
			</div>
		</div>
	</div>
	</div>
</div>
</body>
</html>