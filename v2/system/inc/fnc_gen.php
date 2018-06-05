<?php

function clsRO($val){
			$valFin=eregi_replace("[\n|\r|\n\r]", " ", $val);
			return $valFin;
		}
		function datefRO($val){
			$newDate = date("Y-m-d", strtotime($val));
			return($newDate);
		}

function calcIMC($IMC=NULL, $pesoKG=NULL, $talla=NULL){
	$talla=$talla/100;
	if((!$IMC)||($IMC==NULL)||($IMC==0)){
		if(($talla>0)&&($pesoKG>0)){
			$IMC=$pesoKG / ($talla*$talla);
		}
	}

	if($IMC<=0) $infIMC='<span class="label label-default"> No Determinado </span>';
	if(($IMC>0)&&($IMC<18)){$infIMC='<span class="label label-danger">Peso Bajo</span>';}
	if(($IMC>=18)&&($IMC<25)){$infIMC='<span class="label label-info">Normal</span>';}
	if(($IMC>=25)&&($IMC<30)){$infIMC='<span class="label label-success">Sobrepeso</span>';}
	if(($IMC>=30)&&($IMC<35)){$infIMC='<span class="label label-warning">Obesidad grado I</span>';}
	if(($IMC>=35)&&($IMC<40)){$infIMC='<span class="label label-warning">Obesidad grado II</span>';}
	if($IMC>=40){$infIMC='<span class="label label-danger"> Obesidad grado III</span>';}

	$retIMC['val']=number_format($IMC,2);
	$retIMC['inf']=$infIMC;
	
	return $retIMC;
}

function genSelectG($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL){
	//$nom. name selselector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales	
	
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	if (!$nom) $nom="select";		
	echo '<select name="'.$nom.'" id="'.$nom.'" class="'.$class.'" '.$opt.'>';
	echo '<option value=""';	
	if (!(strcmp(-1, $sel))) {echo "selected=\"selected\"";} ?>	
	<?php echo '>- Seleccione -</option>';	
	if ($totalRows_RS_datos>0){	
		$grpSel=NULL; $banG=false;
		do {
			$grpAct=$row_RS_datos['sGRUP'];
			if($grpSel!=$grpAct){		
				if($banG==true) echo '</optgroup>'; 
				echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
				$grpSel=$grpAct;
				$banG=true;
			}
			echo '<option value="'.$row_RS_datos['sID'].'"';	
			if (!(strcmp($row_RS_datos['sID'], $sel))) {echo "selected=\"selected\"";} ?>	
			<?php echo '>'.$row_RS_datos['sVAL'].'</option>';	
		} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
		if($banG==true) echo '</optgroup>';
	}	
	$rows = mysql_num_rows($RS_datos);	
	if($rows > 0) {	
		mysql_data_seek($RS_datos, 0);	
		$row_RSe = mysql_fetch_assoc($RS_datos);	
	}
	echo '</select>';	
	mysql_free_result($RS_datos);
	
}



//FUNCTION TO GENERATE SELECT (FORM html)
function genSelect($nom=NULL, $RS_datos, $sel=NULL, $class=NULL, $opt=NULL, $id=NULL, $placeHolder=NULL, $showIni=TRUE){
	//Version 3.0 (Multiple con soporte choses, selected multiple)
	//$nom. nombre sel selector
	//$RS_datos. Origen de Datos
	//$sel. Valor Seleccionado
	//$class. Clase aplicada para Objeto
	//$opt. Atributos opcionales
	if($RS_datos){
	$row_RS_datos = mysql_fetch_assoc($RS_datos);
	$totalRows_RS_datos = mysql_num_rows($RS_datos);
	
	
	if(!isset($id))$id=$nom;
	if (!$nom) $nom="select";
	echo '<select name="'.$nom.'" id="'.$id.'" class="'.$class.'" data-placeholder="'.$placeHolder.'" '.$opt.'>';
	
	if($showIni==TRUE){
		echo '<option value=""';
		if (!$sel) {echo "selected=\"selected\"";}
		echo '>- Seleccione -</option>';	
	}
	
	if($totalRows_RS_datos>0){
	do {
		$grpAct=$row_RS_datos['sGRUP'];
		if(($grpSel!=$grpAct)&&($grpAct)){		
			if($banG==true) echo '</optgroup>'; 
			echo '<optgroup label="'.$row_RS_datos['sGRUP'].'">';
			$grpSel=$grpAct;
			$banG=true;
		}
		echo '<option value="'.$row_RS_datos['sID'].'"'; 
		if(is_array($sel)){ if(in_array($row_RS_datos['sID'],$sel)){ echo 'selected="selected"'; }
		}else{ if (!(strcmp($row_RS_datos['sID'], $sel))) {echo 'selected="selected"';} }
		?>
		<?php echo '>'.$row_RS_datos['sVAL'].'</option>';
	} while ($row_RS_datos = mysql_fetch_assoc($RS_datos));
	if($banG==true) echo '</optgroup>';
	$rows = mysql_num_rows($RS_datos);
	if($rows > 0) {
		mysql_data_seek($RS_datos, 0);
		$row_RSe = mysql_fetch_assoc($RS_datos);
	}
	}
	echo '</select>';
	
	mysql_free_result($RS_datos);
	}else{
		echo '<span class="label label-danger">Error genSelect : '.$nom.'</span>';
	}
}

?>