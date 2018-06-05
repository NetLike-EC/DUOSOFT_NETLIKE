<?php require_once('../../init.php');
$id=vParam('id', $_GET['id'], $_POST['id']);
$detPac=dPac($id);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
if($detPac['pac_fec']) $detPac_fec=edad($detPac['pac_fec']).'Años';

?>
<nav class="navbar navbar-default" role="navigation">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">CIRUGIAS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $detPac_nom ?></a></li>
        <li><a><?php echo $detPac_fec ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <a href="<?php echo $RAIZc ?>com_cirugia/cirugia_form.php?idp=<?php echo $id ?>" class="btn btn-info fancybox.iframe fancyreload"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc.'com_index/'?>">Inicio</a></li>
  <li><a href="<?php echo $RAIZc.'com_cirugia/'?>">Cirugias</a></li>
  <li class="active">Paciente</li>
</ol>
<?php if($detPac){
$qry=sprintf('SELECT * FROM db_cirugias WHERE pac_cod=%s ORDER BY id_cir DESC',
SSQL($id,'int'));
$RS=mysql_query($qry);
$dRS=mysql_fetch_assoc($RS);
$tr_RSh=mysql_num_rows($RS);
?>
<div>

<?php if ($tr_RSh>0){ ?>
	<div>
	  <table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
		<th>Paciente</th>
        <th>Diagnostico</th>
        <th colspan="2">Cirugia Realizada</th>
        <th style="width:30%">Protocolo</th>
        <th>Evolucion</th>
        <th>Multimedia</th>
        <th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php
    $dPac=detRow('db_clientes','pac_cod',$dRS['pac_cod']);
	$detProt=$dRS['protocolo'];
	$contDetProt=strlen($detProt);
	if($contDetProt>200){
		$detProt=substr($detProt,0,200).' ...';
	}
	$typexam=dTyp($dRS['typ_cod']);
	$typexam=$typexam['typ_val'];
	if($classlast==TRUE){ $classlast=FALSE; $classtr='class="warning"'; }else{$classtr='';}?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $dRS['id_cir'] ?></td>
			<td><?php echo $dPac['pac_nom'].' '.$dPac['pac_ape'] ?></td>
            <td><?php echo $dRS['diagnostico'] ?></td>
            <td><?php echo $dRS['fechar'] ?></td>
            <td><?php echo $dRS['cirugiar'] ?></td>
            <td><?php echo $detProt ?></td>
            <td><?php echo $dRS['evolucion'] ?></td>
            <td><?php echo totRowsTab('db_cirugias_media','id_cir',$dRS['id_cir']) ?></td>
            <td>
            <div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_cirugia/cirugia_form.php?idr=<?php echo $dRS['id_cir'] ?>" class="btn btn-primary btn-xs fancybox fancybox.iframe fancyreload">
            <i class="fa fa-pencil-square-o"></i> Modificar</a>
            <a href="<?php echo $RAIZc; ?>com_cirugia/actions.php?idr=<?php echo $dRS['id_cir'] ?>&acc=<?php echo md5("DELRF") ?>" class="btn btn-danger btn-xs fancybox fancybox.iframe fancyclose">
            <i class="fa fa-trash-o"></i> Eliminar</a>
            </div>
            </td>
        </tr>
        <?php } while ($dRS = mysql_fetch_assoc($RS));?>
        </tbody>
        </table>
    </div>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
}?>
</div>
<?php mysql_free_result($RS);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>