<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$action=vParam('action', $_GET['action'], $_POST['action']);

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

//IF MOD INVENTARIO PRODUCTS
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'INVP')){
	$insertGoTo = $_SESSION['urlp'];
	if((isset($_POST['form']))&&($_POST['form']=='form_prod')){
		$valueimage=$_POST['imagea'];
		if(!($_FILES['userfile']['name'])) $resultado.="";
		else{
			$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
			$param_file['siz']=15728640;
			$param_file['pat']=RAIZidb.'prod/';
			$param_file['pre']='prod';
			$aux_grab=uploadfile($param_file, $_FILES['userfile']);
			if($aux_grab[1]==1) $LOG.=$aux_grab[0];
			else{
				
				if($_POST['imagea']){
					$LOG.=deleteFile($param_file['pat'],$valueimage);
					deleteFile($param_file['pat'],'t_'.$valueimage);
				}
				$valueimage=$aux_grab[2];
				fnc_genthumb($param_file['pat'], $aux_grab[2], "", 640, 480); //Resize Original Image
				fnc_genthumb($param_file['pat'], $aux_grab[2], "t_", 200, 150);	//Generate Thumb
			}
		}
		
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_inv_productos SET 
			prod_cod=%s, prod_nom=%s, mar_id=%s, tip_cod=%s, prod_obs=%s, prod_img=%s, pri_1=%s, pri_2=%s, pri_3=%s WHERE prod_id=%s',
			GetSQLValueString($_POST['txt_cod'],'text'),
			GetSQLValueString($_POST['txt_nom'],'text'),
			GetSQLValueString($_POST['id_mar_sel'],'int'),
			GetSQLValueString($_POST['id_tip_sel'],'int'),
			GetSQLValueString($_POST['txt_obs'],'text'),
			GetSQLValueString($valueimage,'text'),
			GetSQLValueString($_POST['pri_1'],'text'),
			GetSQLValueString($_POST['pri_2'],'text'),
			GetSQLValueString($_POST['pri_3'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO
			tbl_inv_productos (prod_cod, prod_nom, mar_id, tip_cod, prod_obs, prod_stat, prod_img, pri_1, pri_2, pri_3)
			VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($_POST['txt_cod'],'text'),
			GetSQLValueString($_POST['txt_nom'],'text'),
			GetSQLValueString($_POST['id_mar_sel'],'int'),
			GetSQLValueString($_POST['id_tip_sel'],'int'),
			GetSQLValueString($_POST['txt_obs'],'text'),
			GetSQLValueString('1','int'),
			GetSQLValueString($valueimage,'text'),
			GetSQLValueString($_POST['pri_1'],'text'),
			GetSQLValueString($_POST['pri_2'],'text'),
			GetSQLValueString($_POST['pri_3'],'text'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		if(!$_POST['txt_cod']){
			$detTip=detRow('tbl_inv_tipos','tip_cod',$_POST['id_tip_sel']);
			$detTip_nom=substr($detTip['tip_nom'], 0, 3);
			$_POST['txt_cod']=$id.$detTip_nom;
			
			$qry=sprintf('UPDATE tbl_inv_productos SET prod_cod=%s WHERE prod_id=%s',
			GetSQLValueString($_POST['txt_cod'],'text'),
			GetSQLValueString($id,'int'));
			if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
			else $LOG.='<h4>Error al Actualizar</h4>';
			
		}
		createImagesIDBarCode($_POST['txt_cod'],NULL,RAIZidb.'barcode_prod/','.jpg');
		/***************************** MULTI ATRIBS REVIEW *****************************/
		//Multiple Cats Review
		$CatSel=$_POST['atribSel'];
		$contMultCats=count($CatSel);
		//Eliminar MultiCats anteriores
		$qryDelMC=sprintf('DELETE FROM tbl_inv_productos_atrib WHERE prod_id=%s',
			GetSQLValueString($id, "int"));
		@mysql_query($qryDelMC)or($LOG.=mysql_error());
		//Inserta las MultiCats seleccionadas
		for($i=0;$i<$contMultCats;$i++){
			$qryinsMC=sprintf('INSERT INTO tbl_inv_productos_atrib (prod_id,typ_cod) VALUES (%s,%s)',
				GetSQLValueString($id, "int"),
				GetSQLValueString($CatSel[$i], "int"));
			@mysql_query($qryinsMC)or($LOG.=mysql_error());
		}
		/***************************** END MULTI ATRIBS *****************************/
		
		$LOG.=mysql_error();
		$insertGoTo .= '?id='.$id;
	}
	if((isset($action))&&($action=='DEL')){
		$detProd=detInvProd($id);
		$qry=sprintf('DELETE FROM tbl_inv_productos WHERE prod_id=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)){
			$LOG.=deleteFile(RAIZidb.'prod/',$detProd['prod_img']);
			deleteFile(RAIZidb.'prod/t_',$detProd['prod_img']);
			$LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		}
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if(isset($_GET['stat'])){
		$qry=sprintf('UPDATE tbl_inv_productos SET prod_stat=%s WHERE prod_id=%s',
			GetSQLValueString($stat,'text'),
			GetSQLValueString($id,'int'));
		
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<b>Error al Actualizar Status</b>';
	}
}//END IF MOD INVENTARIO PRODUCTS
//IF MOD INVENTARIO TIPOS
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'INVT')){
	$insertGoTo = $_SESSION['urlp'];
	if((isset($_POST['form']))&&($_POST['form']=='form_tip')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_inv_tipos SET tip_nom=%s, tip_des=%s, cat_cod=%s WHERE tip_cod=%s',
				GetSQLValueString($txt_nom,'text'),
				GetSQLValueString($txt_des,'text'),
				GetSQLValueString($id_cat_sel,'int'),
				GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_inv_tipos (tip_nom, tip_des, cat_cod, tip_stat) VALUES (%s,%s,%s,%s)',
				GetSQLValueString($txt_nom,'text'),
				GetSQLValueString($txt_des,'text'),
				GetSQLValueString($id_cat_sel,'int'),
				GetSQLValueString('1','text'));
			if(@mysql_query($qry)){
				$id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo .= '?id='.$id;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry=sprintf('DELETE FROM tbl_inv_tipos WHERE tip_cod=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente.</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if(isset($_GET['stat'])){
		$qry=sprintf('UPDATE tbl_inv_tipos SET tip_stat=%s WHERE tip_cod=%s',
			GetSQLValueString($stat,'text'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
}//END MOD INVENTARIO TIPOS
//IF MOD INVENTARIO CATS
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'INVC')){
	$insertGoTo = $_SESSION['urlp'];;
	if((isset($_POST['form']))&&($_POST['form']=='form_cat')){
		if((isset($action))&&($action=='UPD')){
			$qry=sprintf('UPDATE tbl_inv_categorias SET cat_nom=%s, cat_des=%s WHERE cat_cod=%s',
				GetSQLValueString($txt_nom,'text'),
				GetSQLValueString($txt_des,'text'),
				GetSQLValueString($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry=sprintf('INSERT INTO tbl_inv_categorias (cat_nom, cat_des, cat_stat) VALUES (%s,%s,%s)',
				GetSQLValueString($txt_nom,'text'),
				GetSQLValueString($txt_des,'text'),
				GetSQLValueString('1','int'));
			if(@mysql_query($qry)){
				$id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo .= '?id='.$id;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry=sprintf('DELETE FROM tbl_inv_categorias WHERE cat_cod=%s',
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if(isset($_GET['stat'])){
		$qry=sprintf('UPDATE tbl_inv_categorias SET cat_stat=%s WHERE cat_cod=%s',
			GetSQLValueString($stat,'int'),
			GetSQLValueString($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
}//END IF MOD INVENTARIO CATS
//IF MOD INVENTARIO MARCAS
if ((isset($_SESSION['MODSEL'])) && ($_SESSION['MODSEL'] == 'INVM')){
	$insertGoTo = $_SESSION['urlp'];
	if((isset($_POST['form']))&&($_POST['form']=='form_mar')){
		if((isset($action))&&($action=='UPD')){
			$qry='UPDATE tbl_inv_marcas SET mar_nom="'.$txt_nom.'" WHERE mar_id="'.$id.'"';
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($action))&&($action=='INS')){
			$qry='INSERT INTO tbl_inv_marcas (mar_nom, mar_stat) VALUES ("'.$txt_nom.'", "1")';
			if(@mysql_query($qry)or($LOG.=mysql_error())){
				$id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		$LOG.=mysql_error();
		$insertGoTo .= '?id='.$id;
	}
	if((isset($action))&&($action=='DELETE')){
		$qry='DELETE FROM tbl_inv_marcas WHERE mar_id='.$id;
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if(isset($_GET['stat'])){
		$qry='UPDATE tbl_inv_marcas SET mar_stat="'.$stat.'" WHERE mar_id='.$id;
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
}//END IF MOD INVENTARIO MARCAS

$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOG.='Operación Ejecutada Exitosamente';
}else{
	mysql_query("ROLLBACK;");
	$LOG.='Fallo del Sistema, intente de nuevo';
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
header(sprintf("Location: %s", $insertGoTo));
?>