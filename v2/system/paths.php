<?php
$domainName=''; //Folder to $RAIZ url
$folderBase=''; //Remoto. '/'; Local. '/Folder/' (Folder in www)
$folderCont='DUOSOFT_NETLIKE/v2/'; //Folder if system is in subdirectory
$serverRoot=$_SERVER['DOCUMENT_ROOT'].'/';
$hostType=$_SERVER[HTTP_HOST].'/'; //Remoto. 'www.'; Local. 'localhost/'
$protocolS='http://';
//FILESYSTEM
define('RAIZ0',$serverRoot.$folderBase);
define('RAIZ',RAIZ0.$folderCont);
define('RAIZi',RAIZ.'images/');
define('RAIZidb',RAIZ.'images/db/');
define('RAIZm',RAIZ.'modulos/');
define('RAIZmdb',RAIZ.'media/db/');
define('RAIZf',RAIZ.'frames/');
define('RAIZc',RAIZ.'com/');
define('RAIZs',RAIZ.'system/');
define('RAIZu',RAIZ.'uploads/');
define('RAIZa',RAIZ.'assets/');

global $RAIZ0,$RAIZ,$RAIZi,$RAIZj,$RAIZc,$RAIZc,$RAIZs,$RAIZidb;
$urlCont=$hostType.$domainName;
$RAIZ0=$protocolS.$urlCont;
$RAIZ=$protocolS.$urlCont.$folderCont;
$RAIZa=$RAIZ.'assets/';
$RAIZi=$RAIZa.'images/';
$RAIZii=$RAIZi.'icons/';
$RAIZidb=$RAIZ.'images/db/';
$RAIZj=$RAIZ.'js/';
$RAIZt=$RAIZ.'css/';
$RAIZc=$RAIZ.'com/';
$RAIZci=$RAIZ.'com/com_index/';
$RAIZs=$RAIZ.'system/';
$RAIZu=$RAIZ.'uploads/';
$RAIZmdb=$RAIZ.'media/db/';

/*
echo '<hr>';
echo 'RAIZ0 -> '.RAIZ0.'<hr>';
echo 'RAIZ -> '.RAIZ.'<hr>';
echo '$RAIZ0 -> '.$RAIZ0.'<hr>';
echo '$RAIZ -> '.$RAIZ.'<hr>';
echo '<hr>';
*/

$_SESSION['urlp']=$_SESSION['urlc'];
$_SESSION['urlc']=basename($_SERVER['SCRIPT_FILENAME']);//URL clean Current;
$urlc=$_SESSION['urlc'];
$urlp=$_SESSION['urlp'];
?>