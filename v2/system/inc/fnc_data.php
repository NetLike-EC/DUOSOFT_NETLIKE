<?php
//Generar QRY para busqueda de pacientes

function genCadSearchPac($term){

if ($term){
	$cadBus=fnc_cutblanck($term);
	$cadBusT=explode(" ",$cadBus);
  	$cadBusN=count($cadBusT);
	//echo $cadBusN;
	if($cadBusN>1){
	$qry=sprintf('SELECT *, MATCH (db_clientes_nom.pac_nom, db_clientes_nom.pac_ape) AGAINST (%s) AS Score FROM db_clientes_nom
INNER JOIN db_clientes ON db_clientes.pac_cod=db_clientes_nom.pac_cod
WHERE MATCH (db_clientes_nom.pac_nom, db_clientes_nom.pac_ape) AGAINST (%s)
ORDER BY Score DESC ',
	SSQL($cadBus,'text'),
	SSQL($cadBus,'text'));
	}else{
		$qry=sprintf('SELECT * FROM db_clientes_nom
INNER JOIN db_clientes ON db_clientes.pac_cod=db_clientes_nom.pac_cod
WHERE db_clientes.pac_nom LIKE %s OR db_clientes.pac_ape LIKE %s ',
	SSQL('%'.$cadBus.'%','text'),
	SSQL('%'.$cadBus.'%','text'));
	}
}else{
	$qry=sprintf('SELECT * FROM db_clientes ORDER BY pac_cod DESC ');
}
return $qry;
}

//ESTADO FACTURA
function estCon($est){
	if($est=='1'){
		$stat['txt']='Tratada';
		$stat['inf']='<a class="btn disabled btn-info navbar-btn">Tratada <i class="fa fa-check-square-o"></i></a>';
	}else if($est=='0'){
		$stat['txt']='Anulada';
		$stat['inf']='<a class="btn disabled btn-danger navbar-btn">Anulada <i class="fa fa-check-square-o"></i></a>';
	}else if($est=='3'){
		$stat['txt']='Reservada';
		$stat['inf']='<a class="btn btn-info navbar-btn">Reservada <i class="fa fa-check-square-o"></i></a>';
	}else if(!$est){
		$stat['txt']='NO GUARDADA';
		$stat['inf']='<a class="btn disabled btn-danger navbar-btn">NO GUARDADA <i class="fa fa-arrow-circle-right"></i></a>';
	}
	return($stat);
}

//ULTIMA IMAGEN DE UN PACIENTE
function lastImgPac($param){
$dPI=detRow('db_clientes_media','cod_pac',$param,'id','DESC');
if($dPI){
	$dMed=detRow('db_media','id_med',$dPI['id_med']);
}
return $dMed['file'];
}

