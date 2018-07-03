<?php include('../../init.php');
$data=$_REQUEST;
$acc=$data['acc'];
$id=$data['id'];
$ids=$data['ids'];
//**********************************************************************************
//**********************************************************************************
//TRANSACTION
mysql_query("SET AUTOCOMMIT=0;");
mysql_query("BEGIN;");
//**********************************************************************************
//**********************************************************************************
//UPDATE 
if((isset($acc))&&($acc=='setDB')){
	switch($data['tbl']){
		case "GallTit" :
			$paramTbl='tbl_gallery';
			$paramField='gall_tit';
			$paramFieldK='gall_id';
			$msgSuccess="Titulo de galeria actualizado. ";
			$banEP=TRUE;
		break;
		case "GallItemTit" :
			$paramTbl='tbl_gallery_items';
			$paramField='img_tit';
			$paramFieldK='img_id';
			$msgSuccess="Titulo de imagen actualizado. ";
			$banEP=TRUE;
		break;
		case "ItemPri" :
			$paramTbl='tbl_items';
			$paramField='item_price';
			$paramFieldK='item_id';
			$msgSuccess="Price Updated. ";
			$banEP=TRUE;
		break;
		case "ItemCan" :
			$paramTbl='tbl_items';
			$paramField='item_can';
			$paramFieldK='item_id';
			$msgSuccess="Quantity Updated. ";
			$banEP=TRUE;
		break;
		case md5("statMUSA") :
			$paramTbl='tbl_items';
			$paramField='item_statusMU';
			$paramFieldK='item_id';
			$msgSuccess="Status MercoUSA Updated. ";
			$banEP=TRUE;
		break;
	}

	if($banEP){
		$qry=sprintf('UPDATE %s SET %s=%s WHERE %s=%s LIMIT 1',
				SSQL($paramTbl,''),
				SSQL($paramField,''),
				SSQL($data['val'],'text'),
				SSQL($paramFieldK,''),
				SSQL($data['ids'],'int'));
		//$LOG.=$qry;
		if(mysql_query($qry)){
			$vP=TRUE;
			$LOG.=$msgSuccess;
		}else $LOG.="No se pudo actualizar. ".mysql_error();
	}
}

//DELETE GALLERY ITEM : tbl_gallery_items
if((isset($acc))&&($acc=='DelImg')){
	$dPic=detRow('tbl_gallery_items','img_id',$ids);
	$qry=sprintf('DELETE FROM tbl_gallery_items WHERE img_id=%s LIMIT 1',
	SSQL($ids, 'int'));
	if(mysql_query($qry)){
		$vP=TRUE;
		$LOG.="Imagen Eliminada Correctamente. ID. ".$ids;
		deleteFile(RAIZ0.'data/img/item/',$dPic['img_path']);
		deleteFile(RAIZ0.'data/img/item/','t_'.$dPic['img_path']); 
	}else $LOG.='No se pudo Eliminar. '.mysql_error();
}
//END DELETE GALLERY ITEM
//////////////////////////////////////////////
//DELETE GALLERY UNLINK ITEM : tbl_gallery_ref
if((isset($acc))&&($acc=='UNLINKGALLITEM')){
	$qry=sprintf('DELETE FROM tbl_gallery_ref WHERE id=%s LIMIT 1',
	SSQL($ids, 'int'));
	if(mysql_query($qry)){
		$vP=TRUE;
		$LOG.="Galeria desvinculada del Item.";
	}else $LOG.='No se pudo desvincular. '.mysql_error();
}
//END DELETE GALLERY UNLINK ITEM
//**********************************************************************************
//**********************************************************************************
//**********************************************************************************

$LOG.=mysql_error();
//$LOG.=$data['name'];
$resL=$LOG;
if($vP==TRUE){
	mysql_query("COMMIT;");
	$resT='Success';
	$resE=true;
	$resV=$data['val'];
}else{
	mysql_query("ROLLBACK;");
	$resT='Wrong';
	$resE=false;
}
$datos = array(
	'val' => $resV,
	'est' => $resE,
	'res' => $resT,
	'log' => $resL
);
mysql_query("SET AUTOCOMMIT=1;");
//END TRANSACTION
echo json_encode($datos);
?>