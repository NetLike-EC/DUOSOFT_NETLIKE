<?php include_once('../../init.php');
$id=$_GET['id'];
$detRep=detRow('db_rep_obs','id',$id);
$detCon=detRow('db_consultas','con_num',$detRep['con_num']);
$detPac=detRow('db_clientes','pac_cod',$detCon['pac_cod']);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$detPac_edad=edad($detPac['pac_fec']);
$dettrat_fecha=date_ame2euro($dettrat['fecha']);

$qryRepDets=sprintf('SELECT * FROM db_rep_obs_detalle WHERE id_rep=%s',
SSQL($id,'int'));
$RSrepD=mysql_query($qryRepDets) or (mysql_error());
$row_RSrepD=mysql_fetch_assoc($RSrepD);
$TR_RSrepD=mysql_num_rows($RSrepD);

$qryM=sprintf('SELECT * FROM db_rep_obs_media WHERE id_rep=%s',
SSQL($id,'int'));
$RSm=mysql_query($qryM)or(mysql_error());
$row_RSm=mysql_fetch_assoc($RSm);
$TR_RSm=mysql_num_rows($RSm);
?>

<page_footer>
	<?php include(RAIZf.'fra_print_footer_gen.php') ?>
</page_footer>
<table style="width:100%" cellpadding="0" cellspacing="0">
	<tr>
    	<td style="width:20%">
        <?php
		$logo=RAIZi.'struct/logo001.jpg';
		?>
        <img src="<?php echo $logo ?>">
        </td>
        <td style="width:80%">
        <div style="padding:5px; text-align:center; font-size:24px;"><span style="color:#F30"><strong>BioGepa</strong></span></div>
<div style="padding:5px; text-align:center; font-size:20px; color:#036">Reproducción Humana y Ginecología</div>
<div style="padding:5px; text-align:center; font-size:16px; color:#036; text-decoration:underline; font-weight:bold">Reporte Ultrasonico Obstetrico</div>
        </td>
    </tr>
</table>
<div style="border:1px solid #CCC; margin:5px 0; padding:2px;">
	<span style="padding:5px; background:#CCC ">Fecha: </span> <span><?php echo $detRep['fechar'] ?></span> 
    <span style="padding:5px; background:#CCC; margin-left:10px;">Paciente: </span> <span><?php echo $detPac_nom ?></span> 
    <span style="padding:5px; background:#CCC; margin-left:10px;">Edad: </span> <span><?php echo $detPac_edad ?> años</span>
