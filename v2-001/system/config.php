<?php 
function startConfigs(){
	if(!($_SESSION['config'])){
		$conf=parse_ini_file(RAIZs.'config.ini',TRUE);
		foreach($conf as $x => $xval){
			foreach($xval as $y => $yval) $configEnd[$x][$y]=$yval;
		}
		$_SESSION['conf']=$configEnd;
	}
}
startConfigs();

date_default_timezone_set('America/Guayaquil');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
$sdate=date('Y-m-d');
$sdatet=date('Y-m-d H:i:s');

/*
$sdate=date('Y-m-d');
$sdatet=date('Y-m-d H:i:s');
setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
*/
//TEMA BOOTSTRAP
if($_SESSION['bsTheme']) $bsTheme=$_SESSION['bsTheme'];
else $bsTheme=$_SESSION['conf']['var']['theme'];
?>