<?php
require('../../init.php');
require_once(RAIZs."base/inc/PHPExcel/PHPExcel.php");
mysql_select_db($db_conn_wa, $conn);
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
$objPHPExcel->getDefaultStyle()->getFont()->setSize(10);
//Escribir los datos en nuestro documento.
$query_RS = "SELECT * FROM tbl_contact_mail INNER JOIN tbl_contact_data ON tbl_contact_mail.idMail=tbl_contact_data.idMail ORDER BY idData DESC ".$pages->limit;
$RSm = mysql_query($query_RS) or die(mysql_error());
$row_RS = mysql_fetch_assoc($RSm);
$totalRows_RS = mysql_num_rows($RSm);

$titles = array('ID','FECHA','EMAIL','NOMBRE','COUNTRY','STATE','CITY','ZIP','PHONE','MESSAGE');
$row = 2;
do{	
	$dataId=$row_RS['idData'];
	$dataDate=$row_RS['date'];
	$dataMail=$row_RS['mail'];
	$dataName=$row_RS['name'];
	$dataCountry=$row_RS['country'];
	$dataState=$row_RS['state'];
	$dataCity=$row_RS['city'];
	$dataZip=$row_RS['zip'];
	$dataPhone=$row_RS['phone1'];
	if($row_RS['phone2']) $dataPhone.='/'.$row_RS['phone2'];
	$dataMess=$row_RS['message'];
	$data = array($dataId,$dataDate,$dataMail,$dataName,$dataCountry,$dataState,$dataCity,$dataZip,$dataPhone,$dataMess);
	//Escribir los datos.
	$objPHPExcel->setActiveSheetIndex(0)
	->fromArray($titles, null, 'A1')
	->fromArray($data, null, 'A'.$row.'');
	$row ++;
}while ($row_RS = mysql_fetch_assoc($RSm));

//Propiedades de la hoja.
$objPHPExcel->getActiveSheet()->setTitle('Contact WelchaAllyn Web');
$objPHPExcel->setActiveSheetIndex(0);
//Finalmente descargar el archivo.
header('Content-Type: application/vnd.ms-excel');
header('Content-Disposition: attachment;filename="welchallyn_contact_'.$sdate.'.xls"');
header('Cache-Control: max-age=0');	
$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
$objWriter->save('php://output');
exit;
?>