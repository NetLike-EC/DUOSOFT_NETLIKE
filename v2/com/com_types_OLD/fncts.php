<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$ids=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$data=$_POST;

mysqli_query($conn,"SET AUTOCOMMIT=0;");
mysqli_query($conn,"BEGIN;");
if((isset($data['form']))&&($data['form']=='form_mod')){
	if((isset($acc))&&($acc=='UPD')){
		$qry=sprintf('UPDATE tbl_types SET typ_ref=%s, typ_nom=%s, typ_val=%s 
		WHERE md5(typ_cod)=%s LIMIT 1',			
		SSQL($data['form_ref'],'text'),
		SSQL($data['form_nom'],'text'),
		SSQL($data['form_val'],'text'),
		SSQL($ids,'text'));
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['upd-true'];
		}else $LOG.=$cfg[p]['upd-false'].mysqli_error($conn);
	}
	if((isset($acc))&&($acc=='INS')){
		$qry=sprintf('INSERT INTO tbl_types (typ_ref, typ_nom, typ_val, typ_stat) 
		VALUES (%s,%s,%s,%s)',
		SSQL($data['form_ref'],'text'),
		SSQL($data['form_nom'],'text'),
		SSQL($data['form_val'],'text'),
		SSQL('1','int'));
		if(mysqli_query($conn,$qry)){ 
			$vP=TRUE;
			$id=mysqli_insert_id($conn);
			$ids=md5($id);
			$LOG.=$LOG.=$cfg[p]['ins-true'];
		}else $LOG.=$cfg[p]['ins-true'].mysqli_error($conn);
	}
}
if((isset($acc))&&($acc=='DELt')){
	$qry=sprintf('DELETE FROM tbl_types 
	WHERE md5(typ_cod)=%s LIMIT 1',
		SSQL($ids,'text'));
	if(mysqli_query($conn,$qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
}
if((isset($acc))&&($acc=='STt')){
	$qry=sprintf('UPDATE tbl_types SET typ_stat=%s 
	WHERE md5(typ_cod)=%s LIMIT 1',
		SSQL($stat,'int'),
		SSQL($ids,'text'));
	if(mysqli_query($conn,$qry)){
		$vP=TRUE;
		$LOG.=$LOG.=$cfg[p]['est-true'];
	}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
}

$goTo.='?ids='.$ids.$GotoPar;
$LOG.=mysqli_error($conn);
if($vD) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP==TRUE)){
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
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>