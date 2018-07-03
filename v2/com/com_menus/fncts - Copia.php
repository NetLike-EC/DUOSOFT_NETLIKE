<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$det=$_POST;
$vP=FALSE;
$accjs=FALSE;

mysqli_query($conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn,"BEGIN;"); //Inicia la transaccion

	//ACCIONES form_men (MENUS CONTENEDORES)
	if((isset($det['form']))&&($det['form']==md5('form_men'))){
		if((isset($acc))&&($acc=='UPD')){
			$qry=sprintf('UPDATE tbl_menus SET nom=%s, ref=%s WHERE id=%s',			
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL($id,'int'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.="<h4>Actualizado Correctamente.</h4>";
			}else $LOG.='<h4>Error al Actualizar</h4>'.mysqli_error($conn);
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO tbl_menus (nom, ref, stat) 
			VALUES (%s,%s,%s)',
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL('1','int'));
			if(mysqli_query($qry)){ 
				$vP=TRUE;
				$id=mysqli_insert_id($conn); $LOG.="<h4>Creado Correctamente.</h4>";
			}else $LOG.='<h4>Error al Grabar</h4>'.mysqli_error($conn);
		}
	}
	if((isset($det['form']))&&($det['form']==md5('form_meni'))){
		//echo 'form_meni.<br>';
		if((isset($acc))&&($acc==md5('UPDmi'))){
			//echo 'UPDmi.<br>';
			$qry=sprintf('UPDATE tbl_menus_items SET 
			men_idc=%s, men_padre=%s, men_nombre=%s, men_tit=%s, men_link=%s, men_icon=%s, men_orden=%s, men_stat=%s, men_css=%s, men_precode=%s, men_postcode=%s, mod_cod=%s  
			WHERE men_id=%s',			
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL($det['dStat'],'int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'int'),
			SSQL($id,'int'));
			if(mysqli_query($conn,$qry)){
				$LOG.="<h4>Actualizado Correctamente.</h4>";
				$qry=sprintf('UPDATE tbl_menus_items SET men_idc=%s WHERE men_padre=%s',			
				SSQL($det['dIDC'],'int'),
				SSQL($id,'int'));
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$LOG.="<h4>Sub-items Actualizados Correctamente.</h4>";
				}else $LOG.='<h4>Error al Actualizar Hijos</h4>'.mysqli_error($conn);
			}else $LOG.='<h4>Error al Actualizar</h4>'.mysqli_error($conn);
		}
		if((isset($acc))&&($acc==md5('INSmi'))){
			//echo 'INSmi.<br>';
			if(!$det['dIDP']) $det['dIDP']=0;
			$qry=sprintf('INSERT INTO tbl_menus_items (men_idc, men_padre, men_nombre, men_tit, men_link, men_icon, men_orden, men_stat, men_css, men_precode, men_postcode, mod_cod) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL('1','int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'text'));
			$LOG.=$qry;
			if(mysqli_query($conn,$qry)){
				//echo 'TRUE INSmi.<br>';
				$vP=TRUE;
				$id=mysqli_insert_id($conn); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else{
				$LOG.='<h4>Error al Grabar</h4>'.mysqli_error($conn);
				//echo 'FALSE INSmi.<br>'.mysqli_error($conn);
			}
		}
		
	}
	$goTo.='?id='.$id;
	//ACCIONES GET
	if((isset($acc))&&($acc==md5('DELm'))){
		$qry=sprintf('DELETE FROM tbl_menus WHERE menu_id=%s',
			SSQL($id,'int'));
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.="<h4>Eliminado Correctamente</h4>";
		}else $LOG.='<h4>No se pudo Eliminar</h4>'.mysqli_error($conn);
	}
	if((isset($acc))&&($acc==md5('STmc'))){
		$qry=sprintf('UPDATE tbl_menus SET stat=%s WHERE id=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($id,'int'));
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.="<h4>Status Actualizado</h4>";
		}else $LOG.='<h4>Error al Actualizar Status</h4>'.mysqli_error($conn);
	}
	if((isset($acc))&&($acc==md5('STmi'))){
		$qry=sprintf('UPDATE tbl_menus_items SET men_stat=%s WHERE men_id=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($id,'int'));
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.="<h4>Status Actualizado</h4>";
		}else $LOG.='<h4>Error al Actualizar Status</h4>'.mysqli_error($conn);
	}
	if((isset($acc))&&($acc==md5('DELmi'))){
		//echo '$acc DELmi';
		$qry=sprintf('DELETE FROM tbl_menu_usuario WHERE men_id=%s',
			SSQL($id,'int'));
		if(mysqli_query($conn,$qry)){
			$qry=sprintf('DELETE FROM tbl_menus_items WHERE men_id=%s',
			SSQL($id,'int'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.="<h4>Eliminado Correctamente</h4>";
			}else $LOG.='<h4>No se pudo Eliminar</h4>'.mysqli_error($conn);
		
		}	
		$accjs=TRUE;
	}
/******************************/

$LOG.=mysqli_error($conn);
if($vD==TRUE) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP==TRUE)){
	$_SESSION['sBr']=$data['cli_nom'].' '.$data['cli_ape'];
	mysqli_query($conn,"COMMIT;");
	$LOGt.='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZii.'Ok-48.png';
}else{
	mysqli_query($conn,"ROLLBACK;");
	$LOGt.='Solicitud no Procesada'.mysqli_error($conn);
	$LOGc='alert-danger';
	$LOGi=$RAIZii.'Cancel-48.png';
}
mysqli_query($conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;

/******************************/

if($accjs==TRUE){ //echo 'entra a JS';
	include(RAIZf.'_head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    </body>
<?php }else{ //echo 'NO entra a JS';
	header(sprintf("Location: %s", $goTo));
}
//if(!$acc){ echo 'parent.location.reload();';}
?>