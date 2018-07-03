<?php require('../../init.php'); 
$idr=vParam('idr',$_GET['idr'],$_POST['idr'],NULL);
$idp=vParam('idp',$_GET['idp'],$_POST['idp'],NULL);
$idc=vParam('idc',$_GET['idc'],$_POST['idc'],NULL);
$id=vParam('id',$_GET['id'],$_POST['id'],NULL);
$acc=vParam('acc',$_GET['acc'],$_POST['acc'],NULL);
$form=vParam('form',$_GET['form'],$_POST['form'],NULL);
$det=$_POST;

mysql_query("SET AUTOCOMMIT=0;"); //Desabilita el autocommit
mysql_query("BEGIN;"); //Inicia la transaccion

/**************************************
***************************************
******************** REPORTE OBSTETRICO
***************************************
**************************************/
if(($form)&&($form=='repObs')){
//BEG INSERT REPORTE
if($acc==md5('INS')){
//BEG VERIFY FILE
if(($_FILES['userfile']['name'])){
	$param_file['ext']=array('.txt','.TXT');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZu.'report/ecografo/';
	$param_file['pre']='eco';
	$upload=uploadfile($param_file, $_FILES['userfile']);	
	
	if($upload['EST']==TRUE){
		$obt=paramsRepObs(RAIZu.'report/ecografo/'.$upload['FILE']);
		if($obt){
			$detInsRepObs=insRepObs($idc,$idp,$obt);
			$idr=$detInsRepObs['id'];
			$rowsDet=$detInsRepObs['rows'];
			$LOG.=$detInsRepObs['LOG'];
			$detInsRepObsDet=insRepObsDet($idr,$obt,$rowsDet);
			$LOG.=$detInsRepObsDet['LOG'];
		}else{
			$LOG.= "<h4>ERROR ALGORITMO LECTURA</h4>";
		}
	}else{
		$obt=$det;
	}
}else{

//BEG INS MANUAL
$qryIns=sprintf('INSERT INTO db_rep_obs (con_num, pac_cod, fechar, fechae, fum, est) 
VALUES (%s,%s,%s,%s,%s,%s)',
SSQL($idc,'int'),
SSQL($idp,'int'),
SSQL($sdate,'date'),
SSQL($fechae,'date'),
SSQL($fum,'date'),
SSQL('1','date'));
if(@mysql_query($qryIns)){
	$LOG.='<p>Reporte Creado Correctamente</p>';
	$idr=mysql_insert_id();
	
	$qryInsRepObs=sprintf('INSERT INTO db_rep_obs_detalle 
	(id_rep,
	va_snc, va_cerebelo, va_vent_lat, va_estomago, va_par_abd, va_4camcar, va_vejiga, va_rin, va_col, va_cor_umb, va_ext,
	obs)
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idr,'int'),
				
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		
		SSQL('Biometria Fetal acorde a ','text'));
	
	
	if(@mysql_query($qryInsRepObs)){
		$LOG.='<p>Detalle Reporte Creado Correctamente</p>';
	}else{
		$LOG.='<p>Error al Crear Detalle Reporte</p>';
		$LOG.=mysql_error();
	}
	
}else{
	$LOG.='<p>Error al Crear Reporte</p>';
	$LOG.=mysql_error();
}
//END INS MANUAL

}
//END VERIFY FILE
}//END INSERT REPORTE
//BEG UPDATE REPORTE
if($acc==md5('UPD')){
//VERIFY FILE
if(($_FILES['userfile']['name'])){
	$param_file['ext']=array('.txt','.TXT');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZu.'report/ecografo/';
	$param_file['pre']='eco';
	$upload=uploadfile($param_file, $_FILES['userfile']);	
	
	if($upload['EST']==TRUE){
		$obt=paramsRepObs(RAIZu.'report/ecografo/'.$upload['FILE']);
		if($obt){
			//DELETE REP ANT
			$detDelRep=delRepObs($idr);
			$LOG.=$detDelRep['LOG'];
			$detUpdRepObs=updRepObs($idr,$obt);
			$LOG.=$detUpdRepObs['LOG'];
			$rowsDet=$detUpdRepObs['rows'];
			$detInsRepObsDet=insRepObsDet($idr,$obt,$rowsDet);
			$LOG.=$detInsRepObsDet['LOG'];
		}else{
			$LOG.= "<h4>ERROR ALGORITMO LECTURA</h4>";
		}
	}else{
		$obt=$det;
	}
}else{

//BEG UPD MANUAL
$qryUpd=sprintf('UPDATE db_rep_obs SET fechae=%s, fum=%s WHERE id=%s',
SSQL($fechae,'text'),
SSQL($fum,'text'),
SSQL($idr,'int'));
if(@mysql_query($qryUpd)){
	$LOG.='<p>Reporte Actualizado Correctamente</p>';
}else{
	$LOG.='<p>Error al Actualizar Reporte</p>';
	$LOG.=mysql_error();
}
//END UPD MANUAL


}
//END VERIFY FILE
//BEG IMAGES FILES
if(($_FILES['userfileimg']['name'])){
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'images/db/ecografo/';
	$param_file['pre']='eco';
	$files=array();
	$fdata=$_FILES['userfileimg'];
	if(is_array($fdata['name'])){
		for($i=0;$i<count($fdata['name']);++$i){
			$files[]=array(
			'name'    =>$fdata['name'][$i],
			'type'  => $fdata['type'][$i],
			'tmp_name'=>$fdata['tmp_name'][$i],
			'error' => $fdata['error'][$i], 
			'size'  => $fdata['size'][$i]  
			);
		}
	}else $files[]=$fdata;
	foreach ($files as $file) { 
		$upl=uploadfile($param_file, $file);
		if($upl['EST']==TRUE){
			//INS MEDIA
			$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
			SSQL($upl['FILE'], "text"),
			SSQL('Ecografia', "text"),
			SSQL("1", "int"));
			$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
			$insID=mysql_insert_id();
			//INS REP OBS MEDIA
			$qryIns = sprintf("INSERT INTO db_rep_obs_media (id_rep, id_med) VALUES (%s,%s)",
			SSQL($idr, "int"),
			SSQL($insID, "int"));
			$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
			$insID=mysql_insert_id();
			
			fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);
		}
	}
}
//END IMAGES FILES
}
$goTo='obs_form.php?idr='.$idr.'&idp='.$idp.'&idc='.$idc;
}
//END UPDATE REPORTE
/**************************************
***************************************
******************** REPORTE ECOGRAFICO
***************************************
**************************************/
if(($form)&&($form=='repEco')){
if($acc==md5('INS')){
//VERIFY FILE
if(($_FILES['userfile']['name'])){
	$param_file['ext']=array('.txt','.TXT');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZu.'report/ecografo/';
	$param_file['pre']='eco';
	$upload=uploadfile($param_file, $_FILES['userfile']);	
	
	if($upload['EST']==TRUE){
		$obt=paramsRepEco(RAIZu.'report/ecografo/'.$upload['FILE']);
		if($obt){
			$detInsRepObs=insRepEco($idc,$idp,$obt);
			$idr=$detInsRepObs['id'];
			$LOG.=$detInsRepObs['LOG'];
		}else{
			$LOG.= "<p>ERROR ALGORITMO LECTURA</p>";
		}
	}else{
		$obt=$det;
	}
}else{//INSERTA REPORTE ECOGRAFICO MANUAL
	//INSERTA REPORTE
	$qryInsRep=sprintf('INSERT INTO db_rep_eco (con_num, pac_cod, fechar, fechae, tipo, 
	rec_utero, rec_ovder, obs_ovder, rec_ovizq, obs_ovizq, 
	eco_hall, eco_ohall, eco_diag, est) 
	VALUES (%s,%s,%s,%s,
	%s,%s,%s,%s,%s,
	%s,%s,%s,%s,%s)',
	SSQL($idc,'int'),//consulta
	SSQL($idp,'int'),//paciente
	SSQL($GLOBALS['sdate'],'date'),//recha registro
	SSQL($fechae,'date'),//recha ecografia
	SSQL($tipo,'int'),//paciente
	
	SSQL($rec_utero,'text'),
	SSQL($rec_ovder,'text'),
	SSQL($obs_ovder,'text'),
	SSQL($rec_ovizq,'text'),
	SSQL($obs_ovizq,'text'),
		
	SSQL($eco_hall,'text'),//recha ecografia	
	SSQL($eco_ohall,'text'),//recha ecografia	
	SSQL($eco_diag,'text'),
	SSQL('1','int'));
	if(mysql_query($qryInsRep)){
		$LOG.='<h4>Reporte Ginecologico Creado</h4>';
		$idr=mysql_insert_id();
	}else{
		$LOG.=mysql_error();
	}
}
}//END IF INS
if($acc==md5('UPD')){
//ACTUALIZA REPORTE
//VERIFY FILE
if(($_FILES['userfile']['name'])){
	$param_file['ext']=array('.txt','.TXT');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZu.'report/ecografo/';
	$param_file['pre']='eco';
	$upload=uploadfile($param_file, $_FILES['userfile']);	
	if($upload['EST']==TRUE){
		$obt=paramsRepEco(RAIZu.'report/ecografo/'.$upload['FILE']);
		if($obt){
			//DELETE REP ANT
			$detUpdRepObs=updRepEco($idr,$obt);
			$LOG.=$detUpdRepObs['LOG'];
		}else{
			$LOG.= "<h4>ERROR ALGORITMO LECTURA</h4>";
		}
	}else{
		$obt=$det;
	}
}
//IMAGES FILES
if(($_FILES['userfileimg']['name'])){
	$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
	$param_file['siz']=2097152;
	$param_file['pat']=RAIZ.'images/db/ecografo/';
	$param_file['pre']='eco';
	$files=array();
	$fdata=$_FILES['userfileimg'];
	if(is_array($fdata['name'])){
		for($i=0;$i<count($fdata['name']);++$i){
			$files[]=array(
			'name'    =>$fdata['name'][$i],
			'type'  => $fdata['type'][$i],
			'tmp_name'=>$fdata['tmp_name'][$i],
			'error' => $fdata['error'][$i], 
			'size'  => $fdata['size'][$i]  
			);
		}
	}else $files[]=$fdata;
	foreach ($files as $file) { 
		$upl=uploadfile($param_file, $file);
		if($upl['EST']==TRUE){
			//INS MEDIA
			$qryIns = sprintf("INSERT INTO db_media (file, des, estado) VALUES (%s,%s,%s)",
			SSQL($upl['FILE'], "text"),
			SSQL('Ecografia', "text"),
			SSQL("1", "int"));
			$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
			$insID=mysql_insert_id();
			//INS REP OBS MEDIA
			$qryIns = sprintf("INSERT INTO db_rep_eco_media (id_eco, id_med) VALUES (%s,%s)",
			SSQL($idr, "int"),
			SSQL($insID, "int"));
			$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
			$insID=mysql_insert_id();
			
			fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);
		}
	}
}
//END IMAGE UPLOAD
}
$goTo='eco_form.php?idr='.$idr.'&idp='.$idp.'&idc='.$idc;
}

