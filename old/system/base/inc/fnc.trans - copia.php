<?php

//Funcion para verificar
function verifyFactCom($com_num){
	$query_data=sprintf('SELECT * FROM tbl_factura_com WHERE com_num = %s',
		GetSQLValueString($com_num,'int'));
	$RSdata = mysql_query($query_data);
	$row_RSdata = mysql_fetch_assoc($RSdata);
	$totalRows_RSdata = mysql_num_rows($RSdata);
	return $row_RSdata;
}

//FUncion que ingresa registro de auditoria
function AUD($obs){
	$qry = sprintf("INSERT INTO tbl_auditoria (user_id, aud_dat, aud_obs) VALUES (%s, %s, %s)",
		GetSQLValueString($_SESSION['MM_UserID'], "int"),
    	GetSQLValueString($GLOBALS['sdatet'], "text"),
		GetSQLValueString($obs, "text"));
	if(!mysql_query($qry)){ $LOG.=mysql_error(); }
	return mysql_insert_id();
}
function verAnuCom($com_num){
	$varReturn=TRUE;
	$query_data=sprintf('SELECT * FROM tbl_compra_det WHERE com_num = %s',
		GetSQLValueString($com_num,'int'));
	$RSdata = mysql_query($query_data);
	$row_RSdata = mysql_fetch_assoc($RSdata);
	$totalRows_RSdata = mysql_num_rows($RSdata);
	if ($totalRows_RSdata > 0){
		do{
			$comdet_id=$row_RSdata['comdet_id'];
			$query_exis=sprintf('SELECT * FROM tbl_inventario 
			INNER JOIN tbl_compra_det ON tbl_inventario.inv_id=tbl_compra_det.inv_id 
			WHERE comdet_id = %s',
				GetSQLValueString($comdet_id,'int'));
			$RSexis = mysql_query($query_exis);
			$row_RSexis = mysql_fetch_assoc($RSexis);
			$totalRows_RSexis = mysql_num_rows($RSexis);
			
			$invSale=$row_RSexis['inv_sal'];
			if($invSale>0){
				$varReturn=FALSE;
				break;
			}
		}while ($row_RSdata = mysql_fetch_assoc($RSdata));
	}else{ $varReturn=FALSE;}
	return $varReturn;
}
function verAnuVen($ven_num){
	$varReturn=TRUE;
	$query_cab=sprintf('SELECT * FROM tbl_venta_cab WHERE ven_num = %s',
		GetSQLValueString($ven_num,'int'));
	$RScab = mysql_query($query_cab);
	$row_RScab = mysql_fetch_assoc($RScab);
	$totalRows_RScab = mysql_num_rows($RScab);
	if($row_RScab['ven_stat']==0){
		$varReturn=FALSE;
	}else{
		$query_data=sprintf('SELECT * FROM tbl_venta_det WHERE ven_num = %s',
			GetSQLValueString($ven_num,'int'));
		$RSdata = mysql_query($query_data);
		$row_RSdata = mysql_fetch_assoc($RSdata);
		$totalRows_RSdata = mysql_num_rows($RSdata);
		if ($totalRows_RSdata > 0){
			do{
				$comdet_id=$row_RSdata['vendet_id'];
				$query_exis=sprintf('SELECT * FROM tbl_inventario 
				INNER JOIN tbl_venta_det ON tbl_inventario.inv_id=tbl_venta_det.inv_id 
				WHERE vendet_id = %s',
					GetSQLValueString($comdet_id,'int'));
				$RSexis = mysql_query($query_exis);
				$row_RSexis = mysql_fetch_assoc($RSexis);
				$totalRows_RSexis = mysql_num_rows($RSexis);
				
				$invSale=$row_RSexis['inv_sal'];
				if($invSale<=0){
					$varReturn=FALSE;
					break;
				}
			}while ($row_RSdata = mysql_fetch_assoc($RSdata));
		}else{ $varReturn=FALSE;}
	}
	return $varReturn;
}

