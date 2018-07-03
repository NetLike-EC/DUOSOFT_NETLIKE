<?php
function edadC($dateBorn){
	if($dateBorn){
	$dateAct = $GLOBALS['sdate']; // separamos en partes las fechas 
	$array_nacimiento = explode ( "-", $dateBorn ); 
	$array_actual = explode ( "-", $dateAct ); 
	$anos =  $array_actual[0] - $array_nacimiento[0]; // calculamos años 
	$meses = $array_actual[1] - $array_nacimiento[1]; // calculamos meses 
	$dias =  $array_actual[2] - $array_nacimiento[2]; // calculamos días 
	//ajuste de posible negativo en $días 
	if ($dias<0){
		--$meses; 
		//ahora hay que sumar a $dias los dias que tiene el mes anterior de la fecha actual 
		switch ($array_actual[1]) { 
			   case 1:     $dias_mes_anterior=31; break; 
			   case 2:     $dias_mes_anterior=31; break; 
			   case 3:  
					if (bisiesto($array_actual[0])) 
					{ 
						$dias_mes_anterior=29; break; 
					} else { 
						$dias_mes_anterior=28; break; 
					} 
			   case 4:     $dias_mes_anterior=31; break; 
			   case 5:     $dias_mes_anterior=30; break; 
			   case 6:     $dias_mes_anterior=31; break; 
			   case 7:     $dias_mes_anterior=30; break; 
			   case 8:     $dias_mes_anterior=31; break; 
			   case 9:     $dias_mes_anterior=31; break; 
			   case 10:     $dias_mes_anterior=30; break; 
			   case 11:     $dias_mes_anterior=31; break; 
			   case 12:     $dias_mes_anterior=30; break; 
		}
		$dias=$dias + $dias_mes_anterior; 
	} 
	//ajuste de posible negativo en $meses 
	if ($meses<0){
		--$anos; 
		$meses=$meses + 12; 
	}
	$ret=$anos." años <br> ".$meses." meses <br> ".$dias." días ";
	}else $ret;
	return($ret);
}

function bisiesto($anio_actual){ 
    $bisiesto=false; 
    //probamos si el mes de febrero del año actual tiene 29 días 
      if (checkdate(2,29,$anio_actual)) 
      { 
        $bisiesto=true; 
    } 
    return $bisiesto; 
}
function fnc_cutblanck($bus){
	if (substr($bus,0,1)==' ') $bus=substr($bus,1,strlen($bus));
	if (substr($bus,strlen($bus) - 1,1)==' ') $bus=substr($bus, 0, strlen($bus) - 1);
	return($bus);
}
function edad($edad){
	if($edad){
		list($Y,$m,$d) = explode("-",$edad);
		return( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
	}else return '-';
}
function dTyp($param){
	Global $conn;
	$qry = sprintf("SELECT * FROM  db_types WHERE typ_cod=%s",SSQL($param,'text'));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); 
	$dRS = mysqli_fetch_assoc($RS); 
	mysqli_free_result($RS);return ($dRS);
}

function genLink($link,$txt,$css=NULL,$params=NULL){//v.1.1 -> duotics-lib
	$firstP=TRUE;
	if($params){
		foreach($params as $x => $xVal) {
			if($firstP==TRUE){
				$lP.='?'.$x.'='.$xVal;
				$firstP=FALSE;
			}else $lP.='&'.$x.'='.$xVal;
		}
	}
	$st='<a href="'.$link.$lP.'" class="'.$css.'">'.$txt.'</a>';
	return $st;
}
function startConfigs(){
	if(!($_SESSION['conf'])){
		//$conf=parse_ini_file(RAIZs.'config.ini',TRUE);
		if(!$_SESSION['lang']) $_SESSION['lang']='en';
		$conf=parse_ini_file(RAIZs.'lang/'.$_SESSION['lang'].'.ini',TRUE);
		foreach($conf as $x => $xval){
			foreach($xval as $y => $yval) $configEnd[$x][$y]=$yval;
		}
		$_SESSION['conf']=$configEnd;
	}
}
//Conpara si 2 URL son iguales, returna TRUE si son iguales
function compUrl($url1,$url2){
	if($url1==$url2) return TRUE;
	else return FALSE;
}
function mysqli_result($res, $row, $field=0){//v.0.1 -> duotics_lib
    $res->data_seek($row); 
    $datarow = $res->fetch_array(); 
    return $datarow[$field]; 
}
function cLOG($data){//v.0.2 -> duotics_lib
  echo '<script>';
  echo 'console.log('. json_encode( $data ) .')';
  echo '</script>';
}

