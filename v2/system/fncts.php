<?php
//Mail
require_once('inc/class.phpmailer.php');
require_once('inc/class.smtp.php');
//Other
require_once("inc/class.image-resize.php");
require_once("inc/paginator.class.php");
require_once("inc/upload.class.php");
include_once('inc/html2pdf_v4.03/html2pdf.class.php');
//include_once('inc/phpExcelReader/reader.php');
//Personal Functions
require_once("inc/fnc_data.php");
require_once("inc/fnc_gen.php");
require_once("inc/fnc_sys.php");
require_once("inc/fnc_lang.php");

function deleteFile($path,$file,$vT=FALSE,$pT='t_'){
$fileDel=$path.$file;
	if (file_exists($fileDel)) {
		if (unlink($fileDel)) $LOG.='<span>Imagen anterior eliminada</span>';
		else $LOG.='<span>Error al eliminar imagen anterior</span>';
	}else $LOG.='<span>Imagen anterior no Existe</span>';
	if($vT==TRUE){
		$fileDelT=$path.$pT.$file;
		if (file_exists($fileDelT)) {
			if (unlink($fileDelT)) $LOG.='<span>Thumb Imagen anterior eliminada</span>';
			else $LOG.='<span>Error al eliminar Thumb imagen anterior</span>';
		}else $LOG.='<span>Thumb  Imagen anterior no Existe</span>';
	}
return $LOG;
}
function fnc_log(){
	if(!isset($_SESSION['LOGr'])) $_SESSION['LOGr']='warning';
	if (!isset($_SESSION)){session_start();}
	if(isset($_SESSION['LOG'])) echo '<div id="log" class="alert alert-'.$_SESSION['LOGr'].'"><button type="button" class="close" data-dismiss="alert">&times;</button>'.$_SESSION['LOG'].'</div>';
	unset($_SESSION['LOG']);
	unset($_SESSION['LOGr']);
}

function fnc_image_exist($RAIZ,$ruta,$nombre){
	if ((!(isset($nombre)))||($nombre=="")) $nombre="error.jpg";
	if (file_exists(RAIZ0.$ruta.$nombre)) return $RAIZ.$ruta.$nombre;
	else return $RAIZ.'assets/images/struct/no_image.jpg';
}

function vImg($ruta,$nombre,$thumb=TRUE,$pthumb='t_',$retHtml=FALSE){//v1.5
	//$ruta. Ruta o subcarpeta definida dentro de la RAIZi (carpeta de imagenes)
	//$nombre. Nombre del Archivo
	//$thumb. TRUE o FALSE en caso de querer recuperar thumb
	//$pthumb PREFIJO de Thumb
	//RAIZ must be named RAIZ0 depends the root folder
	$imgRet['n']=$GLOBALS['RAIZ'].'assets/images/struct/no_image.jpg';
	$imgRet['t']=$GLOBALS['RAIZ'].'assets/images/struct/t_no_image.jpg';//$imgRet['n'];
	$imgRet['s']=FALSE;//Verify if file exist is default FALSE
	if($nombre){
		if (file_exists(RAIZ0.$ruta.$nombre)){
			$imgRet['s']=TRUE;//FILE EXIST RETURN TRUE AND ALL DATA (link normal, link thumb, file name original)
			$imgRet['f']=$nombre;
			$imgRet['n']=$GLOBALS['RAIZ0'].$ruta.$nombre;
			$imgRet['t']=$imgRet['n'];
			if ($thumb==TRUE){
				if (file_exists(RAIZ0.$ruta.$pthumb.$nombre)){
					$imgRet['t']=$GLOBALS['RAIZ0'].$ruta.$pthumb.$nombre;
				}
			}
		}
	}
	//Direct Return HTML Code *********** TERMINAR ESTE CODIGO
	if($retHtml){
		foreach($retHtml as $key => $valor){
			if($key!='tip') $paramCode=' '.$key.' = '.'"'.$valor.'"';
		}
		switch($retHtml['tip']){
			case 'imgn':
				$imgRet['code']='<img src="'.$imgRet['n'].'" '.$paramCode.'>';
			break;
			case 'imgt':
				$imgRet['code']='<img src="'.$imgRet['t'].'" '.$paramCode.'>';
			break;
			case 'aimg':
				$imgRet['code']='<a href="'.$imgRet['n'].'" '.$paramCode.'><img src="'.$imgRet['t'].'"></a>';
			break;
		}
		
	}
	return $imgRet;
}

