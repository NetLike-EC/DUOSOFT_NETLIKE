<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$ids=fnc_verifiparam('ids', $_GET['ids'], $_POST['ids']);
$val=fnc_verifiparam('val', $_GET['val'], $_POST['val']);
$idimg=fnc_verifiparam('idimg', $_GET['idimg'], $_POST['idimg']);
$acc=fnc_verifiparam('acc', $_GET['acc'], $_POST['acc']);
$goTo=fnc_verifiparam('url', $_GET['url'], $_POST['url']);
$dat=$_POST;
$vP=FALSE;
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
//MOD GALLERY
	if((isset($_POST['form']))&&($_POST['form']=='form_gall')){
		if((isset($acc))&&($acc=='UPD')){
			$qry=sprintf('UPDATE tbl_gallery SET itemview=%s, gall_tit=%s, gall_stat=%s WHERE gall_id=%s',
			SSQL($dat['itemview'],'int'),
			SSQL($dat['title'],'text'),
			SSQL($dat['status'],'int'),
			SSQL($id,'int'));
			if(@mysql_query($qry)){
				$LOG.=$cfg['p']['upd-true'];
				$vP=TRUE;
				//BEG UPLOAD IMAGE
				if(($_FILES['userfile']['name'])){
					$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG'),"size"=>2097152,"pat"=>RAIZ0.'images/data/',"pre"=>"gall");
					$dFU=uploadfile($_FILES['userfile'], $paramsF);
					if($dFU['EST']==TRUE){
						$qINSGI = sprintf("INSERT INTO `tbl_gallery_items` (`gall_id`,`img_tit`,`img_path`,`img_status`) 
						VALUES (%s,%s,%s,%s)",
						SSQL($id, "int"),
						SSQL($dat['titimg'], "text"),
						SSQL($valImg, "text"),
						SSQL("1", "text"));
						if(mysql_query($qINSGI)){
							$insID=mysql_insert_id();
							$LOG.=$cfg['p']['ins-true'];
							$vP=TRUE;
						}else{
							$LOG.=$cfg['p']['ins-false'].$qINSGI.'<hr>'.mysql_error();
							$vP=FALSE;
						}
						$valImg=$dFU['FILE'];
						fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 220, 220);
					}
					$LOG.=$dFU['LOG'];
				}
				//END UPLOAD IMAGE
			}else{
				$LOG.=$cfg['p']['upd-false'].mysql_error();
			}
			$goTo.='?id='.$id;
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO tbl_gallery (itemview, gall_tit, gall_stat) VALUES (%s,%s,%s)',
			SSQL($dat['itemview'],'int'),
			SSQL($dat['title'],'text'),
			SSQL($dat['status'],'int'));
			if(@mysql_query($qry)){
				$id=@mysql_insert_id();
				$LOG.=$cfg['p']['ins-true'];
			}else $LOG.=$cfg['p']['ins-false'].mysql_error();
			$goTo.='?id='.$id;
		}
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////
		/*GALLERY REFERENCES*/
		$qryDelref=sprintf('DELETE FROM tbl_gallery_ref WHERE idg=%s', 
			SSQL($id, "int"));
		mysql_query($qryDelref)or($LOG.=mysql_error());
		
		//GALLERY IN MULTIPLES ITEMS
		if($_POST['valSelI']){
			foreach($_POST['valSelI'] as $valI){
				$qryinsMI=sprintf('INSERT INTO tbl_gallery_ref (idg,idr,ref) VALUES (%s,%s,%s)',
					SSQL($id, "int"),
					SSQL($valI, "int"),
					SSQL('ITEM', "text"));
				mysql_query($qryinsMI)or($LOG.=mysql_error());
			}
		}
		//END
		//GALLERY IN MULTIPLES ARTICLES
		if($_POST['valSelA']){
			foreach($_POST['valSelA'] as $valI){
				$qryinsMI=sprintf('INSERT INTO tbl_gallery_ref (idg,idr,ref) VALUES (%s,%s,%s)',
					SSQL($id, "int"),
					SSQL($valI, "int"),
					SSQL('ART', "text"));
				mysql_query($qryinsMI)or($LOG.=mysql_error());
			}
		}
		//END
		//////////////////////////////////////////////////
		//////////////////////////////////////////////////
		
	}
	if((isset($acc))&&($acc==md5('DELGALL'))){
		$qryA=sprintf('DELETE FROM tbl_gallery WHERE md5(gall_id)=%s LIMIT 1',
		SSQL($ids,'text'));
		if(mysql_query($qryA)){
			$LOG.="<h4>Gallery Deleted Successfully</h4>ID. ".$ids;
			$qryB=sprintf('DELETE FROM tbl_gallery_ref WHERE md5(idg)=%s',
			SSQL($ids,'text'));
			if(mysql_query($qryB)){
				$LOG.="<h4>References Deleted Successfully</h4>ID. ".$ids;
			}else $LOG.='<h4>Error while deleting Gallery</h4>';
		}else $LOG.='<h4>Error while deleting References</h4>';
		$goTo='index.php';
	}
	if((isset($acc))&&($acc=='DELIMG')){
		$qry=sprintf('DELETE FROM tbl_gallery_items WHERE gall_id=%s AND img_id=%s',
		SSQL($id,'int'),
		SSQL($idimg,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Imagen Deleted Successfully</h4>id. ".$id;
		else $LOG.='<h4>Error while deleting image</h4>';
		$goTo.='?id='.$id;
	}
	if((isset($acc))&&($acc=='ST')){
		$qry=sprintf('UPDATE tbl_gallery SET gall_stat=%s WHERE gall_id=%s',
		SSQL($val,'int'),
		SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Updated</h4> ID. ".$id;
		else $LOG.='<h4>Error while Update Status</h4>';
		$goTo='index.php';
	}
//END MOD GALL
$LOG.=mysql_error();
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