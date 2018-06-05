<?php include('../../init.php');
loginN(); 
$mSel='mVenGen';
  $_SESSION['MODSEL']="VEN";//Variable para identificar el MODULO en el que se encuentra
  $_SESSION[$ses_id]['venta']=null;//Variable que contendrá el Array de la lista de Articulos a Comprar / Vender
  $_SESSION['stat_proc']="PROCESS";//Variable para Verificar que se a terminado de Crear la Compra, en esta instancia se reinicia el valor a PROCESS para permitir la creacion de una nueva compra

$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<div class="page-content"><?php include('_c_index.php'); ?></div>
</div>
</body>
</html>