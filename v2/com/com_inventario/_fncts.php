<?php include('../../init.php');
$_SESSION['LOG']=NULL;
$ids=vParam('ids', $_GET['ids'], $_POST['ids']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$val=vParam('val', $_GET['val'], $_POST['val']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$data=$_POST;
$vP=FALSE;
$vD=FALSE;
//TRANSACTION
mysqli_query($conn,"SET AUTOCOMMIT=0;");
mysqli_query($conn,"BEGIN;");
$valImg=$_POST['imagea'];

if(isset($_POST['form'])){
	//MOD INVENTARIO PRODUCTS
	if($_POST['form']==md5('formProd')){
	if(($_FILES['userfile']['name'])){
		$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg'),"size"=>2097152,"pat"=>RAIZ0.'data/img/item/',"pre"=>"prod");
		$dFU=uploadfile($_FILES['userfile'], $paramsF);
		if($dFU['EST']==TRUE){
			if($_POST['imagea']) $LOG.=deleteFile($paramF['pat'],$valImg,TRUE,'t_');
			$valImg=$dFU['FILE'];
			fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 250, 250);
		} $LOG.=$dFU['LOG'];
	}
	$itemStat=$_POST['item_status'];
	if (($itemStat=='Enable')||($itemStat=='1')) $itemStat='1';
	else if (($itemStat=='Disable')||($itemStat=='0')) $itemStat='0';
	else $itemStat=1;
	//BEG GENERATE URL FRIENDLY
	if(!$data['txt_alias']) $data['txt_alias']=genUrlFriendly($data['txt_nom']);
	//BUSCO SI EXISTE UNA URL AMIGABLE SIMILAR
	$paramsN[]=array(
		array("cond"=>"AND","field"=>"item_aliasurl","comp"=>"=","val"=>$data['txt_alias']),
		array("cond"=>"AND","field"=>"md5(item_id)","comp"=>'<>',"val"=>$ids)
	);//CONDICIONES CAMPO URL e ID tabla
	$dFindUrlF=detRowNP('tbl_items',$paramsN);
	if($dFindUrlF) $data['txt_alias'].=$sdate;//Si encontro un parecido agrego un distintivo al final
	//END GENERATE URL FRIENDLY
	/*******************************/
	switch($acc){
		case md5('UPDi'):
			$det=detRow('tbl_items','md5(item_id)',$ids);
			$id=$det['item_id'];
			if(!$data['txt_alias']) $data['txt_alias']=generate_aliasurl($data['txt_cod']);//Generate ALIAS URL
			$qry=sprintf('UPDATE tbl_items SET item_cod=%s, item_nom=%s, item_ref=%s, item_des=%s, item_spec=%s, brand_id=%s, item_aliasurl=%s, item_img=%s, item_lastupdate=%s, item_status=%s, item_statusMU=%s, item_price=%s, item_can=%s  
			WHERE md5(item_id)=%s LIMIT 1',
			SSQL($data['txt_cod'], "text"),
			SSQL($data['txt_nom'], "text"),
			SSQL($data['txt_ref'], "text"),
			SSQL($data['txt_des'], "text"),
			SSQL($data['txt_spec'], "text"),
			SSQL($data['txt_brand'], "int"),
			SSQL($data['txt_alias'], "text"),
			SSQL($valImg, "text"),
			SSQL($sdate, "date"),
			SSQL($itemStat, "int"),
			SSQL($data['item_statusMU'], "int"),
			SSQL($data['item_price'], "text"),
			SSQL($data['item_can'], "text"),
			SSQL($ids, "text"));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else $cfg['p']['upd-false'].mysqli_error($conn);
		break;
		case md5('INSi'):
			if(!$data['txt_alias']) $data['txt_alias']=generate_aliasurl($data['txt_cod']);//Generate ALIAS URL
			$qry=sprintf('INSERT INTO tbl_items
			(item_cod,item_nom,item_ref,item_des,item_spec,item_aliasurl,item_date,brand_id,item_status,item_statusMU,item_price,item_can,item_img)
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($data['txt_cod'], "text"),
			SSQL($data['txt_nom'], "text"),
			SSQL($data['txt_ref'], "text"),
			SSQL($data['txt_des'], "text"),
			SSQL($data['txt_spec'], "text"),
			SSQL($data['txt_alias'], "text"),
			SSQL($sdate, "date"),
			SSQL($data['txt_brand'], "int"),
			SSQL($itemStat, "int"),
			SSQL(1, "int"),
			SSQL($data['item_price'], "text"),
			SSQL($data['item_can'], "text"),
			SSQL($valImg, "text"));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$id=mysqli_insert_id($conn);
				$ids=md5($id);
				$LOG.=$cfg['p']['ins-true'];
			}else $cfg['p']['ins-false'].mysqli_error($conn);
		break;
	}
	
	//Multiple Cats Review
	$valSel=$_POST['valSel'];
	$contMultVals=count($valSel);
	if($contMultVals>0){
		//Eliminar MultiCats anteriores
		$qryDelMC=sprintf('DELETE FROM tbl_items_type_vs WHERE item_id=%s',
			SSQL($id, "int"));
		$LOGd.=$qryDelMC.'<br>';
		if(mysqli_query($conn,$qryDelMC)){
			$contCMI=0;
			for($i=0;$i<$contMultVals;$i++){
				$qryinsMC=sprintf('INSERT INTO tbl_items_type_vs (item_id,typID) VALUES (%s,%s)',
					SSQL($id, "int"),
					SSQL($valSel[$i], "int"));
				$LOGd.=$qryinsMC.'<br>';
				if(mysqli_query($conn,$qryinsMC)){
					$vP=TRUE;
					$contCMI++;
				}else{
					$LOG.=mysqli_error($conn);
					$vP=FALSE;
					break;
				}
			}
		}else $LOG.=mysqli_error($conn);
		$LOGd.='Multiple Cats inserted. '.$contCMI;
		//Inserta las MultiCats seleccionadas
	}
	
	/***************************** PICS GALLS REVIEW *****************************/
	$vPG=FALSE;
	if(($vP) && ($data['uploader_count'])){
		$detGS=detRow('tbl_gallery','gall_id',$data['gallSel']);
		if($detGS){
			$LOGd.='<p>Gallery Exist</p>';
			$idgs=$detGS['gall_id'];
		}else{
			$LOGd.='<p>Gallery creation</p>';
			$qryIG=sprintf('INSERT INTO tbl_gallery (gall_stat) VALUES (%s)',
				SSQL(1,'int'));
			$LOGd.=$qryIG.'<br>';
			if(mysqli_query($conn,$qryIG)){
				$idgs=mysqli_insert_id($conn);
				$qryIGR=sprintf('INSERT INTO tbl_gallery_ref (idg,idr,ref) VALUES (%s,%s,%s)',
					SSQL($idgs,'int'),
					SSQL($id,'int'),
					SSQL('ITEM','text'));
				$LOGd.=$qryIGR.'<br>';
				if(mysqli_query($conn,$qryIGR)){
					$vPG=TRUE;
				}else $LOG.='<p>Gallery reference creation error</p>'.mysqli_error($conn);
			}else $LOG.='<p>Gallery creation error</p>'.mysqli_error($conn);
		}
	//END if(!$detGS){
		$contUpload=$data['uploader_count'];
		if(($vPG) && ($contUpload>0)){
			$LOGd.='<p>Upload files</p>';
			for($k=0;$k<$contUpload;$k++){
				$fileTemp='uploader_'.$k.'_tmpname';
				if($data['FU_ofn']==TRUE) $fileTit='uploader_'.$k.'_name';
				$fileStat='uploader_'.$k.'_status';
				$qryinsG=sprintf('INSERT INTO tbl_gallery_items (gall_id,img_tit,img_path,img_status) VALUES (%s,%s,%s,%s)',
					SSQL($idgs, "int"),
					SSQL($data[$fileTit], "text"),
					SSQL($data[$fileTemp], "text"),
					SSQL('1','int'));
				$LOGd.=$qryinsG;
				if(mysqli_query($conn,$qryinsG)){
					$LOGd.='<p>Image Upload Successfully</p>';
				}else $LOG.='<p>Error while upload file</p>'.mysqli_error($conn);
				fnc_genthumb(RAIZ0.'data/img/item/', $data[$fileTemp], "t_", 300, 250);
			}//END for($k=0;$k<$contUpload;$k++){
		}
	}//END if($data['uploader_count']){
	
}
	//MOD INVENTARIO TYPES
	if($_POST['form']==md5('formTyp')){
		if(($_FILES['userfile']['name'])){
			$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg'),"size"=>2097152,"pat"=>RAIZ0.'data/img/cat/',"pre"=>"cat");
			$dFU=uploadfile($_FILES['userfile'], $paramsF);
			if($dFU['EST']==TRUE){
				if($_POST['imagea']){
					$LOG.=deleteFile($paramF['pat'],$valImg,TRUE,'t_');
				}
				$valImg=$dFU['FILE'];
				fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 250, 250);
			}
			$LOG.=$dFU['LOG'];
		}
		/*******************************/
		//BEG GENERATE URL FRIENDLY
		if(!$data['typUrl']) $data['typUrl']=genUrlFriendly($data['typNom']);
		//BUSCO SI EXISTE UNA URL AMIGABLE SIMILAR
		$paramsN[]=array(
			array("cond"=>"AND","field"=>"typUrl","comp"=>"=","val"=>$data['typUrl']),
			array("cond"=>"AND","field"=>"md5(typID)","comp"=>'<>',"val"=>$ids)
		);//CONDICIONES CAMPO URL e ID tabla
		$dFindUrlF=detRowNP('tbl_items_type',$paramsN);
		//Si encontro un parecido agrego un distintivo al final
		if($dFindUrlF) $data['typUrl'].='-1';
		//END GENERATE URL FRIENDLY
		/*******************************/
		switch($acc){
			case md5('UPDt'):
				$qry=sprintf('UPDATE tbl_items_type SET typ_id=%s, typNom=%s, typUrl=%s, typDes=%s, typIDp=%s, typImg=%s WHERE md5(typID)=%s LIMIT 1',
				SSQL($data['typ_id'], "int"),
				SSQL($data['typNom'], "text"),
				SSQL($data['typUrl'], "text"),
				SSQL($data['typDes'], "text"),
				SSQL($data['typIDp'], "text"),
				SSQL($valImg, "text"),
				SSQL($ids, "text"));
				//echo $qryupd;
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$LOG.=$cfg[p]['upd-true'];
				}else $LOG.=$cfg[p]['upd-false'].mysqli_error($conn);
			break;
			case md5('INSt'):
				$qry=sprintf('INSERT INTO tbl_items_type (typIDp,typNom,typDes,typImg,typDate,typUrl,typ_id,typEst) 
				VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
				SSQL($data['typIDp'], "text"),
				SSQL($data['typNom'], "text"),
				SSQL($data['typDes'], "text"),
				SSQL($valImg, "text"),
				SSQL($sdate, "date"),
				SSQL($data['typUrl'], "text"),
				SSQL($_POST['typ_id'], "int"),
				SSQL('1', "int"));
				$LOGd.=$qry.'<br>';
				if(mysqli_query($conn,$qry)){
					$vP=TRUE;
					$ids=md5(mysqli_insert_id($conn));
					$LOG.=$cfg[p]['ins-true'];
				}else $LOG.=$cfg[p]['ins-false'].mysqli_error($conn);
			break;
			
		}
	}
	//MOD INVENTARIO BRANDS
	if($_POST['form']==md5('formBrand')){
		if(($_FILES['userfile']['name'])){
			$paramsF=array("ext"=>array('.jpg','.gif','.png','.jpeg'),"size"=>2097152,"pat"=>RAIZ0.'data/img/brand/',"pre"=>"brand");
			$dFU=uploadfile($_FILES['userfile'], $paramsF);
			if($dFU['EST']==TRUE){
				if($_POST['imagea']) $LOG.=deleteFile($paramF['pat'],$valImg,TRUE,'t_');
				$valImg=$dFU['FILE'];
				fnc_genthumb($paramsF['pat'], $dFU['FILE'], "t_", 250, 250);
			} $LOG.=$dFU['LOG'];
		}
		if($acc==md5('UPDb')){
			$qry=sprintf('UPDATE tbl_items_brands SET name=%s, url=%s, data=%s, img=%s, vimg=%s, status=%s WHERE md5(id)=%s',
			SSQL($data['iNom'], "text"),
			SSQL($data['iUrl'], "text"),
			SSQL($data['iDes'], "text"),
			SSQL($valImg, "text"),
			SSQL($data['iVImg'], "int"),
			SSQL($data['iStat'],"int"),
			SSQL($ids, "text"));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg['p']['upd-true'];
			}else $LOG.=$cfg['p']['upd-false'].mysqli_error($conn);
		}
		if($acc==md5('INSb')){
			$qry=sprintf('INSERT INTO tbl_items_brands (date,name,url,data,img,vimg,hits,status) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($sdate, "date"),
			SSQL($data['iNom'], "text"),
			SSQL($data['iUrl'], "text"),
			SSQL($data['iDes'], "text"),
			SSQL($valImg, "text"),
			SSQL($data['iVImg'], "int"),
			SSQL(1, "int"),
			SSQL(1, "int"));
			$LOGd.=$qry.'<br>';
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$ids=md5(mysqli_insert_id($conn));
				$LOG.=$cfg['p']['ins-true'];
			}else $LOG.=$cfg['p']['upd-false'].mysqli_error($conn);
		}
	}
}else{
	switch($acc){
	//acc PRODUCT MULTIPLE
	case md5('PRODMULT'):
	//BEG MULTIPLE ACC
	$vP=TRUE;
	switch($data['accm']){
		case md5("delete"):
			$contRows=0;
			$lis=$data['lis'];
			if($lis){
				foreach($lis as $val){
					$contRows++;
					$qry=sprintf('DELETE FROM tbl_items WHERE item_id=%s LIMIT 1',
					SSQL($val,'int'));
					if(mysqli_query($conn,$qry)){
						$qryb=sprintf('DELETE FROM tbl_items_type_vs WHERE item_id=%s',
						SSQL($val,'int'));
						if(mysqli_query($conn,$qryb)){
							if($contRows<=25) $LOG.=$val." Deleted, ";
						}else $vP=FALSE;
					}else{
						$vP=FALSE;
						$LOG.='<h4>Error Detele Item '.$val.'</h4>';
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
					$qry=sprintf('UPDATE tbl_items SET item_status=0 WHERE item_id=%s LIMIT 1',
					SSQL($val,'int'));
					if(mysqli_query($conn,$qry)) $vP=TRUE;
					else{
						$vP=FALSE;
						$LOG.='<h4>Error Disable Item '.$val.'</h4>';
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
					$qry=sprintf('UPDATE tbl_items SET item_status=1 WHERE item_id=%s LIMIT 1',
					SSQL($val,'int'));
					if(mysqli_query($conn,$qry)) $vP=TRUE;
					else{
						$vP=FALSE;
						$LOG.='<h4>Error Enable Item '.$val.'</h4>';
					}
				}
				$LOG.='<h4>Disabled. '.$contRows.' Rows</h4>';
			}else $LOG.='No selection';
		break;
	}
	$goTo.='invItem.php';
	//END MULTIPLE ACC
	break;
	//acc CLONE Product
	case md5('CLONi'):
		$det=detRow('tbl_items','md5(item_id)',$ids);
		if($det){
			$qry=sprintf('INSERT INTO tbl_items (item_cod, brand_id, item_aliasurl, item_nom, item_ref, item_des, item_spec, item_date, item_status) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($det['item_cod'].' '.md5($sdatet),'text'),
			SSQL($det['brand_id'],'int'),
			SSQL($det['item_aliasurl'].' '.md5($sdatet),'text'),
			SSQL($det['item_nom'],'text'),
			SSQL($det['item_ref'],'text'),
			SSQL($det['item_des'],'text'),
			SSQL($det['item_spec'],'text'),
			SSQL($sdate,'text'),
			SSQL(0,'int'));
			//$LOG.=$qry;
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.="<h4>Clonado Correctamente</h4>";
				$ids=mysqli_insert_id($conn);
			}else $LOG.='<h4>No se pudo Clonar</h4>'.mysqli_error($conn);
		}else $LOG.='<h4>No se encuentra elemento a clonar</h4>'.mysqli_error($conn);
	break;
	//acc DELETE Product
	case md5('DELi'):
		$qry=sprintf('DELETE FROM tbl_items WHERE md5(item_id)=%s LIMIT 1',
		SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['del-true'];
		}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
		$GotoPar.='&view=TRASH';
	break;
	//acc DelImg
	case 'DelImg':
		$dPic=detRow('tbl_gallery_items','img_id',$data['idpic']);
		$qry=sprintf('DELETE FROM tbl_gallery_items WHERE img_id=%s',
		SSQL($data['idpic'], 'int'));
		if(mysqli_query($conn,$qry)) $LOG.="<h4>Eliminado Correctamente </h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
		$LOG.=deleteFile(RAIZ0.'data/img/item/',$dPic['img_path']);
		$LOG.=deleteFile(RAIZ0.'data/img/item/','t_'.$dPic['img_path']); 
	break;
	//acc STATUS Product
	case md5('STi'):
		$qry=sprintf('UPDATE tbl_items SET item_status=%s WHERE md5(item_id)=%s LIMIT 1',
		SSQL($val,'int'),
		SSQL($ids,'text'));
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg['p']['est-true'];
		}else $LOG.=$cfg['p']['est-true'].mysqli_error($conn);
	break;
	//acc DELETE Category
	case md5('DELc'):
		$TRitem=totRowsTab('tbl_items_type_vs','md5(typID)',$ids);
		$TRsubc=totRowsTab('tbl_items_type','md5(typIDp)',$ids);	
		if(($TRitem>0)||($TRsubc>0)){
			$LOG=$cfg[p]['del-false']."Related items";
		}else{
			$qry=sprintf('DELETE FROM tbl_items_type WHERE md5(typID)=%s LIMIT 1',
			SSQL($ids,'text'));
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
		}
		$GotoPar.='&view=TRASH';
	break;
	//acc STATUS Category
	case md5('STc'):
		$qry=sprintf('UPDATE tbl_items_type SET typEst=%s WHERE md5(typID)=%s LIMIT 1',
		SSQL($val,'int'),
		SSQL($ids,'text'));
		$LOGd.=$qry.'<br>';
		if(mysqli_query($conn,$qry)){
			$vP=TRUE;
			$LOG.=$cfg[p]['est-true'];
		}else $LOG.=$cfg[p]['est-false'].mysqli_error($conn);
	break;
	case md5('MIGC'):
		$LOG.='<h2>MIGRATE DATA TO CATEGORY</h2>';
		$qMC=sprintf('UPDATE tbl_items_type SET typIDp=%s WHERE typIDp=%s',
					  SSQL($data['typIDp'],'int'),
					  SSQL($ids,'int'));
		if(mysqli_query($conn,$qMC)){
			$LOG.='<p>'.mysqli_affected_rows().' Categories Migrated</p>';
		}else{
			$LOG.='<p>No Categories was Migrated. '.mysqli_error($conn).'</p>';
		}
		$qMI=sprintf('SELECT * FROM tbl_items_type_vs 
		RIGHT JOIN tbl_items ON tbl_items_type_vs.item_id = tbl_items.item_id
		WHERE tbl_items_type_vs.typID=%s',
					  SSQL($ids,'int'));
		$RSmi=mysqli_query($conn,$qMI) or die (mysqli_error($conn));
		$dRSmi=mysqli_fetch_assoc($RSmi);
		$tRSmi=mysqli_num_rows($RSmi);
		if($tRSmi>0){
			do{//RECORRO LISTA DE ITEMS item_id WHERE typID=$ids (Items actualmente encontrados con typID relacionado)
				$param='AND item_id='.$dRSmi['item_id'].' AND typID='.$data['typIDp'];
				$TR=totRowsTabP('tbl_items_type_vs',$param);
				if($TR>0){//ELIMINO
					$qryUCVId=sprintf('DELETE FROM tbl_items_type_vs WHERE id=%s',
						  SSQL($dRSmi['id'],'int'));
					if(mysqli_query($conn,$qryUCVId)) $contMID++;
					else $LOG.='<p>Delete old. '.mysqli_error($conn).'</p>';
				}else{
					//$LOG.='TR. '.$TR.'<hr>';
					$qryUCVI=sprintf('UPDATE tbl_items_type_vs SET typID=%s WHERE id=%s',
						  SSQL($data['typIDp'],'int'),
						  SSQL($dRSmi['id'],'int'));
					if(mysqli_query($conn,$qryUCVI)){
						$contMI++;
					}else $LOG.='<p>Fail to Migrate Item. '.mysqli_error($conn).'</p>';
				}
			}while($dRSmi=mysqli_fetch_assoc($RSmi));
			$LOG.='<p>Items Migrated. '.$contMI.'</p>';
			$LOG.='<p>Items No  neccesary Migrated. '.$contMID.'</p>';
		}else $LOG.='<p>No Items to Migrate.</p>';
		$vP=TRUE;
	
	break;
	case md5('DELb'):
		$TR=totRowsTab('tbl_items','md5(brand_id)',$ids);
		if($TR>0) $LOG.=$cfg[p]['del-false'].$TR.' related items';
		else{
			$qry=sprintf('DELETE FROM tbl_items_brands WHERE md5(id)=%s LIMIT 1',
			SSQL($ids,'text'));
			$LOGd.=$qry;
			if(mysqli_query($conn,$qry)){
				$vP=TRUE;
				$LOG.=$cfg[p]['del-true'];
			}else $LOG.=$cfg[p]['del-false'].mysqli_error($conn);
		}
		$GotoPar.='&view=TRASH';
	break;
	case md5('STb'):
		$qry=sprintf('UPDATE tbl_items_brands SET status=%s WHERE md5(id)=%s LIMIT 1',
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