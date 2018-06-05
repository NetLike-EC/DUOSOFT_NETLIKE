<?php 
$id=vParam('id', $_GET['id'], $_POST['id']);
$detPac=dPac($id);
$detPac_nom=$detPac['pac_nom'].' '.$detPac['pac_ape'];
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
      <a class="navbar-brand" href="#">REPORTES GINECOLOGICOS</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#"><?php echo $detPac_nom ?></a></li>
        <li><a><?php echo $detPac_fec ?></a></li>
      </ul>
      <div class="navbar-right btn-group navbar-btn">
      <a href="<?php echo $RAIZc ?>com_reps/eco_form.php?idp=<?php echo $id ?>" class="btn btn-info fancybox.iframe fancyreload"><col-md- class="glyphicon glyphicon-plus-sign"></col-md-> NUEVO</a>
      </div>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>
<ol class="breadcrumb">
  <li><a href="<?php echo $RAIZc.'com_index/'?>">Inicio</a></li>
  <li><a href="<?php echo $RAIZc.'com_reps/gin_list_gen.php'?>">Reportes Ginecologicos</a></li>
  <li class="active">Paciente</li>
</ol>

<?php if($detPac){ ?>
<?php 
$qry=sprintf('SELECT * FROM  db_rep_eco WHERE pac_cod=%s ORDER BY id DESC',
SSQL($id,'int'));
$RSr=mysql_query($qry);
$row_RSr=mysql_fetch_assoc($RSr);
$tr_RSr=mysql_num_rows($RSr);
?>
<div class="">
<?php if ($tr_RSr>0){
$classlast=TRUE;
$classtr;
?>
<div class="well well-sm">
<span class="label label-primary">Resultados <strong><?php echo $tr_RSr ?></strong></span>
</div>
<div>
	<table class="table table-striped table-bordered table-condensed">
	<thead>
	<tr>
		<th>ID</th>
        <th>Paciente</th>
		<th>Fecha Registro</th>
        <th>Fecha Ecografía</th>
        <th>Fetos</th>
        <th>Multimedia</th>
		<th>Responsable</th>
		<th></th>
	</tr>
	</thead>
    <tbody>
	<?php do{ ?>
	<?php $detP=detRow('db_clientes','pac_cod',$row_RSr['pac_cod']); ?>
	<tr <?php echo $classtr?>>
        	<td><?php echo $row_RSr['id'] ?></td>
            <td><?php echo $detP['pac_nom'].' '.$detP['pac_ape'] ?></td>
			<td><?php echo $row_RSr['fechar'] ?></td>
            <td><?php echo $row_RSr['fechae'] ?></td>
			<td><?php echo totRowsTab('db_rep_obs_detalle','id_rep',$row_RSr['id']) ?></td>
            <td><?php echo totRowsTab('db_rep_obs_media','id_rep',$row_RSr['id']) ?></td>
            <td></td>
            <td><div class="btn-group">
            <a href="<?php echo $RAIZc ?>com_reps/eco_print.php?id=<?php echo $row_RSr['id'] ?>" class="btn btn-default btn-xs fancybox fancybox.iframe">
            <i class="fa fa-print"></i> Imprimir</a>
            </div>
            </td>
        </tr>
        <?php } while ($row_RSr = mysql_fetch_assoc($RSr));?>
        </tbody>
        </table>
    </div>
<?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>
  </div>
<?php }else{ ?>
<div class="alert alert-warning"><h4>Paciente No Existe</h4></div>
<?php } ?>