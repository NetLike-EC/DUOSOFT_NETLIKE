<?php

//BEG GENERACION MENU
function genMenu($refMC,$css=NULL,$vrfUL=TRUE){
	//Consulta para Menus Principales
	$qry=sprintf("SELECT * FROM tbl_menus_items 
	INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
	INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
	WHERE tbl_menus.ref = %s 
	AND tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s 
	AND tbl_menus_items.men_stat = %s 
	ORDER BY men_orden ASC",
	SSQL($refMC,'text'),
	SSQL('0','int'),
	SSQL($_SESSION['dU']['usr_id'],'int'),
	SSQL('1','text'));
	$RSmp = mysql_query($qry) or die(mysql_error());
	$dRSmp = mysql_fetch_assoc($RSmp);
	$tRSmp = mysql_num_rows($RSmp);
	if($tRSmp > 0){
		do{
			//Consulta para Submenus
			$qry2 = sprintf("SELECT * FROM tbl_menus_items 
			INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id 
			WHERE tbl_menus_items.men_padre = %s AND tbl_menu_usuario.usr_id = %s AND tbl_menus_items.men_stat = %s 
			ORDER BY men_orden ASC",
			SSQL($dRSmp['men_id'],'int'),
			SSQL($_SESSION['dU']['usr_id'],'int'),
			SSQL(1,'int'));
			$RSmi = mysql_query($qry2) or die(mysql_error());
			$dRSmi = mysql_fetch_assoc($RSmi);
			$tRSmi = mysql_num_rows($RSmi);
			if($tRSmi>0) $cssSM="dropdown"; 
			else $cssSM="";
			if($dRSmp['men_link']) $link = $GLOBALS['RAIZc'].$dRSmp['men_link'];
			else $link = "#";
			if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
			$ret.='<li class="'.$cssSM.'">'; 
			if($tRSmi > 0){
				$ret.='<a href="'.$link.'" class="dropdown-toggle"';
				if($tRSmi > 0){ $ret.='data-toggle="dropdown"';
			}
			$ret.='>';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'];
			if($tRSmi > 0){
				$ret.=' <b class="caret"></b>';
			}
			$ret.='</a>';
			$ret.='<ul class="dropdown-menu">';
			do{
				if($dRSmi['men_link']){ 
					$link = $GLOBALS['RAIZc'].$dRSmi['men_link'];
				}else{
					$link = "#"; 
				}
			if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
			$ret.='<li><a href="'.$link.'">';
			if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
			$ret.=$dRSmi['men_tit'].'</a></li>';
			if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];
			}while($dRSmi = mysql_fetch_assoc($RSmi));
			mysql_free_result($RSmi);
			$ret.='</ul>';
		}else{
			
			$ret.='<a href="'.$link.'">';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'].'</a>';
		}                             	                    
		$ret.='</li>';
		if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
	}while($dRSmp = mysql_fetch_assoc($RSmp));
	mysql_free_result($RSmp);
	}else{
		$ret.='<li>No existen menus para <strong>'.$refMC.'</strong></li>';
	}
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}
//END GENERACION MENU
function detNumConAct($idc,$idp){
	if($idc) $param ='AND con_num<=%s';
	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s '.$param,
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSRtot=mysql_query($qryRTot);
	$row_RSRtot=mysql_fetch_assoc($RSRtot);
	$numRTot=mysql_num_rows($RSRtot);
	if(!$idc) $numRTot++;
	return $numRTot;
}
function gebBtnHis($idc,$idp){
	$qryTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s',
	SSQL($idp,'int'));
	$RStot=mysql_query($qryTot);
	$row_RStot=mysql_fetch_assoc($RStot);
	$numTot=mysql_num_rows($RStot);
	
	$qryRTot=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s AND con_num<=%s',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSRtot=mysql_query($qryRTot);
	$row_RSRtot=mysql_fetch_assoc($RSRtot);
	$numRTot=mysql_num_rows($RSRtot);
	
	$qryIni=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num ASC LIMIT 1',
	SSQL($idp,'int'));
	$RSini=mysql_query($qryIni);
	$row_RSini=mysql_fetch_assoc($RSini);
	$idIni=$row_RSini['con_num'];
	
	$qryFin=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s ORDER BY con_num DESC LIMIT 1',
	SSQL($idp,'int'));
	$RSfin=mysql_query($qryFin);
	$row_RSfin=mysql_fetch_assoc($RSfin);
	$idFin=$row_RSfin['con_num'];
	
	$qryAnt=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num<%s ORDER BY con_num DESC LIMIT 1',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSant=mysql_query($qryAnt);
	$row_RSant=mysql_fetch_assoc($RSant);
	$idAnt=$row_RSant['con_num'];
	
	$qrySig=sprintf('SELECT * FROM db_consultas WHERE pac_cod=%s and con_num>%s ORDER BY con_num ASC LIMIT 1',
	SSQL($idp,'int'),
	SSQL($idc,'int'));
	$RSsig=mysql_query($qrySig);
	$row_RSsig=mysql_fetch_assoc($RSsig);
	$idSig=$row_RSsig['con_num'];

	if($idIni==$idc){
		$cssIni='disabled';
		$cssAnt='disabled';
	}else{
		$link_ini='form.php?idc='.$row_RSini['con_num'];
	}
	if($idFin==$idc){
		$cssFin='disabled';
		$cssSig='disabled';
	}else{
		$link_fin='form.php?idc='.$row_RSfin['con_num'];
	}

	$link_ant='form.php?idc='.$idAnt;
	$link_sig='form.php?idc='.$idSig;
	
	$btn_ini='<a href="'.$link_ini.'" class="btn btn-default btn-sm '.$cssIni.'"><i class="fa fa-fast-backward"></i>';
	$btn_ini.='</a>';
	$btn_fin='<a href="'.$link_fin.'" class="btn btn-default btn-sm '.$cssFin.'"><i class="fa fa-fast-forward"></i>';
	$btn_fin.='</a>';
	$btn_ant='<a href="'.$link_ant.'" class="btn btn-default btn-sm '.$cssAnt.'"><i class="fa fa-step-backward"></i>';
	$btn_ant.='</a>';
	$btn_sig='<a href="'.$link_sig.'" class="btn btn-default btn-sm '.$cssSig.'"><i class="fa fa-step-forward"></i>';
	$btn_sig.='</a>';
	echo $btn_ini.$btn_ant.'<span class="label label-default">'.$numRTot.' / '.$numTot.'</span>'.$btn_sig.$btn_fin;
}


function fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}

function fncImgExist($ruta,$nombre){
	if (!(isset($nombre))) $nombre="error";
	if (file_exists(RAIZ.$ruta.$nombre)){
		$dirImg = $GLOBALS['RAIZ'].$ruta.$nombre;
	} else {
		$dirImg=$GLOBALS['RAIZa'].'images/struct/no_image.jpg';
	}
	return ($dirImg);	
} 

//uploadfile() :: Carga de Archivos al Servidor
function uploadfile($params, $file){
	//Version 1.1
	$code = md5(uniqid(rand()));
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['siz']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['siz']/1024/1024).' MB</h4>';
		else{ // Verifica Permisos de Carpeta, Si Carpeta Existe.
			if(!is_writable($params['pat'])) $LOG.='<h4>Permisos Folder Insuficientes, contacte al Administrador del Sistema</h4>';
			else{// Mueve el archivo a su lugar correpondiente.
				if(!move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $LOG.='<h4>Error al Cargar el Archivo</h4>';
				else{
					$aux_grab=TRUE;
					$LOG.='<p>Archivo Cargado Correctamente</p>';
				}
			}
		}
	}
	$auxres['LOG']=$LOG;
	$auxres['EST']=$aux_grab;
	$auxres['FILE']=$filename;
	return $auxres; 
}

