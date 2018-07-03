<?php
require('../../init.php');
require_once(RAIZs."inc/PHPExcel/PHPExcel.php");
$data=$_REQUEST;
$valSel=$data['valSel'];
var_dump($valSel);
echo '<hr>';
$cont_valSel=count($valSel);
for($x=0;$x<=$cont_valSel;$x++){
	$valRet.=$valSel[$x];
	if($x<$cont_valSel) $valRet.=',';
}
echo $valRet;
//$fecI=$data['fecI'];
//$fecF=$data['fecF'];
//$selAll=intval($data['selAll']);
//$isTest=intval($data['isTest']);
//$isBan=intval($data['isBan']);
//$isBad=intval($data['isBad']);
//var_dump($data);
//Inicializar la clase.
$objPHPExcel = new PHPExcel();
//Propiedades del documento (creador, titulo, etc..)
$objPHPExcel->getProperties()
	->setCreator("Mercoframes")
	->setLastModifiedBy("")
	->setTitle("MERCOFRAMESUSA")
	->setSubject("")
	->setDescription("")
	->setKeywords("")
	->setCategory("Reportes");
//Seleccionar la fuente a utilizar.
$objPHPExcel->getDefaultStyle()->getFont()->setName(‘Arial’);
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
//if(!$selAll){
//	if($fecI)$param.=" AND date>='".$fecI."'";
	//if($fecF)$param.=" AND date<='".$fecF."'";
//}

/*Escribir los datos en nuestro documento.
	- tbl_items.brand_id
		***************
		- Reichert = 19
		- Kowa = 10
		- Tomey = 22
		- Optopol = 31
		- Sonomed = 39
		- Visslo = 24
		- Forus = 51
		- Icare = 50
		- Canon = 4
		***************
		- Potec = 18
		- Argo = 2
		- Hans Heiss = 5
		- Shin Noppon = 21
		- Welch Allyn = 26
*/
$qryRS = sprintf("SELECT tbl_items.item_id as ID, tbl_items.item_cod as COD, tbl_items.item_nom as NOM, tbl_items.item_img, tbl_items.item_des AS LDES, tbl_items.item_img as IMG,
tbl_items_brands.name as BNOM
FROM tbl_items 
LEFT JOIN tbl_items_brands ON tbl_items.brand_id=tbl_items_brands.id
WHERE tbl_items.brand_id IN (18,2,5,26,21) AND item_status=1 ORDER BY tbl_items.item_id DESC",
GetSQLValueString($isTest,'int'),
GetSQLValueString($isBan,'int'));
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
	$dat['pri']=null;
	$dat['dim']=null;
	$dat['spec']='aqui va todo el texto de la pagina';//null;//$dRS['LDES'];
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