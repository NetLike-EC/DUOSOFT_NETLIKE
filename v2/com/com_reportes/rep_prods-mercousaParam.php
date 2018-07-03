<?php require('../../init.php');
require_once(RAIZs."inc/PHPExcel/PHPExcel.php");
$data=$_REQUEST;
$valSel=$data['valSel'];
$cont_valSel=count($valSel);
for($x=0;$x<=$cont_valSel;$x++){
	$valRet.=$valSel[$x];
	if($x<$cont_valSel-1) $valRet.=',';
}
//CREO EXCEL
$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()//Propiedades del documento (creador, titulo, etc..)
	->setCreator("Mercoframes")
	->setLastModifiedBy("")
	->setTitle("MERCOFRAMESUSA")
	->setSubject("")
	->setDescription("")
	->setKeywords("")
	->setCategory("Reportes");
$objPHPExcel->getDefaultStyle()->getFont()->setName(‘Arial’);//Seleccionar la fuente a utilizar.
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);

$qryRS = sprintf("SELECT tbl_items.item_id as ID, tbl_items.item_cod as COD, tbl_items.item_nom as NOM, tbl_items.item_price as PRI, tbl_items.item_des AS LDES, tbl_items.item_img as IMG,
tbl_items_brands.name as BNOM
FROM tbl_items 
LEFT JOIN tbl_items_brands ON tbl_items.brand_id=tbl_items_brands.id
WHERE tbl_items.brand_id IN (%s) AND item_status=1 AND item_statusMU=1  
ORDER BY tbl_items_brands.name ASC",
GetSQLValueString($valRet,''));
//echo $qryRS;
$RS = mysql_query($qryRS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$tRS = mysql_num_rows($RS);

$titles = array('sku','_category','sub-category','description','brand','image','name','price','dimension','specification','weight','qty');
$row = 2;
do{
	$dCat=detRow('tbl_items_type_vs','item_id',$dRS['ID']);
	$dCatn=detRow('tbl_items_type','typID',$dCat['typID']);
	$dCatS=detRow('tbl_items_type','typID',$dCatn['typIDp']);
	
	$dat['sku']=$dRS['COD'];
	$dat['cat']=$dCatn['typNom'];
	if($dCatS['typID']!=1) $dat['scat']=$dCatS['typNom'];
	else $dat['scat']=null;
	$dat['des']=$dRS['NOM'];//null;//
	$dat['brand']=$dRS['BNOM'];//null;//
	$dat['image']=$dRS['IMG'];//null;//
	$dat['nom']=$dRS['NOM'];
	$dat['pri']=$dRS['PRI'];
	$dat['dim']=null;
	$dat['spec']=$dRS['LDES'];//'aqui va todo el texto de la pagina';//null;//$dRS['LDES'];
	$dat['weight']=null;
	$dat['quant']=null;
	
	//$data = array($dataId,$dataMail,$dataName,$dataCompany,$dataCountry,$dataState,$dataCity,$dataZip,$dataAddress,$dataPhone1,$dataPhone2);
		//Escribir los datos.
		$objPHPExcel->setActiveSheetIndex(0)
		->fromArray($titles, null, 'A1')
		->fromArray($dat, null, 'A'.$row.'');
		$row ++;
}while ($dRS = mysql_fetch_assoc($RS));

//Propiedades de la hoja.
$objPHPExcel->getActiveSheet()->setTitle('All data');
$objPHPExcel->setActiveSheetIndex(0);
//Finalmente descargar el archivo.

if(!$param) $PosNameFileDownload='(all)';
else{
	if($fecI==$fecF) $PosNameFileDownload=' ('.$fecI.')';
	else $PosNameFileDownload=' ('.$fecI.'_'.$fecF.')';
}
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="mercoframes_catalog_template-'.$sdatet.'.xls"');
header('Cache-Control: max-age=0');	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>