//FUNCTION TO GENERATE SELECT (FORM html)
function generarselectOLD($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL){
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if(!isset($id))$id=$nom;
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if (!$nom) $nom="select";
	//echo "CONT: ".count($sel);
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" '.$opt.'>';
	echo '<option value=""';
	if (!(strcmp(-1, $sel))) {echo 'selected="selected"';} ?>
    <?php echo '>- Seleccione -</option>';
	do {
		echo '<option value="'.$row_RS_datos['sID'].'"'; 
		if(is_array($sel)){
			if(in_array($row_RS_datos['sID'],$sel)) echo 'selected="selected"';
		}else{
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';}
		}
		?>
		<?php echo '>'.$row_RS_datos['sVAL'].'</option>';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	$rows = mysql_num_rows($RS_datos);
	if($rows > 0) {
		mysql_data_seek($RS_datos, 0);
		$row_RSe = mysql_fetch_assoc($RS_datos);
	}
	echo '</select>';
	mysql_free_result($RS_datos);
}

//FUNCTION TO GENERATE SELECT (FORM html) *NEW v.3.0
function generarselect($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if($RS_datos){
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>- Seleccione -</option>';	
	}
	
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
		if(is_array($sel)){ if(in_array($row_RS_datos['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';} }
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
	}else{
		echo '<span class="label label-danger">Error generarSelect : '.$nom.'</span>';
	}
}

function catsitempath_upd($idcat, $iditem){
$statusrepeatbread=0;
$breadcrumb=NULL;//Vinculo de la Ruta total a ser devuelta
do{
	$query_RS = "SELECT cat_id, cat_nom, typ_id, cat_id_parent FROM tbl_items_cats WHERE cat_id=".$idcat;
	$RS = mysql_query($query_RS) or die(mysql_error());
	$row_RS = mysql_fetch_assoc($RS);
	$idcat=$row_RS['cat_id_parent'];
	$breadcrumb=$row_RS['cat_nom']." - ".$breadcrumb;
	if($idcat==0) $statusrepeatbread=1;
}while($statusrepeatbread==0);
$updcad="UPDATE tbl_items SET item_path='$breadcrumb' WHERE item_id=".$iditem;
if (mysql_query($updcad)) $LOG= $iditem." [UPD] ";
else $LOG= $iditem." [NO] ";
$result=$LOG.$breadcrumb;
return ($result);
}
function aliasurl_upd_itemWA($id,$string){
	$updcad=sprintf("UPDATE tbl_wa_items SET item_aliasurl=%s WHERE item_id=%s",
	GetSQLValueString($string, "text"),
	GetSQLValueString($id,'int'));
	if (mysql_query($updcad)){
		return $res='TRUE';
	}else{
		return $res=mysql_error();
	}
}
function aliasurl_upd_cat($id,$string){
	$updcad=sprintf("UPDATE tbl_items_cats SET cat_aliasurl=%s WHERE cat_id=%s",
	GetSQLValueString($string, "text"),
	GetSQLValueString($id,'int'));
	if (mysql_query($updcad)){
		return $res='TRUE';
	}else{
		return $res=mysql_error();
	}
}
function aliasurl_upd_catWA($id,$string){
	$updcad=sprintf("UPDATE tbl_wa_items_cats SET cat_aliasurl=%s WHERE cat_id=%s",
	GetSQLValueString($string, "text"),
	GetSQLValueString($id,'int'));
	if (mysql_query($updcad)){
		return $res='TRUE';
	}else{
		return $res=mysql_error();
	}
}

function returnchildxml($loc,$lastmod,$changefreq,$priority){
	$buffer;
	$buffer.='<url>';
	$buffer.='<loc>'.$loc.'</loc>';
	$buffer.='<lastmod>'.$lastmod.'</lastmod>';
	$buffer.='<changefreq>'.$changefreq.'</changefreq>';
	$buffer.='<priority>'.$priority.'</priority>';
	$buffer.='</url>';
	return($buffer);
}



?>