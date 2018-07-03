<?php include('../../init.php');
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$val=fnc_verifiparam('val', $_GET['val'], $_POST['val']);
$acc=fnc_verifiparam('acc', $_GET['acc'], $_POST['acc']);
$goTo=fnc_verifiparam('url', $_GET['url'], $_POST['url']);
$dat=$_POST;
$valFile=$dat['fileorig'];
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
//IF MOD FILES
if((isset($dat['form']))&&($dat['form']==md5('formFile'))){
	$LOGd.='<hr>form=formFile<br>';
	if(($_FILES['file']['name'])){
		$paramsF=array("ext"=>array('.pdf','.PDF','.zip','.rar','.doc','.docx', '.xls', '.xlsx'),"size"=>15728640,"pat"=>RAIZ0.'docs/',"pre"=>"file");
		$dFU=uploadfile($_FILES['file'], $paramsF);
		if($dFU['EST']==TRUE){
			$valFile=$dFU['FILE'];
			$dat['external']=0;
			$valFile=$dFU['FILE'];
		} $LOG.=$dFU['LOG'];
	}else{
		if($dat['link']){
			$valFile=$dat['link'];
			$dat['external']=1;
		}
	}
	if(!isset($dat['status'])) $dat['status']=1;
	switch($acc){
		case md5('UPDfile'):
			$qry=sprintf('UPDATE tbl_mod_attach SET att_title=%s, is_external=%s, att_status=%s, att_link=%s WHERE att_id=%s',
			SSQL($dat['title'],'text'),
			SSQL($dat['external'],'int'),
			SSQL($dat['status'],'int'),
			SSQL($valFile,'text'),
			SSQL($id,'int'));
			if(mysql_query($qry)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else $LOG.=$cfg['p']['upd-true'].mysql_error();
		break;
		case md5('INSfile'):
			$LOGd.='INSfile<br>';
			$qry=sprintf('INSERT INTO tbl_mod_attach (att_title, is_external, att_status, att_link) VALUES (%s,%s,%s,%s)',
			SSQL($dat['title'],'text'),
			SSQL($dat['external'],'int'),
			SSQL($dat['status'],'int'),
			SSQL($valFile,'text'));
			if(mysql_query($qry)){
				$vP=TRUE;
				$id=mysql_insert_id();
				$LOG.=$cfg['p']['ins-true'];
			}else $LOG.=$cfg['p']['upd-false'].mysql_error();
		break;
	}

	//FILE IN MULTIPLES ITEMS
	$qryDelMI=sprintf('DELETE FROM tbl_mod_attach_item WHERE att_id=%s', SSQL($id, "int"));
	mysql_query($qryDelMI)or($LOG.=mysql_error());
	if($_POST['valSelI']){
	foreach($_POST['valSelI'] as $valI){
		$qryinsMI=sprintf('INSERT INTO tbl_mod_attach_item (att_id,item_id) VALUES (%s,%s)',
			SSQL($id, "int"),
			SSQL($valI, "int"));
		mysql_query($qryinsMI)or($LOG.=mysql_error());
	}
	}
	//END FILE MULTIPLE ITEMS
	//FILE IN MULTIPLES CATS
	$qryDelMC=sprintf('DELETE FROM tbl_mod_attach_cat WHERE att_id=%s', SSQL($id, "int"));
	mysql_query($qryDelMC)or($LOG.=mysql_error());
	if($_POST['valSelC']){
	foreach($_POST['valSelC'] as $valC){
		$qryinsMC=sprintf('INSERT INTO tbl_mod_attach_cat (att_id,typID) VALUES (%s,%s)',
			SSQL($id, "int"),
			SSQL($valC, "int"));
		mysql_query($qryinsMC)or($LOG.=mysql_error());
	}
	}
	//END FILE MULTIPLE CATS
	//FILE IN MULTIPLE BRANDS
	$qryDelMB=sprintf('DELETE FROM tbl_mod_attach_brand WHERE att_id=%s', SSQL($id, "int"));
	mysql_query($qryDelMB)or($LOG.=mysql_error());
	if($_POST['valSelB']){
	foreach($_POST['valSelB'] as $valB){
		$qryinsMB=sprintf('INSERT INTO tbl_mod_attach_brand (att_id,b_id) VALUES (%s,%s)',
			SSQL($id, "int"),
			SSQL($valB, "int"));
		mysql_query($qryinsMB)or($LOG.=mysql_error());
	}
	}
}

switch($acc){
	case md5('DELfile'):
		$qry=sprintf('DELETE FROM tbl_mod_attach WHERE att_id=%s',
		SSQL($id,'int'));
		if(mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg['p']['del-true'];;
		}else $LOG.=$cfg['p']['del-true'].mysql_error();
	break;
	case md5('STfile'):
		$qry=sprintf('UPDATE tbl_mod_attach SET att_status=%s WHERE att_id=%s',
		SSQL($val,'int'),
		SSQL($id,'int'));
		if(mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$cfg['p']['est-true'];;
		}else $LOG.=$cfg['p']['est-true'].mysql_error();
	break;
	case md5('EXfile'):
		$qry=sprintf('UPDATE tbl_mod_attach SET is_external=%s WHERE att_id=%s',
		SSQL($val,'int'),
		SSQL($id,'int'));
		if(mysql_query($qry)){
			$vP=TRUE;
			$LOG.="<h4>External Status Update</h4>";
		}else $LOG.='<h4>Error while Update External Status</h4>'.mysql_error();
	break;
}
//END IF MOD INVENTARIO CATS
$goTo.='?id='.$id;
$LOG.=mysql_error();
//$LOG.=$LOGd;
if((!mysql_error())&&($vP==TRUE)){
	mysql_query("COMMIT;");
	$LOGt=$cfg['p']['m-ok'];
	$LOGc=$cfg['p']['c-ok'];
	$LOGi=$RAIZa.$cfg['p']['i-ok'];	
}else{
	mysql_query("ROLLBACK;");
	$LOGt=$cfg['p']['m-fail'];
	$LOGc=$cfg['p']['c-fail'];
	$LOGi=$RAIZa.$cfg['p']['i-fail']; 
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;
header(sprintf("Location: %s", $goTo));
?>