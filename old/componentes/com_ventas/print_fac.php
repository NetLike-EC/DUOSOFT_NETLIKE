<?php include('../../init.php');
$id=vParam('id',$_GET['id'],$_POST['id']);
$det=detRow('tbl_factura_ven','id',$id);
$detAud=detAud($det['aud_id']);
$detVen=detRow('tbl_venta_cab','ven_num',$det['ven_num']);
$detCli=detRow('tbl_clientes','cli_cod',$detVen['cli_cod']);
$detPer=detRow('tbl_personas','per_id',$detCli['per_id']);

$qryVenDet=sprintf("SELECT * FROM tbl_venta_det WHERE ven_num=%s",
	GetSQLValueString($det['ven_num'],"int"));
$RSvd=mysql_query($qryVenDet) or die (mysql_error());
$rowRSvd=mysql_fetch_assoc($RSvd);


include(RAIZf.'_head.php') ?>
<body style="background:#FFF !important; font-family:Segoe, 'Segoe UI', 'DejaVu Sans', 'Trebuchet MS', Verdana, sans-serif; font-size:11px;">
<div style="width:490px; border:0px none; padding:35px;">
<a onClick="window.print()">Print</a>. N°. <?php echo $det['fac_num'] ?>
<table style="margin-top:70px">
<tr><td style="padding:20px;"></td></tr>
<tr>
<td>
	<table>
    	<tr>
        	<td style="padding-left:0px;" colspan="2"><strong>Fecha:</strong> <?php echo $detAud['aud_dat'] ?></td>
        </tr>
    	<tr>
        	<td style="padding-left:0px; width:400px"><strong>Nombres:</strong> <?php echo $detPer['per_nom'].' '.$detPer['per_ape'] ?></td>
            <td style="padding-left:0px; width:220px"><strong>Cedula/RUC:</strong> <?php echo $detPer['per_doc'] ?></td>
        </tr>
        <tr>
        	<td style="padding-left:0px; width:400px"><strong>Direccion:</strong> <?php echo $detPer['per_dir'] ?></td>
            <td style="padding-left:0px; width:220px"><strong>Telefono:</strong> <?php echo $detPer['per_tel'] ?></td>
        </tr>
    </table>
</td>
</tr>
<tr>
<td style="height:390px; vertical-align:top;">
	<div style="padding-top:2px;"> </div>
    <table style="width:500px;">
    	<tr style="border-bottom:1px dotted #ccc">
        	<td style="width:60px;"><strong>CANT.</strong></td>
            <td style="width:280px;"><strong>DESCRIPCION</strong></td>
            <td style="width:80px;"><strong>V.UNIT</strong></td>
            <td style="width:80px;"><strong>SUBTOTAL</strong></td>
        </tr>
		<?php do{ ?>
        <?php $detInv=detRow('tbl_inventario','inv_id',$rowRSvd['inv_id']);
		$detProd=detRow('tbl_inv_productos','prod_id',$detInv['prod_id']);
		$detProd_nom=$detProd['prod_nom'];
		$detVen_subtotlin=($rowRSvd['ven_can'])*($rowRSvd['ven_pre']);
		$subtot+=$detVen_subtotlin;
		?>
        <tr style="border-bottom:1px dotted #ccc">
        	<td style="width:60px;"><?php echo $rowRSvd['ven_can'] ?></td>
            <td style="width:280px; font-size:9px;"><?php echo $detProd_nom ?></td>
            <td style="width:80px;"><?php echo $rowRSvd['ven_pre'] ?></td>
            <td style="width:80px;"><?php echo $detVen_subtotlin ?></td>
        </tr>
        <?php }while($rowRSvd=mysql_fetch_assoc($RSvd)); ?>
    </table>

</td>
</tr>
<tr>
<td>
	<table style="width:480px;">
    	<tr>
        	<td style="width:370px">
            
            	<table style="width:100%">
                	<tr>
                    	<td style="text-align:center; width:50%">
                        	<div style=" width:80%; margin-top:30px; padding-top:10px; border-top:1px solid #666">
                            AUTORIZA
                            </div>
                        </td>
                        <td style="text-align:center; width:50%">
                        	<div style=" width:80%; margin-top:30px; padding-top:10px; border-top:1px solid #666">
                            RECIBI CONFORME
                            </div>
                        </td>
                    </tr>
                </table>
            
            </td>
            <td style="width:150px">
            	<table style="width:100%">
                	<tr>
                    	<td><strong>SUBTOTAL</strong></td>
                        <td class="text-right"><?php echo $subtot ?></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                    	<td></td>
                        <td class="text-right"></td>
                    </tr>
                    <tr>
                    	<td class="text-right"><strong>IVA</strong> <?php echo $_SESSION['conf']['taxes']['iva'] ?>%</td>
                        <td class="text-right"><?php echo $subtot*$_SESSION['conf']['taxes']['iva_si']?></td>
                    </tr>
                    <tr style="font-size:13px;">
                    	<td><strong>TOTAL</strong></td>
                        <td class="text-right"><?php echo $subtot*$_SESSION['conf']['taxes']['iva_ii'] ?></td>
                    </tr>
                    
                </table>
            </td>
        </tr>
    </table>
</td>
</tr>
</table>
</div>
</body>