function vLogin($mSel=NULL){//v.0.3 -> duotics_libs :: pending update to source library
	//echo 'function. msel. '.$mSel.'<br>';
	Global $conn;
	$res=FALSE;
	$vVM=FALSE;
	if($_SESSION['dU']['LEVEL']!=0){
		//echo 'NO LEV0. <br>';
		//$LOGd.='LEVEl 0<br>';
		if($mSel){
			//echo 'menSel. ';
			//$LOGd.="Men Sel $mSel<br>";
			$qry=sprintf('SELECT * FROM tbl_menus_items 
			INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id=tbl_menu_usuario.men_id
			LEFT JOIN db_componentes ON tbl_menus_items.mod_cod=db_componentes.mod_cod
			WHERE tbl_menu_usuario.usr_id=%s AND tbl_menus_items.men_nombre=%s',
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($mSel,'text'));
			echo $qry.'<br>';
			$RS=mysqli_query($conn,$qry);
			$dRS=mysqli_fetch_assoc($RS);
			$tRS=mysqli_num_rows($RS);
			if($tRS>0) $vVM=TRUE;
		}else{
			//echo 'NO menSel. ';
			$vVM=TRUE;
		}
	}else{
		//echo 'LEV0. <br>';
		if($mSel){
			//echo 'menSel. '.$mSel.'<br>';
			$detMenS=detRow('tbl_menus_items','men_nombre',$mSel);
			//var_dump($detMenS);
			//echo '<br>';
			$dRS=detRow('db_componentes','mod_cod',$detMenS['mod_cod']);
			$dM[id]=$dRS[mod_cod];
			$dM[nom]=getLangT('db_componentes','mod_nom',$dRS[mod_cod],$_SESSION['lang']);
			$dM[des]=getLangT('db_componentes','mod_des',$dRS[mod_cod],$_SESSION['lang']);
			$dM[ico]=$dRS[mod_icon];
			$dM[ref]=$dRS[mod_ref];
		}
		//echo 'LEV another. ';
		$LOGd.='LEVEl Another<br>';
	}
	
	$MM_authorizedUsers = "";
	$MM_donotCheckaccess = "true";
	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
	//echo 'before is autorized<br>';
	//if (!((isset($_SESSION['MM_Username'])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION['MM_Username'])))) {   
	$isAuth=isAuthorized("",$MM_authorizedUsers, $_SESSION['dU']['USER'], $_SESSION['dU']['LEVEL']);
	//echo 'after is autorized<br>';
	
	
	
	if (!((isset($_SESSION['dU']['USER'])))) {
		//echo 'NO MM_Username. '.$_SESSION['dU']['USER'].'<br>';
			if(!$vVM){
				//echo 'NO vVM. '.$vVM.'<br>';
				if(!$isAuth){
					//echo 'NO isAuth. '.$isAuth.'<br>';
					//echo 'NO AUTH<br>';
					$res=TRUE;
				  	$MM_qsChar = "?";
				  	$MM_referrer = $_SERVER['PHP_SELF'];

				  	if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
				  	if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
					$MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
	  				header("Location: ". $MM_restrictGoTo); 
	  				exit;
				}else{
					//echo 'NO isAuth. '.$isAuth.'<br>';
				}
			}else{
				//echo 'NO vVM. '.$vVM.'<br>';
			}
	}else{
		//echo 'YES MM_Username. '.$_SESSION['dU']['USER'].'<br>';
		$res=FALSE;
		//echo 'SI AUTH<br>';
	}
	
	//echo 'Auth. '.$res;
	return($dM);
	echo $LOGd;
}

