<?php
include('init.php');
$loginFormAction = $_SERVER['PHP_SELF'];
login($_POST['username'], $_POST['password'], $_GET['accesscheck']);
include(RAIZf.'_head.php'); ?>
<body class="login">
<div class="logo"></div>
<div class="content">
<?php fnc_log();?>
    <!-- BEGIN LOGIN FORM -->
    <form class="form-vertical login-form" action="<?php echo $loginFormAction; ?>" name="form_autenth" method="post" >
      <h3 class="form-title">Acceso al sistema</h3>
      <div class="alert alert-error hide">
        <button class="close" data-dismiss="alert"></button>
        <span>Ingrese su usuario y contraseña.</span>
      </div>
      <div class="control-group">
        <!--ie8, ie9 does not support html5 placeholder, so we just show field title for that-->
        <label class="control-label visible-ie8 visible-ie9">Username</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-user"></i>
            <input class="m-wrap placeholder-no-fix" type="text" placeholder="Nombre de Usuario" name="username"/>
          </div>
        </div>
      </div>
      <div class="control-group">
        <label class="control-label visible-ie8 visible-ie9">Password</label>
        <div class="controls">
          <div class="input-icon left">
            <i class="icon-lock"></i>
            <input class="m-wrap placeholder-no-fix" type="password" placeholder="Contraseña" name="password"/>
          </div>
        </div>
      </div>
      <div class="form-actions">
        <button type="submit" class="btn green pull-right">
        Ingresar <i class="m-icon-swapright m-icon-white"></i>
        </button>            
      </div>
    </form>
    <!-- END LOGIN FORM -->
</div>
<div class="copyright">2013 &copy; DUOTICS.</div>

<script>
	jQuery(document).ready(function() {     
		App.initLogin();
	});
</script>
</body>
</html>