<?php
//Datos de una TABLA / CAMPO / CONDICION
function detRow($table,$field,$param){ $query_RS_datos = sprintf("SELECT * FROM %s WHERE %s = %s",
GetSQLValueString($table, ''),
GetSQLValueString($field, ''),
GetSQLValueString($param, "text"));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos de una TABLA / CAMPO / CONDICION --> Selección
function detSRow($table,$field,$param){ $query_RS_datos = sprintf("SELECT * FROM %s WHERE %s=%s",
GetSQLValueString($table,''),
GetSQLValueString($field,''),
GetSQLValueString($param,'text'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Auditoria
function detAud($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_auditoria 
INNER JOIN tbl_user_system ON tbl_auditoria.user_id=tbl_user_system.user_id 
INNER JOIN tbl_empleados ON tbl_user_system.emp_cod=tbl_empleados.emp_cod 
INNER JOIN tbl_personas ON tbl_empleados.per_id=tbl_personas.per_id 
WHERE tbl_auditoria.aud_id=%s",
GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Modulo
function detMod($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_modules WHERE mod_ref=%s",
GetSQLValueString($param1,'text')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Empleados
function detEmpPer($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_empleados 
LEFT JOIN tbl_personas ON tbl_empleados.per_id=tbl_personas.per_id  WHERE emp_cod=%s",
GetSQLValueString($param1,'int')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Cliente
function detCliPer($param1){ $query_RS_datos = sprintf('SELECT * FROM tbl_clientes 
LEFT JOIN tbl_personas ON tbl_clientes.per_id=tbl_personas.per_id WHERE cli_cod=%s',
GetSQLValueString($param1,'int')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Proveedores
function detProvPer($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_proveedores 
LEFT JOIN tbl_personas ON tbl_proveedores.per_id=tbl_personas.per_id  WHERE prov_id=%s",
GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Personas
function detPer($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_personas WHERE per_id=%s",
GetSQLValueString($param1,'int')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Datos Empleados
function fnc_dataUser($param1){ $query_RS_datos = sprintf("SELECT * FROM tbl_user_system WHERE user_username=%s",
GetSQLValueString($param1,'text')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Detalle Producto
function detInvProd($param1){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_productos WHERE prod_id=%s",
	GetSQLValueString($param1,'int')); $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Detalle Categoria
function detInvCat($param1){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_categorias WHERE cat_cod=%s", GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Detalle Tipo
function detInvTip($param1){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_tipos WHERE tip_cod=%s", GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}
//Detalle Marca
function detInvMar($param1){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_marcas WHERE mar_id=%s", GetSQLValueString($param1,'int'));
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Detalle Profundo del Producto
function detProdAll($param1){
	$query_RS_datos = "SELECT tbl_inv_productos.prod_id, tbl_inv_productos.prod_nom, tbl_inv_tipos.tip_nom, tbl_inv_marcas.mar_nom, tbl_inv_productos.prod_img FROM tbl_inv_productos INNER JOIN tbl_inv_tipos ON tbl_inv_productos.tip_cod=tbl_inv_tipos.tip_cod INNER JOIN tbl_inv_marcas ON tbl_inv_productos.mar_id=tbl_inv_marcas.mar_id WHERE tbl_inv_productos.prod_id=".$param1;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

function dataProdExis($param1){
	$query_RS_datos = sprintf('SELECT tbl_compra_det.prod_id as prod_id FROM tbl_inventario 
	INNER JOIN tbl_compra_det ON tbl_inventario.comdet_id=tbl_compra_det.id 
	INNER JOIN tbl_inv_productos ON tbl_compra_det.prod_id=tbl_inv_productos.prod_id
	WHERE inv_id=%s',
	GetSQLValueString($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);
}

//Detalle Cabecera Factura Compra
function fnc_detComCab($param1){ $query_RS_datos = "SELECT * FROM tbl_compra_cab WHERE com_num='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Detalle Detalle Factura Compra
function fnc_detComDet($param1){ $query_RS_datos = "SELECT * FROM tbl_compra_det WHERE id='".$param1."'"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Numero de Ciclo mas alto
function fnc_numIniCic(){
$query_RS_datos = "SELECT MAX(faccic_id) AS id, MAX(faccic_ini) AS num FROM tbl_factura_ciclosf";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
$row_RS_datos = mysql_fetch_assoc($RS_datos);
$totalRows_RS_datos = mysql_num_rows($RS_datos);
return ($row_RS_datos);
mysql_free_result($RS_datos);
}

//Detalle de un Ciclo de Facturacion
function detCicloFacLast(){ $query_RS_datos = "SELECT * FROM tbl_factura_ciclosf ORDER BY faccic_id DESC LIMIT 1"; $RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($row_RS_datos); mysql_free_result($RS_datos);}

//Numero de Factura mas alto
function fnc_numMaxFac(){
	$detCic=fnc_numIniCic();
	$cic_id=$detCic['id'];
	$query_RS_datos = sprintf('SELECT MAX(fac_num) AS num FROM tbl_factura_ven WHERE faccic_id=%s',
	GetSQLValueString($cic_id,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);

	if($row_RS_datos['num']){
		$num_fac_max=$row_RS_datos['num']+1;
	}else{
		$num_fac_max=$detCic['num'];
	}

	return ($num_fac_max);
	mysql_free_result($RS_datos);
}

/************
TOTALS
************/
function fnc_TotCli(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_clientes");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_TotInvProd(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_productos");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_TotInvTip(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_tipos");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_TotInvCat(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_categorias");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
function fnc_TotInvMar(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_inv_marcas");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_TotMod(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_modules");$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_TotAtrib(){
	$query_RS_datos = sprintf("SELECT * FROM tbl_types WHERE mod_ref=%s",
	GetSQLValueString('ATRIB','text'));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_TotMenus(){
	$query_RS_datos = "SELECT * FROM tbl_menus";
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}
//Total de Items de menus
function fnc_TotMenuItems($id=NULL){
	//$id : es el ID del menú en caso que quiera ver el total de items referentes a un menú
	if($id){//Si paso el $id (menu_id), armo una condicion para ver los items de un menu, caso contrario no hay condicion y muestra todos los items
		$cond=sprintf('WHERE menu_id=%s',GetSQLValueString($id,'int'));
	}
	$query_RS_datos = "SELECT * FROM tbl_menus_items ".$cond;
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function fnc_TotalRows($table){
$query_RS_datos = sprintf("SELECT * FROM %s",
GetSQLValueString($table,''));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); $row_RS_datos = mysql_fetch_assoc($RS_datos); $totalRows_RS_datos = mysql_num_rows($RS_datos); return ($totalRows_RS_datos); mysql_free_result($RS_datos);
}

function listTypesMod($param){
$query_RS_datos = sprintf("SELECT typ_cod as sID, typ_nom as sVAL, typ_ref as sGRUP FROM tbl_types WHERE mod_ref=%s ORDER BY sGRUP ASC",
GetSQLValueString($param,'text'));$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); return ($RS_datos); mysql_free_result($RS_datos);
}

function listAtribProd($param1){
	$query_RS_datos = sprintf('SELECT typ_cod as sID FROM tbl_inv_productos_atrib WHERE prod_id=%s',
	GetSQLValueString($param1,'int'));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	if($totalRows_RS_datos>0){
		$x=0;
		do{
			$listCats[$x]=$row_RS_datos['sID'];
			$x++;
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	}
	mysql_free_result($RS_datos);
	return ($listCats);
}

function valPVP($val){
	$val=number_format(($val*1.12),4);
	return $val;
}
function valNETO($val){
	$val=number_format(($val/1.12),4);
	return $val;
}

function listatipos($param1){
$query_RS_datos = "SELECT typ_cod AS sID, typ_nom as sVAL FROM tbl_types WHERE typ_ref='".$param1."' AND typ_stat='1'";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}
function listAtr($param1){
$query_RS_datos = "SELECT id AS sID, nom as sVAL FROM tbl_inv_atr WHERE ref='".$param1."'";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos); mysql_free_result($RS_datos);
}

function listProveedores(){$query_RS_datos = "SELECT tbl_proveedores.prov_id as sID, CONCAT(tbl_personas.per_nom,' ',tbl_personas.per_ape) as sVAL FROM tbl_proveedores
INNER JOIN tbl_personas ON tbl_proveedores.per_id=tbl_personas.per_id";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());return ($RS_datos);mysql_free_result($RS_datos);}
//Listado de Menus Contenedores
function listMenus(){$query_RS_datos = "SELECT menu_id as sID, CONCAT(menu_nom,' (',menu_id,')') as sVAL FROM tbl_menus";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());return ($RS_datos);mysql_free_result($RS_datos);}

//Listado de Items de Menu Validos : Son los items que son hijos del nivel 0 
function listItemsVal(){$query_RS_datos = "SELECT itemmenu_id as sID, CONCAT(itemmenu_nom,' - ',itemmenu_tit,' - ',itemmenu_id) as sVAL FROM tbl_menus_items WHERE itemmenu_parent=0";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());return ($RS_datos);mysql_free_result($RS_datos);}

function listaempleado($param1){
$query_RS_datos = "SELECT emp_cod AS sID, CONCAT(emp_nom, ' ', emp_ape) AS sVAL FROM tbl_empleados WHERE emp_tip='".$param1."'";
$RS_datos = mysql_query($query_RS_datos) or die(mysql_error()); 
return ($RS_datos);
mysql_free_result($RS_datos);
}

?>