<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$det=$_POST;
$vD=FALSE;
$vP=FALSE;
$vJ=FALSE;

mysqli_query($conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn,"BEGIN;"); //Inicia la transaccion

if($det['form']){
	if((isset($det['form']))&&($det['form']==md5(formMC))){
		if((isset($acc))&&($acc==md5(UPDmc))){
			$qry=sprintf('UPDATE tbl_menus SET nom=%s, ref=%s WHERE md5(id)=%s LIMIT 1',
						 SSQL($det['iNom'],'text'),
						 SSQL($det['iRef'],'text'),
						 SSQL($det['iSec'],'text'),
						 SSQL($ids,'text'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.="<h4>Actualizado Correctamente.</h4>";
			}else $LOG.='<h4>Error al Actualizar</h4>'.mysqli_error($conn);
		}
		if((isset($acc))&&($acc==md5(INSmc))){
			$qry=sprintf('INSERT INTO tbl_menus (nom, ref, sec, stat) VALUES (%s,%s,%s,%s)',
						 SSQL($det['iNom'],'text'),
						 SSQL($det['iRef'],'text'),
						 SSQL($det['iSec'],'text'),
						 SSQL('1','int'));
			if(mysqli_query($conn,$qry)){ 
				$vP=TRUE;
				$id=mysqli_insert_id($conn);
				$ids=md5($id);
				$LOG.=$cfg[p]['ins-true'];
			}else $LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
		}
	}
	if((isset($det['form']))&&($det['form']==md5(formMI))){
		if((isset($acc))&&($acc==md5(UPDmi))){
		$LOGd.='UPDmi.<br>';
		$dS=detRow('tbl_menus_items','md5(men_id)',$ids);
		$id=$dS[men_id];
		$qry=sprintf('UPDATE tbl_menus_items SET men_idc=%s, men_padre=%s, men_nombre=%s, men_link=%s, men_icon=%s, men_orden=%s, men_stat=%s, men_css=%s, men_precode=%s, men_postcode=%s, mod_cod=%s WHERE md5(men_id)=%s LIMIT 1',			
		SSQL($det['dIDC'],'int'),
		SSQL($det['dIDP'],'int'),
		SSQL($det['dNom'],'text'),
		SSQL($det['dLnk'],'text'),
		SSQL($det['dIco'],'text'),
		SSQL($det['dOrd'],'int'),
		SSQL($det['dStat'],'int'),
		SSQL($det['dCss'],'text'),
		SSQL($det['dPreCode'],'text'),
		SSQL($det['dPostCode'],'text'),
		SSQL($det['dMod'],'int'),
		SSQL($ids,'text'));
		if(mysqli_query($conn,$qry)){
			$LOG.=$cfg[p]['upd-true'];
			$qry=sprintf('UPDATE tbl_menus_items SET men_idc=%s WHERE men_padre=%s',			
			SSQL($det['dIDC'],'int'),
			SSQL($id,'int'));
			if(mysqli_query($conn,$qry)){
				$LOG.="<h4>Sub-items Actualizados Correctamente.</h4>";
				if($det['lang']){
					$vL=setLangTxt('tbl_menus_items',$det['lang'],$id);
					$LOG.=$vL[log];
					if($vL[est])$vP=TRUE;
					else $vP=FALSE;
				}

			}else $LOG.='<h4>Error al Actualizar Hijos</h4>'.mysqli_error($conn);
		}else $LOG.='<h4>Error al Actualizar</h4>'.mysqli_error($conn);
	}
		if((isset($acc))&&($acc==md5(INSmi))){
		$logD.='INSmi.<br>';
		if(!$det['dIDP']) $det['dIDP']=0;
		$qry=sprintf('INSERT INTO tbl_menus_items (men_idc, men_padre, men_nombre, men_link, men_icon, men_orden, men_stat, men_css, men_precode, men_postcode, mod_cod) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($det['dIDC'],'int'),
		SSQL($det['dIDP'],'int'),
		SSQL($det['dNom'],'text'),
		SSQL($det['dLnk'],'text'),
		SSQL($det['dIco'],'text'),
		SSQL($det['dOrd'],'int'),
		SSQL('1','int'),
		SSQL($det['dCss'],'text'),
		SSQL($det['dPreCode'],'text'),
		SSQL($det['dPostCode'],'text'),
		SSQL($det['dMod'],'text'));
		$LOGd.=$qry;
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$id=mysqli_insert_id($conn);
			$LOGd.='INS true<br>';
			$ids=md5($id);
			$LOG.=$cfg[p]['ins-true'];
			if($det['lang']){
				$vL=setLangTxt('tbl_menus_items',$det['lang'],$id);
				$LOGd.=$vL[log];
				if($vL[est]) $vP=TRUE;
				else $vP=FALSE;
			}
		}else{
			$LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
		}
	}
	}
	$goTo.='?ids='.$ids;
}else{//ELSE IF $det['form']
	//ACTIONS acc
	switch($acc){
		case md5('DELmc'):
			$qry=sprintf('DELETE FROM tbl_menus WHERE md5(id)=%s LIMIT 1',
						 SSQL($ids,'text'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
		break;
		case md5('STmc'):
			$qry=sprintf('UPDATE tbl_menus SET stat=%s WHERE md5(id)=%s LIMIT 1',
						 SSQL($val,'int'),
						 SSQL($ids,'text'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['est-true'];
			}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
		break;
		case md5('DELmi'):
			$qry=sprintf('DELETE FROM tbl_menu_usuario WHERE md5(men_id)=%s',
			SSQL($ids,'text'));
			if(mysqli_query($conn,$qry)){
				$qry=sprintf('DELETE FROM tbl_menus_items WHERE md5(men_id)=%s',
				SSQL($ids,'text'));
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$LOG.=$cfg[p]['del-true'];
				}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
			}
			$vJ=TRUE;
		break;
		case md5('STmi'):
			$qry=sprintf('UPDATE tbl_menus_items SET men_stat=%s WHERE men_id=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($id,'int'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['est-true'];
			}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
		break;
		default:
		break;	
	}
}//END IF $det['form']
/******************************/

if($vD) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP)){
	mysqli_query($conn,"COMMIT;");
	$LOGt=$cfg['p']['m-ok'];
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];	
}else{
	mysqli_query($conn,"ROLLBACK;");
	$LOGt=$cfg['p']['m-fail'];
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail']; 
}
mysqli_query($conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['i']=$LOGi;

/******************************/

if($vJ){ //echo 'entra a JS';
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