function fnc_ins_per($_POST){
	$detPer=detRow('tbl_personas','per_doc',$_POST['form_doc']);
	if($detPer){
		$LOG.='<h4>Persona Existente</h4>';
		$qryupd = sprintf("UPDATE tbl_personas SET per_nom=%s, per_ape=%s, per_mail=%s, per_dir=%s, per_ciu=%s, per_tel=%s, per_cel=%s, per_fecnac=%s, per_cont_nom=%s, per_cont_tel=%s, per_cont_dir=%s, per_cont_mail=%s WHERE per_id=%s",
    	GetSQLValueString($_POST['form_nom'], "text"),
		GetSQLValueString($_POST['form_ape'], "text"),
		GetSQLValueString($_POST['form_mail'], "text"),
		GetSQLValueString($_POST['form_dir'], "text"),
		GetSQLValueString($_POST['form_ciu'], "text"),
		GetSQLValueString($_POST['form_tel'], "text"),
		GetSQLValueString($_POST['form_cel'], "text"),
		GetSQLValueString($_POST['form_naci'], "date"),			
		GetSQLValueString($_POST['form_cont_nom'], "text"),
		GetSQLValueString($_POST['form_cont_tel'], "text"),
		GetSQLValueString($_POST['form_cont_dir'], "text"),
		GetSQLValueString($_POST['form_cont_mail'], "text"),
		GetSQLValueString($detPer['per_id'], "int"));
		if(!mysql_query($qryupd)){ $LOG.=mysql_error(); $LOG.='<h4>Error al Actualizar Persona</h4>';
		}else $LOG.='<h4>Actualizado Correctamente</h4>';
		$id_per=$detPer['per_id'];
	}else{
		$qryins = sprintf("INSERT INTO tbl_personas (per_doc, per_nom, per_ape, per_mail, per_dir, per_ciu, per_tel, per_cel, per_fecnac, per_cont_nom, per_cont_tel, per_cont_dir, per_cont_mail) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
		GetSQLValueString($_POST['form_doc'], "text"),
    	GetSQLValueString($_POST['form_nom'], "text"),
		GetSQLValueString($_POST['form_ape'], "text"),
		GetSQLValueString($_POST['form_mail'], "text"),
		GetSQLValueString($_POST['form_dir'], "text"),
		GetSQLValueString($_POST['form_ciu'], "text"),
		GetSQLValueString($_POST['form_tel'], "text"),
		GetSQLValueString($_POST['form_cel'], "text"),
		GetSQLValueString($_POST['form_naci'], "date"),			
		GetSQLValueString($_POST['form_cont_nom'], "text"),
		GetSQLValueString($_POST['form_cont_tel'], "text"),
		GetSQLValueString($_POST['form_cont_dir'], "text"),
		GetSQLValueString($_POST['form_cont_mail'], "text"));			
		if(!mysql_query($qryins)){ $LOG.=mysql_error(); $LOG.='<h4>Error al crear la Persona</h4>';
		}else $LOG.='<h4>Persona Creada Correctemente</h4>';
		$id_per=mysql_insert_id();
	}
	$resultado['id']=$id_per;
	$resultado['log']=$LOG;
	return($resultado);
}

