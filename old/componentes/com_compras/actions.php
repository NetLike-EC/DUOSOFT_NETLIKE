<?php include('../../init.php');
	$id = vParam('id',$_GET['id'],$_POST['id']);
	mysql_query("SET AUTOCOMMIT=0;");
	mysql_query("BEGIN;");

	//INS CABECERA FACTURA
		$aud=AUD('Ingreso de Compra');
		$qryInsCom=sprintf("INSERT INTO tbl_compra_cab (prov_id, aud_id, com_proc, com_imp, tip_pag, com_obs, com_stat) 
		VALUES (%s,%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($prov_id,'int'),
		GetSQLValueString($aud,'int'),
		GetSQLValueString($com_proc,'text'),
		GetSQLValueString($com_imp,'double'),
		GetSQLValueString($tip_pag,'int'),
		GetSQLValueString($com_obs,'text'),
		GetSQLValueString("1",'int'));
		mysql_query($qryInsCom)or($LOG.=mysql_error());
		$com_num=mysql_insert_id();//ID Compra Insertada
		$subtotal_com=0;
		foreach ($productos as $v){
				$ProdId=$v["id"];
				$ProdCan=$v["can"];
				$ProdPre=$v["pre"];
				$ProdPre = number_format($ProdPre,2,'.','');
				
				//INSERT INVENTARIO
				$qryInsInv=sprintf("INSERT INTO tbl_inventario (prod_id, inv_can, inv_val, inv_sal) 
				VALUES (%s,%s,%s,%s)",
				GetSQLValueString($ProdId,'int'),
				GetSQLValueString($ProdCan,'int'),
				GetSQLValueString($ProdPre,'text'),
				GetSQLValueString('0','int'));
				mysql_query($qryInsInv)or($LOG.=mysql_error());
				$inv_id=mysql_insert_id();
				
				//INSERT COMPRA DETALLE
				$qryInsComDet=sprintf("INSERT INTO tbl_compra_det (com_num, inv_id) 
				VALUES (%s,%s)",
				GetSQLValueString($com_num,'int'),
				GetSQLValueString($inv_id,'int'));
				mysql_query($qryInsComDet)or($LOG.=mysql_error());
				$comdetId=mysql_insert_id();
				
				$subtotal_com=$subtotal_com+($id_prod_can*$id_prod_pre);
				
			}
		$total_com=$subtotal_com+($subtotal_com*$_SESSION['conf']['taxes']['iva_si']);
		//INC CTA X PAGAR
		$qryInsCtaPag=sprintf("INSERT INTO tbl_cta_pag (com_num, aud_id, cta_plazo, cta_valor, cta_abono, cta_stat) 
		VALUES (%s,%s,%s,%s,%s,%s)",
		GetSQLValueString($com_num,'int'),
		GetSQLValueString($aud,'int'),
		GetSQLValueString('30','int'),
		GetSQLValueString($total_com,'int'),
		GetSQLValueString('0','int'),
		GetSQLValueString('1','int'));
		mysql_query($qryInsCtaPag)or($LOG.=mysql_error());
		//COMMIT OR ROLLBACK
		if(!(mysql_error())){
			mysql_query("COMMIT;")or(mysql_error());
			$LOG.="<h4>Compra Grabada Correctamente</h4>";
			$_SESSION['stat_proc']='SAVED'; // Para Evitar Duplicar Registros
			$GoTo=$RAIZc."com_compras/compra_detail.php?com_num=".$com_num;
		}else{
			mysql_query("ROLLBACK;")or(mysql_error());
			$LOG.="<h4>No se ha podido grabar la compra, <strong>intente nuevamente</strong></h4>";
			$GoTo=$RAIZc.'com_compras/compra_form.php';
		}

$LOG.=mysql_error();
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $GoTo));
?>