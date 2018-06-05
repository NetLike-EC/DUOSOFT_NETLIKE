<?php include('../../init.php');
include(RAIZf.'head.php');?>
<body class="cero">
<div class="container-fluid">
<div class="page-header"><h1>db_types <small>Mantenimiento Base de Datos</small></h1></div>
<div class="well well-sm">
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
	"robs_pos"=>array('NO DETERMINADO','DORSO IZQ.'),
	"robs_pres"=>array('NO DETERMINADO','CEFALICO'),
	"robs_liq_ami"=>array('NORMAL','OLIGOAMNIOS','LEVE','MODERADO','SEVERO'),
	"robs_plac"=>array('NORMAL','ANTERIOR ALTA','ANTERIOR BAJA','POSTERIOR ALTA','POSTERIOR BAJA',
	'PREVIA MARGINAL','PREVIA PARCIAL', 'PREVIA TOTAL','NORMO INSERTA'),
	"robs_va"=>array('N','A','NV'),
	"robs_va_sexo"=>array('MASCULINO','FEMENINO','NV'),
	"PUBLI"=>array('Radio','Prensa Escrita','Referido','Medico','WEB'),
	"TIPPAG"=>array('Efectivo','Credito','Poliza')
);

foreach($TYPES as $x=>$x_value){
	echo '<h5>TYP_REF = '.$x.'</h5>';
	$itemsl=count($x_value);
	echo '<small>';
	for($y=0;$y<$itemsl;$y++){
		
		$selitem=$x_value[$y];
		$query_RSt = sprintf("SELECT * FROM db_types WHERE typ_ref = %s AND typ_val=%s", 
			SSQL($x, "text"),
			SSQL($selitem, "text"));
		$RSt = mysql_query($query_RSt);
		$row_RSt = mysql_fetch_assoc($RSt);
		$totalRows_RSt = mysql_num_rows($RSt);
		$resitm='';
		if(!$row_RSt){
			$insertSQL = sprintf("INSERT INTO `db_types` (`typ_ref`,`typ_val`) VALUES (%s,%s)",
				SSQL($x, "text"),
				SSQL($selitem, "text"));
			$ResultInsert = mysql_query($insertSQL) or die(mysql_error());
			$classitm='label-info';
			$resitm='<i class="icon-star icon-white"></i>';
		}
		echo '<span class="label label-default '.$classitm.'">'.$selitem.' '.$resitm.'</span> ';
	}
	echo '</small>';
}
?>
</div>
<div class="alert alert-info"><h4>Tarea Finalizada</h4></div>
</div>
</body>
</html>