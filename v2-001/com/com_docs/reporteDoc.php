<?php include_once('../../init.php');
$detDoc=detRow('db_documentos','id_doc',$id);
$detPac=detRow('db_clientes','pac_cod',$detDoc['pac_cod']);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
$detPac_edad=edad($detPac['pac_fec']);
$dettrat_fecha=date_ame2euro($detDoc['fecha']);
?>
<?php $setTitle='DOCUMENTO: '.$detDoc['nombre']?>
<page backtop="10mm" backbottom="10mm" backleft="10mm" backright="5mm">
<page_header>
	<?php include(RAIZf.'fra_print_header_gen.php') ?>
</page_header>
<page_footer>
	<?php include(RAIZf.'fra_print_footer_gen.php') ?>
</page_footer>

<div style="margin-top:40px;">
<?php echo $detDoc['contenido'] ?>
</div>
<?php
$qryDDG=sprintf('SELECT db_diagnosticos.nombre as d_nom FROM db_documentos_diag_vs 
INNER JOIN db_diagnosticos ON db_documentos_diag_vs.id_diag=db_diagnosticos.id_diag 
WHERE id_doc=%s',
SSQL($id,'int'));
$RSDDG=mysql_query($qryDDG)or die(mysql_error());
$dRSDDG=mysql_fetch_assoc($RSDDG);
$trRSDDG=mysql_num_rows($RSDDG);
if($trRSDDG>0){
?>
<span style="font-weight:bold;">Diagnósticos: </span> 
<?php do{ ?>
	<span style="padding:10px 15px; background:#ddd; border:1px solid #ccc; font-size:12px;">
    <?php echo $dRSDDG['d_nom'] ?>
    </span>
<?php }while($dRSDDG=mysql_fetch_assoc($RSDDG)); ?>
<?php } ?>
</page>