<?php include('../../init.php');
$_SESSION['LOG']=NULL;//INICIALIZA SESSION LOG
$id=vParam('id',$_GET['id'],$_POST['id']); //ID STANDAR
$idp=vParam('idp',$_GET['idp'],$_POST['idp']); //ID PACIENTE
$idc=vParam('idc',$_GET['idc'],$_POST['idc']); //ID CONSULTA
$idtim=vParam('idtim',$_GET['idtim'],$_POST['idtim']); //ID MEDIA
$url=vParam('url',$_GET['url'],$_POST['url']); //URL RETORNO
//VARIABLE ACCION Y REDIRECCION
$action=vParam('action',$_GET['action'],$_POST['action']);
if($url) $goTo=$url;
else $goTo=$_SESSION['urlp'];

if((!$_POST['status'])) $_POST['status']=1;
switch ($_POST['status']) {
    case 'ACT':
        $dStat='1';
        break;
    case 'INA':
        $dStat='0';
        break;
    default:
        $dStat='1';
}

/**********************************************************************/
//FUNCIONES PARA EXAMENES
if ((isset($_POST['form'])) && ($_POST['form'] == 'fti')){
	
	//IMAGES FILES
	if(($_FILES['efile']['name'])){
		$param_file['ext']=array('.jpg','.gif','.png','.jpeg','.JPG', '.GIF', '.PNG', '.JPEG');
		$param_file['siz']=2097152;//en KBPS
		$param_file['pat']=RAIZ.'media/db/tinf/';
		$param_file['pre']='cir';
		$files=array();
		$fdata=$_FILES['efile'];
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
				SSQL($dfile, "text"),
				SSQL("1", "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				//INS REP OBS MEDIA
				$qryIns = sprintf("INSERT INTO db_tratamiento_infertilidad_media (id_ti, id_med) VALUES (%s,%s)",
				SSQL($id, "int"),
				SSQL($insID, "int"));
				$ResultInsertc = mysql_query($qryIns) or die(mysql_error());
				$insID=mysql_insert_id();
				
				fnc_genthumb($param_file['pat'], $upl['FILE'], "t_", 330, 330);
			}
			$LOG.=$upl['LOG'];
		}
	}
	//END IMAGE UPLOAD
	
	if($action=='INS'){	
	$qryinst=sprintf('INSERT INTO db_tratamiento_infertilidad (pac_cod,con_num,date,datei,datef,donante,des,typ_cod,status)
	VALUES (%s,%s,%s,%s,%s,%s,%s,%s,%s)',
	SSQL($_POST['idp'], "int"),
	SSQL($_POST['idc'], "int"),
	SSQL($sdate, "date"),
	SSQL($_POST['datei'], "date"),
	SSQL($_POST['datef'], "date"),
	SSQL($_POST['don'], "text"),
	SSQL($_POST['des'], "text"),
	SSQL($_POST['typ_cod'], "text"),
	SSQL($dStat, "int"));
	if(@mysql_query($qryinst)){ $id = @mysql_insert_id();
		$LOG.='<p>Tratamiento Infertilidad Creado</p>';
	}else $LOG.='Error al Crear Tratamiento Infertilidad';
	$goTo.='?id='.$id;
	}
	if($action=='UPD'){	
	$qryupd=sprintf('UPDATE db_tratamiento_infertilidad SET datei=%s,datef=%s,typ_cod=%s,donante=%s,des=%s,status=%s WHERE id_ti=%s',
	SSQL($_POST['datei'], "date"),
	SSQL($_POST['datef'], "date"),
	SSQL($_POST['typ_cod'], "int"),
	SSQL($_POST['don'], "text"),
	SSQL($_POST['des'], "text"),
	SSQL($dStat, "int"),
	SSQL($id, "int"));
	if(@mysql_query($qryupd)) $LOG.='<p>Tratamiento Infertilidad Actualizado</p>';
	else $LOG.='Error al Actualizar Tratamiento Infertilidad. ';
	$goTo.='?id='.$id;
	}
	
}
if ((isset($action)) && ($action == 'DELEF')){
	$qrydel=sprintf('DELETE FROM db_tratamiento_infertilidad_media WHERE id_ti=%s',
	SSQL($id, "int"));
	if(@mysql_query($qrydel)){
		$LOG.='<p>Eliminado Multimedia</p>';
		
		$qrydel=sprintf('DELETE FROM db_tratamiento_infertilidad WHERE id_ti=%s',
		SSQL($id, "int"));
		if(@mysql_query($qrydel)){
			$LOG.='<p>Eliminado Tratamiento Infertilidad</p>';
		}else{
			$LOG.=mysql_error();
		}
		
	}else{
		$LOG.=mysql_error();
	}
	
	
	
	
	$accjs=TRUE;
}
if ((isset($action)) && ($action == 'DELMTI')){
	$detTI=detRow('db_tratamiento_infertilidad_media','id',$idtim);
	$id=$detTI['id_ti'];
	$qrydel=sprintf('DELETE FROM db_tratamiento_infertilidad_media WHERE id=%s',
	SSQL($idtim, "int"));
	if(@mysql_query($qrydel)){
		$LOG.='<p>Eliminado Multimedia</p>';
	}else{
		$LOG.=mysql_error();
	}
	$goTo.='?id='.$id;
}
$LOG.=mysql_error();
$_SESSION['LOG']['m']=$LOG;

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