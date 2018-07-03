<?php require('../../init.php');
require_once(RAIZs."inc/PHPExcel/PHPExcel.php");
$data=$_REQUEST;
$valSel=$data['valSel'];
$cont_valSel=count($valSel);
for($x=0;$x<=$cont_valSel;$x++){
	$valRet.=$valSel[$x];
	if($x<$cont_valSel-1) $valRet.=',';
}

//CREO CSV
// output headers so that the file is downloaded rather than displayed
header('Content-Type: text/csv; charset=utf-8');
header('Content-Disposition: attachment; filename=CSV-mercousa'.$sdatet.'.csv');

// create a file pointer connected to the output stream
$output = fopen('php://output', 'w');

$qryRS = sprintf("SELECT tbl_items.item_id as ID, tbl_items.item_cod as COD, tbl_items.item_nom as NOM, tbl_items.item_price as PRI, tbl_items.item_can as QTY, 
tbl_items.item_des AS LDES, tbl_items.item_spec as LSPEC, tbl_items.item_img as IMG,
tbl_items_brands.name as BNOM
FROM tbl_items 
LEFT JOIN tbl_items_brands ON tbl_items.brand_id=tbl_items_brands.id
WHERE tbl_items.brand_id IN (%s) AND item_status=1 AND item_statusMU=1  
ORDER BY tbl_items_brands.name ASC",
				 SSQL($valRet,''));
$RS = mysql_query($qryRS) or die(mysql_error());
$dRS = mysql_fetch_assoc($RS);
$tRS = mysql_num_rows($RS);

$titles = array('sku','_category','sub-category','brand','image','name','price','weight','qty','description','specification');
fputcsv($output, $titles);
do{
	$dCat=detRow('tbl_items_type_vs','item_id',$dRS['ID']);
	$dCatN=detRow('tbl_items_type','typID',$dCat['typID']);
	$dCatS=detRow('tbl_items_type','typID',$dCatN['typIDp']);
	
	$dat['sku']=$dRS['COD'];
	if($dCatS['typID']!=1) $dat['sub-category']=$dCatS['typNom']; else $dat['sub-category']='';
	$dat['_category']=$dCatN['typNom'];
	$dat['brand']=$dRS['BNOM'];//null;//
	$dat['image']=$dRS['IMG'];//null;//
	$dat['name']=$dRS['NOM'];
	$dat['price']=number_format($dRS['PRI'],2,".",",");//$dRS['PRI'];
	$dat['weight']='1';
	if(intval($dRS['QTY'])<=0) $dat['qty']='10'; else $dat['qty']=intval($dRS['QTY']);

	$dat['description']=$dRS['LDES'];//'aqui va todo el texto de la pagina';//null;//$dRS['LDES'];
	$dat['specification']=$dRS['LSPEC'];//'aqui va todo el texto de SPECIFICATIONS
	if(!$dat['specification']) $dat['specification']=$dRS['LDES'];
	
	//Escribir los datos.
	fputcsv($output, $dat);
}while ($dRS = mysql_fetch_assoc($RS));
?>