</div>
<div style="margin-top:10px;">
<table style="width:100%">
	<tr>
    	<td style="width:55%;">
        	<table style="width:100%; background:#efefef; border:1px solid #CCC"  cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:50%"><strong>FUM:</strong> <?php echo $detRep['fum'] ?></td>
                    <td style="width:50%"><strong>N° Fetos:</strong> <?php echo $TR_RSrepD ?></td>
                </tr>
                <tr>
                	<td style="width:50%"><strong>FPP.FUM:</strong> <?php echo $row_RSrepD['fpp_fum'] ?></td>
                    <td style="width:50%"><strong>EG.x FUM:</strong> <?php echo $row_RSrepD['eg_fum'] ?></td>
                </tr>
                <tr>
                	<td style="width:50%"><strong>FPP.GA:</strong> <?php echo $row_RSrepD['fpp_ga'] ?></td>
                    <td style="width:50%"><strong>EG.x US:</strong> <?php echo $row_RSrepD['eg_us'] ?></td>
                </tr>
            </table>
            <?php $contD=1;
			$SECC2.='<div style="border: 1px solid #eee">
			<div style="background:#036; color:#fff; padding:2px;">VALORACION BIOMETRICA</div>';
			
			$SECC3.='<div style="border: 1px solid #eee">
			<div style="background:#036; color:#fff; padding:2px;">VALORACION BIOFISICA</div>';
			
			$SECC4.='<div style="border: 1px solid #eee">
			<div style="background:#036; color:#fff; padding:2px;">VALORACION ANATOMICA</div>';
			
			$SECC5.='<div style="border: 1px solid #eee">
			<div style="background:#036; color:#fff; padding:2px;">INDICES</div>';
			
			$SECC6.='<div style="border: 1px solid #eee">
			<div style="background:#036; color:#fff; padding:2px;">CONCLUSIONES</div>';
			?>
            <?php do{ ?>
            <?php
            	$det_posicion=detRow('db_types','typ_cod',$row_RSrepD['posicion']);
				$det_posicion=$det_posicion['typ_val'];
				$det_presentacion=detRow('db_types','typ_cod',$row_RSrepD['presentacion']);
				$det_presentacion=$det_presentacion['typ_val'];
				
				$det_liquido=detRow('db_types','typ_cod',$row_RSrepD['liq_ami']);
				$det_liquido=$det_liquido['typ_val'];
				
				$det_placenta=detRow('db_types','typ_cod',$row_RSrepD['placenta']);
				$det_placenta=$det_placenta['typ_val'];
				
				$va_snc=detRow('db_types','typ_cod',$row_RSrepD['va_snc']);
				$va_snc=$va_snc['typ_val'];
				$va_cerebelo=detRow('db_types','typ_cod',$row_RSrepD['va_cerebelo']);
				$va_cerebelo=$va_cerebelo['typ_val'];
				$va_vent_lat=detRow('db_types','typ_cod',$row_RSrepD['va_vent_lat']);
				$va_vent_lat=$va_vent_lat['typ_val'];
				$va_estomago=detRow('db_types','typ_cod',$row_RSrepD['va_estomago']);
				$va_estomago=$va_estomago['typ_val'];
				$va_par_abd=detRow('db_types','typ_cod',$row_RSrepD['va_par_abd']);
				$va_par_abd=$va_par_abd['typ_val'];
				$va_4camcar=detRow('db_types','typ_cod',$row_RSrepD['va_4camcar']);
				$va_4camcar=$va_4camcar['typ_val'];
				$va_vejiga=detRow('db_types','typ_cod',$row_RSrepD['va_vejiga']);
				$va_vejiga=$va_vejiga['typ_val'];
				$va_rin=detRow('db_types','typ_cod',$row_RSrepD['va_rin']);
				$va_rin=$va_rin['typ_val'];
				$va_col=detRow('db_types','typ_cod',$row_RSrepD['va_col']);
				$va_col=$va_col['typ_val'];
				$va_cor_umb=detRow('db_types','typ_cod',$row_RSrepD['va_cor_umb']);
				$va_cor_umb=$va_cor_umb['typ_val'];
				$va_ext=detRow('db_types','typ_cod',$row_RSrepD['va_ext']);
				$va_ext=$va_ext['typ_val'];
				$va_sex=detRow('db_types','typ_cod',$row_RSrepD['va_sex']);
				$va_sex=$va_sex['typ_val'];
			
            if(($row_RSrepD['pes_fet'])||($det_posicion)||($det_presentacion)){
            $SECC1.='<table style="width:100%; border:1px solid #CCC" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:5%; background:#999; color:#FFF; font-size:14px;"><strong>'.$contD.'</strong></td>
                    <td style="width:30%"><strong>Peso:</strong> <br>'.$row_RSrepD['pes_fet'].'</td>
                    <td style="width:30%"><strong>Posición:</strong> <br>'.$det_posicion.'</td>
                    <td style="width:35%"><strong>Presentación:</strong> <br>'.$det_presentacion.'</td>
                </tr>
            </table>';
			}
			if($row_RSrepD['val_bio']){
			$SECC2.='<table style="width:100%" cellpadding="0" cellspacing="0">
			<tr>
			<td style="width:5%; background:#999; color:#FFF; font-size:14px;">'.$contD.'</td>
			<td style="width:95%">'.$row_RSrepD['val_bio'].'</td>
			</tr>
			</table>';
			}
			if(($det_liquido)||($det_placenta)||($row_RSrepD['fcf'])||($row_RSrepD['grado'])){
				$detPlacGrado=NULL;
				if(($row_RSrepD['grado'])||($row_RSrepD['grado']>=0)) $detPlacGrado=' - Grado.'.$row_RSrepD['grado'];
			$SECC3.='<table style="width:100%; border:1px solid #CCC" cellpadding="0" cellspacing="0">
            	<tr>
                	<td style="width:5%; background:#999; color:#FFF; font-size:14px;"><strong>'.$contD.'</strong></td>
                    <td style="width:25%"><strong>Liq. Ami:</strong> <br>'.$det_liquido.'</td>
                    <td style="width:35%"><strong>Placenta:</strong> <br>'.$det_placenta.$detPlacGrado.'</td>
                    <td style="width:35%">'.$row_RSrepD['fcf'].'</td>
                </tr>
            </table>';
			}
			
			if(($va_snc)||($va_cerebelo)||($va_vent_lat)||($va_estomago)||($va_par_abd)||($va_4camcar)||($va_vejiga)||($va_rin)||($va_col)||($va_cor_umb)||($va_ext)||($va_sex)){
			$SECC4.='<table style="width:100%; border:1px solid #CCC" cellpadding="0" cellspacing="0">
            	<tr>
                	<td rowspan="3" style="width:4%; background:#999; color:#FFF; font-size:14px;">'.$contD.'</td>
                    <td style="width:24%"><strong>SNC:</strong> '.$va_snc.'</td>
                    <td style="width:24%"><strong>Cerebelo:</strong> '.$va_cerebelo.'</td>
                    <td style="width:23%"><strong>Vent.Lat:</strong> '.$va_vent_lat.'</td>
					<td style="width:25%"><strong>Estom:</strong> '.$va_estomago.'</td>
                </tr>
				<tr>
                    <td style="width:24%"><strong>Pared.Ab:</strong> '.$va_par_abd.'</td>
                    <td style="width:24%"><strong>4Cam.Car:</strong> '.$va_4camcar.'</td>
                    <td style="width:23%"><strong>Vejiga:</strong> '.$va_vejiga.'</td>
					<td style="width:25%"><strong>Riñon:</strong> '.$va_rin.'</td>
                </tr>
				<tr>
                    <td style="width:24%"><strong>Columna:</strong> '.$va_col.'</td>
                    <td style="width:24%"><strong>Cor.Umb:</strong> '.$va_cor_umb.'</td>
                    <td style="width:23%"><strong>Ext:</strong> '.$va_ext.'</td>
					<td style="width:25%"><strong>Sexo:</strong> '.$va_sex.'</td>
                </tr>
            </table>';
			}
			
			if($row_RSrepD['cocientes']){
			$SECC5.='<table style="width:100%"  cellpadding="0" cellspacing="0">
			<tr>
			<td style="width:5%; background:#999; color:#FFF; font-size:14px;">'.$contD.'</td>
			<td style="width:95%">'.$row_RSrepD['cocientes'].'</td>
			</tr>
			</table>';
			}
			
			if($row_RSrepD['obs']){
			$SECC6.='<table style="width:100%"  cellpadding="0" cellspacing="0">
			<tr>
			<td style="width:5%; background:#999; color:#FFF; font-size:14px;">'.$contD.'</td>
			<td style="width:95%">'.$row_RSrepD['obs'].'</td>
			</tr>
			</table>';
			}
            $contD++;
			}while($row_RSrepD=mysql_fetch_assoc($RSrepD));
			
			if($TR_RSrepD<=1){ $padSpace="25px"; }
			if($TR_RSrepD==2){ $padSpace="5px"; }
			if($TR_RSrepD>=3){ $padSpace="0px"; }
			
			$divSpace='<div style="margin:'.$padSpace.' 0;">&nbsp;</div>';
			$SECC2.='</div>';
			$SECC3.='</div>';
			$SECC4.='</div>';
			$SECC5.='</div>';
			$SECC6.='</div>';
            echo $SECC1;
			echo $divSpace;
			echo $SECC2;
			echo $divSpace;
			echo $SECC3;
			echo $divSpace;
			echo $SECC4;
			echo $divSpace;
			echo $SECC5;
			echo $divSpace;
			echo $SECC6;
			?>    
        </td>
        <td style="width:45%;">
        <?php
        if($TR_RSm>0){
		$contImg=1;
		do{
		if($contImg<=3){
		$detMedia=detRow('db_media','id_med',$row_RSm['id_med']);
		$detMedia_img=RAIZidb.'ecografo/'.$detMedia['file'];
		?>
        <div style="padding:0 0 10px 0;">
        <img src="<?php echo $detMedia_img ?>" style="width:330px;">
        </div>
		<?php
		}
		$contImg++;
		}while($row_RSm = mysql_fetch_assoc($RSm));
		}else{ ?>
        No se han registrado imagenes
		<?php } ?>
        </td>
    </tr>
</table>
</div>