function urlReturn($urlr,$urld=NULL){
//$urlr -> URL para retornar
//$urld -> URL defecto para el Modulo
	$urla=$_SESSION['urlp'];
	$urlc=$_SESSION['urlc'];
	if (($urlr)&&($urlr != $urlc)){
		$urlf=$urlr;
	}else if(($urla)&&($urla != $urlc)){
		$urlf=$urla;
	}else if(($urld)&&($urld != $urlc)){
		$urlf=$urld;
	}else { $urlf=$GLOBALS['RAIZ'].'com_index/'; }
	return $urlf;
}
/*
function vLOG(){
	session_start();
	if(isset($_SESSION['LOG'])) echo '<div id="log">
	<div class="alert alert-warning">
	<button type="button" class="close" data-dismiss="alert">&times;</button>
	'.$_SESSION['LOG'].'</div></div>';
	unset($_SESSION['LOG']);
	unset($_SESSION['LOGr']);
}
*/
//fnc_log() :: Funcions para la visualización de un LOG o mensaje de alerta (se visualiza solamente por 5 segundos)
function sLOG($type='a', $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){
	//SESSION_LOG: Vector ['m']=Mensaje; ['t']=Titulo; ['c']=class, ['i']=imagen
	//echo '<hr>*** '.$_SESSION['LOG']['m'].'***<hr>';
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else $LOG=$_SESSION['LOG'];
	if(!$LOG['c']) $LOG['c']='alert-warning';
	if((isset($LOG['m']))&&($LOG['m'])){
		if($type=='a'){
			$sLog='<div id="log">';
			$sLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
			$sLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
			$sLog.=$LOG['m'];
			$sLog.='</div></div>';
		}else if($type=='g'){
			if($LOG['m']){
			$sLog='<script type="text/javascript">
			logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");</script>';
			}
		}else{
			$sLog='<div>'.$LOG['m'].'</div>';
		}
		echo $sLog;
		unset($_SESSION['LOG']);
		unset($_SESSION['LOG']['m']);
	}
}
function isAuthorized($strUsers, $UserName) { 
  // For security, start by assuming the visitor is NOT authorized. 
  $isValid = False;
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) { 
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { $isValid = true; } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = true; } 
    if (($strUsers == "") && true) { $isValid = true; } 
  } 
  return $isValid; 
}
//FUNCTIONS ACCESS USERS
function vLogin($mSel=NULL){//,$accesscheck=FALSE){
	if($mSel){
		$qry=sprintf('SELECT * FROM tbl_menus_items 
		INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id=tbl_menu_usuario.men_id
		LEFT JOIN db_componentes ON tbl_menus_items.mod_cod=db_componentes.mod_cod
		WHERE tbl_menu_usuario.usr_id=%s AND tbl_menus_items.men_nombre=%s',
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($mSel,'text'));
		$RS=mysql_query($qry);
		$dRS=mysql_fetch_assoc($RS);
		$tRS=mysql_num_rows($RS);
		if($tRS>0) $vVM=TRUE;
		else $vVM=FALSE;
	}else $vVM=TRUE;
	$MM_authorizedUsers = "";
	$MM_donotCheckaccess = "true";
	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
	if (!((isset($_SESSION['MM_Username'])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION['MM_Username'])))) {   
 
	  $MM_qsChar = "?";
	  $MM_referrer = $_SERVER['PHP_SELF'];
	  
	  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
	  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
	  
	  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	  header("Location: ". $MM_restrictGoTo); 
	  exit;
	}
	if($mSel) return($dRS);
}


//BEG FUNCTION LOGIN
function login($username, $password, $accesscheck){
if (isset($username)) {
	$loginUsername=$username;
	$password=md5($password);
	
	if ($accesscheck) $MM_redLS = $accesscheck;
	else $MM_redLS = $GLOBALS['RAIZc']."com_index/";
	$MM_redLF = $GLOBALS['RAIZ']."index.php";
	$MM_redRF = true;
  	
	$qryLOGIN=sprintf("SELECT usr_id, usr_nombre, usr_contrasena, usr_est as EST, usr_theme FROM tbl_usuario WHERE usr_nombre=%s AND usr_contrasena=%s",
	SSQL($loginUsername, "text"), 
	SSQL($password, "text"));
	
	$LoginRS = mysql_query($qryLOGIN) or die(mysql_error());
	$loginFoundUser = mysql_num_rows($LoginRS);
	$row_LoginRS = mysql_fetch_assoc($LoginRS);
	if ($loginFoundUser) {
		if($row_LoginRS['EST']==1){
			if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
			$_SESSION['autentificacion']=TRUE;
			$_SESSION['dU']=$row_LoginRS;
			$_SESSION['MM_Username'] = $loginUsername;
			$_SESSION['MM_UserID'] = $row_LoginRS['usr_id'];
			$_SESSION['MM_UserAUD'] = $row_LoginRS['id_aud'];
			$_SESSION['bsTheme'] = $row_LoginRS['usr_theme'];
			$id_aud=AUD($_SESSION['MM_UserAUD'],NULL,'sysacc');
			$tLOG='<h4>Usuario Identificado</h4>';
			header("Location: ".$MM_redLS.'?LOG='.$tLOG);
		}else{
			$tLOG='<h4>Usuario Deshabilitado</h4>Comuniquese con el Administrador';
			header("Location: ".$MM_redLF.'?LOG='.$tLOG);
		}
	}else{
		$tLOG='<h4>Error de Nombre de Usuario - Contraseña</h4>Intente de nuevo';
		header("Location: ".$MM_redLF.'?LOG='.$tLOG);
	}
	
}//END IF username
}
//END FUNCTION LOGIN

//SI EL USUARIO NO SE HA LOGEADO REDIRECCIONA A wrong-access.php
function fnc_autentificacion(){
	if(!$_SESSION['autentificacion'])
		header('Location: '.$MM_redirectLoginFailed);		 
}

//Funcion Validar URL
function fnc_datURLv($urlactual,$usr_id){
	//include(RUTAcon.'conexion-mysql.php');
	$sql = sprintf('SELECT * FROM tbl_menus 
	inner join tbl_menu_usuario on tbl_menus.men_id=tbl_menu_usuario.men_id
	where usr_id =%s and men_link LIKE  %s',
	SSQL($usr_id,'int'),
	SSQL("%".$urlactual,"text"));
	$query = mysql_query($sql) or die(mysql_error());
	$row = mysql_fetch_assoc($query);
	return $row;
	mysql_free_result($query);

}





?>