/*************************/
/*************************/
//OTHER ACCIONS NO FOR FORM
if($acc==md5('DELROI')){
$qryDelI=sprintf('DELETE FROM db_rep_obs_media WHERE id=%s',
SSQL($id,'int'));
mysql_query($qryDelI)or(mysql_error());
$goTo='obs_form.php?idr='.$idr;
}
if($acc==md5('DELREI')){
$qryDelI=sprintf('DELETE FROM db_rep_eco_media WHERE id=%s',
SSQL($id,'int'));
mysql_query($qryDelI)or(mysql_error());
$goTo='eco_form.php?idr='.$idr;
}
//Eliminar Reporte Obstetrico y Tablas Relacionadas
if($acc=='DELRO'){
	$_SESSION['tab']['con']='cROB';
	$qryDelRepMed=sprintf('DELETE FROM db_rep_obs_media WHERE id_rep=%s',
	SSQL($idr,'int'));
	if(@mysql_query($qryDelRepMed)){
		$LOG.='<p>Multimedia Reporte Eliminado</p>';
		$qryDelRepDet=sprintf('DELETE FROM db_rep_obs_detalle WHERE id_rep=%s',
		SSQL($idr,'int'));
		if(@mysql_query($qryDelRepDet)){
			$LOG.='<h4>Reporte Detalles Eliminado</h4>';
			$qryDelRep=sprintf('DELETE FROM db_rep_obs WHERE id=%s',
			SSQL($idr,'int'));
			if(@mysql_query($qryDelRep)){
				$LOG.='<p>Reporte Eliminado</p>';
			}else{
				$LOG.='<h4>Error Eliminar Reporte</h4>';
				$LOG.=mysql_error();
			}
		}else{
			$LOG.='<p>Error Eliminar Reporte Detalles</p>';
			$LOG.=mysql_error();
		}
	}else{
		$LOG.='<p>Error Eliminar Reporte Multimedia</p>';
		$LOG.=mysql_error();
	}
	$accjs=TRUE;
}

