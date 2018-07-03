<?php include('../../init.php');

$id_user = $_SESSION['dU']['usr_id'];
fnc_autentificacion();
$URL_Visita_Ult=basename($_SERVER['REQUEST_URI'], "/");
$url_autorizado=fnc_datURLv($URL_Visita_Ult, $id_user);
if((basename($url_autorizado['men_link'],"/"))==$URL_Visita_Ult){
	
$_SESSION['MODSEL']="CON";
include(RAIZf."head.php");
include(RAIZf.'fraTop.php'); ?>
<div class="container">
	<?php echo gen_pageTit($_SESSION['MODSEL']) ?>
	<div class="well well-sm"><?php include(RAIZc.'com_pacientes/pacientes_find.php'); ?></div>
    <div><?php include(RAIZc.'com_pacientes/pacientes_list.php'); ?></div>
</div>
<?php include(RAIZf.'fraBot.php');
include(RAIZm.'taskbar/_taskbar_consultas.php'); ?>
</body>
</html>

<?php }else
	{		
		$_SESSION['MSG'] = 'Acceso no Autorizado';
		$_SESSION['MSGdes'] = 'PERMISOS INSUFICIENTES';
		$_SESSION['MSGimg'] = $RUTAi.'noautorizado.png';
		header("Location: ".$RAIZ);	
	}
?>