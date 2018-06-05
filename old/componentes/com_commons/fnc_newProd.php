<?php include('../../init.php');
$form=vParam('form', $_GET['form'], $_POST['form']);
$action=vParam('action', $_GET['action'], $_POST['action']);

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

if((isset($_POST['form']))&&($_POST['form']=='form_prodc')){
	if((isset($action))&&($action=='INS')){
		if(!($_FILES['userfile']['name'])) $LOG.='No Imagen';
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
		$qry=sprintf('INSERT INTO
			tbl_inv_productos (prod_cod, prod_nom, mar_id, tip_cod, prod_obs, prod_img, prod_stat, pri_1, pri_2, pri_3)
			VALUES(%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			GetSQLValueString($_POST['prod_cod'],'text'),
			GetSQLValueString($_POST['prod_nom'],'text'),
			GetSQLValueString($_POST['mar_id'],'int'),
			GetSQLValueString($_POST['tip_cod'],'int'),
			GetSQLValueString($_POST['prod_obs'],'text'),
			GetSQLValueString($valueimage,'text'),
			GetSQLValueString('1','int'),
			GetSQLValueString($_POST['pri_1'],'int'),
			GetSQLValueString($_POST['pri_2'],'int'),
			GetSQLValueString($_POST['pri_3'],'int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		if(!$_POST['prod_cod']){
				$detTip=detRow('tbl_inv_tipos','tip_cod',$_POST['tip_cod']);
				$detTip_nom=substr($detTip['tip_nom'], 0, 3);
				$_POST['prod_cod']=$id.$detTip_nom;
				
				$qry=sprintf('UPDATE tbl_inv_productos SET prod_cod=%s WHERE prod_id=%s',
				GetSQLValueString($_POST['prod_cod'],'text'),
				GetSQLValueString($id,'int'));
				if(@mysql_query($qry)){ $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;}
				else $LOG.='<h4>Error al Actualizar</h4>';
			
			}
			createImagesIDBarCode($_POST['prod_cod'],NULL,RAIZidb.'barcode_prod/','.jpg');
	}
}

$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$respuesta['accion']['est'] = 'TRUE';
	$respuesta['accion']['tit'] = 'Carga Correcta';
	$respuesta['accion']['msg'] = $LOG;

}else{
	mysql_query("ROLLBACK;");
	$respuesta['accion']['est'] = 'FALSE';
	$respuesta['accion']['tit'] = 'Carga incorrecta';
	$respuesta['accion']['msg'] = $LOG;

}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
echo json_encode($respuesta);	// Enviar la respuesta al cliente en formato JSON
?>