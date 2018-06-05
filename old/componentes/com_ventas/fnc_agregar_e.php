<?php include('../../init.php');
if($_SESSION['stat_proc']=='PROCESS'){
	$productos = $_SESSION[$ses_id]['venta'];//Lista de Productos a Comprar
	$totProd=count($productos);	
	if($totProd>0){
		$cli_cod=vParam('cli_cod',$_GET['cli_cod'],$_POST['cli_cod'],FALSE);
		mysql_query("SET AUTOCOMMIT=0;");
		mysql_query("BEGIN;");
		//echo '<h4>BEGIN</h4>';
		//INS VENTA CABECERA-> tbl_venta_cab
		$aud=AUD('Ingreso de Venta Cabecera');
		$qryInsVenCab=sprintf("INSERT INTO tbl_venta_cab (cli_cod, aud_id, ven_obs, tip_pag, ven_stat) VALUES (%s,%s,%s,%s,%s)",
		GetSQLValueString($cli_cod,'int'),
		GetSQLValueString($aud,'int'),
		GetSQLValueString($ven_obs,'text'),
		GetSQLValueString($tip_pag,'text'),
		GetSQLValueString('1','int'));
		//echo $qryInsVenCab;
		mysql_query($qryInsVenCab)or($LOG.=mysql_error());
		$ven_num=mysql_insert_id();
		
		//echo '<h4>'.$ven_num.'</h4>';
		$subtotal_ven=0;
		//echo '<h4>VENTA CAB INSERTED</h4>';
		//Recorrido ARRAY Venta
		//echo '<h4>BEGIN FOREACH</h4>';
		foreach ($productos as $v){
			$ProdId=$v["id"];
			$ProdCan=$v["can"];
			$ProdPre=$v["pre"];
			$ProdPre = number_format($ProdPre,2,'.','');
			$subtotal_ven+=($ProdCan*$ProdPre);
			//Detalle de Los Inventarios Actualizados
			//echo '<h4>Func actualizacion_inventario_venta</h4>';
			$inv=actualizacion_inventario_venta($ProdId, $ProdCan);
			//Recorrido ARRAY Inventarios
			foreach ($inv as $v){
				//echo '<p>EACH PRODUCT</p>';
				$invId=$v["inv_id"];//Registro de Inventario del cual se va a descargar el producto
				$invCan=$v["det_cant"]; //Cantidad que se va a descargar del Inventario seleccionado anteriormente
				$qryInsD=sprintf("INSERT INTO tbl_venta_det (ven_num, inv_id, ven_can, ven_pre) VALUES (%s,%s,%s,%s)",
				GetSQLValueString($ven_num,'int'),
				GetSQLValueString($invId,'int'),
				GetSQLValueString($invCan,'int'),
				GetSQLValueString($ProdPre,'text'));
				mysql_query($qryInsD)or($LOG.=mysql_error());
				//echo '<p>'.$qryInsD.'</p>';
					
			}
		}
		//echo '<h4>END FOREACH</h4>';
		$total_ven=$subtotal_ven+($subtotal_ven*$_SESSION['conf']['taxes']['iva_si']);

		//INC CTA X COBRAR
		$aud=AUD('Generacion Cta x Cobrar');
		$qryInsCtaPag=sprintf("INSERT INTO tbl_cta_cob (ven_num, aud_id, cta_plazo, cta_valor, cta_abono, cta_stat) 
		VALUES (%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($ven_num,'int'),
		GetSQLValueString($aud,'int'),
		GetSQLValueString('30','int'),
		GetSQLValueString($total_ven,'int'),
		GetSQLValueString('0','int'),
		GetSQLValueString('1','int'));
		mysql_query($qryInsCtaPag)or($LOG.=mysql_error());
		
		//COMMIT OR ROLLBACK
		if(!(mysql_error())){
			mysql_query("COMMIT;")or(mysql_error());
			$LOG.="<h4>Compra Grabada Correctamente</h4>";
			$_SESSION['stat_proc']='SAVED'; // Para Evitar Duplicar Registros
			$GoTo=$RAIZc."com_ventas/venta_detail.php?id=".$ven_num;
			unset($_SESSION[$ses_id]['venta']);
		}else{
			mysql_query("ROLLBACK;")or(mysql_error());
			$LOG.="<h4>No se ha podido grabar la compra, <strong>intente nuevamente</strong></h4>";
			$GoTo=$RAIZc.'com_ventas/egreso.php';
		}
	}else{
		$LOG.="<h4>No hay Productos</h4>Debe ingresar al menos un producto para guardar la Factura";
		$GoTo=$RAIZc.'com_ventas/egreso.php';
		$_SESSION['LOGr']="e";
	}
}else{
	$LOG.="<h4>Acceso no permitido a las funciones</h4>";
	$GoTo=$RAIZc.'com_ventas/';
}
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $GoTo));
?>