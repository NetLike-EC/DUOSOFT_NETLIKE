<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$url=vParam('url', $_GET['url'], $_POST['url']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$lang=vParam('lang', $_GET['lang'], $_POST['lang']);
$goTo=$url;
$vP=FALSE;
$vD=TRUE;
$det=$_POST;
//TRANSACTION
mysqli_query($conn,"SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysqli_query($conn,"BEGIN;"); //Inicia la transaccion
if(isset($det['form'])){
	if($det['form']==md5('formMod')){
		if((isset($acc))&&($acc==md5('UPDm'))){
			$dS=detRow('db_componentes','md5(mod_cod)',$ids);
			$id=$dS[mod_cod];
			$LOGd.='$id. '.$id.'<br>';
			$qry=sprintf('UPDATE db_componentes SET mod_ref=%s, mod_nom=%s, mod_des=%s, mod_icon=%s, mod_stat=%s WHERE md5(mod_cod)=%s LIMIT 1',
			SSQL($det['mod_ref'],'text'),
			SSQL($det['mod_nom'],'text'),
			SSQL($det['mod_des'],'text'),
			SSQL($det['mod_icon'],'text'),
			SSQL($det['mod_stat'],'int'),
			SSQL($ids,'text'));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['upd-true'];
				if($lang){
					$vL=setLangTxt('db_componentes',$lang,$id);
					$LOG.=$vL[log];
					if($vL[est])$vP=TRUE;
					else $vP=FALSE;
				}else $LOGd.='No language input<br>';
				
			}else $LOG.=$cfg[p]['upd-false'].mysqli_error($conn);
		}
		if((isset($acc))&&($acc==md5('INSm'))){
			$qry=sprintf('INSERT INTO db_componentes (mod_ref, mod_nom, mod_des, mod_icon, mod_stat) 
			VALUES (%s,%s,%s,%s,%s)',
			SSQL($det['mod_ref'],'text'),
			SSQL($det['mod_nom'],'text'),
			SSQL($det['mod_des'],'text'),
			SSQL($det['mod_icon'],'text'),
			SSQL($det['mod_stat'],'int'));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){ 
				$vP=TRUE;
				$id=mysqli_insert_id($conn);
				$ids=md5($id);
				$LOG.=$cfg[p]['ins-true'];
				
				if($lang){
					$vL=setLangTxt('db_componentes',$lang,$id);
					$LOGd.=$vL[log];
					if($vL[est]) $vP=TRUE;
					else $vP=FALSE;
				}else $LOGd.='No language input<br>';
				
			}else $LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
		}
	}
	$goTo.='?ids='.$ids;
}else{
	switch($acc){
		case md5('DELm'):
			$qry=sprintf('DELETE FROM db_componentes WHERE md5(mod_cod)=%s LIMIT 1',
			SSQL($ids,'text'));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
		break;
		case md5('STATm'):
			$qry=sprintf('UPDATE db_componentes SET mod_stat=%s WHERE md5(mod_cod)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['est-true'];
			}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
		break;
	}
}

$LOG.=mysqli_error($conn);
if($vD) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP==TRUE)){
	mysqli_query($conn,"COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysqli_query($conn,"ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysqli_query($conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
$goTo=urlr($goTo);
header(sprintf("Location: %s", $goTo));
?>