<?php 
$cfg=$_SESSION['conf'];
date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$sdate=date('Y-m-d');
$sdatet=date('Y-m-d H:i:s');
//TEMA BOOTSTRAP
if($_SESSION['bsTheme']) $bsTheme=$_SESSION['bsTheme'];
else $bsTheme=$_SESSION['conf']['var']['theme'];
$cfg[wTit]='NetLike';
$cfg[wTer]='v.4.0';
$msgFS='<h3>First save item</h3>';
?>