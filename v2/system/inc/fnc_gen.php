<?php 
//generate Page title <h1>
function genPageTit($img=NULL,$tit,$des=NULL,$pullR=NULL,$pullL=NULL){
	$pageTit;
	$pageTit.='<h1>';
	if ($pullL) $pageTit.='<div class="pull-left">'.$pullL.'</div>';
	if ($img) $pageTit.=$img;
	$pageTit.=' ';
	$pageTit.=$tit;
	$pageTit.=' ';
	if ($des) $pageTit.='<small>'.$des.'</small>';
	if ($pullR) $pageTit.='<div class="pull-right">'.$pullR.'</div>';
	$pageTit.='</h1>';
	return $pageTit;
}

//function vParam  v.1.1 : 2017-01-05
function vParam($nompar, $pget, $ppost, $revsess=NULL){
	/* $nompar. Nombre del parametro a verificar.
	$pget. Obtenemos parametros GET.
	$ppost. Obtenemos parametros POST.
	$revsess. TRUE o FALSE para confirmar si recuperamos valor desde la $_SESSION */
	session_start();
	if(isset($pget)) {$retorno=$pget;}
	else if (isset($ppost)){$retorno=$ppost;}
	else if ($revsess==TRUE) $retorno=$_SESSION[$nompar];
	if ($revsess==TRUE) $_SESSION[$nompar]=$retorno;
	return $retorno;
}



//Verifica Parametro
function vParam_ant($nompar, $pget, $ppost){
	session_start();
	if(isset($pget)) {$id_ret=$pget;}
	else if (isset($ppost)){$id_ret=$ppost;}
	else $id_ret=$_SESSION[$nompar];
	return $id_ret;
}

