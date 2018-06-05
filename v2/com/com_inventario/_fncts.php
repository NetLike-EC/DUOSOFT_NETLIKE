<?php 
	include('../_config.php');
	require_once(RAIZ.'Connections/conn.php');
	session_start();
	$_SESSION['LOG']=NULL;
	if(isset($_POST['id_sel'])) $id_sel=$_POST['id_sel'];
	else $id_sel=$_GET['id_sel'];
	if(isset($_POST['action'])) $action=$_POST['action'];
	else $action=$_GET['action'];
//IF MOD INVENTARIO PRODUCTS
if ((isset($_SESSION['MOD_SEL_ITEM'])) && ($_SESSION['MOD_SEL_ITEM'] == 'PRODUCTOS')){ $insertGoTo = 'items_prod_gest.php';
	if((isset($_POST['form']))&&($_POST['form']=='form_prod')){
		if(!($_FILES['userfile']['name'])) $resultado.="";
		else{
			$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
			$param_file['siz']=2097152;
			$param_file['pat']=RAIZ.'images/db/prod/';
			$param_file['pre']='prod';
			$aux_grab=uploadfile($param_file, $_FILES['userfile']);
			if($aux_grab[1]==1) $LOG.=$aux_grab[0];
			else{
				$valueimage_upd=' ,prod_img="'.$aux_grab[2].'"';
				$valueimage_ins[1]=" ,prod_img"; $valueimage_ins[2]=' ,"'.$aux_grab[2].'"';
			}
		}
		if((isset($action))&&($action=='UPDATE')){
			$qry='UPDATE tbl_productos SET prod_nom="'.$_POST['txt_nom'].'", mar_id="'.$_POST['id_mar_sel'].'", tip_cod="'.$_POST['id_tip_sel'].'", prod_obs="'.$_POST['txt_obs'].'"'.$valueimage_upd.' WHERE prod_id='.$id_sel;
			if(@mysql_query($qry)){ $LOG.="Actualizado Correctamente. ID=".$id_sel; $action="UPDATE";}
			else $LOG.='<b>Error al Actualizar</b><br />';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry='INSERT INTO tbl_productos (prod_nom, mar_id, tip_cod, prod_obs, prod_stat'.$valueimage_ins[1].')VALUES("'.$_POST['txt_nom'].'", "'.$_POST['id_mar_sel'].'", "'.$_POST['id_tip_sel'].'", "'.$_POST['txt_obs'].'", "1"'.$valueimage_ins[2].')';
			if(@mysql_query($qry)){ $id_sel=@mysql_insert_id(); $LOG.="Creado Correctamente. ID=".$id_sel; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysql_error();
		$insertGoTo = 'items_prod_form.php?id_sel='.$id_sel.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_productos WHERE prod_id="'.$id_sel.'"';
		if(@mysql_query($qry)) $LOG.="Eliminado Correctamente :: ID = ".$id_sel;
		else $LOG.='<b>No se pudo Eliminar</b><br />';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_productos SET prod_stat="'.$stat.'" WHERE prod_id='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Status Actualizado:: ID = ".$id_sel;
		else $LOG.='<b>Error al Actualizar Status</b><br />';
	}
	$LOG.=mysql_error();
}//END IF MOD INVENTARIO PRODUCTS
//IF MOD INVENTARIO TIPOS
if ((isset($_SESSION['MOD_SEL_ITEM'])) && ($_SESSION['MOD_SEL_ITEM'] == 'TIPOS')){
	$insertGoTo = 'items_tip_gest.php';
	if((isset($_POST['form']))&&($_POST['form']=='form_tip')){
		if((isset($action))&&($action=='UPDATE')){
			$qry='UPDATE tbl_prod_tipos SET tip_nom="'.$txt_tip_nom.'", tip_des="'.$txt_tip_des.'", cat_cod="'.$id_cat_sel.'" WHERE tip_cod='.$id_sel;
			if(@mysql_query($qry)) $LOG.="Actualizado Correctamente. ID=".$id_sel;
			else $LOG.='<b>Error al Actualizar</b><br />';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry='INSERT INTO tbl_prod_tipos (tip_nom, tip_des, cat_cod, tip_stat) VALUES ("'.$txt_tip_nom.'", "'.$txt_tip_des.'", "'.$id_cat_sel.'", "1")';
			if(@mysql_query($qry)){
				$id_sel=@mysql_insert_id(); $LOG.="Creado Correctamente. ID=".$id_sel; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysql_error();
		$insertGoTo = 'items_tip_form.php?id_sel='.$id_sel.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_prod_tipos WHERE tip_cod="'.$id_sel.'"';
		if(@mysql_query($qry)) $LOG.="Eliminado Correctamente:: ID = ".$id_sel;
		else $LOG.='<b>No se pudo Eliminar</b><br />';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_prod_tipos SET tip_stat="'.$stat.'" WHERE tip_cod='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Status Actualizado:: ID = ".$id_sel;
		else $LOG.='<b>Error al Actualizar Status</b><br />';
	}
	$LOG.=mysql_error();
}//END MOD INVENTARIO TIPOS
//IF MOD INVENTARIO CATS
if ((isset($_SESSION['MOD_SEL_ITEM'])) && ($_SESSION['MOD_SEL_ITEM'] == 'CATEGORIAS')){
	$insertGoTo = 'items_cat_gest.php';
	if((isset($_POST['form']))&&($_POST['form']=='form_cat')){
		if((isset($action))&&($action=='UPDATE')){
			$qry='UPDATE tbl_prod_categorias SET cat_nom="'.$txt_cat_nom.'", cat_des="'.$txt_cat_des.'" WHERE cat_cod="'.$id_sel.'"';
			if(@mysql_query($qry)) $LOG.="Actualizado Correctamente. ID=".$id_sel;
			else $LOG.='<b>Error al Actualizar</b><br />';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry='INSERT INTO tbl_prod_categorias (cat_nom, cat_des, cat_stat) VALUES ("'.$txt_cat_nom.'", "'.$txt_cat_des.'", "'."1".'")';
			if(@mysql_query($qry)){
				$id_sel=@mysql_insert_id(); $LOG.="Creado Correctamente. ID=".$id_sel; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysql_error();
		$insertGoTo = 'items_cat_form.php?id_sel='.$id_sel.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_prod_categorias WHERE cat_cod='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Eliminado Correctamente:: ID = ".$id_sel;
		else $LOG.='<b>No se pudo Eliminar</b><br />';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_prod_categorias SET cat_stat="'.$stat.'" WHERE cat_cod='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Status Actualizado:: ID: ".$id_sel;
		else $LOG.='<b>Error al Actualizar Status</b><br />';
	}
	$LOG.=mysql_error();
}//END IF MOD INVENTARIO CATS
//IF MOD INVENTARIO MARCAS
if ((isset($_SESSION['MOD_SEL_ITEM'])) && ($_SESSION['MOD_SEL_ITEM'] == 'MARCAS')){
	$insertGoTo = 'items_mar_gest.php';
	if((isset($_POST['form']))&&($_POST['form']=='form_mar')){
		if((isset($action))&&($action=='UPDATE')){
			$qry='UPDATE tbl_marcas SET mar_nom="'.$txt_mar_nom.'" WHERE mar_id="'.$id_sel.'"';
			if(@mysql_query($qry)) $LOG.="Actualizado Correctamente. ID=".$id_sel;
			else $LOG.='<b>Error al Actualizar</b><br />';
		}
		if((isset($action))&&($action=='INSERT')){
			$qry='INSERT INTO tbl_marcas (mar_nom, mar_stat) VALUES ("'.$txt_mar_nom.'", "1")';
			if(@mysql_query($qry)or($LOG.=mysql_error())){
				$id_sel=@mysql_insert_id(); $LOG.="Creado Correctamente. ID=".$id_sel; $action="UPDATE";
			}else $LOG.='<b>Error al Grabar</b><br />';
		}
		$LOG.=mysql_error();
		$insertGoTo = 'items_mar_form.php?id_sel='.$id_sel.'&action='.$action;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_marcas WHERE mar_id='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Eliminado Correctamente:: ID: ".$id_sel;
		else $LOG.='<b>No se pudo Eliminar</b><br />';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_marcas SET mar_stat="'.$stat.'" WHERE mar_id='.$id_sel;
		if(@mysql_query($qry)) $LOG.="Status Actualizado:: ID: ".$id_sel;
		else $LOG.='<b>Error al Actualizar Status</b><br />';
	}
	$LOG.=mysql_error();
}//END IF MOD INVENTARIO MARCAS
$_SESSION['LOG']=$LOG;
if(mysql_error()) $_SESSION['LOGr']="e";
header(sprintf("Location: %s", $insertGoTo));
?>