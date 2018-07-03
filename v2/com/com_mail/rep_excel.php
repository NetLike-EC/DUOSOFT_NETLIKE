<?php
require('../../init.php');
require_once(RAIZs."base/inc/PHPExcel/PHPExcel.php");	
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
//Escribir los datos en nuestro documento.
$query_RSlist = "SELECT * FROM tbl_contact_mail INNER JOIN tbl_contact_data ON tbl_contact_mail.idMail=tbl_contact_data.idMail ORDER BY idData DESC ".$pages->limit;
$RSm = mysql_query($query_RSlist) or die(mysql_error());
$row_RSlist = mysql_fetch_assoc($RSm);
$totalRows_RSlist = mysql_num_rows($RSm);

$titles = array('ID','WEBSITE','FECHA','EMAIL','NOMBRE','BIRTHDAY','COUNTRY','STATE','CITY','ZIP','PHONE','MESSAGE','IP');
$row = 2;
do{	
	$dataId=$row_RSlist['idData'];
	$dataFrom=$row_RSlist['from'];
	$dataDate=$row_RSlist['date'];
	$dataMail=$row_RSlist['mail'];
	$dataName=$row_RSlist['name'];
	$dataBirthday=$row_RSlist['birthday'];
	$dataCountry=$row_RSlist['country'];
	$dataState=$row_RSlist['state'];
	$dataCity=$row_RSlist['city'];
	$dataZip=$row_RSlist['zip'];
	$dataPhone1=$row_RSlist['phone1'];
	$dataPhone2=$row_RSlist['phone2'];
	$dataMess=$row_RSlist['msg'];
	$dataIp=$row_RSlist['ip'];
	$data = array($dataId,$dataFrom,$dataDate,$dataMail,$dataName,$dataBirthday,$dataCountry,$dataState,$dataCity,$dataZip,$dataPhone1.'-'.$dataPhone2,$dataMess,$dataIp);
	//Escribir los datos.
	$objPHPExcel->setActiveSheetIndex(0)
	->fromArray($titles, null, 'A1')
	->fromArray($data, null, 'A'.$row.'');
	$row ++;
}while ($row_RSlist = mysql_fetch_assoc($RSm));

//Propiedades de la hoja.
$objPHPExcel->getActiveSheet()->setTitle('All data');
$objPHPExcel->setActiveSheetIndex(0);
//Finalmente descargar el archivo.
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="mercoframes_contact_'.$sdate.'.xls"');
header('Cache-Control: max-age=0');	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>