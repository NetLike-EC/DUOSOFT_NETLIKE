<?php include('../../init.php');
mysql_select_db($db_conn_wa, $conn);
$_SESSION['LOG']=NULL;
$id=fnc_verifiparam('id', $_GET['id'], $_POST['id']);
$action=fnc_verifiparam('action', $_GET['action'], $_POST['action']);
$insertGoTo=$_SESSION['urlp'];
	
//BEG MOD ARTICLES PAGES
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'ARTPWA')){
	if((isset($_POST['form']))&&($_POST['form']=='form_page')){
		$valueimage=$_POST['imagea'];
		if(!($_FILES['userfile']['name'])) $resultado.="";
		else{
			$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
			$param_file['siz']=2097152;
			$param_file['pat']=RAIZ0.'welchallyn/img/db/articles/';
			$param_file['pre']='art';
			$aux_grab=uploadfile($param_file, $_FILES['userfile']);
			if($aux_grab[1]==1) $LOG.=$aux_grab[0];
			else{
				if($_POST['imagea']){
					$LOG.=deleteFile($param_file['pat'],$valueimage);
					deleteFile($param_file['pat'],'t_'.$valueimage);
				}
				$valueimage=$aux_grab[2];
				fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 220, 190);
			}
		}
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_articles SET cat_id=%s, art_url=%s, title=%s, view_title=%s, view_image=%s, short_des=%s, long_des=%s, dupdate=%s, status=%s, seo_title=%s, seo_metades=%s, image=%s WHERE art_id=%s',
			GetSQLValueString($_POST['cat_id'],'int'),
			GetSQLValueString($_POST['art_url'],'text'),
			GetSQLValueString($_POST['title'],'text'),
			GetSQLValueString($_POST['view_title'],'text'),
			GetSQLValueString($_POST['view_image'],'text'),
			GetSQLValueString($_POST['short_des'],'text'),
			GetSQLValueString($_POST['long_des'],'text'),
			GetSQLValueString(date('Y-m-d'),'date'),
			GetSQLValueString($_POST['status'],'text'),
			GetSQLValueString($_POST['seo_title'],'text'),
			GetSQLValueString($_POST['seo_metades'],'text'),
			GetSQLValueString($valueimage,'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id; $action="UPD";}
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_articles (cat_id, art_url, title, view_title, view_image, short_des, long_des, dcreate, hits, status, seo_title, seo_metades, image) VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($_POST['cat_id'],'int'),
			GetSQLValueString($_POST['art_url'],'text'),
			GetSQLValueString($_POST['title'],'text'),
			GetSQLValueString($_POST['view_title'],'text'),
			GetSQLValueString($_POST['view_image'],'text'),
			GetSQLValueString($_POST['short_des'],'text'),
			GetSQLValueString($_POST['long_des'],'text'),
			GetSQLValueString(date('Y-m-d'),'date'),
			GetSQLValueString('1','text'),
			GetSQLValueString('1','text'),
			GetSQLValueString($_POST['seo_title'],'text'),
			GetSQLValueString($_POST['seo_metades'],'text'),
			GetSQLValueString($valueimage,'text'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id; $action="UPD";
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo.='?id='.$id.'&action='.$action;
	}
	if((isset($action))&&($action=='DEL')){
		$qry=sprintf('DELETE FROM tbl_articles WHERE art_id=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STAT')){
		$qry=sprintf('UPDATE tbl_articles SET status=%s WHERE art_id=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>Articulo: ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
	$LOG.=mysql_error();
}//END MOD ARTICLES PAGES
//BEG MOD ARTICLES CATEGORIES
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'ARTCWA')){
	if((isset($_POST['form']))&&($_POST['form']=='form_catpage')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_articles_cat SET cat_nom=%s, cat_des=%s, cat_url=%s WHERE cat_id=%s',
			GetSQLValueString($_POST['cat_nom'],'text'),
			GetSQLValueString($_POST['cat_des'],'text'),
			GetSQLValueString($_POST['cat_url'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_articles_cat (cat_nom, cat_des, cat_url, cat_lev, cat_order, cat_status) VALUES (%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($_POST['cat_nom'],'text'),
			GetSQLValueString($_POST['cat_des'],'text'),
			GetSQLValueString($_POST['cat_url'],'text'),
			GetSQLValueString('1','int'),
			GetSQLValueString('1','int'),
			GetSQLValueString('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id; $action="UPD";
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo.='?id='.$id;
	}
	if((isset($action))&&($action=='DEL')){
		$qry=sprintf('DELETE FROM tbl_articles_cat WHERE cat_id=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($action))&&($action=='STAT')){
		$qry=sprintf('UPDATE tbl_articles_cat SET cat_status=%s WHERE cat_id=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
	$LOG.=mysql_error();
}//END MOD ARTICLES PAGES
$_SESSION['LOG']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
header(sprintf("Location: %s", $insertGoTo));
?>