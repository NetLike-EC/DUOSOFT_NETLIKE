<?php require_once('../../init.php');
include(RAIZf.'head.php'); ?>
<title>POLIZA</title>
<?php
$paciente_RS_poliza = "-1";
if (isset($_GET['idp'])) {
  $paciente_RS_poliza = $_GET['idp'];
}

$query_RS_poliza = sprintf("SELECT MAX(cod_pol) as poliza FROM tbl_polizas WHERE  cod_pac=%s", SSQL($paciente_RS_poliza, "int"));
$RS_poliza = mysql_query($query_RS_poliza) or die(mysql_error());
$row_RS_poliza = mysql_fetch_assoc($RS_poliza);
$totalRows_RS_poliza = mysql_num_rows($RS_poliza);

$cod_poliza_RS_find_poliza = "-1";
if (isset($_GET['cod_poliza'])) {
  $cod_poliza_RS_find_poliza = $_GET['cod_poliza'];
}

$query_RS_find_poliza = sprintf("SELECT * FROM tbl_polizas WHERE cod_pol = %s", SSQL($cod_poliza_RS_find_poliza, "int"));
$RS_find_poliza = mysql_query($query_RS_find_poliza) or die(mysql_error());
$row_RS_find_poliza = mysql_fetch_assoc($RS_find_poliza);
$totalRows_RS_find_poliza = mysql_num_rows($RS_find_poliza);

$accion = $_GET['accion'];
$cod_poliza = $_GET['cod_poliza'];
$idpac=$_GET['idp'];
//secho "ok".$accion."poliza".$cod_poliza."consulta".$_GET['con_num'];

if ($accion=="GUARDAR")
{
	$poliza_num = $row_RS_poliza['poliza']+1;
	$connum=$_GET['con_num'];
	$txt_valor=$_POST['txt_valor'];
	$fec = date("m/d/y");
	//$est_pol = 'P';
}
else 
{
	if ($accion=="ACTUALIZAR")
	{
		$poliza_num = $row_RS_find_poliza['cod_pol'];
		$connum = $row_RS_find_poliza['con_num'];
		$txt_valor= $row_RS_find_poliza['val_pol'];
		$fec = $row_RS_find_poliza['fec_pol'];
		//echo $row_RS_find_poliza['cod_pol'];
		$est_pol = 'R';
	}
}

$ext_admitidas = array('.jpg','.gif','.png','.jpeg'); // Extensiones permitidas.

if($_POST["userfile"]){
	echo"Subida IMagen<br />";
	echo $_POST["userfile"]."<br />";
	$resfileupload=uploadfile($_POST["userfile"], "img_db/pol/", $ext_admitidas, "2097152");
	echo $resfileupload[0]."<br />";
	echo $resfileupload[1]."<br />";
	
	$fileextnam = $_FILES['userfile']['name']; // Obtiene el nombre del archivo, y su extension.
	echo "-".$fileextnam."-<br />";
	$ext = substr($fileextnam, strpos($fileextnam,'.'), strlen($fileextnam)-1); // Saca su extension.
	
	$filename = $code.'_'.$prefijo.'pol'.$ext; // Obtiene el nombre del archivo, y su extension.}
	
	echo "*".$filename;
	
	if($resfileupload[0]=="OK"){
		$tempsqlfile[0]=" ,file_poliza=";
		$tempsqlfile[1]="'".$resfileupload[1]."'";
	}
}
if (($_POST["action"]=="GUARDAR")&&($txt_valor!=0)){
	
	$cadena ="INSERT INTO tbl_polizas (est_pol,val_pol,fec_pol,con_num,cod_pac, file_poliza) VALUES ('$est_pol','$txt_valor','$fec','$connum','$idpac', $tempsqlfile[1])";
	
	
	@mysql_query($cadena)or($LOG=mysql_error());
	$LOG.= "Poliza Grabada [OK]<br />";	
	$accion = "ACTUALIZAR";
}
else
{
   if (($_POST["action"]=="ACTUALIZAR")&&($txt_valor!=0))
   {
		//@mysql_query("UPDATE tbl_polizas set val_pol='$txt_valor',fec_pol='$fec' where cod_pac='$idpac' and con_num='$connum'")or($LOG=mysql_error());
	//$LOG.= "Poliza Actualizada [OK]<br />";	
		//echo "UPDATE tbl_polizas set val_pol='$txt_valor',fec_pol='$fec'".$tempsqlfile[0].$tempsqlfile[1]." where cod_pac='$idpac' and con_num='$connum'";
   }
	//$accion = "ACTUALIZAR";
	//echo $accion;
}
?>

<body>
<div id="head_sec"><a href="#" class="link">POLIZA</a></div>
<div id="cont_head">
<form method="post" action="polizas_form.php?idp=<?php echo $_GET['idp'];?>&cod_poliza=<?php echo $poliza_num;?>&accion=<?php echo $accion;?>&con_num=<?php echo $connum;?>" >
<?php
$row_pac = dPac($_GET['idp']); 
?>
<table border="3" align="center">
<tr bordercolor="#000000">
	<td>Poliza Numero:</td>
	<td><?php echo $poliza_num;?></td>
</tr>
<tr>
	<td>Fecha Poliza:</td>
    <td><?php echo $fec;?></td>
</tr>
<tr>
	<td>Paciente:</td>
    <td><?php echo $row_pac["cli_nom"]." ".$row_pac["cli_ape"];?></td>
</tr>
<tr>
	<td>Consulta Numero:</td>
    <td><?php echo $connum;?></td>
</tr>
<tr>
	<td>Valor Poliza:</td>
    <td><input type="text" name="txt_valor" value="<?php echo $txt_valor;?>" /></td>
</tr>
<?php 
if(($row_RS_find_poliza['file_poliza'])&&($accion=="ACTUALIZAR"))
{
	?>
	<tr><td></td><td><img src="<?php echo $row_RS_find_poliza['../../file_poliza']; ?>"/></td></tr>
	<?php 
}else{?>
	<tr><td></td><td>NO Existe Archivo imagen</td></tr>
<?php }?>
<tr>
	<td>Cargar Poliza:</td>
    <td><input name="userfile" type="file" class="txt_values-sec" id="userfile" size="0" /></td>
</tr>
<tr><td></td><td><input type="submit" value="<?php echo $accion;?>"/>
  <input name="action" type="hidden" id="action" value="<?php echo $accion;?>"></td></tr>
 </table>
</form>
</div>
</body>
</html>
<?php
mysql_free_result($RS_poliza);

mysql_free_result($RS_find_poliza);
?>