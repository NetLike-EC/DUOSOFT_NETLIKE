<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=vParam('id', $_GET['id'], $_POST['id']);
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$dat= $_REQUEST;

mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");

if((isset($dat['form']))&&($dat['form']==md5('form_video'))){
	if(!$dat['iSTAT']) $dat['iSTAT']=1;
	if((isset($acc))&&($acc==md5('UPDv'))){
		$qry=sprintf('UPDATE tbl_mod_videos SET itemview=%s, vid_title=%s, vid_code=%s, vid_status=%s WHERE MD5(vid_id)=%s LIMIT 1',
			SSQL($dat['iIV'],'int'),
			SSQL($dat['iTIT'],'text'),
			SSQL($dat['iCOD'],'text'),
			SSQL($dat['iSTAT'],'int'),
			SSQL($ids,'text'));
		if(mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['upd-true'];//"<h4>Actualizado Correctamente.</h4>";
		}else $LOG.=$cfg[p]['upd-false'];//'<h4>Error</h4>'.mysql_error();
	}
	if((isset($acc))&&($acc==md5('INSv'))){
		$qry=sprintf('INSERT INTO tbl_mod_videos (itemview, vid_title, vid_code, vid_status) VALUES (%s,%s,%s,%s)',
			SSQL($dat['iIV'],'int'),
			SSQL($dat['iTIT'],'text'),
			SSQL($dat['iCOD'],'text'),
			SSQL($dat['iSTAT'],'int'));
		if(mysql_query($qry)){
			$vP=TRUE;
			$ids=md5(mysql_insert_id());
			$LOG.=$cfg[p]['ins-true'];//"<h4>Creado Correctamente.</h4>";
		}else $LOG.=$cfg[p]['ins-false'].mysql_error();//'<h4>Error</h4>'.mysql_error();
	}
	$goTo.='?ids='.$ids;
}
if((isset($acc))&&($acc==md5('DELv'))){
	$qry=sprintf('DELETE FROM tbl_mod_videos WHERE md5(vid_id)=%s LIMIT 1',
				SSQL($ids,'text'));
	if(mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];//'<h4>Eliminado Correctamente</h4>';
	}else $LOG.=$cfg[p]['del-false'].mysql_error();//'<h4>Error</h4>'.mysql_query();
}
if((isset($acc))&&($acc==md5('STv'))){
	$qry=sprintf('UPDATE tbl_mod_videos SET vid_status=%s WHERE md5(vid_id)=%s LIMIT 1',
				SSQL($dat['val'],'int'),
				SSQL($ids,'text'));
	if(mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['est-true'];//"<h4>Status Actualizado</h4>";
	}else $LOG.=$cfg[p]['est-false'].mysql_error();//'<h4>Error</h4>'.mysql_query();
}

$LOG.=mysql_error();
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt='Operación Exitosa';
	$LOGc='alert-success';
	$LOGi='48/success.png';
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Solicitud no Procesada';
	$LOGc='alert-danger';
	$LOGi='48/cancel.png';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>