function vLogin_old($mSel=NULL){//v.0.1
	//,$accesscheck=FALSE){
	Global $conn;
	$vVM=NULL;
	if($mSel){
		echo 'si $mSel. '.$mSel;
		$qry=sprintf('SELECT * FROM tbl_menus_items 
		INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id=tbl_menu_usuario.men_id
		LEFT JOIN db_componentes ON tbl_menus_items.mod_cod=db_componentes.mod_cod
		WHERE tbl_menu_usuario.usr_id=%s AND tbl_menus_items.men_nombre=%s',
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($mSel,'text'));
		$RS=mysqli_query($conn,$qry);
		$dRS=mysql_fetch_assoc($RS);
		$tRS=mysql_num_rows($RS);
		if($tRS>0) $vVM=TRUE;
		else $vVM=FALSE;
	}else{
		$vVM=TRUE;
		echo 'no $mSel. ';
	}
	
	$MM_authorizedUsers = "";
	$MM_donotCheckaccess = "true";
	$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
	
	if (!((isset($_SESSION['MM_Username'])) && ($vVM) && (isAuthorized($MM_authorizedUsers, $_SESSION['MM_Username'])))) {
 		echo 'entra al if';
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



//VERIFY LOGIN USER ACCESS NORMAL
function fnc_accessnorm(){
if (!isset($_SESSION)) session_start(); 
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";
$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
}
//VERIFY LOGIN USER ACCESS LEVEL
function fnc_accesslev($levelaccess){
if (!isset($_SESSION)) session_start();
if (isset($levelaccess))
$MM_authorizedUsers = $levelaccess;
$MM_donotCheckaccess = "false";
$MM_restrictGoTo = $GLOBALS['RAIZ']."wrongaccess.php";
if (!((isset($_SESSION['MM_Username'])) && (isAuthorized("",$MM_authorizedUsers, $_SESSION['MM_Username'], $_SESSION['MM_UserGroup'])))) {   
  $MM_qsChar = "?";
  $MM_referrer = $_SERVER['PHP_SELF'];
  if (strpos($MM_restrictGoTo, "?")) $MM_qsChar = "&";
  if (isset($_SERVER['QUERY_STRING']) && strlen($_SERVER['QUERY_STRING']) > 0) 
  $MM_referrer .= "?" . $_SERVER['QUERY_STRING'];
  $MM_restrictGoTo = $MM_restrictGoTo. $MM_qsChar . "accesscheck=" . urlencode($MM_referrer);
  header("Location: ". $MM_restrictGoTo); 
  exit;
}
}
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized3($strUsers, $UserName) { 
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
function isAuthorized($strUsers, $strGroups, $UserName=NULL, $UserGroup=NULL) {
	//echo 'function isAuthorized. <br>';
	// For security, start by assuming the visitor is NOT authorized. 
  $isValid = FALSE; 
  // When a visitor has logged into this site, the Session variable MM_Username set equal to their username. 
  // Therefore, we know that a user is NOT logged in if that Session variable is blank. 
  if (!empty($UserName)) {
	  
    // Besides being logged in, you may restrict access to only certain users based on an ID established when they login. 
    // Parse the strings into arrays. 
    $arrUsers = Explode(",", $strUsers); 
    $arrGroups = Explode(",", $strGroups); 
    if (in_array($UserName, $arrUsers)) { $isValid = TRUE; } 
    // Or, you may restrict access to only certain users based on their username. 
    if (in_array($UserGroup, $arrGroups)) { $isValid = TRUE; } 
    if (($strUsers == "") && TRUE) { $isValid = TRUE; } 
  }
	//echo 'isValid. '.$isValid;
	//echo 'end function isAuthorized. <br>';
  return $isValid;
	
}

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized_old($strUsers, $UserName) {
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
//
//LOGIN TO SYSTEM
function login($loginUsername, $loginPassword, $accesscheck){//v.1.2
	Global $conn;
	$vL=FALSE;
	if (isset($loginUsername)) {
		$LOGd.='TRUE $loginUsername. '.$loginUsername;
		//session_start();
		$loginPassword=md5($loginPassword);
		
		if ($accesscheck) $MM_redLS = $accesscheck;
		else $MM_redLS = $GLOBALS['RAIZc']."com_index/";
		$MM_redLF = $GLOBALS['RAIZ']."index.php";
		$MM_redRF = true;
		
		$qry=sprintf("SELECT user_id as ID, user_username as USER, user_password as PASS, user_status as EST, 
		user_level as LEVEL, user_theme as THEME, user_lang as LANG, id_aud as AUD
		FROM tbl_user_system WHERE user_username=%s AND user_password=%s",
						  SSQL($loginUsername, "text"), 
						  SSQL($loginPassword, "text"));
		$LoginRS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$loginFoundUser = mysqli_num_rows($LoginRS);
		$dLoginRS = mysqli_fetch_assoc($LoginRS);
		if ($loginFoundUser) {
			if($dLoginRS['EST']==1){
				if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
				$_SESSION['autentificacion']=TRUE;
				$_SESSION['dU']=$dLoginRS;
				$_SESSION['MM_Username'] = $loginUsername;
				$_SESSION['MM_UserID'] = $dLoginRS['ID'];
				$_SESSION['MM_UserAUD'] = $dLoginRS['AUD'];
				$_SESSION['MM_UserLEV'] = $dLoginRS['LEV'];
				$_SESSION['bsTheme'] = $dLoginRS['THEME'];
				$_SESSION['lang']=$dLoginRS['LANG'];
				$id_aud=AUD($_SESSION['MM_UserAUD'],NULL,'sysacc');

				startConfigs();
				
				$vL=TRUE;
				$LOG='<h4>Usuario Identificado</h4>';
			}else $LOG='<h4>Usuario Deshabilitado</h4>Comuniquese con el Administrador';
		}else $LOG='<h4>Error de Nombre de Usuario - Contraseña</h4>Intente de nuevo';
		//echo $LOG;
		if($vL){//Login TRUE
			header("Location: ".$MM_redLS.'?LOG='.$LOG);
		}else{//Login False
			header("Location: ".$MM_redLF.'?LOG='.$LOG);
		}
	}
}

//Guarda Acceso de Usuarios al Sistema
function fnc_acces_usersys($param1){
	$accessDate=date('Y-m-d H:i:s',time() - 3600);
	$_SESSION['data_access']=$accessDate;
	$accessIp=getRealIP();
	$qryINS=sprintf('INSERT INTO tbl_user_access (user_cod, access_datet, access_ip) VALUES (%s, %s, %s)',
	SSQL($param1,'int'),
	SSQL($accessDate,'text'),
	SSQL($accessIp,'text'));
	mysql_query($qryINS)or die(mysql_error());
}
//
function genPageHead($MOD, $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$pullR=NULL){//v.0.3
	$banMod=FALSE;
	if($MOD){
		$rowMod=detMod($MOD);
		if($rowMod){$banMod=TRUE;}
	}
	if ($banMod==FALSE){
		$rowMod['mod_nom']=$tit;
		$rowMod['mod_cod']=$id;
		$rowMod['mod_des']=$des;
		$rowMod['mod_icon']=$icon;
	}
	$returnTit;
	$returnTit.='<div class="page-header">';
	if ($pullL) $returnTit.='<div class="pull-left">'.$pullL.'</div>';
    $returnTit.='<'.$tag.'>';
	if($rowMod['mod_icon']){ $returnTit.=' <i class="'.$rowMod['mod_icon'].'"></i> ';	}
	if($id){ $returnTit.=' <span class="label label-primary">'.$rowMod['mod_cod'].'</span> ';	}
	$returnTit.=$rowMod['mod_nom'];
    $returnTit.=' <small>'.$rowMod['mod_des'].'</small>';
	$returnTit.='</'.$tag.'>';
	if ($pullR) $returnTit.='<div class="pull-right">'.$pullR.'</div>';
	$returnTit.='</div>';
	
	return $returnTit;
}

function genPageHeader($MOD, $tip='header',$tag='h1', $param=NULL, $pullL=NULL, $pullR=NULL){//duotics_lib->v.1.0
	//var_dump($param);
	$banMod=FALSE;
	if($MOD){
		$dM=detMod($MOD);
		if($dM){
			$banMod=TRUE;
			$dM['nom']=getLangT('db_componentes','mod_nom',$dM[mod_cod],$_SESSION['lang']);
			$dM['des']=getLangT('db_componentes','mod_des',$dM[mod_cod],$_SESSION['lang']);
			$dM['icon']=$dM['mod_icon'];
		}
	}else $banMod=FALSE;
		
	if(!$banMod){
		//echo 'NO param. <br>';
		if($param['id']) $dM['id']=$param['id'];
		if($param['nom']) $dM['nom']=$param['nom'];
		if($param['des']) $dM['des']=$param['des'];
		if($param['icon']) $dM['icon']=$param['icon'];
		//var_dump($dM);
	}//else echo 'SI param. <br>';
	//var_dump($dM);
	//echo '<br>*tip. '.$tip.'<br>';
	$ret;
	switch($tip){
		case 'header':
			//$ret.'header';
			$ret.='<div class="page-header">';
			if ($pullL) $ret.='<div class="pull-left">'.$pullL.'</div>';
			if ($pullR) $ret.='<div class="pull-right">'.$pullR.'</div>';
			if(!$tag) $tag='h1';
			$ret.='<'.$tag.'>';
			if($dM['icon']) $ret.=' <i class="'.$dM['icon'].'"></i> ';
			if($param['id']) $ret.=' <span class="label label-default">'.$dM['id'].'</span> ';
			$ret.=$dM['nom'];
			$ret.=' <small>'.$dM['des'].'</small>';
			$ret.='</'.$tag.'>';
			$ret.='</div>';
			//echo 'fin header<br>';
		break;
		case 'navbar':
			$ret.'navbar';
			$ret.='<nav class="navbar navbar-default">';
			$ret.='<div class="container-fluid">';
			$ret.='<div class="navbar-header">';
			$ret.='<a class="navbar-brand" href="#">'.$dM['nom'];
			$ret.=' <small class="label label-default">'.$dM['des'].'</small></a>';
			$ret.='</div>';
			$ret.='</div></nav>';
		break;
		default:
			$ret.='<div>';
			if($id) $ret.=' <span class="label label-default">'.$dM['id'].'</span> ';
			$ret.=$dM['nom'];
			$ret.='<div>';
		break;
	}
	return $ret;
}

function genPageHeader_old($MOD, $tip='page-header', $tit=NULL, $tag='h1', $id=NULL, $des=NULL,$icon=NULL,$pullL=NULL,$pullR=NULL){//duotics_lib->v.0.5
	$banMod=FALSE;
	if($MOD){
		$dM=detMod($MOD);
		if($dM) $banMod=TRUE;
	}
	if(!$banMod){
		$dM['mod_nom']=$tit;
		$dM['mod_cod']=$id;
		$dM['mod_des']=$des;
		$dM['mod_icon']=$icon;
	}
	//echo 'tip. '.$tip.'<br>';
	$ret;
	switch($tip){
		case 'header':
			$ret.='<div class="page-header">***';
			if ($pullL) $ret.='<div class="pull-left">'.$pullL.'</div>***';
			$ret.='<'.$tag.'>';
			if($dM['mod_icon']) $ret.=' <i class="'.$dM['mod_icon'].'"></i> ';
			if($id) $ret.=' <span class="label label-default">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.=' <small>'.$dM['mod_des'].'</small>';
			if ($pullR) $ret.='<div class="pull-right">'.$pullR.'</div>';
			$ret.='</'.$tag.'>';
			
			$ret.='</div>';
		break;
		case 'navbar':
			$ret.='<nav class="navbar navbar-default">';
			$ret.='<div class="container-fluid">';
			$ret.='<div class="navbar-header">';
			$ret.='<a class="navbar-brand" href="#">'.$dM['mod_nom'];
			$ret.=' <small class="label label-default">'.$dM['mod_des'].'</small></a>';
			$ret.='</div>';
			$ret.='</div></nav>';
		break;
		default:
			$ret.='<div>';
			if($id) $ret.=' <span class="label label-default">'.$dM['mod_cod'].'</span> ';
			$ret.=$dM['mod_nom'];
			$ret.='<div>';
		break;
	}
	return $ret;
}

function getLangT($table,$field,$idr,$lang){
	$detLT=detRow('db_lang_table','table_name',$table);
	if($detLT){
		$idt=$detLT[id];

		$paramsN=NULL;//REINICIAR EL $paramsN siempre ya que si entra a un bucle se almacena y da error
		$paramsN[]=array(
			array("cond"=>"AND","field"=>"idt","comp"=>"=","val"=>$idt),
			array("cond"=>"AND","field"=>"field_name","comp"=>'=',"val"=>$field),
			array("cond"=>"AND","field"=>"idr","comp"=>'=',"val"=>$idr),
			array("cond"=>"AND","field"=>"lang","comp"=>'=',"val"=>$lang),
		);
		$detT=detRowNP('db_lang_txt',$paramsN);
		$ret=$detT['txt'];
	}
	return $ret;
}

//GENERACION DE MENUS CON NIVELES Y LENGUAJES
function genMenu($refMC,$css=NULL,$vrfUL=TRUE){//v.3.0
	Global $conn;
	Global $RAIZ;
	//verifico si el menu existe
	$dMC=detRow('tbl_menus','ref',$refMC);
	if($dMC){
		//Consulta si el usuario es SuperAdmin
		if($_SESSION['dU']['LEVEL']!=0){
			$userJoin=' INNER JOIN tbl_menu_usuario ON tbl_menus_items.men_id = tbl_menu_usuario.men_id ';
			$userLevel=' AND tbl_menu_usuario.usr_id ='.$_SESSION['dU']['ID'];
		}
		//Consulta para Menus Principales
		$qry=sprintf("SELECT * FROM tbl_menus_items ".
		$userJoin.
		"INNER JOIN tbl_menus on tbl_menus_items.men_idc=tbl_menus.id 
		WHERE tbl_menus.ref = %s 
		AND tbl_menus_items.men_padre = %s ".
		$userLevel.
		" AND tbl_menus_items.men_stat = %s 
		ORDER BY men_orden ASC",
		SSQL($refMC,'text'),
		SSQL('0','int'),
		SSQL('1','text'));
		
		$RSmp = mysqli_query($conn,$qry) or die(mysqli_error($conn));
		$dRSmp = mysqli_fetch_assoc($RSmp);
		$tRSmp = mysqli_num_rows($RSmp);
		//echo $qry;
		//
		if($tRSmp > 0){
			do{
				$detMenuTopLang_tit=getLangT('tbl_menus_items','men_tit',$dRSmp['men_id'],$_SESSION['lang']);
				//Consulta para Submenus
				$qry2 = sprintf("SELECT * FROM tbl_menus_items WHERE tbl_menus_items.men_padre = %s AND tbl_menus_items.men_stat = %s ORDER BY men_orden ASC",
				SSQL($dRSmp['men_id'],'int'),
				SSQL(1,'int'));
				$RSmi = mysqli_query($conn,$qry2) or die(mysqli_error($conn));
				$dRSmi = mysqli_fetch_assoc($RSmi);
				$tRSmi = mysqli_num_rows($RSmi);
				
				if($tRSmi>0) $cssSM="dropdown"; 
				else $cssSM="";
				if($dRSmp['men_link']) $link = $RAIZ.$dRSmp['men_link'];
				else $link = "#";
				if($dRSmp['men_precode']) $ret.=$dRSmp['men_precode'];
				$ret.='<li class="'.$cssSM.' '.$dRSmp['men_css'].'" style="'.$dRSmp['men_sty'].'">';
				if($tRSmi > 0){
					$ret.='<a href="'.$link.'" class="dropdown-toggle"';
					if($tRSmi > 0){ 
						$ret.='data-toggle="dropdown"';
					}
					$ret.='>';
					if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
					$ret.=$detMenuTopLang_tit;
					if($tRSmi > 0){
						$ret.=' <b class="caret"></b>';
					}
					$ret.='</a>';
					$ret.='<ul class="dropdown-menu">';
					do{
						$detMenuSecLang_tit=getLangT('tbl_menus_items','men_tit',$dRSmi['men_id'],$_SESSION['lang']);//TEXT according to language
						if($dRSmi['men_link']){ 
							$link = $RAIZ.$dRSmi['men_link'];
						}else{
							$link = "#"; 
						}
						if($dRSmi['men_precode']) $ret.=$dRSmi['men_precode'];
						$ret.='<li><a href="'.$link.'" class="'.$dRSmi['men_css'].'">';

						if($dRSmi['men_icon']) $ret.='<i class="'.$dRSmi['men_icon'].'"></i> ';
						//if(!$dRSmi['titv']) $dRSmi['titv']=$dRSmi['men_tit'];
						//$ret.=$dRSmi['titv'].'</a></li>';
						$ret.=$detMenuSecLang_tit.'</a></li>';

						if($dRSmi['men_postcode']) $ret.=$dRSmi['men_postcode'];

					}while($dRSmi = mysqli_fetch_assoc($RSmi));
					mysqli_free_result($RSmi);
					$ret.='</ul>';
				}else{
					$ret.='<a href="'.$link.'">';
					if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
					$ret.=$detMenuTopLang_tit.'</a>';
				}                             	                    
				$ret.='</li>';
				if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
		}while($dRSmp = mysqli_fetch_assoc($RSmp));
		mysqli_free_result($RSmp);
		}else{
			$ret.='<li>No items in menu <strong>'.$refMC.'</strong></li>';
		}
	}else $ret.='<li>No existe menu <strong>'.$refMC.'</strong></li>';
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

function genMenu_old($refMC,$css=NULL,$vrfUL=TRUE){//v.0.1
	//Consulta para Menus Principales
	Global $conn;
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
	$RSmp = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRSmp = mysqli_fetch_assoc($RSmp);
	$tRSmp = mysqli_num_rows($RSmp);
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
			$RSmi = mysqli_query($conn,$qry2) or die(mysqli_error($conn));
			$dRSmi = mysqli_fetch_assoc($RSmi);
			$tRSmi = mysqli_num_rows($RSmi);
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
			}while($dRSmi = mysqli_fetch_assoc($RSmi));
			mysqli_free_result($RSmi);
			$ret.='</ul>';
		}else{
			
			$ret.='<a href="'.$link.'">';
			if($dRSmp['men_icon']) $ret.='<i class="'.$dRSmp['men_icon'].'"></i> ';
			$ret.=$dRSmp['men_tit'].'</a>';
		}                             	                    
		$ret.='</li>';
		if($dRSmp['men_postcode']) $ret.=$dRSmp['men_postcode'];
	}while($dRSmp = mysqli_fetch_assoc($RSmp));
	mysqli_free_result($RSmp);
	}else{
		$ret.='<li>No existen menus para <strong>'.$refMC.'</strong></li>';
	}
	//Verifica si solicito UL, si no devolveria solo LI
	if($vrfUL) $ret='<ul class="'.$css.'">'.$ret.'</ul>';
	return $ret;
}

function uploadfile($file, $params){// v.1.3
	$code = md5($GLOBALS['sdatet']);
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['size']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['size']/1024/1024).' MB</h4>';
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

function uploadfile_old($file, $params){
	//Version 1.1
	$code = md5($GLOBALS['sdatet']);
	$prefijo = $params['pre'].'_'.$code;
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=FALSE;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	// Verifica si la extension es valida
	if(!in_array($ext,$params['ext'])) $LOG.='<h4>Archivo no valido</h4>';
	else{ // Verifica el tamaño maximo
		if(filesize($file['tmp_name']) > $params['size']) $LOG.='<h4>Archivo Demasiado Grande :: maximo '.($params['size']/1024/1024).' MB</h4>';
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

function genUrlFriendly($url) {
	$url = strtolower($url);// Tranformamos todo a minusculas
	$find = array('á', 'é', 'í', 'ó', 'ú', 'ñ');
	$repl = array('a', 'e', 'i', 'o', 'u', 'n');
	$url = str_replace ($find, $repl, $url);//Rememplazamos caracteres especiales latinos
	$find = array(' ', '&', '\r\n', '\n', '+'); 
	$url = str_replace ($find, '-', $url);// Añaadimos los guiones
	$find = array('/[^a-z0-9\-<>]/', '/[\-]+/', '/<[^>]*>/');
	$repl = array('', '-', '');
	$url = preg_replace ($find, $repl, $url);// Eliminamos y Reemplazamos demás caracteres especiales
	return $url;
}

function genSelect($nom=NULL, $RS, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni="Select"){//v.4.0
	/* PARAMS
	$nom. attrib 'name' for <select>
	$RS. Data Recordset; need two parameters: sID, sVAL
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	if($RS){
	$dRS = mysqli_fetch_assoc($RS);
	$tRS = mysqli_num_rows($RS);
		
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value="'.$valIni.'"';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$nomIni.'</option>';	
	}
	
	if($tRS>0){
	do {
		$grpAct=$dRS['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$dRS['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$dRS['sID'].'"'; 
		if(is_array($sel)){ if(in_array($dRS['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($dRS['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$dRS['sVAL'].'</option>';
	} while ($dRS = mysqli_fetch_assoc($RS));
	if($banG==true) echo '</optgroup>';
	$rows = mysqli_num_rows($RS);
	if($rows > 0) {
		mysqli_data_seek($RS, 0);
		$dRSe = mysqli_fetch_assoc($RS);
	}
	}
	echo '</select>';
	
	mysqli_free_result($RS);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}

function genSelectManual($nom=NULL, $data, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE, $valIni=NULL, $nomIni='Select'){
	//Version 3.2 
	/* PARAMS
	$nom. attrib 'name' for <select>
	$data. Data Recordset
	$sel. Value Selected
	$class. attrib 'class' for <select>
	$opt. optional attrib
	$id. attrib 'id' for <select>
	$placeholder. attrib 'placeholder' for <select>
	$showIni. view default value
	$valIni. value of default value
	$nomIni. name of default value
	*/
	if($data){	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>'.$valIni.'</option>';	
	}
	foreach($data as $xid => $xval){
		echo '<option value="'.$xval.'"'; 
		if(is_array($sel)){ if(in_array($xval,$sel)) echo 'selected="selected"'; }
		else{ if (!(strcmp($xval, $sel))) echo 'selected="selected"'; }
		echo '>'.$xid.'</option>';
	}
	echo '</select>';
	}else{
		echo '<span class="label label-danger">Error genSelectManual : '.$nom.'</span>';
	}
}

//FUNCION AUDITORIA AUD v.2.0 (2015-07-07)
function AUD($id=NULL,$des=NULL,$eve=NULL){
	Global $conn;
	//Generación Descrición ($des), dependiendo del Evento ($eve)
	switch ($eve) {
    	case 'sysacc':{
			$_SESSION['data_access']=$GLOBALS['sdatet'];
			$des='IP. '.getRealIP();
			break;
		}
		default:{
			
		}
	}
	//Pregunto si existe id_aud ($id)
	if($id){
		//Pregunto Si db_auditoria Existente
		$detAud=detRow('db_auditoria','id_aud',$id);
		if($detAud){
			$id_aud=$detAud['id_aud'];
			//INSERTO db_auditoria_Detalle
			$qry=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
			SSQL($id,'int'),
			SSQL($_SESSION['MM_UserID'],'int'),
			SSQL($GLOBALS['sdatet'],'text'),
			SSQL($eve,'text'),
			SSQL($des,'text'));
			mysqli_query($conn,$qry);
		}
	}else{
		//INSERT db_auditoria
		$qryAud=sprintf('INSERT INTO db_auditoria (aud_datet) 
		VALUES (%s)',
		SSQL($GLOBALS['sdatet'],'text'));
		mysqli_query($conn,$qryAud);
		$id_aud=mysqli_insert_id($conn);
		
		//INSERT db_auditoria_detalle
		$qryAudDet=sprintf('INSERT INTO db_auditoria_detalle (id_aud, user_cod, audd_datet, audd_eve, audd_des) VALUES (%s,%s,%s,%s,%s)',
		SSQL($id_aud,'int'),
		SSQL($_SESSION['MM_UserID'],'int'),
		SSQL($GLOBALS['sdatet'],'text'),
		SSQL($eve,'text'),
		SSQL($des,'text'));
		mysqli_query($conn,$qryAudDet);
	}
	return($id_aud);
}

//Form Params
function getParamSQL($params){
	$pl= count($params);
	for($x = 0; $x < $pl; $x++) {
    	$qryParam.=' AND '.$params[$x][0].$params[$x][1].$params[$x][2];
	}
	echo '<hr><hr><hr>- '.$qryParam.'<hr>';
	return $qryParam;
}

function getParamSQLA($params){
	if($params){
		foreach($params as $val){
			if(!$val[3]) $val[3]=' AND ';
			$qryParam.=$val[3].' '.$val[0].' '.$val[1].' "'.$val[2].'"';
		}
	}
	return $qryParam;
}

function getParamSQLcond($params){
	if($params){
		foreach($params as $val){
			$qryParam.=' '.$val[3].' '.$val[0].$val[1].$val[2];
		}
	}
	return $qryParam;
}

function totRowsTabP($table,$param=NULL){//v.2.0
	Global $conn;
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s WHERE 1=1 %s',
	SSQL($table,''),
	SSQL($param,''));
	$RS = mysqli_query($conn,stripslashes($qry)) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	return ($dRS['TR']);
}


