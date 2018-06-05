<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>tbl_types <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-small">
<?php
$TYPES = array(
	"TIPSAN"=>array('AB Rh +','AB Rh -','A Rh +','A Rh -','B Rh +','B Rh -','O Rh +','O Rh -'),
	"ESTCIV"=>array('Casado','Soltero','Divorciado','Viudo','Union Libre'),
	"SECTOR"=>array('Urbano','Rural'),
	"SEXO"=>array('Masculino','Femenino'),
	"INST"=>array('Primaria','Secundaria','Superior','Cuarto Nivel','Tecnica Vocacional', 'Ninguna'),
	"TIPEMP"=>array('Administrador','Medico','Enfermera','Secretaria'),
	"TIPCON"=>array('Privado','IESS','Seguro Privado','PREPAGO','CORTESIA'),
	"TIPEXAM"=>array('Examen de Sangre','Examen de Orina','Examen de Heces','IMAGENEOLOGIA'),
	"EMPTRB"=>array('NINGUNA','PRIVADA','PUBLICA','PROPIA'),
	"TIPCLI"=>array('Normal','Especial','Mayorista')
);

foreach($TYPES as $x=>$x_value){
	echo '<h5>TYP_REF = '.$x.'</h5>';
	$itemsl=count($x_value);
	echo '<small>';
	for($y=0;$y<$itemsl;$y++){
		
		$selitem=$x_value[$y];
		$query_RSt = sprintf("SELECT * FROM tbl_types WHERE typ_ref = %s AND typ_nom=%s", 
			GetSQLValueString($x, "text"),
			GetSQLValueString($selitem, "text"));
		$RSt = mysql_query($query_RSt);
		$row_RSt = mysql_fetch_assoc($RSt);
		$totalRows_RSt = mysql_num_rows($RSt);
		$resitm='';
		if(!$row_RSt){
			$insertSQL = sprintf("INSERT INTO `tbl_types` (`typ_ref`,`typ_nom`) VALUES (%s,%s)",
				GetSQLValueString($x, "text"),
				GetSQLValueString($selitem, "text"));
			$ResultInsert = mysql_query($insertSQL) or die(mysql_error());
			$classitm='label-info';
			$resitm='<i class="icon-star icon-white"></i>';
		}
		echo '<span class="label '.$classitm.'">'.$selitem.' '.$resitm.'</span> ';
	}
	echo '</small>';
}
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>