//Eliminar Reporte Econgrafico y Tablas Relacionadas
if($acc=='DELRE'){
	$_SESSION['tab']['con']='cECO';
	$qryDelRepMed=sprintf('DELETE FROM db_rep_eco_media WHERE id_eco=%s',
	SSQL($idr,'int'));
	if(@mysql_query($qryDelRepMed)){
		$LOG.='<p>Multimedia Reporte Eliminado</p>';
		$qryDelRep=sprintf('DELETE FROM db_rep_eco WHERE id=%s',
		SSQL($idr,'int'));
		if(@mysql_query($qryDelRep)){
			$LOG.='<p>Reporte Eliminado</p>';
		}else{
			$LOG.='<p>Error Eliminar Reporte</p>';
			$LOG.=mysql_error();
		}
	}else{
		$LOG.='<h4>Error Eliminar Reporte Multimedia</h4>';
		$LOG.=mysql_error();
	}
	$accjs=TRUE;
}
//INSERT FETO (REPORTE OBSTETRICO DETALLE)
if($acc==md5('addFet')){
	$qryInsRepObs=sprintf('INSERT INTO db_rep_obs_detalle 
	(id_rep,va_snc, va_cerebelo, va_vent_lat, va_estomago, va_par_abd, va_4camcar, va_vejiga, va_rin, va_col, va_cor_umb, va_ext, obs)
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s,%s)',
		SSQL($idr,'int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('59','int'),
		SSQL('Biometria Fetal acorde a ','text'));
	$LOG.=$qryInsRepObs;
	if(@mysql_query($qryInsRepObs)){
		$LOG.='<p>Detalle Reporte Añadido Correctamente</p>';
	}else{
		$LOG.='<p>Error al Crear Detalle Reporte</p>';
		$LOG.=mysql_error();
	}
	$goTo='obs_form.php?idr='.$idr;
	$LOG.="Añadido";
}

//VERIFY COMMIT
$LOG.=mysql_error();
if(!mysql_error()){
	mysql_query("COMMIT;");
	$LOGt='Operación Ejecutada Exitosamente';
	$LOGc='alert-success';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['ok'];
}else{
	mysql_query("ROLLBACK;");
	$LOGt='Fallo del Sistema';
	$LOGc='alert-danger';
	$LOGi=$RAIZa.$_SESSION['conf']['i']['fail'];
}
mysql_query("SET AUTOCOMMIT=1;"); //Habilita el autocommit
$_SESSION['LOG']['m']=$LOG;
$_SESSION['LOG']['c']=$LOGc;
$_SESSION['LOG']['t']=$LOGt;
$_SESSION['LOG']['i']=$LOGi;

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
	header('Location: '.$goTo);
}
?>