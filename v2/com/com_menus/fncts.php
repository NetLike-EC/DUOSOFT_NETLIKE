<?php include('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$acc=vParam('acc', $_GET['acc'], $_POST['acc']);
$goTo=vParam('url', $_GET['url'], $_POST['url']);
$det=$_POST;
$accjs=FALSE;
	//ACCIONES form_men (MENUS CONTENEDORES)
	if((isset($det['form']))&&($det['form']=='form_men')){
		if((isset($acc))&&($acc=='UPD')){
			$qry=sprintf('UPDATE tbl_menus SET nom=%s, ref=%s WHERE id=%s',			
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
			else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO tbl_menus (nom, ref, stat) 
			VALUES (%s,%s,%s)',
			SSQL($det['iNom'],'text'),
			SSQL($det['iRef'],'text'),
			SSQL('1','int'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
	}
	if((isset($det['form']))&&($det['form']=='form_meni')){
		if((isset($acc))&&($acc=='UPD')){
			$qry=sprintf('UPDATE tbl_menus_items SET 
			men_idc=%s, men_padre=%s, men_nombre=%s, men_tit=%s, men_link=%s, men_icon=%s, men_orden=%s, men_stat=%s, men_css=%s, men_precode=%s, men_postcode=%s, mod_cod=%s  
			WHERE men_id=%s',			
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL($det['dStat'],'int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'int'),
			SSQL($id,'int'));
			if(@mysql_query($qry)){
				$LOG.="<h4>Actualizado Correctamente.</h4>ID. ".$id;
				$qry=sprintf('UPDATE tbl_menus_items SET men_idc=%s WHERE men_padre=%s',			
				SSQL($det['dIDC'],'int'),
				SSQL($id,'int'));
				if(@mysql_query($qry)){
					$LOG.="<h4>Hijos Actualizados Correctamente.</h4>ID. ".$id;
				}else $LOG.='<h4>Error al Actualizar Hijos</h4>';
			}else $LOG.='<h4>Error al Actualizar</h4>';
		}
		if((isset($acc))&&($acc=='INS')){
			$qry=sprintf('INSERT INTO tbl_menus_items (men_idc, men_padre, men_nombre, men_tit, men_link, men_icon, men_orden, men_stat, men_css, men_precode, men_postcode, mod_cod) 
			VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
			SSQL($det['dIDC'],'int'),
			SSQL($det['dIDP'],'int'),
			SSQL($det['dNom'],'text'),
			SSQL($det['dTit'],'text'),
			SSQL($det['dLnk'],'text'),
			SSQL($det['dIco'],'text'),
			SSQL($det['dOrd'],'int'),
			SSQL('1','int'),
			SSQL($det['dCss'],'text'),
			SSQL($det['dPreCode'],'text'),
			SSQL($det['dPostCode'],'text'),
			SSQL($det['dMod'],'text'));
			if(@mysql_query($qry)){ $id=@mysql_insert_id(); $LOG.="<h4>Creado Correctamente.</h4>ID. ".$id;
			}else $LOG.='<h4>Error al Grabar</h4>';
		}
		
	}
	$goTo.='?id='.$id;
	//ACCIONES GET
	if((isset($acc))&&($acc=='DELM')){
		$qry=sprintf('DELETE FROM tbl_menus WHERE menu_id=%s',
			SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
		else $LOG.='<h4>No se pudo Eliminar</h4>';
	}
	if((isset($acc))&&($acc=='STATM')){
		$qry=sprintf('UPDATE tbl_menus SET menu_stat=%s WHERE menu_id=%s',
			SSQL($stat,'int'),
			SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
	if((isset($acc))&&($acc=='DELMI')){
		$qry=sprintf('DELETE FROM tbl_menu_usuario WHERE men_id=%s',
			SSQL($id,'int'));
		if(@mysql_query($qry)){
			$qry=sprintf('DELETE FROM tbl_menus_items WHERE men_id=%s',
			SSQL($id,'int'));
			if(@mysql_query($qry)) $LOG.="<h4>Eliminado Correctamente</h4>ID. ".$id;
			else $LOG.='<h4>No se pudo Eliminar</h4>';
		
		}	
		$accjs=TRUE;
	}
	if((isset($acc))&&($acc=='STATMI')){
		$qry=sprintf('UPDATE tbl_menus_items SET itemmenu_stat=%s WHERE itemmenu_id=%s',
			SSQL($stat,'int'),
			SSQL($id,'int'));
		if(@mysql_query($qry)) $LOG.="<h4>Status Actualizado</h4>ID. ".$id;
		else $LOG.='<h4>Error al Actualizar Status</h4>';
	}
$LOG.=mysql_error();
$_SESSION['LOG']['t']='Atributos';
$_SESSION['LOG']['m']=$LOG;
if((mysql_error())||(isset($LOGe))) $_SESSION['LOGr']="danger"; else $_SESSION['LOGr']="success";
$goTo=urlr($goTo);

if($accjs==TRUE){
	include(RAIZf.'head.php'); ?>
	<body class="cero">
    <div id="alert" class="alert alert-info"><h2>Procesando</h2></div>
	<script type="text/javascript">
	$( "#alert" ).slideDown( 300 ).delay( 2000 ).fadeIn( 300 );
	parent.location.reload();
	</script>
    </body>
<?php }else{
	header(sprintf("Location: %s", $goTo));
}
?>