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
      <a class="navbar-brand" href="#">TRATAMIENTOS INFERTILIDAD</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $detPac_nom ?></a></li>
        <li><a><?php echo $detPac_fec ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <a href="<?php echo $RAIZc ?>com_hc/examen_form.php?idp=<?php echo $id ?>" class="btn btn-info fancyreload fancybox.iframe"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO EXAMEN</a>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc.'com_index/'?>">Inicio</a></li>
  <li><a href="<?php echo $RAIZc.'com_tinf/'?>">Tratamientos Infertilidad</a></li>
  <li class="active">Paciente</li>
</ol>
<?php if($detPac){
$qry=sprintf('SELECT * FROM db_tratamiento_infertilidad WHERE pac_cod=%s ORDER BY id_ti DESC',
SSQL($id,'int'));
$RSh=mysql_query($qry);
$row_RSh=mysql_fetch_assoc($RSh);
$tr_RSh=mysql_num_rows($RSh);
?>
<div>

<?php if ($tr_RSh>0){ ?>
	<div>
	  <table id="mytable" class="table table-bordered table-condensed table-striped table-hover">
<thead>
	<tr>
    	<th>ID</th>
		<th><abbr title="Fecha Registro">Fecha</abbr></th>
        <th><abbr title="Fecha Inicio">Inicio</abbr></th>
		<th><abbr title="Fecha Fin">Finaliza</abbr></th>
        <th>Tipo Tratamiento</th>
        <th>Donante</th>
        <th>Estado</th>
        <th></th>
	</tr>
</thead>
<tbody> 
	<?php do{?>
	<?php
	$detPac=detRow('db_clientes','pac_cod',$row_RSh['pac_cod']);
	$detTT=detRow('db_types','typ_cod',$row_RSh['typ_cod']);
	if($row_RSh['status']==1) $btnStatTI='<span class="label label-success">Activo</a>';
	else $btnStatTI='<span class="label label-warning">Finalizado</a>';
	?>
    <tr>
    	<td><?php echo $row_RSh['id_ti'] ?></td>
			<td><?php echo $row_RSh['date'] ?></td>
            <td><?php echo $row_RSh['datei'] ?></td>
            <td><?php echo $row_RSh['datef'] ?></td>
            <td><?php echo $detTT['typ_val'] ?></td>
            <td><?php echo $row_RSh['donante'] ?></td>
            <td><?php echo $btnStatTI ?></td>
            <td>
            <a class="btn btn-info btn-xs fancyreload fancybox.iframe" href="form.php?id=<?php echo $row_RSh['id_ti'];?>">
        	<i class="fa fa-edit fa-lg"></i> Editar</a>
            
            <a href="<?php echo $RAIZc; ?>com_tinf/form.php?id=<?php echo $row_RSh['id_ti'] ?>&action=DELEF" class="btn btn-default btn-danger btn-xs fancybox.iframe fancyclose"><i class="fa fa-trash-o"></i> Eliminar</a>
            </td>
    	</tr>
    <?php } while ($row_RSh = mysql_fetch_assoc($RSh)); ?>
</tbody>
</table>
    </div>
<?php }else{
	echo '<div class="alert alert-warning"><h4>No Existen Registros</h4></div>';
}?>
</div>
<?php mysql_free_result($RSh);
}else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>