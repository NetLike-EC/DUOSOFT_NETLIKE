<?php require_once('../../Connections/conn.php');
$idp_pol_Rs_polizas = "-1";
if (isset($_GET['idp_pol'])) {
  $idp_pol_Rs_polizas = $_GET['idp_pol'];
}

$query_Rs_polizas = sprintf("SELECT * FROM tbl_polizas WHERE cod_pac = %s", SSQL($idp_pol_Rs_polizas, "int"));
$Rs_polizas = mysql_query($query_Rs_polizas) or die(mysql_error());
$row_Rs_polizas = mysql_fetch_assoc($Rs_polizas);
$totalRows_Rs_polizas = mysql_num_rows($Rs_polizas);

$idp_pol_Rs_paciente = "-1";
if (isset($_GET['idp_pol'])) {
  $idp_pol_Rs_paciente = $_GET['idp_pol'];
}

$query_Rs_paciente = sprintf("SELECT * FROM db_clientes WHERE db_clientes.pac_cod = %s", SSQL($idp_pol_Rs_paciente, "int"));
$Rs_paciente = mysql_query($query_Rs_paciente) or die(mysql_error());
$row_Rs_paciente = mysql_fetch_assoc($Rs_paciente);
$totalRows_Rs_paciente = mysql_num_rows($Rs_paciente);
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Documento sin título</title>
</head>

<body bgcolor="#FFFFFF">
<div id="cont_head">
<table id="tabla1">
<tr><td><?php echo $row_Rs_paciente['pac_nom']." ".$row_Rs_paciente['pac_ape'];?></td></tr>
<tr>
	<td>Poliza</td>
    <td>Valor</td>
    <td>Fecha</td>
    <td>Estado</td>


    
</tr>
<?php
do 
{
	?>
	<tr>
    	<td><a href="polizas_form.php?cod_poliza=<?php echo $row_Rs_polizas['cod_pol'];?>&amp;accion=ACTUALIZAR&amp;idp=<?php echo $row_Rs_paciente['pac_cod'];?>">Editar</a></td>
        <td><?php echo $row_Rs_polizas['cod_pol'];?></td>
        <td><?php echo $row_Rs_polizas['fec_pol'];?></td>
        <td><?php echo $row_Rs_polizas['val_pol'];?></td>
        <td><?php echo $row_Rs_polizas['est_pol'];?></td>
	</tr>
	<?php
}while ($row_Rs_polizas = mysql_fetch_assoc($Rs_polizas));
?>
</table>
</div>
</body>
</html>
<?php
mysql_free_result($Rs_polizas);

mysql_free_result($Rs_paciente);
?>
