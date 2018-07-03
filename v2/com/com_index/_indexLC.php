<?php 
//Fecha Ayer
$sdateA = strtotime ('-1 day',strtotime($sdate));
$sdateA = date('Y-m-j',$sdateA);
//FECHAS HOY INICIO AL FIN
$sdatet_ini=$sdate.' 00:00:00';
$sdatet_fin=$sdate.' 11:59:59';

//CONSULTAS RESERVAS
$qryCr=sprintf('SELECT * FROM db_fullcalendar WHERE fechai>=%s AND fechaf<=%s  AND est=1 ORDER BY horai ASC',
SSQL($sdate,'date'),
SSQL($sdate,'date'));
$RSCr=mysql_query($qryCr);
$row_RSCr=mysql_fetch_assoc($RSCr);
$TR_RSCr=mysql_num_rows($RSCr);

//CONSULTAS HOY
$qryCh=sprintf('SELECT * FROM db_consultas WHERE con_fec=%s ORDER BY con_num DESC',
SSQL($sdate,'date'));
$RSCh=mysql_query($qryCh);
$row_RSCh=mysql_fetch_assoc($RSCh);
$TR_RSCh=mysql_num_rows($RSCh);

//CONSULTAS AYER
$qryCa=sprintf('SELECT * FROM db_consultas WHERE con_fec=%s ORDER BY con_num DESC',
SSQL($sdateA,'date'));
$RSCa=mysql_query($qryCa);
$row_RSCa=mysql_fetch_assoc($RSCa);
$TR_RSCa=mysql_num_rows($RSCa);

?>
<div class="row">
	<div class="col-sm-7">
        <div class="panel panel-danger">
            <div class="panel-heading">Consultas Programadas <span class="label label-danger"><?php echo $sdate ?></span></div>
            <div class="panel-body">
                Pendietes <span class="label label-danger"><?php echo $TR_RSCr ?></span>
            </div>
            <?php if($TR_RSCr>0){ ?>
            <ul class="list-group">
                    <?php do{ ?>
                    <?php $detPac=detRow('db_clientes','cli_id',$row_RSCr['cli_id']);
                    $detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
                    $detRes_fec=$row_RSCr['fechai'];
                    if($row_RSCr['horai']){
                        $detRes_hor=strtotime($row_RSCr['horai']); 
                        $detRes_hor=date('H:i',$detRes_hor);
                        $detHor='<span class="label label-default">'.$detRes_hor.'</span> ';
                    }else{
                        $detHor='<span class="label label-default"><i class="fa fa-question-circle fa-lg"></i></span> ';
                    }
                    $detTyp=detRow('db_types','typ_cod',$row_RSCr['typ_cod']);
                    if($detTyp) $detTyp_nom=' / '.$detTyp['typ_val'];
                    if($detPac){
                        $det_tit='<a href="'.$RAIZc.'com_consultas/form.php?idp='.$row_RSCr['cli_id'].'&idr='.$row_RSCr['id'].'">';
                        $det_tit.=$detPac['cli_nom'].' '.$detPac['cli_ape'].$detTyp_nom;
                        $det_tit.='</a>';
                    }else{
                        $det_tit=$row_RSCr['obs'].$detTyp_nom;
                    }
                    
                    
                    ?>
                    <li class="list-group-item">
                    <?php echo $detHor ?>
                    <?php echo $det_tit ?>
                    </li>
                    <?php }while($row_RSCr=mysql_fetch_assoc($RSCr)); ?>
                </ul>
            <?php } ?>
            <div class="panel-body">
                Atendidas <span class="label label-success"><?php echo $TR_RSCh ?></span>
            </div>
            <?php if($TR_RSCh>0){ ?>
            <ul class="list-group">
                    <?php do{ ?>
                    <?php $detPac=detRow('db_clientes','cli_id',$row_RSCh['cli_id']);
                    $detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
                    $detAud=detRow('db_auditoria','id_aud',$row_RSCh['id_aud']);
                    $detAud_fec=$detAud['aud_datet'];
                    $detAud_fec=strtotime($detAud_fec); 
                    $detAud_hor=date('H:i',$detAud_fec);
                    ?>
                    <li class="list-group-item">
                    <span class="label label-default"><?php echo $detAud_hor ?></span> 
                    <span class="label label-info"><?php echo $row_RSCh['con_num'] ?></span>
                    <a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $row_RSCh['con_num'] ?>&idp=<?php echo $row_RSCh['cli_id'] ?>">
                        <?php echo $detcli_nom ?>
                    </a>
                    </li>
                    <?php }while($row_RSCh=mysql_fetch_assoc($RSCh)); ?>
                </ul>
            <?php } ?>
        </div>
	</div>  
    <div class="col-sm-5">
        <div class="panel panel-primary">
            <div class="panel-heading">Consultas Ayer <span class="label label-default"><?php echo $sdateA ?></span></div>
            <div class="panel-body">
                Total Consultas <span class="label label-primary"><?php echo $TR_RSCa ?></span>
            </div>
            <?php if($TR_RSCa>0){ ?>
            <ul class="list-group">
                    <?php do{ ?>
                    <?php $detPac=detRow('db_clientes','cli_id',$row_RSCa['cli_id']);
                    $detcli_nom=$detPac['cli_nom'].' '.$detPac['cli_ape'];
                    $detAud=detRow('db_auditoria','id_aud',$row_RSCa['id_aud']);
                    $detAud_fec=$detAud['aud_datet'];
                    $detAud_fec=strtotime($detAud_fec); 
                    $detAud_hor=date('H:i',$detAud_fec);
                    ?>
                    <li class="list-group-item">
                    <span class="label label-default"><?php echo $detAud_hor ?></span> 
                    <span class="label label-info"><?php echo $row_RSCa['con_num'] ?></span>
                    <a href="<?php echo $RAIZc ?>com_consultas/form.php?idc=<?php echo $row_RSCa['con_num'] ?>">
                        <?php echo $detcli_nom ?>
                    </a>
                    </li>
                    <?php }while($row_RSCa=mysql_fetch_assoc($RSCa)); ?>
                </ul>
            <?php } ?>
        </div>
    </div>
</div>