//TOT ROWS table
function totRowsTabP_ant($table,$param=NULL){
	$qry = sprintf('SELECT * FROM %s WHERE 1=1 ',
	SSQL($table,''));
	$qry.=$param;
	//echo "<hr>-TRTP. ".$qry."<hr>";
	$RS = mysql_query($qry) or die(mysql_error().'XQ ???');
	//echo '<hr>ERROR RS ?<hr>';
	$dRS = mysql_fetch_assoc($RS);
	//echo '<hr>ERROR dRS ?<hr>';
	$trRS = mysql_num_rows($RS);
	//echo '<hr>ERROR trRS ?<hr>';
	//echo "<hr>* TR. ".$trRS.'<hr>';
	return ($trRS);
	
}

//TOT ROWS table ANT
function totRowsTab_old($table,$field,$param,$cond='='){
	Global $conn;
	$qry = sprintf('SELECT * FROM %s WHERE %s%s%s',
	SSQL($table,''),
	SSQL($field,''),
	SSQL($cond,''),
	SSQL($param,'text'));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	$trRS = mysqli_num_rows($RS);
	return ($trRS);
}

function totRowsTab($table,$field=NULL,$param=NULL,$cond='='){//v.2.0
	Global $conn;
	if(($field)&&($param)){
		$qryCond=sprintf(' WHERE %s %s %s',
						SSQL($field,''),
						SSQL($cond,''),
						SSQL($param,'text'));
	}
	$qry = sprintf('SELECT COUNT(*) AS TR FROM %s '.$qryCond,
	SSQL($table,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	return ($dRS['TR']);/*SHow me a integer value (count) of parameters*/
}

function detRowGSel($table,$fieldID,$fieldVal,$field,$param,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v1.1
	Global $conn;
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	//$qry = sprintf('SELECT %s as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
	$qry = sprintf('SELECT '.$fieldVal.' as sVAL, %s AS sID FROM %s WHERE %s=%s %s',
	//SSQL($fieldVal,''),
	SSQL($fieldID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'),
	SSQL($orderBy,''));
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); 
	return ($RS); mysqli_free_result($RS);
}

function detRowGSelNP($table,$fieldID,$fieldVal,$params,$ord=FALSE,$valOrd=NULL,$ascdes='ASC'){//v0.1
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal){
				$lP.=sprintf('%s %s %s %s',
							SSQL($xVal['cond'],''),
							SSQL($xVal['field'],''),
							SSQL($xVal['comp'],''),
							SSQL($xVal['val'],'text'));
			}
		}
	}
	if($ord){
		if(!($valOrd)) $orderBy='ORDER BY '.' sVAL '.$ascdes;
		else $orderBy='ORDER BY '.$valOrd.' '.$ascdes;
	}
	$qry = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE 1=1 '.$lP.' %s',
	SSQL($fieldID,''),
	SSQL($fieldVal,''),
	SSQL($table,''),
	//SSQL($lP,''),
	SSQL($orderBy,''));
	//echo $qry;
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