/************************************************************************************************************
	FUNCIONES DATOS (seleccionados), para seleccionarlos dento del Generar Select
************************************************************************************************************/
function detRowSel($table,$fielID,$field,$param){
	$query_RS_datos = sprintf('SELECT %s as sID FROM %s WHERE %s=%s',
	SSQL($fielID,''),
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if($totalRows_RS_datos>0){ $x=0;
		do{ $listCats[$x]=$row_RS_datos['sID']; $x++;
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return ($listCats);
}
//
function detRowGSel($table,$fieldID,$fieldVal,$field,$param){
$query_RS_datos = sprintf('SELECT %s AS sID, %s as sVAL FROM %s WHERE %s=%s',
SSQL($fieldID,''),
SSQL($fieldVal,''),
SSQL($table,''),
SSQL($field,''),
SSQL($param,'text'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}

//Datos de una TABLA / CAMPO / CONDICION
function detRow($table,$field,$param,$foN=NULL, $foF='ASC'){ 
if($foN) $paramOrd='ORDER BY '.$foN.' '.$foF;
$qry = sprintf("SELECT * FROM %s WHERE %s = %s ".$paramOrd.' LIMIT 1',
SSQL($table, ''),
SSQL($field, ''),
SSQL($param, "text"));
$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
mysql_free_result($RS); return ($dRS);
}

//Datos de una TABLA / CAMPO / CONDICION
function detSigLast($id){ $query_RS_datos = sprintf("SELECT * FROM db_signos WHERE pac_cod = %s ORDER BY id DESC",
SSQL($id, "int"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos de una terapista
function deterapista($id){ $query_RS_datos = sprintf("SELECT db_empleados.emp_cod,emp_nom,emp_ape 
FROM clinic_freimo.db_empleados
inner join tbl_usuario on tbl_usuario.emp_cod=db_empleados.emp_cod
WHERE db_empleados.emp_cod = %s",
SSQL($id, "int"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}


//Datos de una TABLA / CAMPO / CONDICION
function detRow2P($table,$field1,$param1,$field2,$param2,$cond){
$query_RS_datos = sprintf("SELECT * FROM %s WHERE %s=%s %s %s=%s",
SSQL($table, ''),
SSQL($field1, ''),
SSQL($param1, "text"),
SSQL($cond, ""),
SSQL($field2, ""),
SSQL($param2, "text"));
echo $query_RS_datos;
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);

}

function detRowNP($table,$params){
if($params){
	foreach($params as $x => $dat) {
		foreach($dat as $y => $xVal) $lP.=$xVal['cond'].' '.$xVal['field'].' '.$xVal['comp'].' "'.$xVal['val'].'" ';
	}
}
$qry = sprintf("SELECT * FROM %s WHERE 1=1 ".$lP,
SSQL($table, ''));
$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
return ($dRS); mysql_free_result($RS);
}

//Datos AUDITORIA
function infAud($id){
	$detAudi=dataAud($id,'ASC');
	$detAudi_id=$detAudi['id'];
	$detAudi_user=$detAudi['emp_nom'].' '.$detAudi['emp_ape'];
	$detAudi_inf='<small>'.$detAudi_user.' '.$detAudi['audd_datet'].'</small>';

	$detAudf=dataAud($id,'DESC');
	$detAudf_id=$detAudf['id'];
	
	if($detAudi_id!=$detAudf_id){
		$detAudf_user=$detAudf['emp_nom'].' '.$detAudf['emp_ape'];
		$detAudf_inf="Actualización. ".$detAudf_user.' '.$detAudf['audd_datet'];
	}
	
	$infAud='<span title="'.$detAudf_inf.'" class="tooltips">'.$detAudi_inf.'</span>';
return $infAud;
}

function dataAud($param1,$ord){
	if (!$ord) $ord='DESC';
	$query_RS_datos = sprintf('SELECT * FROM db_auditoria_detalle 
	LEFT JOIN tbl_usuario ON db_auditoria_detalle.usr_id=db_auditoria_detalle.usr_id 
	INNER JOIN db_empleados ON tbl_usuario.emp_cod=db_empleados.emp_cod 
	WHERE db_auditoria_detalle.id_aud=%s ORDER BY db_auditoria_detalle.id %s LIMIT 1',
	SSQL($param1,'text'),
	SSQL($ord,''));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	return ($row_RS_datos);
	mysql_free_result($RS_datos);
}

//Datos Modulo
function detMod($param1){ $qry = sprintf("SELECT * FROM db_componentes WHERE mod_cod=%s", SSQL($param1,'text'));
$RS=mysql_query($qry) or die(mysql_error()); $dRS=mysql_fetch_assoc($RS); 
return ($dRS); mysql_free_result($RS);
}

//Datos Modulo
function fnc_datamod($param1){ $query_RS_datos = "SELECT * FROM db_componentes WHERE mod_ref='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos Empleados
function dataEmp($param1){
	$query_RS_datos = sprintf('SELECT * FROM db_empleados WHERE emp_cod=%s LIMIT 1',
	SSQL($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos TYPES (db_types) [OK nueva version este si va]
function dTyp($param){ $qry = sprintf("SELECT * FROM  db_types WHERE typ_cod=%s",SSQL($param,'text'));
$RS = mysql_query($qry) or die(mysql_error()); $dRS = mysql_fetch_assoc($RS); 
mysql_free_result($RS);return ($dRS);
}
//Datos Usuario Systema
function dataUser($param1){
	$query_RS_datos = sprintf('SELECT * FROM tbl_usuario WHERE usr_nombre=%s LIMIT 1',
	SSQL($param1,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos paciente
function dPac($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_clientes WHERE db_clientes.pac_cod = %s", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Datos paciente
function dataPachis($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_signos WHERE db_signos.pac_cod = %s ORDER BY id DESC LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Diagnostico Definitivo
function fnc_datadiagd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_diagnosticos WHERE db_diagnosticos.id= %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Tratamiento
function fnc_datatrat($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos WHERE tid= %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Tratamiento Detalle
function fnc_datatratd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_tratamientos_detalle WHERE id= %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Obstetrico
function fnc_dataObs($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico WHERE obs_id= %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Obstetrico Detalle
function fnc_dataObsd($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_obstetrico_detalle WHERE id= %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}


//Datos Examen
function fnc_dataexam($param1){
	$query_RS_datos = sprintf("SELECT * FROM  db_examenes WHERE id = %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Documento Formato
function fnc_datadocf($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_documentos_formato WHERE id_df = %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Documento
function fnc_datadoc($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_documentos WHERE id_doc = %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Cirugia
function fnc_datacir($param1){
	$query_RS_datos = sprintf("SELECT * FROM db_cirugias WHERE id = %s LIMIT 1", SSQL($param1, "int"));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
	
//TOT ROWS
function totRowsTab($table,$field,$param){
	$query_RS_datos = sprintf('SELECT * FROM %s WHERE %s=%s',
	SSQL($table,''),
	SSQL($field,''),
	SSQL($param,'text'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	return ($totalRows_RS_datos);
}
?>