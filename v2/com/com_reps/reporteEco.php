<?php include_once('../../init.php');
$id=$_GET['id'];
$detRep=detRow('db_rep_eco','id',$id);
$detCon=detRow('db_consultas','con_num',$detRep['con_num']);
$detPac=detRow('db_clientes','cli_id',$detCon['cli_id']);
$detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
$detPac_edad=edad($detPac['cli_fec']);
$dettrat_fecha=date_ame2euro($dettrat['fecha']);

$qryM=sprintf('SELECT * FROM db_rep_eco_media WHERE id_eco=%s',
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
        <div style="padding:5px; text-align:center; font-size:24px;"> <span style="color:#F30"><strong>BioGepa</strong></span></div>
<div style="padding:5px; text-align:center; font-size:20px; color:#036">Reproducción Humana y Ginecología</div>
<div style="padding:5px; text-align:center; font-size:16px; color:#036; text-decoration:underline; font-weight:bold">ECOGRAFIA TRANSVAGINAL</div>
        </td>
    </tr>
</table>

<div style="border:1px solid #CCC; margin:5px 0; padding:2px;">
	<span style="padding:5px; background:#CCC ">Fecha: </span> <span><?php echo $detRep['fechar'] ?></span> 
    <span style="padding:5px; background:#CCC; margin-left:10px;">Paciente: </span> <span><?php echo $detcli_nom ?></span> 
    <span style="padding:5px; background:#CCC; margin-left:10px;">Edad: </span> <span><?php echo $detPac_edad ?> años</span>
</div>
<div style="margin-top:10px;">
<table style="width:100%">
	<tr>
    	<td style="width:55%;">
        	
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">HALLAZGOS</div>
            <div style="padding:2px;"><?php echo $detRep['eco_hall'] ?></div>
            </div>
            
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">UTERO</div>
            <div style="padding:2px;"><?php echo $detRep['rec_utero'] ?></div>
            </div>
            
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">OVARIO DERECHO</div>
            <div style="padding:2px;">
            <table style="width:100%;" cellpadding="0" cellspacing="0">
            	<tr>
                    <td style="width:50%"><strong>Dimensiones:</strong> <br><?php echo $detRep['rec_ovder'] ?></td>
                    <td style="width:50%"><strong>Observaciones:</strong> <br><?php echo $detRep['obs_ovder'] ?></td>
                </tr>
            </table>
            
            </div>
            </div>
            
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">OVARIO IZQUIERDO</div>
            <div style="padding:2px;">
            <table style="width:100%;" cellpadding="0" cellspacing="0">
            	<tr>
                    <td style="width:50%"><strong>Dimensiones:</strong> <br><?php echo $detRep['rec_ovizq'] ?></td>
                    <td style="width:50%"><strong>Observaciones:</strong> <br><?php echo $detRep['obs_ovizq'] ?></td>
                </tr>
            </table>
            
            </div>
            </div>
            
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">OTROS HALLAZGOS</div>
            <div style="padding:2px;"><?php echo $detRep['eco_ohall'] ?></div>
            </div>
            
            <div style="border: 1px solid #eee; margin-bottom:5px;">
			<div style="background:#036; color:#fff; padding:2px;">DIAGNOSTICO</div>
            <div style="padding:10px; font-size:16px;"><?php echo $detRep['eco_diag'] ?></div>
            </div>
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