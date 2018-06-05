<?php $protocol='http://';
$domainName='DUOSOFT_STUCTO/';
$folderCont='';
$serverRoot=$_SERVER['DOCUMENT_ROOT'];
/*LOCAL*/
$hostType='localhost/'; //LOCAL
$folderBase='/'.$domainName; //LOCAL
/*REMOTO*/
//$folderBase='/'; //REMOTO
//$hostType='/'; //REMOTO

define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',$serverRoot.$folderBase.$folderCont);
define('RAIZa',$serverRoot.$folderBase.$folderCont.'assets/');
define('RAIZm',$serverRoot.$folderBase.$folderCont.'modulos/');
define('RAIZf',$serverRoot.$folderBase.$folderCont.'frames/');
define('RAIZc',$serverRoot.$folderBase.$folderCont.'componentes/');
define('RAIZs',$serverRoot.$folderBase.$folderCont.'system/');
define('RAIZi',$serverRoot.$folderBase.$folderCont.'images/');
define('RAIZidb',$serverRoot.$folderBase.$folderCont.'images/db/');
$urlCont=$hostType.$domainName;
$RAIZ0=$protocol.$urlCont;
$RAIZ=$protocol.$urlCont.$folderCont;
$RAIZa=$RAIZ.'assets/';
$RAIZi=$RAIZ.'images/';
$RAIZidb=$RAIZ.'images/db/';
$RAIZm=$RAIZ.'modulos/';
$RAIZc=$RAIZ.'componentes/';
$RAIZf=$RAIZ.'frames/';
$RAIZs=$RAIZ.'system/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'styles/';

$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;

function startConfigs(){
	if(!($_SESSION['config'])){
		$conf=parse_ini_file(RAIZs.'base/config.ini',TRUE);
		foreach($conf as $x => $xval){
			foreach($xval as $y => $yval) $configEnd[$x][$y]=$yval;
		}
		$_SESSION['conf']=$configEnd;
	}
}
startConfigs();

$_SESSION['conf']['taxes']['iva_si'];

date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$sdate=date('Y-m-d');
$sdatet=date('Y-m-d H:m:s');
?>