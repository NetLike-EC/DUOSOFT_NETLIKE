<?php require_once('../../Connections/conn.php'); ?>

<?php
/*function disable_reserv($con_fin,$pac_fin){
if(@mysql_result(@mysql_query("SELECT * FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'"),'cons_res_num'))
{
	if(@mysql_query("DELETE FROM db_consultas_reserva WHERE con_num='$con_fin' AND pac_cod='$pac_fin'")or($res_fun=mysql_error()))
		$res_fun.="Eliminada Reserva";
	else
		$res_fun.="Falla Eliminación Reserva";
}
return $res_fun;
}
?>
<?php
session_start();
$con_num=$_POST['idc'];
$idp=$_POST['idp'];
$txt_con_diag=$_POST['txt_con_diag'];
$date_con=date("Y-m-d H:i:s");
$txt_con_val=$_POST['txt_con_val'];
$sel_tip_pag=$_POST['list_tip_pag'];

if ($_POST['btn_action']=="GRABAR")
{
	@mysql_query("INSERT INTO db_consultas (con_num, pac_cod, con_fec, con_diagp, con_stat, con_val, tip_pag) VALUES ('$con_num','$idp', '$date_con','$txt_con_diag','1','$txt_con_val','$sel_tip_pag')")or($LOG=mysql_error());
	$LOG.= "Consulta Grabada [OK]<br />";
	if(@mysql_query("INSERT INTO tbl_cta_por_cobrar (con_num, pac_cod, cta_fecha, cta_detalle, cta_valor, cta_abono, cta_cantidad) VALUES ('$con_num','$idp', '$date_con', 'Consulta $con_num', '$txt_con_val', '0', '1')")or($LOG.=mysql_error()))
		$LOG.= "Cuenta x Cobrar - Generada [OK]<br />";
	else
		$LOG.= "ERROR - Cuenta x Cobrar no Grabada";


	if ($sel_tip_pag==3)
	{
		@mysql_query("INSERT INTO tbl_polizas (con_num,cod_pac,est_pol) VALUES 			('$con_num','$idp','P')")or($LOG=mysql_error());
		$LOG.= "Poliza Grabada [OK]<br />";
	}
	
	
}
if ($_POST['btn_action']=="ACTUALIZAR")
{
	if($_POST['cons_stat']==0)
		$SQL_upd="UPDATE db_consultas SET con_diagp='$txt_con_diag', con_stat='1', con_fec='$date_con', tip_pag='$sel_tip_pag' WHERE con_num='$con_num' AND pac_cod='$idp'";
	else
		$SQL_upd="UPDATE db_consultas SET con_diagp='$txt_con_diag', con_stat='1' WHERE con_num='$con_num' AND pac_cod='$idp'";
		
	if(@mysql_query($SQL_upd)or($LOG=mysql_error()))
	{
		$LOG.= "Actualizado. Consulta:".$con_num.'<br />';
		$LOG.= disable_reserv($con_num,$idp);
	}
	else
		$LOG.= "ERROR Actualización";

}
$_SESSION['LOG']=$LOG;
$insertGoTo = 'form.php?LOG='.$LOG.'&idc='.$con_num.'&idp='.$idp.'&action_cons=update';
header(sprintf("Location: %s", $insertGoTo));
*/
?>