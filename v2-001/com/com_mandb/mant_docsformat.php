<?php include('../../init.php');
include(RAIZf.'head.php');
$inf_sello="";
$img_uteroA='<img src="'.$RAIZ.'images/struct/uteroA.jpg" />';
$img_uteroB='<img src="'.$RAIZ.'images/struct/uteroB.jpg" />';
$inf_sello="";
$inf_med='<p style="text-align: center;">Dr. Eduardo Baculima Bernal<br/>GINECOLOGO - MED. REPRODUCTIVA</p>';
$inf_cont='<p style="text-align: right;">Email: fertilidad@biogepa.com</p>';
?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1><a onClick="location.reload();" class="btn"><i class="icon-refresh"></i></a> db_documentos_formato <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
<?php
$docformat[0]['nom']='CERTIFICADO';
$docformat[0]['for']='
<div style="font-size:14px;">
<br/>
<br/>
<br/>
<br/>
<br/>
<p style="text-align: right;">Cuenca, .</p>
<br/>
<br/>
<p>A Peticion Verbal de la parte interesada se extiende la presente</p>
<h2 style="text-align: center;">CERTIFICACION</h2>
<p>Que , con CI: , de edad .<br>
Acude a la consulta, presentando un Diagnóstico compatible con . </p>
<p>Se recomienda reposo.</p>
<p>Certificación extendida a , en la ciudad de Cuenca, para ser presentada a quien corresponda.</p>
<br/>
<br/>'.$inf_sello.'</div>';

$docformat[1]['nom']='CONSTANCIA';
$docformat[1]['for']='
<div style="font-size:14px;">
<br/>
<br/>
<p style="text-align: right;">Cuenca, .<br/>Paciente. .</p>
<br/>
<br/>
<h2 style="text-align: center;">CONSTANCIA</h2>
<p>Que el señor/a, ,con CI: . Es atendido en este consultorio el día de la fecha desde las  hasta las .</p>
<p>Para ser presentada a quien corresponda.</p>
<br/>
<p>Atentamente</p>
<br/>'.$inf_sello.'<br/>'.$inf_med.'<br/>'.$inf_cont.'</div>';

$docformat[2]['nom']='INCAPACIDAD';
$docformat[2]['for']='
<div style="font-size:14px; font-family:Arial, Helvetica, sans-serif; padding:20px 10px 10px 20px;">
<br/>
<br/>
<br/>
<h2 style="text-align: center;">CERTIFICADO DE INCAPACIDAD MEDICA</h2>
<br />
<br />
<p><strong>FECHA DE INCAPACIDAD:</strong>&nbsp;&nbsp;</p>
<div>
	<div style="width:50%; float:left"><strong>INGRESO:</strong> <br />&nbsp;</div>
	<div style="width:50%; float:left"><strong>EGRESO:</strong> <br />&nbsp;</div>
</div>
&nbsp;
<br />
<p><strong>NOMBRES Y APELLIDOS DEL PACIENTE:</strong></p>
<p></p>
<br />
<p><strong>NUMERO DE CÉDULA DE IDENTIFICACIÓN:</strong></p>
<p></p>
<br />
<p><strong>DIAGNÓSTICO:</strong></p>
<p></p>
<br />
<p><strong>NÚMERO DE DÍAS DE INCAPACIDAD: </strong></p>
<div>
	<div style="width:50%; float:left"><strong>NUMERO:</strong>&nbsp;</div>
	<div style="width:50%; float:left"><strong>LETRAS:</strong>&nbsp;</div>
    <div style="clear:both"></div>
	<br />
	<div>Desde &nbsp;&nbsp;&nbsp; hasta </div>
</div>
&nbsp;
<br />
<br />
<p><strong>NOMBRES Y APELLIDOS DEL TRATANTE: </strong></p>
<p></p>
<br/>'.
$inf_sello
.'<br/>
<p>FIRMA DEL TRATANTE: _________________________________
<div style="text-align:center">CÓDIGO Y SELLO DEL MSP</div></p></div>';

$docformat[3]['nom']='NORMALES';
$docformat[3]['for']='
<div style="font-size:14px;">
<br/>
<br/>
<br/>
<p style="text-align: right;">Cuenca, .</p>
<br/>
<br/>
<p>A Peticion Verbal de la parte interesada certifico que luego de haber sido examinado el Paciente. , de edad. con numero de Cédula de Identidad. </p>
<p>No presenta alteración orgánica alguna, ni enfermedad infecto-contagiosa.</p>
<p>Es lo que puedo certificar en honor a la verdad.</p>
<br/></div>';

$docformat[4]['nom']='HISTEROSCOPIA';
$docformat[4]['for']='
<div style="font-size:14px;">
<br/>
<p style="text-align: left;"><strong>Fecha</strong>: </p>
<p style="text-align: left;"><strong>Paciente</strong>: </p>
<br/>'.
'<table style="width:100%"><tr>
<td style="width:40%">'.$img_uteroA.'</td>
<td style="width:60%">'.$img_uteroB.'</td>
</tr></table>'.
'<br/>
<br/>
<h2>Informe</h2>
<ul>
<li>HISTEROSCOPIA OFICINAL: UM: </li>
<li>VAGINOSCOPIA: </li>
<li>CUELLO: </li>
<li>ENDOCERVIX: </li>
<li>UTERO: </li>
<li>C. UTERINA: </li>
<li>ENDOMETRIO: </li>
<li>OSTIUM DERECHO: </li>
<li>OSTIUM IZQUIERDO: </li>
</ul>
<h2>Conclusiones</h2>
<ul>
<li>&nbsp;</li>
</ul>
</div>';

$numdf=count($docformat);
echo '<p>Formatos a Procesar: '.$numdf.'</p>';
echo '<ol>';
for($i=0;$i<$numdf;$i++){
	$nombre=$docformat[$i]['nom'];
	$format=$docformat[$i]['for'];
	
	$query_RS_datos = sprintf("SELECT * FROM db_documentos_formato WHERE nombre = %s LIMIT 1", 
	SSQL($nombre, "text"));
	$RS_datos = mysql_query($query_RS_datos) or die(mysql_error());
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	echo '<li>';
	if($totalRows_RS_datos>0){
		$insertSQL = sprintf("UPDATE `db_documentos_formato` set `formato`=%s WHERE nombre=%s",
		SSQL($format, "text"),
		SSQL($nombre, "text"));
		if(mysql_query($insertSQL)) echo '<h4>Actualizado Formato de Documento</h4>Nombre: '.$nombre;
		else echo '<h4>Error</h4>No se pudo crear Actualizar de Documento';
		echo mysql_error();
	}else{
		$insertSQL = sprintf("INSERT INTO `db_documentos_formato` (`nombre`,`formato`) VALUES (%s,%s)",
		SSQL($nombre, "text"),
		SSQL($format, "text"));
		if(mysql_query($insertSQL)) echo '<h4>Creado Formato de Documento</h4>Nombre: '.$nombre;
		else echo '<h4>Error</h4>No se pudo crear Formato de Documento';
		echo mysql_error();	
	}
	echo '</li>';
	mysql_free_result($RS_datos);
}
echo '</ol>';
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>