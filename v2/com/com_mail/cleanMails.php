<?php require('../../init.php');
fnc_accessnorm();
$rowMod=fnc_datamod('MAILCM');
$lm=fnc_verifiparam('lm', $_GET['lm'], $_POST['lm']);
function extract_email_address ($string) {
    foreach(preg_split('/[\s,]+/', $string) as $token) {
	//foreach(preg_split('/\s/', $string) as $token) {
        $email = filter_var(filter_var($token, FILTER_SANITIZE_EMAIL), FILTER_VALIDATE_EMAIL);
        if ($email !== false) $emails[] = $email;
	}
    return $emails;
}
$lmv=extract_email_address($lm);
if($lmv){
	$lmvc = array_unique($lmv);
	foreach ($lmvc as $value) $LF.=$value."<br>";
}
include(RAIZf.'_head.php');
include(RAIZm.'mod_navbar/mod.php') ?>
<div class="container">
<div class="page-header">
<?php echo genPageTit($wp1,$rowMod['mod_nom'],$rowMod['mod_des']); ?>
</div>
<?php fnc_log(); ?>
	<form action="<?php echo $urlc ?>" method="post">
    <div class="row">
    	<div class="col-sm-6">
        	<textarea class="form-control" rows="20" name="lm"><?php echo $lm ?></textarea>
        </div>
    	<div class="col-sm-6">
        	<div class="panel panel-primary">
            	<div class="panel-heading"><?php echo 'Total Emails Obtenidos. <strong>'.count($lmvc).'</strong>'; ?></div>
                <div class="panel-body">
                <?php echo $LF ?>
                </div>
            </div>
        </div>
    	
        
    </div>
    <div class="form-group text-center">
    	<button type="submit" class="btn btn-primary">Ejecutar Limpieza</button>
    </div>
    </form>
</div>
<?php include(RAIZf.'_foot.php'); ?>