<?php require_once('init.php');
include(RAIZf.'_head.php');
?>
<body class="cero">
<div class="container">
	<?php include(RAIZf.'_fra_top_home.php'); ?>
	<p class="lead">Change your password in three easy steps. This helps to keep your new password secure.</p>
	<ol>
	<li>Fill in your email address below.</li>
	<li>We’ll email you a link.</li>
	<li>Open the link to change your password on our website.</li>
	</ol>
	<div class="span8 offset2 well">
	<form action="<?php echo $loginFormAction; ?>" id="form1" name="form_autenth" method="post" class="form-horizontal">
		<legend>Reset your password</legend>
		<div class="control-group"><label class="control-label" for="username">Enter your email address</label>
			<div class="controls">
			<span id="spr_txt_username"><input name="username" type="text" id="username" placeholder="name@mercoframes.net"/><br />
			<span class="textfieldRequiredMsg">Required.</span><span class="textfieldMaxCharsMsg">Too many characters</span></span>
			</div>
		</div>
		<div>
		<input name="btn_login" type="submit" value="RESET PASSWORD" class="btn btn-primary" />
		</div>
</form>
    </div>
</div>

<script type="text/javascript">
<!--
var sprytextfield1 = new Spry.Widget.ValidationTextField("spr_txt_username", "none", {validateOn:["blur"], maxChars:100});
//-->
</script>
</body>
</html>