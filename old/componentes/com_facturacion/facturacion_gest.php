<?php include('../_config.php'); ?>
<?php
if (!isset($_SESSION)) {
  session_start();
  $_SESSION['id_pac']=null;
  $_SESSION[$ses_id]['compra']=null;
  $_SESSION['MODSEL']="FAC";//VARIABLE SESSION Modulo Seleccionado
  $_SESSION['DIRSEL']=dirsel();
  $_SESSION['stat_proc']="PROCESS";//Variable para Verificar que se a terminado de Crear la Compra, en esta instancia se reinicia el valor a PROCESS para permitir la creacion de una nueva compra
}
loginL("1,2,3");
?>

<?php include(RAIZ."/frames/_head.php"); ?>
<?php $rowMod=detMod($_SESSION['MODSEL']); ?>

<script type="text/javascript">
function load_factura(cli_fact){
Shadowbox.open({
		content:    'factura_form.php',
        player:     "iframe",
        title:      "<strong>FACTURACION</strong>",
        options: 	{relOnClose:true}
        //height:     350,
        //width:      350
    });
}
</script>

<body>
<?php include(RAIZ.'/frames/_fra_top.php'); ?>
<div id="generalcont">
    <div id="middlecont">
        <div id="head_sec"><a href="#"><?php echo strtoupper($rowMod['mod_des']); ?></a></div>
        <div id="middle_find"><?php include(RAIZ.'componentes/com_clientes/pacientes_find.php'); ?></div>
        <div id="middle_list"><?php include(RAIZ.'componentes/com_clientes/pacientes_list.php'); ?></div>
    </div>
    <div id="bottomcont"><?php include(RAIZ.'frames/_fra_bottom.php'); ?></div>
</div>
<?php include(RAIZ.'modulos/taskbar/_taskbar_facturas.php'); ?>
</body>
</html>