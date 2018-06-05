<?php
$domainName='';
$folderBase='/'; //Remoto. '/'; Local. '/Folder/' (Folder in www)
//$folderCont='clinic/'; //Folder if system is in subdirectory
$folderCont='DUOSOFT_NETLIKE/'; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'];
//$hostType='localhost/'; //Remoto. 'www.'; Local. 'localhost/'
$hostType='localhost/'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='http://';

define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',$serverRoot.$folderBase.$folderCont);
define('RAIZi',$serverRoot.$folderBase.$folderCont.'images/');
define('RAIZidb',$serverRoot.$folderBase.$folderCont.'images/db/');
define('RAIZm',$serverRoot.$folderBase.$folderCont.'modulos/');
define('RAIZmdb',$serverRoot.$folderBase.$folderCont.'media/db/');
define('RAIZf',$serverRoot.$folderBase.$folderCont.'frames/');
define('RAIZc',$serverRoot.$folderBase.$folderCont.'com/');
define('RAIZs',$serverRoot.$folderBase.$folderCont.'system/');
define('RAIZu',$serverRoot.$folderBase.$folderCont.'uploads/');
define('RAIZa',$serverRoot.$folderBase.$folderCont.'assets/');

global $RAIZ0,$RAIZ,$RAIZi,$RAIZj,$RAIZc,$RAIZc,$RAIZs,$RAIZidb;
$urlCont=$hostType.$domainName;
$RAIZ0=$protocolS.$urlCont;
$RAIZ=$protocolS.$urlCont.$folderCont;
$RAIZi=$RAIZ.'images/';
$RAIZidb=$RAIZ.'images/db/';
$RAIZii=$RAIZ.'images/icons/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'css/';
$RAIZc=$RAIZ.'com/';
$RAIZs=$RAIZ.'system/';
$RAIZs=$RAIZ.'uploads/';
$RAIZmdb=$RAIZ.'media/db/';
$RAIZa=$RAIZ.'assets/';

$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;
$urlc=$_SESSION['urlc'];
$urlp=$_SESSION['urlp'];
?>