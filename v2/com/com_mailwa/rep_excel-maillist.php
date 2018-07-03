<?php require('../../init.php');
mysql_select_db($db_conn_wa, $conn);
require_once(RAIZs."inc/PHPExcel/PHPExcel.php");
$data=$_REQUEST;
$fecI=$data['fecI'];
$fecF=$data['fecF'];
$selAll=intval($data['selAll']);
$isTest=intval($data['isTest']);
$isBan=intval($data['isBan']);
$isBad=intval($data['isBad']);
//var_dump($data);
//Inicializar la clase.
$objPHPExcel = new PHPExcel();
//Propiedades del documento (creador, titulo, etc..)
$objPHPExcel->getProperties()
	->setCreator("Mercoframes")
	->setLastModifiedBy("")
	->setTitle("Message Contact")
	->setSubject("")
	->setDescription("")
	->setKeywords("")
	->setCategory("Reportes");
//Seleccionar la fuente a utilizar.
$objPHPExcel->getDefaultStyle()->getFont()->setName(‘Arial’);
$objPHPExcel->getDefaultStyle()->getFont()->setSize(12);
if(!$selAll){
	if($fecI)$param.=" AND date>='".$fecI."'";
	if($fecF)$param.=" AND date<='".$fecF."'";
}
//Escribir los datos en nuestro documento.
$qryRSm = sprintf('SELECT DISTINCT mail, tbl_contact_mail.idMail, name, company, country, state, city, zip, address, phone1, phone2 
FROM tbl_contact_mail INNER JOIN tbl_contact_data ON tbl_contact_mail.idMail=tbl_contact_data.idMail 
WHERE test=%s AND banned=%s '.$param.' 
GROUP BY mail 
ORDER BY tbl_contact_mail.idMail DESC',
GetSQLValueString($isTest,'int'),
GetSQLValueString($isBan,'int'));
//echo $qryRSm;
$RSm = mysql_query($qryRSm) or die(mysql_error());
$dRSm = mysql_fetch_assoc($RSm);
$tRSm = mysql_num_rows($RSm);

$titles = array('ID','EMAIL','NAME','COMPANY','COUNTRY','STATE','CITY','ZIP','ADDRESS','PHONE1','PHONE2');
$row = 2;
do{	
	$dataMail=$dRSm['mail'];
	if((filter_var($dataMail, FILTER_VALIDATE_EMAIL))||($isBad==1)){
		$dataId=$dRSm['idMail'];	
		$dataName=$dRSm['name'];
		$dataCompany=$dRSm['company'];
		$dataCountry=$dRSm['country'];
		$dataState=$dRSm['state'];
		$dataCity=$dRSm['city'];
		$dataZip=$dRSm['zip'];
		$dataAddress=$dRSm['address'];
		$dataPhone1=$dRSm['phone1'];
		$dataPhone2=$dRSm['phone2'];
		$data = array($dataId,$dataMail,$dataName,$dataCompany,$dataCountry,$dataState,$dataCity,$dataZip,$dataAddress,$dataPhone1,$dataPhone2);
		//Escribir los datos.
		$objPHPExcel->setActiveSheetIndex(0)
		->fromArray($titles, null, 'A1')
		->fromArray($data, null, 'A'.$row.'');
		$row ++;
	}
}while ($dRSm = mysql_fetch_assoc($RSm));

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
header('Content-Disposition: attachment;filename="WAmercoframes_mailist_'.$sdate.$PosNameFileDownload.'.xls"');
header('Cache-Control: max-age=0');	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>