function actualizacion_inventario_venta($id_prod_sel, $cant_prod_sel){//ACTUALIZA EL INVENTARIO DE UN PRODUCTO TRAS UNA VENTA
		$cant_venta=$cant_prod_sel;
		$cont_det=0;
		$detalles_add=NULL;
		while($cant_venta>0){
			$query_RS_inv_stock = sprintf("SELECT inv_id, (inv_can-inv_sal) as stock FROM tbl_inventario
			INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inv_productos.prod_id
			WHERE inv_sal<inv_can AND tbl_inventario.prod_id=%s LIMIT 1",
			GetSQLValueString($id_prod_sel,'int'));
			$RS_inv_stock = mysql_query($query_RS_inv_stock) or die(mysql_error());
			$row_RS_inv_stock = mysql_fetch_assoc($RS_inv_stock);

			$stock_available=$row_RS_inv_stock['stock'];
			$id_inv_update=$row_RS_inv_stock['inv_id'];

			$detalles_add[$cont_det]["inv_id"]=$id_inv_update;

			if($stock_available>$cant_venta)
			{
				@mysql_query("UPDATE tbl_inventario 
				SET inv_sal=inv_sal+".$cant_venta." WHERE inv_id=".$id_inv_update);
				$detalles_add[$cont_det]["det_cant"]=$cant_venta;
				$cant_venta=0;
				break;
			}else{
				@mysql_query("UPDATE tbl_inventario 
				SET inv_sal=inv_sal+".$stock_available." WHERE inv_id=".$id_inv_update);
				$cant_venta=$cant_venta-$stock_available;
				$detalles_add[$cont_det]["det_cant"]=$stock_available;
			}
			$cont_det++;
		}
		return($detalles_add);
	}

function valInvUCom($id,$ps){
	//$ps : Precio Seleccionado del tbl_inv_prod
	$detProd=detInvProd($id);
	if($ps=='1') $ps='pri_1';
	else if($ps=='2') $ps='pri_2';
	else if($ps=='3') $ps='pri_3';		
	$pp=$detProd[$ps];//Obtengo el Valor de Porcentaje de PRECIO 1 de tbl_inv_productos
	if(($pp>0)||($ps=='N')){ //Verifico si el valor de P1>0
		$vp=ultimo_valoracion_inventario_producto($id);//Obtengo el registro de ultimo ingreso de inventario del producto
		$vpt=$vp['inv_val'];//obtengo solo el valor del ultimo ingreso
		$detComDet=detRow('tbl_compra_det','inv_id',$vp['inv_id']);
		$detComCab=detRow('tbl_compra_cab','com_num',$detComDet['com_num']);
		$detComCab_proc=$detComCab['com_proc'];//Obtengo la procedencia de la compra (IMP=Aranceles; LOC=12=i.v.a)
		if($detComCab_proc=='IMP') $detComCab_imp=$detComCab['com_imp']; //SI ES IMP = ARANCELES
		else if ($detComCab_proc=='LOC') $detComCab_imp=12;//SI ES LOC = IVA = 12 %
		$vpt=$vpt+($vpt*$detComCab_imp/100);//Sumo el porcentaje de Aranceles
		$vpt=$vpt+($vpt*$pp/100);//Sumo el Porcentaje de Ganacia de Precio
		$vpt=number_format($vpt,5);
	}else $vpt='N/D';
	return $vpt;
}


// Calcula la edad (formato: año/mes/dia)
function edad($edad){
	if($edad){
		list($Y,$m,$d) = explode("-",$edad);
		$edadRet=( date("md") < $m.$d ? date("Y")-$Y-1 : date("Y")-$Y );
		if($edadRet>1) $edadRet.=' Años';
		else $edadRet.=' Año';
	}else $edadRet='';
	return $edadRet;
}
function uploadfile($params, $file){
	$code = substr(md5(uniqid(rand())),0,6).'_'; $prefijo = '_'.$code.'_';
	$fileextnam = $file['name']; // Obtiene el nombre del archivo, y su extension
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension
	$filename = $prefijo.$params['pac'].$ext; // Obtiene el nombre del archivo, y su extension.
	$aux_grab=0;//Variable para determinar si se cumplieron todos los requisitos y proceso a guardar los archivos
	if(!in_array($ext,$params['ext']))// Verifica si la extension es valida
	{	$resultado.=':: Imagen No Valida (permitido: jpg, gif, png) ::<br />'; $aux_grab=1;
	}else{ if(filesize($file['tmp_name']) > $params['siz'])// Verifica el tamaño maximo
		{	$resultado.=':: Imagen Demasiado Grande :: maximo 2MB<br />'; $aux_grab=1;	
		}else{ if(!is_writable($params['pat']))// Verifica permisos.
			{	$resultado.=':: Permisos Folder Insuficientes, contacte al Administrador del Sistema ::<br />';$aux_grab=1;
			}else{// Mueve el archivo a su lugar correpondiente.
				if(move_uploaded_file($file['tmp_name'],$params['pat'].$filename)) $archivo=$params['pat'].$filename; else{ $resultado.=':: Error al cargar la Imagen ::<br />';$aux_grab=1; }
			}
		}
	}
	$auxres[0]=$resultado; $auxres[1]=$aux_grab; $auxres[2]=$filename;
	return $auxres;}

function fnc_maxnumcons($id_pac){
$id_pac_ct_RS_cons_tot = "-1";
if (isset($id_pac)) {
  $id_pac_ct_RS_cons_tot = $id_pac;
}
$query_RS_cons_tot = 'SELECT MAX(con_num) as maxnumcons FROM tbl_consultas WHERE pac_cod='.$id_pac_ct_RS_cons_tot;
$RS_cons_tot = mysql_query($query_RS_cons_tot) or die(mysql_error());
$row_RS_cons_tot = mysql_fetch_assoc($RS_cons_tot);
$totalRows_RS_cons_tot = mysql_num_rows($RS_cons_tot);
return $row_RS_cons_tot['maxnumcons'];
mysql_free_result($RS_cons_tot);
}
function fnc_log(){
	session_start();
	if(isset($_SESSION['LOG'])){
		if($_SESSION['LOGr']=='e') $classR='alert-error';
		if($_SESSION['LOGr']=='s') $classR='alert-success';
		if($_SESSION['LOGr']=='i') $classR='alert-info';
		
		echo '<div id="log"><div class="alert '.$classR.'">';
		echo '<button type="button" class="close" data-dismiss="alert"></button>';
		echo $_SESSION['LOG'];
		echo '</div></div>';
	}
	unset($_SESSION['LOG']);
	unset($_SESSION['LOGr']);
}

function fnc_image_exist($ruta,$nombre,$thumb=FALSE){
	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	$pthumb='t_';//$pthumb PREFIJO de Thumb
	$imgRet['norm']=$GLOBALS['RAIZi'].'struct/no_image.jpg';
	$imgRet['thumb']=$imgRet['norm'];
	if($nombre){
	if (file_exists(RAIZi.$ruta.$nombre)){
		$imgRet['norm']=$GLOBALS['RAIZi'].$ruta.$nombre;
		$imgRet['thumb']=$imgRet['norm'];
		if ($thumb==TRUE){
			if (file_exists(RAIZi.$ruta.$pthumb.$nombre)){
				$imgRet['thumb']=$GLOBALS['RAIZi'].$ruta.$pthumb.$nombre;
			}
		}
	}}
	return $imgRet;
} 
function vParam($nompar, $pget, $ppost){
	//$nompar :: Nombre del Parametro General (Sirve para verificar si existe una sesion con ese nombre)
	//$pget :: Parametro GET
	//$ppost :: Parametro POST
	session_start();
	if(isset($pget)) {$id_ret=$pget;}
	else if (isset($ppost)){$id_ret=$ppost;}
	else $id_ret=$_SESSION[$nompar];
	return $id_ret;
	}
//CREAR TABLA TEMPORAL PARA BUSQUEDA DE clientes
function fnc_create_temp_pac(){
$query_create_table = "CREATE TEMPORARY TABLE tbl_clientes_temp (id int(11) NOT NULL auto_increment, cli_cod int(6), fullname varchar(100), fulltext(fullname), PRIMARY KEY (id))ENGINE = MYISAM;";
if (mysql_query($query_create_table)){}
else {echo mysql_error();}
$query_datos_pac='SELECT tbl_clientes.cli_cod, tbl_personas.per_nom, tbl_personas.per_ape FROM tbl_personas INNER JOIN tbl_clientes ON tbl_personas.per_id=tbl_clientes.per_id';
$RS_datos_pac = mysql_query($query_datos_pac);
$row_RS_datos_pac = mysql_fetch_assoc($RS_datos_pac);
$totalRows_RS_datos_pac = mysql_num_rows($RS_datos_pac);
if ($totalRows_RS_datos_pac > 0)
{	do 
	{	$nom = $row_RS_datos_pac['per_nom'].' '.$row_RS_datos_pac['per_ape'];
		$query_insert_temp='INSERT INTO tbl_clientes_temp (cli_cod, fullname) VALUES ("'.$row_RS_datos_pac['cli_cod'].'" ,"'.$nom.'")';
		mysql_query($query_insert_temp)or die(mysql_error());
	}while ($row_RS_datos_pac = mysql_fetch_assoc($RS_datos_pac));
//echo "Tabla temporal Creada con ".$totalRows_RS_datos_pac."registros";
}else{echo "Error Creacion Temporal";}
}

function fnc_cutblanck($bus){
	if (substr($bus,0,1)==' ') $bus=substr($bus,1,strlen($bus));
	if (substr($bus,strlen($bus) - 1,1)==' ') $bus=substr($bus, 0, strlen($bus) - 1);
	return($bus);
}
function fnc_gencad_search(){
  session_start();
  $busqueda=fnc_cutblanck($_SESSION['singleBirdRemote']);
  $trozos=explode(" ",$busqueda);
  $numero=count($trozos);
  if ($numero==1)$cadbusca='SELECT * FROM tbl_clientes_temp where fullname LIKE "%'.$busqueda.'%"'; 
  if ($numero>1)$cadbusca='SELECT cli_cod, fullname, MATCH (fullname) AGAINST ("'.$busqueda.'") AS Score FROM tbl_clientes_temp WHERE MATCH (fullname) AGAINST ("'.$busqueda.'") ORDER BY Score DESC';
  return $cadbusca;
}

function tableExists($table_name){
	$Table = mysql_query("show tables like '" . $table_name . "'"); 
	if(mysql_fetch_row($Table) === false)
		return("0");
	else
		return("1");
}

function fnc_cadsearch($busqueda){
	session_start();
	//SI EXISTE CADENA DE BUSQUEDA
	if((isset($busqueda))&&($busqueda!="")){
		$msg_sys.="Existe Cadena *$busqueda* - ";
		$msg_sys.="TBL.".tableExists("tbl_clientes_temp")."//";
		if(tableExists("tbl_clientes_temp")==0){
			$msg_sys.="Tabla Existe - ";
			if($busqueda!=$_SESSION['singleBirdRemote']){
				$msg_sys.="Busqueda *$busqueda* diferente a la sesion *".$_SESSION['singleBirdRemote']."*";
				$_SESSION['singleBirdRemote']=$busqueda;
				mysql_query('DROP TABLE tbl_clientes_temp');
				$msg_sys.="Tabla Borrada - ";
				fnc_create_temp_pac();
				$msg_sys.="Creada Tabla";
			}else{
				$msg_sys.=$_SESSION['singleBirdRemote'];
				mysql_query('DROP TABLE tbl_clientes_temp');
				$msg_sys.="Tabla Borrada - ";
				fnc_create_temp_pac();
				$msg_sys.="Creada Tabla";
			}
			
		}else{
			$_SESSION['singleBirdRemote']=$busqueda;
			$msg_sys.="la tabla no existe";
			fnc_create_temp_pac();
			$msg_sys.="Tabla Creada";
		}
	}
	//echo $msg_sys;
}
//FUNCTIONS ACCESS USERS
function loginN(){
if (!isset($_SESSION)) {
  session_start();
}
$MM_authorizedUsers = "";
$MM_donotCheckaccess = "true";

// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
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
function loginL($levelaccess){
if (!isset($_SESSION)) { session_start(); }
if (isset($levelaccess))
$MM_authorizedUsers = $levelaccess;
$MM_donotCheckaccess = "false";
// *** Restrict Access To Page: Grant or deny access to this page
function isAuthorized($strUsers, $strGroups, $UserName, $UserGroup) { 
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
    if (($strUsers == "") && false) { $isValid = true; } 
  } 
  return $isValid; 
}
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
function fnc_status($id, $stat, $dest,$action=NULL){
if ($stat=="1")
	$status='<a href="'.$dest.'?id='.$id.'&stat=0&action='.$action.'" class="btn mini green"><i class="icon-ok icon-white"></i></a>';
if(($stat=="0")||($stat!="1"))
	$status='<a href="'.$dest.'?id='.$id.'&stat=1&action='.$action.'" class="btn mini red"><i class="icon-remove"></i></a>';
return $status;
}

function dirsel() { return substr($_SERVER["SCRIPT_NAME"],strrpos($_SERVER["SCRIPT_NAME"],"/")+1); }
	function valor_actual_caja_chica(){
		$query_RS_prov = "SELECT * FROM tbl_caja_chica ORDER BY tbl_caja_chica.caj_chi_id DESC LIMIT 1";
		$RS_prov = mysql_query($query_RS_prov) or die(mysql_error());
		$row_RS_prov = mysql_fetch_assoc($RS_prov);
		$totalRows_RS_prov = mysql_num_rows($RS_prov);
		return ($row_RS_prov);
	}	
function valor_factura($id){
	$query_RS_val_fac = sprintf('SELECT SUM(tbl_venta_det.ven_can*tbl_venta_det.ven_pre) as subtot_fac FROM tbl_venta_det WHERE tbl_venta_det.ven_num=%s',
	GetSQLValueString($id,'int'));
	$RS_val_fac = mysql_query($query_RS_val_fac) or die(mysql_error());
	$row_RS_val_fac = mysql_fetch_assoc($RS_val_fac);
	$totalRows_RS_val_fac = mysql_num_rows($RS_val_fac);
	$subtot_fac=$row_RS_val_fac['subtot_fac'];
	$total=$subtot_fac+($subtot_fac*$_SESSION['conf']['taxes']['iva_si']);
	$total=number_format($total,2,".","");
	return ($total);
}
function stock_existente_producto($id){
	//DEVUELVE EL STOCK EN INVENTARIO DE UN PRODUCTO
	$query_RS_prod_stock = sprintf("SELECT SUM(inv_can-inv_sal) as stock_inventario FROM tbl_inventario
	INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inv_productos.prod_id
	WHERE inv_sal<inv_can AND tbl_inventario.prod_id=%s",
	GetSQLValueString($id,'int'));
	$RS_prod_stock = mysql_query($query_RS_prod_stock) or die(mysql_error());
	$row_RS_prod_stock = mysql_fetch_assoc($RS_prod_stock);
	$totalRows_RS_prod_stock = mysql_num_rows($RS_prod_stock);
	return ($row_RS_prod_stock['stock_inventario']);
}
function valoracion_inventario_producto($id_prod){
	//PROMEDIO PONDERADO
	$query_RS = sprintf("SELECT (SUM((inv_can-inv_sal)*inv_val)/SUM(inv_can-inv_sal)) 
	as valor_promedio_inventario FROM tbl_inventario
	INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inv_productos.prod_id
	WHERE inv_sal<inv_can AND tbl_inventario.prod_id=%s",
	GetSQLValueString($id_prod,'int'));
	$RS = mysql_query($query_RS) or die(mysql_error());
	$row_RS = mysql_fetch_assoc($RS);
	$totalRows_RS = mysql_num_rows($RS);
	return ($row_RS['valor_promedio_inventario']);
}

function ultimo_valoracion_inventario_producto($id_prod){
	//VALOR DE LA ULTIMA COMPRA
	$query_RS = sprintf("SELECT tbl_inventario.inv_id, tbl_inventario.inv_val FROM tbl_inventario
	INNER JOIN tbl_inv_productos ON tbl_inventario.prod_id=tbl_inventario.prod_id
	WHERE tbl_inventario.prod_id=%s ORDER BY tbl_inventario.inv_id DESC LIMIT 1",
	GetSQLValueString($id_prod,'int'));
	$RS = mysql_query($query_RS) or die(mysql_error());
	$row_RS = mysql_fetch_assoc($RS);
	$totalRows_RS = mysql_num_rows($RS);
	return($row_RS);
	mysql_free_result($RS);
}

function valor_factura_compra($fac_com_num){
	$query_RS_val_fac = "SELECT SUM(tbl_inventario.inv_can*tbl_inventario.inv_val) as subtot_fac FROM tbl_inventario
	INNER JOIN tbl_compra_det ON tbl_inventario.inv_id = tbl_compra_det.inv_id 
	WHERE tbl_compra_det.com_num=".$fac_com_num;
	$RS_val_fac = mysql_query($query_RS_val_fac) or die(mysql_error());
	$row_RS_val_fac = mysql_fetch_assoc($RS_val_fac);
	$totalRows_RS_val_fac = mysql_num_rows($RS_val_fac);
	$subtot_fac=$row_RS_val_fac['subtot_fac'];
	$total=$subtot_fac+($subtot_fac*$_SESSION['conf']['taxes']['iva_si']);
	$total=number_format($total,2,".","");
	return ($total);
}
function fnc_dataCompra($param1){ $query_RS_datos = "SELECT * FROM tbl_compra_cab WHERE tbl_compra_cab.com_num='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
	
function dataVenta($param1){ $query_RS_datos = sprintf('SELECT * FROM tbl_venta_cab WHERE id=%s',GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}


function listInvMar(){
$query_RS_datos = "SELECT mar_id AS sID, mar_nom AS sVAL FROM tbl_inv_marcas WHERE mar_stat=1 ORDER BY sVAL ASC";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos);
mysql_free_result($RS_datos);
}

function listInvTip(){
$query_RS_datos = "SELECT tbl_inv_tipos.tip_cod AS sID, CONCAT(tbl_inv_tipos.tip_nom,' / ',tbl_inv_categorias.cat_nom) AS sVAL FROM tbl_inv_tipos, tbl_inv_categorias WHERE tbl_inv_tipos.cat_cod=tbl_inv_categorias.cat_cod AND tip_stat=1 ORDER BY sVAL ASC";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos);
mysql_free_result($RS_datos);
}

function listInvCat(){
$query_RS_datos = "SELECT cat_cod AS sID, cat_nom AS sVAL FROM tbl_inv_categorias WHERE cat_stat=1";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos);
mysql_free_result($RS_datos);
}

//FUNCTION TO GENERATE SELECT (FORM html)
function generarselect($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
		if(!isset($id))$id=$nom;
		if (!$nom) $nom="select";
		echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" '.$opt.'>';
		echo '<option value=""';
		if (!(strcmp(-1, $sel))) {echo 'selected="selected"';} ?>
    <?php echo '>- Seleccione -</option>';
	if($totalRows_RS_datos>0){
	do {
		$grpAct=$row_RS_datos['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$row_RS_datos['sID'].'"'; 
		if(is_array($sel)){
			if(in_array($row_RS_datos['sID'],$sel)) echo 'selected="selected"';
		}else{
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';}
		}
		?>
		<?php echo '>'.$row_RS_datos['sVAL'].'</option>';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS_datos);
	if($rows > 0) {
		mysql_data_seek($RS_datos, 0);
		$row_RSe = mysql_fetch_assoc($RS_datos);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS_datos);
}


function login($username, $password, $accesscheck){
if (isset($accesscheck)) $_SESSION['PrevUrl'] = $accesscheck;
if (isset($username)) {
  session_start();
  $loginUsername=$username;
  $password=md5($password);
  $MM_fldUserAuthorization = "user_level";
  $MM_redirectLoginSuccess = $GLOBALS['RAIZc']."com_index/";
  $MM_redirectLoginFailed = $GLOBALS['RAIZ']."errorlogin.php";
  $MM_redirecttoReferrer = true;
  	
  $LoginRS__query=sprintf("SELECT user_id, user_username, user_password, user_level FROM tbl_user_system WHERE user_username=%s AND user_password=%s",
  GetSQLValueString($loginUsername, "text"), GetSQLValueString($password, "text")); 
   
  $LoginRS = mysql_query($LoginRS__query) or die(mysql_error());
  $loginFoundUser = mysql_num_rows($LoginRS);
  $row_LoginRS = mysql_fetch_assoc($LoginRS);
  if ($loginFoundUser) {
    $loginStrGroup  = mysql_result($LoginRS,0,'user_level');    
	if (PHP_VERSION >= 5.1) {session_regenerate_id(true);} else {session_regenerate_id();}
    //declare two session variables and assign them
    $_SESSION['MM_Username'] = $loginUsername;
	$_SESSION['MM_UserID'] = $row_LoginRS['user_id'];
    $_SESSION['MM_UserGroup'] = $loginStrGroup;
    //if (isset($_SESSION['PrevUrl']) && true) $MM_redirectLoginSuccess = $_SESSION['PrevUrl'];	
	fnc_acces_usersys($row_LoginRS['user_id']);
    header("Location: " . $MM_redirectLoginSuccess );
  }
  else header("Location: ". $MM_redirectLoginFailed );
}	
}

//FUNCION REGISTRA ACCESO DE USUARIOS
function fnc_acces_usersys($param1){
	$accessDate=date('Y-m-d H:i:s',time() - 3600);
	$_SESSION['data_access']=$accessDate;
	$accessIp=getRealIP();
	$AUD=AUD($param1,'Login');
	$qryINS=sprintf('INSERT INTO tbl_user_access (aud_id, access_ip) VALUES (%s,%s)',
	GetSQLValueString($AUD,'int'),
	GetSQLValueString($accessIp,'text'));
	mysql_query($qryINS)or die(mysql_error());
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

function deleteFile($path,$file){
if($file){
$fileDel=$path.$file;
if (file_exists($fileDel)) {
    if (unlink($fileDel)) $LOG.='<span>Imagen anterior eliminada</span>';
	else $LOG.='<span>Error al elimiminar imagen anterior</span>';
}else $LOG.='<span>Imagen anterior no Existe</span>';
return $LOG;
}
}

function fnc_genthumb($path, $file, $pref, $mwidth, $mheight){
	$obj = new img_opt(); // Crear un objeto nuevo
	$obj->max_width($mwidth); // Decidir cual es el ancho maximo
	$obj->max_height($mheight); // Decidir el alto maximo
	$obj->image_path($path,$file,$pref); // Ruta, archivo, prefijo
	$obj->image_resize(); // Y finalmente cambiar el tamaño
}




if (!function_exists("GetSQLValueString")) {
function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }

  $theValue = function_exists("mysql_real_escape_string") ? mysql_real_escape_string($theValue) : mysql_escape_string($theValue);

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