/************************************************************************************************************
	FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
************************************************************************************************************/
function detRowSel_old($table,$fielID,$field,$param,$other=NULL){
	$query_RS_datos = sprintf('SELECT %s as sID FROM %s WHERE %s=%s '.$other,
	SSQL($fielID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	//echo '<p>'.$query_RS_datos.'</p>';
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if($totalRows_RS_datos>0){ $x=0;
		do{ $list[$x]=$row_RS_datos['sID']; $x++;
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return ($list);
}
function detRowSel($table,$fielID,$field,$param,$other=NULL){//v.1.1
	Global $conn;
	$qry = sprintf('SELECT %s as sID FROM %s WHERE %s=%s '.$other,
	SSQL($fielID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	$RS_datos = mysqli_query($conn,$qry) or die(mysql_error());
	$row_RS_datos = mysqli_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysqli_num_rows($RS_datos);
	if($totalRows_RS_datos>0){ $x=0;
		do{ $list[$x]=$row_RS_datos['sID']; $x++;
		} while ($row_RS_datos = mysqli_fetch_assoc($RS_datos));
	}
	mysqli_free_result($RS_datos);
	return ($list);
}

//Datos de una TABLA / CAMPO / CONDICION
function detTab($table,$field,$param){ 
	$qry = sprintf("SELECT * FROM %s WHERE %s = %s",
	SSQL($table, ''),
	SSQL($field, ''),
	SSQL($param, "text"));
	$RS = mysql_query($qry) or die(mysql_error()); 
	return ($RS); mysql_free_result($RS);
}

//
function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){//v2.0
	Global $conn;
	if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
	$qry = sprintf("SELECT * FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
				   SSQL($table, ''),
				   SSQL($field, ''),
				   SSQL($param, "text"));
	//echo $qry;
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn)); $dRS = mysqli_fetch_assoc($RS); 
	mysqli_free_result($RS); return ($dRS);
}


function detRowNP($table,$params){ //v2.0 -> duotics_lib
	Global $conn;
	if($params){
		foreach($params as $x => $dat) {
			foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
		}
	}
	$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
	SSQL($table, ''));
	//echo $qry;
	$RS = mysqli_query($conn,$qry) or die(mysqli_error($conn));
	$dRS = mysqli_fetch_assoc($RS);
	mysqli_free_result($RS);
	return ($dRS);
}

//Datos de una TABLA / CAMPO / CONDICION
function totRow($table,$count='*',$field=1,$param=1,$cond='='){ 
	$qry = sprintf("SELECT COUNT(%s) as TR FROM %s WHERE %s%s%s",
	SSQL($count, ''),
	SSQL($table, ''),
	SSQL($field, ''),
	SSQL($cond, ''),
	SSQL($param, "text"));
	$RS = mysql_query($qry) or die(mysql_error()); 
	$dRS = mysql_fetch_assoc($RS);
	return ($dRS['TR']); mysql_free_result($RS);
}


function sLOG($type=NULL, $msg_m=NULL, $msg_t=NULL, $msg_c=NULL, $msg_i=NULL){//v.2.2
	$vrfVL=TRUE; //var para setear $LOG
	if($msg_m){
		$LOG['m']=$msg_m;
		$LOG['t']=$msg_t;
		$LOG['c']=$msg_c;
		$LOG['i']=$msg_i;
	}else $LOG=$_SESSION['LOG'];
	
	if($LOG){
		if(!$LOG['c']) $LOG['c']='alert-info';
		switch ($type){
			case 'a':
				$rLog='<div id="log">';
				$rLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
				$rLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
				if($LOG['t']) $rLog.='<h3>'.$LOG['t'].'</h3>';
				$rLog.=$LOG['m'];
				$rLog.='</div></div>';
			break;
			case 'g':
				$rLog='<script type="text/javascript">
				logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");
				</script>';
			break;
			case 's':
				$vrfVL=FALSE;
			break;
			default:
				$rLog='<div>'.$LOG['m'].'</div>';
			break;
		}
		echo $rLog;
	}
	if($vrfVL){//TRUE unset->LOG, FALSE $_SESSION LOG -> $LOG
		unset($_SESSION['LOG']);
	}else{
		$_SESSION['LOG']=$LOG;
	}
}

function sLOG_ant($type=NULL){
//SESSION_LOG: Vector ['m']=Mensaje; ['t']=Titulo; ['c']=class, ['i']=icono/imagen (Dentro de la carpeta /assets/icon/)
$LOG=$_SESSION['LOG'];
if(isset($LOG['m'])){
	if($LOG['i']) $LOG['i']=$GLOBALS['RAIZa'].'icon/'.$LOG['i'];
	else $LOG['i']=$GLOBALS['RAIZa'].'icon/information.png';
	switch ($type) {
    case 'a':
		if(!($LOG['c'])) $LOG['c']='alert-warning';
		$sLog='<div id="log">';
		$sLog.='<div class="alert alert-dismissable '.$LOG['c'].'" style="margin:10px;">';
		$sLog.='<button type="button" class="close" data-dismiss="alert">&times;</button>';
		$sLog.='<img src="'.$LOG['i'].'" class="pull-left"/> ';
		$sLog.='&nbsp;'.$LOG['m'];
		$sLog.='</div></div>';
        break;
    case 'g':
		$sLog='<script type="text/javascript">
		logGritter("'.$LOG['t'].'","'.$LOG['m'].'","'.$LOG['i'].'");</script>';
        break;
    default:
		$sLog='<div>'.$LOG['m'].'</div>';
	}
	echo $sLog;
}
unset($_SESSION['LOG']);
unset($_SESSION['LOG']['m']);
}//END sLOG

if (!function_exists("SSQL")) {//v.2.0 -> duotics_lib
function SSQL($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") {
  Global $conn;
  if (PHP_VERSION < 6) { $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue; }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($conn, $theValue) : mysqli_real_escape_string($conn, $theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}
}
?>