//Verifica Parametro
function fnc_verifiparam($nompar, $pget, $ppost){
	session_start();
	if(isset($pget)) {$id_ret=$pget;}
	else if (isset($ppost)){$id_ret=$ppost;}
	else $id_ret=$_SESSION[$nompar];
	return $id_ret;
}
//Generar Thumb
function fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}
//VERIFICAR URL
function verificar_url($url){
	$id = @fopen($url,"r"); //abrimos el archivo en lectura
	//hacemos las comprobaciones
	if ($id) $abierto = true;
	else $abierto = false;
	return $abierto;//devolvemos el valor
	fclose($id);//cerramos el archivo
}
//Verifica Existencia Archivo
function fnc_file_exist($RAIZ,$ruta,$nombre){
	if (($RAIZ) && ($ruta))
	if ((!(isset($nombre)))||($nombre=="")) $nombre="error.jpg";
	if (file_exists(RAIZ0.$ruta.$nombre)) return $RAIZ.$ruta.$nombre;
	else return $RAIZ.'images/struct/no_image.jpg';
} 
function fncStat($dest,$params,$css=NULL){
//Funcion para visualizar status v.2.0
$firstP=TRUE;
foreach($params as $x => $xVal) {
    if($x=='val'){
		if($xVal==1){
			$xVal=0;
			$cssST='btn btn-success btn-xs';
			$txtST='<span class="glyphicon glyphicon-ok"></span>';
		}else{
			$xVal=1;
			$cssST='btn btn-warning btn-xs';
			$txtST='<span class="glyphicon glyphicon-remove"></span>';
		}
	}
	if($firstP==TRUE){
		$lP.='?'.$x.'='.$xVal;
		$firstP=FALSE;
	}else $lP.='&'.$x.'='.$xVal;
}
$st='<a href="'.$dest.$lP.'" class="'.$cssST.' '.$css.'">'.$txtST.'</a>';
return $st;
}
//Funcion para visualizar status
function fnc_status($id, $stat, $dest, $acc=NULL){
	//$id. Id del Registro que se va a cambiar el estatus, sirve para armar la url
	//$stat. Estado actual del Registro :: 0=Inactivo, 1=Activo
	//$dest. Url de destino donde va a dirigir el link para modiicar el status
if ($stat=="1")
	$status='<a href="'.$dest.'?id='.$id.'&stat=0&acc='.$acc.'" class="btn btn-success btn-xs"><span class="glyphicon glyphicon-ok"></span></a>';
if(($stat=="0")||($stat!="1"))
	$status='<a href="'.$dest.'?id='.$id.'&stat=1&acc='.$acc.'" class="btn btn-danger btn-xs"><span class="glyphicon glyphicon-remove"></span></a>';
return $status;
}
function generate_aliasurl($string){
	$string='--'.$string;
	$string=strtolower($string);
	$string=clearString($string);
	$string=cleanString($string);
	if (substr($string, -1)=='-')
		$string=substr_replace($string, '',-1);
	return $string;
}
function clearString($string){ //Funciona OK
	$string = preg_replace('([^A-Za-z0-9])', '-', $string);
	return $string;
}
function cleanString($string){
    $string = trim($string);
    $string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'),
        array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'),
        $string
    );
    $string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'),
        array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'),
        $string
    );
    $string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'),
        array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'),
        $string
    );
    $string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'),
        array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'),
        $string
    );
    $string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'),
        array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'),
        $string
    );
    $string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'),
        array('n', 'N', 'c', 'C',),
        $string
    );
    //Esta parte se encarga de eliminar cualquier caracter extraño
    $string = str_replace(
        array("\\", "¨", "º", "--", "~",
             "#", "@", "|", "!", "\"",
             "·", "$", "%", "&", "/",
             "(", ")", "?", "'", "¡",
             "¿", "[", "^", "`", "]",
             "+", "}", "{", "¨", "´",
             ">", "< ", ";", ",", ":",
             "."), '',
        $string
    );
    return $string;
}
//OBTENER IP
function getRealIP(){
   if( $_SERVER['HTTP_X_FORWARDED_FOR'] != '' ){
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ( ( !empty($_ENV['REMOTE_ADDR']) ) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
      // los proxys van añadiendo al final de esta cabecera
      // las direcciones ip que van "ocultando". Para localizar la ip real
      // del usuario se comienza a mirar por el principio hasta encontrar
      // una dirección ip que no sea del rango privado. En caso de no
      // encontrarse ninguna se toma como valor el REMOTE_ADDR
      $entries = split('[, ]', $_SERVER['HTTP_X_FORWARDED_FOR']);
      reset($entries);
      while (list(, $entry) = each($entries)){
         $entry = trim($entry);
         if ( preg_match("/^([0-9]+\.[0-9]+\.[0-9]+\.[0-9]+)/", $entry, $ip_list)){
            // http://www.faqs.org/rfcs/rfc1918.html
            $private_ip = array(
                  '/^0\./',
                  '/^127\.0\.0\.1/',
                  '/^192\.168\..*/',
                  '/^172\.((1[6-9])|(2[0-9])|(3[0-1]))\..*/',
                  '/^10\..*/');
            $found_ip = preg_replace($private_ip, $client_ip, $ip_list[1]);
            if ($client_ip != $found_ip){ $client_ip = $found_ip; break;
            }
         }
      }
   }else{
      $client_ip = ( !empty($_SERVER['REMOTE_ADDR']) ) ?
            $_SERVER['REMOTE_ADDR']
            : ((!empty($_ENV['REMOTE_ADDR'])) ?
               $_ENV['REMOTE_ADDR']
               : "unknown" );
   }
   return $client_ip;
}

//Obtiene URL Actual
function urlc(){

	$url=substr($GLOBALS['RAIZ'], 0, -1).$_SERVER["REQUEST_URI"];
	/*
	$url = 'http'; 
	if ($_SERVER["HTTPS"] == "on"){ $url .= "s"; } 
    $url .= "://"; 
	if ($_SERVER["SERVER_PORT"] != "80"){ 
		$url .= $_SERVER["SERVER_NAME"] . ":" . $_SERVER["SERVER_PORT"] . 
		$_SERVER["REQUEST_URI"]; 
	}else{ 
      $url .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"]; 
    }
	*/
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

if(isset($urlf)){//Verifico si tengo una URL retorno de formulario (urlf)
	//echo '<h4>SI Tengo URL de FORM : '.$urlf.'</h4>';
	$urlr=$urlf;
}else{//NO TENGO URL de FORM 
	//echo '<h4>No tengo URL de FORM</h4>';
	if((compUrl($urlc,$urlp))||(!isset($urlp))){
		//echo '<hr>urlC Iguale urlA';
		$urlr=$GLOBALS['RAIZ'];//Comparo si no son iguales la URL
	}else{
		//echo '<hr>No es igual';
		//echo $urla;
		$urlr=$urlp;
	}
}
//echo $urlr;
return $urlr;
}
?>