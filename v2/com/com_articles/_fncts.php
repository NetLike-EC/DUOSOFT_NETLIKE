<?php include('../../init.php');
fnc_accessnorm();
$id=vParam('id',$_GET['id'],$_POST['id']);
$ids=vParam('ids',$_GET['ids'],$_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$form=vParam('form', $_GET['form'], $_POST['form']);
$url=vParam('url', $_GET['url'], $_POST['url']);
$stat=vParam('stat', $_GET['stat'], $_POST['stat']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$lang=vParam('lang', $_GET['lang'], $_POST['lang']);
$goTo=$url;
$data=$_POST;
$vP=FALSE;
$vD=TRUE;
mysqli_query($conn,"SET AUTOCOMMIT=0;");
mysqli_query($conn,"BEGIN;");

if(isset($data['form'])){
	//BEG MOD ARTICLES PAGES
	if((isset($data['form']))&&($data['form']==md5('formPage'))){
		$valueimage=$_POST['imagea'];
		if(($_FILES['userfile']['name'])){
			$LOG.=RAIZ0.'<br>';
			$LOG.=RAIZ0.'data/img/blog/';
			$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG'),"size"=>2097152,"pat"=>RAIZ0.'data/img/blog/',"pre"=>"art");
			$dFU=uploadfile($_FILES['userfile'], $paramsF);
			if($dFU['EST']==TRUE){
				//deleteFile($paramF['pat'],$valImg,TRUE,'t_');
				if($valueimage) $LOG.=deleteFile($paramsF['pat'],$valueimage,TRUE,'t_');
				$valueimage=$dFU['FILE'];
				//fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
				fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 350, 300);
			}
			$LOG.=$dFU['LOG'];
		}
		switch($acc){
			case md5('UPDp'):
				$dS=detRow('tbl_articles','md5(art_id)',$ids);
				$id=$dS[art_id];
				$LOGd.='$id. '.$id;
				$qry=sprintf('UPDATE tbl_articles SET cat_id=%s, art_url=%s, view_title=%s, view_image=%s, dupdate=%s, featured=%s, status=%s, seo_title=%s, seo_metades=%s, image=%s WHERE md5(art_id)=%s LIMIT 1',
				SSQL($_POST['cat_id'],'int'),
				SSQL($_POST['art_url'],'text'),
				SSQL($_POST['view_title'],'text'),
				SSQL($_POST['view_image'],'text'),
				SSQL(date('Y-m-d'),'date'),
				SSQL($_POST['featured'],'int'),
				SSQL($_POST['status'],'text'),
				SSQL($_POST['seo_title'],'text'),
				SSQL($_POST['seo_metades'],'text'),
				SSQL($valueimage,'text'),
				SSQL($ids,'text'));
				//$LOGd.=$qry.'<br>';
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$LOG.=$cfg['p']['upd-true'];
					
					if($lang){
						$vL=setLangTxt('tbl_articles',$lang,$id);
						$LOG.=$vL[log];
						if($vL[est])$vP=TRUE;
						else $vP=FALSE;
					}else $LOGd.='No multi-languages';
					
				}else $LOG.=$cfg['p']['upd-false'];
			break;
			case md5('INSp'):
				//$LOG.='<p>INS</a>';
				$qry=sprintf('INSERT INTO tbl_articles 
				(cat_id, art_url, view_title, view_image, dcreate, hits, 
				featured, status, seo_title, seo_metades, image) 
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
				SSQL($_POST['cat_id'],'int'),
				SSQL($_POST['art_url'],'text'),
				SSQL($_POST['view_title'],'text'),
				SSQL($_POST['view_image'],'text'),
				SSQL(date('Y-m-d'),'date'),
				SSQL('1','text'),
				SSQL($_POST['featured'],'int'),
				SSQL('1','text'),
				SSQL($_POST['seo_title'],'text'),
				SSQL($_POST['seo_metades'],'text'),
				SSQL($valueimage,'text'));
				$LOGd.=$qry.'<br>';
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$ids=md5(mysqli_insert_id($conn));
					$LOG.=$cfg['p']['ins-true'];
					if($lang){
						$vL=setLangTxt('tbl_articles',$lang,$id);
						$LOGd.=$vL[log];
						if($vL[est]) $vP=TRUE;
						else $vP=FALSE;
					}
				}else $LOG.=$cfg['p']['ins-false'].mysqli_error($conn);
			break;
		}
		//ENS INS
		///////////////////////////////////////////////////////////////////////////////
		/***************************** PICS GALLS REVIEW *****************************/
		if($data['uploader_count']){
			$LOGd.='PIC GALLERY proccess.<br>';
		$detGS=detRow('tbl_gallery','gall_id',$data['gallSel']);
		if(!$detGS){
			$qryIG=sprintf('INSERT INTO tbl_gallery (gall_stat) VALUES (%s)',
			SSQL(1,'int'));
			if(mysqli_query($conn,$qryIG)){
				$idgs=mysqli_insert_id($conn);
				$qryIGR=sprintf('INSERT INTO tbl_gallery_ref (idg,idr,ref) VALUES (%s,%s,%s)',
					SSQL($idgs,'int'),
					SSQL($id,'int'),
					SSQL('ART','text'));
				mysqli_query($conn,$qryIGR);
			}else "<h4>Error while creating Gallery</h4>";
		}else $idgs=$detGS['gall_id'];
		//END if(!$detGS){
		$contUpload=$data['uploader_count'];
		for($k=0;$k<$contUpload;$k++){
			$fileTemp='uploader_'.$k.'_tmpname';
			$fileStat='uploader_'.$k.'_status';
			//if($fileStat=='done'){
				$qryinsG=sprintf('INSERT INTO tbl_gallery_items (gall_id,img_path,img_status) VALUES (%s,%s,%s)',
					SSQL($idgs, "int"),
					SSQL($data[$fileTemp], "text"),
					SSQL('1','int'));
				//$LOG.=$qryinsG;
				if(mysqli_query($conn,$qryinsG)){
					$LOG.='<p>Image Upload Successfully</p>';
				}else{
					$LOG.=mysqli_error($conn);
				}
			fnc_genthumb(RAIZ0.'data/img/blog/', $data[$fileTemp], "t_", 220, 220);
		}//END for($k=0;$k<$contUpload;$k++){
		}//END if($data['uploader_count']){
		/***************************** END PICS GALLS REVIEW *****************************/
	}
	//END MOD ARTICLES PAGES
	//BEG MOD ARTICLES CATEGORIES
	if((isset($data['form']))&&($data['form']==md5('formPCat'))){
		$LOGd.='$form. formPCat<br>';
		$valueimage=$_POST['imagea'];
		if(($_FILES['userfile']['name'])){
			$LOGd.=RAIZ0.'<br>';
			$LOGd.=RAIZ0.'data/img/blogc/';
			$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG'),"size"=>2097152,"pat"=>RAIZ0.'data/img/blogc/',"pre"=>"blogc");
			$dFU=uploadfile($_FILES['userfile'], $paramsF);
			if($dFU['EST']==TRUE){
				//deleteFile($paramF['pat'],$valImg,TRUE,'t_');
				if($valueimage) $LOG.=deleteFile($paramsF['pat'],$valueimage,TRUE,'t_');
				$valueimage=$dFU['FILE'];
				//fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
				fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 350, 300);
			}
			$LOG.=$dFU['LOG'];
		}
		switch($acc){
			case md5('UPDac'):
				$dS=detRow('tbl_articles_cat','md5(cat_id)',$ids);
				$id=$dS[cat_id];
				$LOGd.='$id. '.$id;
				$qry=sprintf('UPDATE tbl_articles_cat SET cat_nom=%s, cat_idp=%s, cat_url=%s, cat_icon=%s, cat_img=%s WHERE md5(cat_id)=%s LIMIT 1',
				SSQL($data['cat_nom'],'text'),
				SSQL($data['idP'],'int'),
				SSQL($data['cat_url'],'text'),
				SSQL($data['cat_icon'],'text'),
				SSQL($valueimage,'text'),
				SSQL($ids,'text'));
				$LOGd.=$qry.'<br>';
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$LOG.=$cfg[p]['upd-true'];
					
					if($lang){
						$vL=setLangTxt('tbl_articles_cat',$lang,$id);
						$LOG.=$vL[log];
						if($vL[est])$vP=TRUE;
						else $vP=FALSE;
					}else $LOGd.='No multi-languages';
					
				}else $LOG.=$cfg[p]['upd-false'].mysqli_error($conn);
			break;
			case md5('INSac'):
				$qry=sprintf('INSERT INTO tbl_articles_cat (cat_nom, cat_idp, cat_url, cat_icon, cat_img, cat_lev, cat_order, cat_status) VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
				SSQL($data['cat_nom'],'text'),
				SSQL($data['idP'],'int'),
				SSQL($data['cat_url'],'text'),
				SSQL($data['cat_icon'],'text'),
				SSQL($valueimage,'text'),
				SSQL('1','int'),
				SSQL('1','int'),
				SSQL('1','int'));
				$LOGd.=$qry.'<br>';
				if(mysqli_query($conn,$qry)){ 
					$vP=TRUE;
					$id=mysqli_insert_id($conn);
					$ids=md5($id); 
					$LOG.=$cfg[p]['ins-true'];
					
					if($lang){
						$vL=setLangTxt('tbl_articles_cat',$lang,$id);
						$LOG.=$vL[log];
						if($vL[est])$vP=TRUE;
						else $vP=FALSE;
					}else $LOGd.='No multi-languages';
					
				}else $LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
			break;
		}
	}
	//END MOD ARTICLES PAGES
}else{
	switch($acc){
	case md5('BLOGP'):
	switch($data['accm']){
		case md5("delete"):
			$contRows=0;
			$lis=$data['lis'];
			if($lis){
				foreach($lis as $val){
					$contRows++;
					$qry=sprintf('DELETE FROM tbl_articles WHERE md5(art_id)=%s LIMIT 1',
					SSQL($val,'text'));
					if(mysqli_query($conn,$qry)){
						$vP=TRUE;
						if($contRows<=25) $LOG.=$val." Deleted, ";
					}else{
						$vP=FALSE;
						$LOG.='<h4>Error Detele Item '.$val.'</h4>'.mysqli_error($conn);
						break;
					}
				}
				$LOG.='<h4>Deleted. '.$contRows.' Rows</h4>';
			}else $LOG.='No selection';
		break;
		case md5("disable"):
			$contRows=0;
			$lis=$data['lis'];
			if($lis){
				foreach($lis as $val){
					$contRows++;
					$qry=sprintf('UPDATE tbl_articles SET status=0 WHERE md5(art_id)=%s LIMIT 1',
					SSQL($val,'text'));
					if(mysqli_query($conn,$qry)) $vP=TRUE;
					else{
						$vP=FALSE;
						$LOG.='<h4>Error Disable Item '.$val.'</h4>'.mysqli_error($conn);
						break;
					}
				}
				$LOG.='<h4>Disabled. '.$contRows.' Rows</h4>';
			}else $LOG.='No selection';
		break;
		case md5("enable"):
			$contRows=0;
			$lis=$data['lis'];
			if($lis){
				foreach($lis as $val){
					$contRows++;
					$qry=sprintf('UPDATE tbl_articles SET status=1 WHERE md5(art_id)=%s LIMIT 1',
					SSQL($val,'text'));
					if(mysqli_query($conn,$qry)) $vP=TRUE;
					else{
						$vP=FALSE;
						$LOG.='<h4>Error Enable Item '.$val.'</h4>'.mysqli_error($conn);
						break;
					}
				}
				$LOG.='<h4>Disabled. '.$contRows.' Rows</h4>';
			}else $LOG.='No selection';
		break;
	}
	$goTo.='page.php';
	//END MULTIPLE ACC
	break;
	//END FORM PAGE
	case md5('DELa'):
		$qry=sprintf('DELETE FROM tbl_articles WHERE md5(art_id)=%s LIMIT 1',
			SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['del-true'];
		}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
	break;
	
	case md5('STATa'):
		$qry=sprintf('UPDATE tbl_articles SET status=%s WHERE md5(art_id)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
	break;
	case md5('FEATa'):
		$qry=sprintf('UPDATE tbl_articles SET featured=%s WHERE md5(art_id)=%s LIMIT 1',
			SSQL($val,'int'),
			SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
	break;
	case md5('DELac'):
		$qry=sprintf('DELETE FROM tbl_articles_cat WHERE md5(cat_id)=%s',
			SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['del-true'];
		}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
	break;
	case md5('STATac'):
		$qry=sprintf('UPDATE tbl_articles_cat SET cat_status=%s WHERE md5(cat_id)=%s',
			SSQL($stat,'int'),
			SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
	break;
	}
}
//ARM LINK RETURN
$goTo.='?ids='.$ids.$GotoPar;
//END TRANSACTION
$LOG.=mysqli_error($conn);
if($vD==TRUE) $LOG.=$LOGd;
if((!mysqli_error($conn))&&($vP==TRUE)){
	mysqli_query($conn,"COMMIT;");
	$rLOG['t']=$cfg['p']['m-ok'];
	$rLOG['c']=$cfg['p']['c-ok'];
	$rLOG['i']=$RAIZa.$cfg['p']['i-ok'];
}else{
	mysqli_query($conn,"ROLLBACK;");
	$rLOG['t']=$cfg['p']['m-fail'];
	$rLOG['c']=$cfg['p']['c-fail'];
	$rLOG['i']=$RAIZa.$cfg['p']['i-fail'];
}
mysqli_query($conn,"SET AUTOCOMMIT=1;"); //Habilita el autocommit
$rLOG['m']=$LOG;
$_SESSION['LOG']=$rLOG;
header(sprintf("Location: %s", $goTo));
?>