<?php include_once('../../init.php');
$IndiceSES = $_POST['IndiceSES'];
if($_SESSION['MODSEL']=="VEN"){
	$eliminar_prod = $_SESSION[$ses_id]['venta'];
	unset($eliminar_prod[$IndiceSES]);
	$_SESSION[$ses_id]['venta'] = $eliminar_prod;
	$GoTo=$RAIZc."com_facturacion/factura_form.php";
}
if($_SESSION['MODSEL']=="COM"){
	$eliminar_prod = $_SESSION[$ses_id]['compra'];
	unset($eliminar_prod[$IndiceSES]);
	$_SESSION[$ses_id]['compra'] = $eliminar_prod;
	$GoTo=$RAIZc."com_compras/compra_form.php";
}
header("Location:".$GoTo);
?>