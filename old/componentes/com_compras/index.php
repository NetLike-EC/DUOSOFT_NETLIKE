<?php include('../../init.php');
loginN(); 
$mSel='mComGen';
  $_SESSION['MODSEL']="COM";//Variable para identificar el MODULO en el que se encuentra
  $_SESSION[$ses_id]['compra']=null;//Variable que contendrá el Array de la lista de Articulos a Comprar / Vender
  $_SESSION['stat_proc']="PROCESS";//Variable para Verificar que se a terminado de Crear la Compra, en esta instancia se reinicia el valor a PROCESS para permitir la creacion de una nueva compra
  $_SESSION['com_num']=null;//Se Reinicia el Numero de la Compra Procesada Previamente 

$rowMod=detMod($_SESSION['MODSEL']);
include(RAIZf.'_head.php'); ?>
<body class="fixed-top">
<?php include(RAIZf.'_fra_top.php'); ?>
<div class="page-container row-fluid">
	<!-- BEGIN SIDEBAR -->
	<?php include(RAIZm.'mod_sidebar/index.php'); ?>
	<!-- END SIDEBAR -->
	<div class="page-content">
		<!-- BEGIN SAMPLE PORTLET CONFIGURATION MODAL FORM-->
		<?php include(RAIZm.'mod_portlet/index.php'); ?>
		<!-- END SAMPLE PORTLET CONFIGURATION MODAL FORM-->
        <!-- BEGIN PAGE -->
		<?php include('_c_index.php'); ?>
		<!-- END PAGE -->
       </div>
</div>
</body>
</html>