<?php include('../../init.php');

$_SESSION['MODSEL']="RPPP";

$id_user = $_SESSION['dU']['usr_id'];
fnc_autentificacion();
$URL_Visita_Ult=basename($_SERVER['REQUEST_URI'], "/");
$url_autorizado=fnc_datURLv($URL_Visita_Ult, $id_user);
if((basename($url_autorizado['men_link'],"/"))==$URL_Visita_Ult){


include(RAIZf."head.php");?>
<body>
<?php include(RAIZm.'mod_menu/menuMain.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div class="well well-sm"><?php include('rep_pacProc_fra.php'); ?></div>
	<div><?php include('rep_pacProc_list.php'); ?></div>
</div>
</body>
<?php include(RAIZf.'footer.php');?>

<?php }else
	{		
		$_SESSION['MSG'] = 'Acceso no Autorizado';
		$_SESSION['MSGdes'] = 'PERMISOS INSUFICIENTES';
		$_SESSION['MSGimg'] = $RUTAi.'noautorizado.png';
		header("Location: ".$RAIZ);	
	}
?>