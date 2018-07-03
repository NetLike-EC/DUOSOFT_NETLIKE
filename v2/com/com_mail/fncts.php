<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$stat=vParam('stat', $_GET['stat'], $_POST['stat']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$det=$_POST;
$vD=FALSE;
$debug.=$urlc.'<br>';
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
if((isset($det['form']))&&($det['form']==md5(formME))){
	switch($acc){
		case md5(UPDcm):
			$qry=sprintf('UPDATE tbl_contact_mail_exception SET mail=%s, WHERE idMail=%s',
					 SSQL($det['mail'],'text'),
					 SSQL($id,'int'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['upd-true'];
			}else $LOG.=$cfg[p]['upd-false'].mysql_error();
		break;
		case md5(INScm):
			$qry=sprintf('INSERT INTO tbl_contact_mail_exception (mail) VALUES (%s)', 
					 SSQL($det['mail'],'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$id=@mysql_insert_id(); 
				$LOG.=$cfg[p]['ins-true'];
			}else $LOG.=$cfg[p]['ins-false'].mysql_error();
		break;
	}
	$goTo.='?id='.$id;
}
if((isset($det['form']))&&($det['form']==md5(formMC))){
	$debug.='formMC<br>';
	switch($acc){
		case md5(UPDmc):
			$qry=sprintf('UPDATE db_mail_campaign SET date=%s, nom=%s, subject=%s, reply=%s, content=%s WHERE MD5(id)=%s',
						 SSQL($sdatet,'text'),
						 SSQL($det['iNom'],'text'),
						 SSQL($det['iSub'],'text'),
						 SSQL($det['iRep'],'text'),
						 SSQL($det['iCon'],'text'),
						 SSQL($id,'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['upd-true'];
			}else $LOG.=$cfg[p]['upd-false'].mysql_error();
		break;
		case md5(INScm):
			$qry=sprintf('INSERT INTO db_mail_campaign (date, nom, subject, reply, content) VALUES (%s,%s,%s,%s,%s)',
						 SSQL($sdatet,'text'),
						 SSQL($det['iNom'],'text'),
						 SSQL($det['iSub'],'text'),
						 SSQL($det['iRep'],'text'),
						 SSQL($det['iCon'],'text'));
			if(@mysql_query($qry)){
				$vP=TRUE;
				$id=md5(@mysql_insert_id());
				$LOG.=$cfg[p]['ins-true'];
			}else $LOG.=$cfg[p]['ins-false'].mysql_error();
		break;
	}
	/***************************** PICS GALLS REVIEW *****************************/
	if($det['uploader_count']){		
	$dMC=detRow('db_mail_campaign','MD5(id)',$id);
	$idMC=$dMC['id'];	
	$contUpload=$det['uploader_count'];
	for($k=0;$k<$contUpload;$k++){
		$fileTemp='uploader_'.$k.'_tmpname';
		$fileStat='uploader_'.$k.'_status';
		$qryIM=sprintf('INSERT INTO db_media (file,nom,est) VALUES (%s,%s,%s)',
					   SSQL($det[$fileTemp], "text"),
					   SSQL('Mail Campaign', "text"),
					   SSQL('1',"int"));
		if(@mysql_query($qryIM)){
			$vP=TRUE;
			$idMI=mysql_insert_id();
			$qryIMMC=sprintf('INSERT INTO db_mail_campaign_media (id_med,id_mc) VALUES (%s,%s)',
							 SSQL($idMI, "int"),
							 SSQL($idMC, "int"));
			if(@mysql_query($qryIMMC)) $contIMGU++;
			else{
				$vP=FALSE;
				break;
				$LOG.='<p>Error to Create media campaign</p>'.mysql_error();
			}
		}else{
			$vP=FALSE;
			break;
			$LOG.='<p>Error to Create media</p>'.mysql_error();
		}
		fnc_genthumb(RAIZ0.'images/mail/', $det[$fileTemp], "t_", 220, 220);
	}
	if($vP==TRUE) $LOG.='<p>'.$contIMGU.' images upload</p>';
	}
	$goTo.='?id='.$id;
}
if((isset($acc))&&($acc==md5(DELme))){
	$qry=sprintf('DELETE FROM tbl_contact_mail_exception WHERE idMail=%s',
				 SSQL($id,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysql_error();
}
if((isset($acc))&&($acc==md5(CLONmc))){
	$dMC=detRow('db_mail_campaign','MD5(id)',$id);
	$dMC['nom'].='_2';
	$qry=sprintf('INSERT INTO db_mail_campaign (date, nom, subject, reply, content) 
		VALUES (%s,%s,%s,%s,%s)',
		SSQL($sdatet,'text'),
		SSQL($dMC['nom'],'text'),
		SSQL($dMC['subject'],'text'),
		SSQL($dMC['reply'],'text'),
		SSQL($dMC['content'],'text'));
		if(@mysql_query($qry)){
			$vP=TRUE;
			$id=md5(@mysql_insert_id());
			$LOG.=$cfg[p]['ins-true'];
	}else $LOG.=$cfg[p]['ins-false'].mysql_error();
	$goTo.='campaign.php';
}
if((isset($acc))&&($acc==md5(DELmc))){
	$qry=sprintf('DELETE FROM db_mail_campaign WHERE MD5(id)=%s',
		SSQL($id,'text'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysql_error();
	$goTo='campaign.php';
}
if((isset($acc))&&($acc==md5(DELmcP))){
	$dPic=detRow('db_mail_campaign_media','id',$det['idpic']);
	$qry=sprintf('DELETE FROM db_mail_campaign_media WHERE id=%s',
	SSQL($det['idpic'], 'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['del-true'];
	}else $LOG.=$cfg[p]['del-false'].mysql_error();
}
if((isset($acc))&&($acc==md5(mailCTest))){
	$qry=sprintf('UPDATE tbl_contact_mail SET test=%s WHERE idMail=%s',
		SSQL($stat,'int'),
		SSQL($id,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['upd-true'];
	}else $LOG.=$cfg[p]['upd-false'].mysql_error();
}
if((isset($acc))&&($acc==md5(mailCBann))){
	$qry=sprintf('UPDATE tbl_contact_mail SET banned=%s WHERE idMail=%s',
		SSQL($stat,'int'),
		SSQL($id,'int'));
	if(@mysql_query($qry)){
		$vP=TRUE;
		$LOG.=$cfg[p]['upd-true'];
	}else $LOG.=$cfg[p]['upd-false'].mysql_error();
}
////////////////////
$LOG.=mysql_error();
if($vD==TRUE) $LOG.=$debug;
$ret['m']=$LOG;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$ret['t']=$cfg[p]['m-ok'];
	$ret['c']=$cfg[p]['c-ok'];
	$ret['i']=$RAIZa.$cfg[p]['i-ok'];
}else{
	mysql_query("ROLLBACK;");
	$ret['t']=$cfg[p]['m-fail'];
	$ret['c']=$cfg[p]['c-fail'];
	$ret['i']=$RAIZa.$cfg[p]['i-fail'];
}
$_SESSION['LOG']=$ret;
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
header(sprintf("Location: %s", $goTo))
?>