<?php

//CREATE IMAGES FOR ID
function createImagesIDBarCode($id,$pref=NULL,$ruta,$ext){
	if (!file_exists($ruta.$pref.$id.$ext)){
		genBarCode($id,$pref,$ruta,'.jpg');
	}
}

function genBarCode($text,$pref,$ruta,$ext){
	$finalcode=$pref.$text;
$font = new BCGFontFile(RAIZ.'fonts/Arial.ttf', 9);
// The arguments are R, G, B for color.
$color_black = new BCGColor(0, 0, 0);
$color_white = new BCGColor(255, 255, 255);

$drawException = null;
try {
	$code = new BCGcode39();
	$code->setScale(1); // Resolution
	$code->setThickness(10); // Thickness
	$code->setForegroundColor($color_black); // Color of bars
	$code->setBackgroundColor($color_white); // Color of spaces
	$code->setFont($font); // Font (or 0)
	$code->parse($finalcode); // Text
} catch(Exception $exception) {
	$drawException = $exception;
}

/* Here is the list of the arguments
1 - Filename (empty : display on screen)
2 - Background color */
$drawing = new BCGDrawing($ruta.$finalcode.$ext, $color_white);
if($drawException) {
	$drawing->drawException($drawException);
} else {
	$drawing->setBarcode($code);
	$drawing->draw();
}

// Header that says it is an image (remove it if you save the barcode to a file)
// Draw (or save) the image into PNG format.
$drawing->finish(BCGDrawing::IMG_FORMAT_JPEG);

}

//generate Page Tittle <h1>
function genPageTit($id=NULL,$tit=NULL,$des=NULL,$pullL=NULL,$pullR=NULL){
	$pageTit;
	$pageTit.='<h3>';
	if ($pullL) $pageTit.=' <div class="pull-left">'.$pullL.'</div> ';
	if ($id) $pageTit.=' <span class="label label-info"><h2>'.$id.'</h2></span> ';
	if ($tit) $pageTit.=$tit;
	if ($des) $pageTit.=' <small>'.$des.'</small> ';
	if ($pullR) $pageTit.=' <div class="pull-right">'.$pullR.'</div> ';
	$pageTit.='<h3>';
	return $pageTit;
}

//Obtiene URL Actual
function urlc(){
	$url=substr($GLOBALS['RAIZ'], 0, -1).$_SERVER["REQUEST_URI"];
	/* $url = 'http'; 
	if ($_SERVER["HTTPS"] == "on"){ $url .= "s"; } 
    $url .= "://"; 
	if ($_SERVER["SERVER_PORT"] != "80"){ 
		$url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . $_SERVER["REQUEST_URI"]; 
	}else{ $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; } */
	return $url; 
}
//Validar URL Retorno
function urlr($urlf=NULL){
	//$urlf :: URL proveniente de un FORM
	//$urla :: URL anterior proveniente de una Session declarada en el Header $_SESSION['urlp']
	//$urlc :: URL actual de el archivo que solicita la validacion de url
//echo '<h4>entra a verurlr</h4>';
$urlp=$_SESSION['urlp'];//URL Previa
$urlc=$_SESSION['urlc'];//URL Actual
//Verifico si tengo una URL retorno de formulario (urlf)
if(isset($urlf)){ $urlr=$urlf;
}else{//NO TENGO URL de FORM 
	//echo '<h4>No tengo URL de FORM</h4>';
	if((compUrl($urlc,$urlp))||(!isset($urlp))){ $urlr=$GLOBALS['RAIZ'];//Comparo si no son iguales la URL
	}else{ $urlr=$urlp; }
}
return $urlr;
}

//sLOG() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
function sLOG($type=NULL){
	$sLog=NULL;
	if(isset($_SESSION['LOG']['m'])){
		if($type=='a'){
			$sLog='<div id="log"><div class="alert alert-dismissable alert-'.$_SESSION['LOG']['c'].'" style="margin:10px;"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$_SESSION['LOG']['m'].'</div></div>';
		}else if($type=='g'){
			$sLog='<script type="text/javascript">logGritter("'.$_SESSION['LOG']['t'].'","'.$_SESSION['LOG']['m'].'","'.$_SESSION['LOG']['i'].'");</script>';
		}else{
			$sLog='<div>'.$_SESSION['LOG']['m'].'</div>';
		}
		echo $sLog;
	}
	unset($_SESSION['LOG']);
}
?>