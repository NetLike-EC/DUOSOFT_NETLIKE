<?php include('../../init.php');

$idt=vParam('idt',$_GET['idt'],$_POST['idt']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$acc='UPD';
$detP=detRow('db_clientes','pac_cod',$idp);

$qryConLst=sprintf('SELECT * FROM clinic_freimo.db_fullcalendar_sesiones
inner join tbl_usuario on tbl_usuario.usr_id=db_fullcalendar_sesiones.id_usu
inner join db_empleados on db_empleados.emp_cod=tbl_usuario.emp_cod
where id_ter=%s',
SSQL($idt,'int'));
$RSt=mysql_query($qryConLst);
$row_RSt=mysql_fetch_assoc($RSt);
$tr_RSt=mysql_num_rows($RSt);

$qry_trat=sprintf('SELECT * FROM clinic_freimo.db_terapias_vs_tratamientos
inner join db_terapiastrata on db_terapiastrata.id_trat=db_terapias_vs_tratamientos.id_trat
where id_ter=%s',
SSQL($idt,'int'));
$RStrat=mysql_query($qry_trat);
$row_RStrat=mysql_fetch_assoc($RStrat);
$tr_RStrat=mysql_num_rows($RStrat);

$cssBody='cero';
include(RAIZf.'head.php');
?>
<style>
#num_sesion {
font-family: Arial,sans-serif;
font-size: 1.0em;
color: #f00;
} 
</style>

<?php sLOG('g') ?>
<form action="../com_terapista/cerrar_tera.php" method="post">
<input name="id_tera" type="hidden" id="id_tera" value="<?php echo $idt?>">
<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">Informe Sesiones<span class="label label-default"><?php echo $idt?></span></a>
    </div>
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
        <li class="active"><a href="#">Paciente</a></li>
        <li><a href="#"><?php echo $detP['pac_nom'].' '.$detP['pac_ape'] ?></a></li>        
      </ul>

      <div class="navbar-right">
        <?php echo $btnAcc ?>        
      </div>
    </div>
  </div>
</nav>
<div class="container-fluid">
	<div class="row">
    	                       
        <div class="col-sm-8">
        	<fieldset class="">    
                                                       	            
               <?php if ($tr_RSt>0){?>
                <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th >Fecha Sesión</th>		
                    <th>Hora</th>
                    <th>Estado</th>
                    <th>Terapista</th>                                       
                    <th style="width:50%">Observaciones en la Sesión</th>
                </tr>
                </thead>    
                <tbody>
                <?php do{ ?>
                <?php 		                   		                    
					if ($row_RSt['est']==1){
                        $estado='Pendiente';
                    }
                    if($row_RSt['est']==2){
                        $estado='Atendido';
                    }
                ?>
                <tr <?php echo $classtr?>>
                        <td><?php echo $row_RSt['fechai'] ?></td>			
                        <td><?php echo $row_RSt['horai'] ?></td>
                        <td><?php echo $estado ?></td>
                        <td><?php echo $row_RSt['emp_nom'].' '.$row_RSt['emp_ape'] ?></td>                        		                     
                        <td><?php echo $row_RSt['obs'] ?></td>
                    </tr>
                    <?php } while ($row_RSt = mysql_fetch_assoc($RSt));?>
                    </tbody>
                    </table>
        <?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>        
            </fieldset>                                                          
        </div> 
        
        <div class="col-sm-4">        
        <fieldset class="well form-horizontal">           
            <legend>Información</legend>
            	<?php if ($tr_RStrat>0){?>
                <table class="table table-striped table-bordered table-condensed">
                <thead>
                <tr>
                    <th>Tratamiento</th>		
                    <th>Instrucciones</th>                    
                </tr>
                </thead>    
                <tbody>
                <?php do{ ?>                       
                <tr <?php echo $classtr?>>
                        <td><?php echo $row_RStrat['nom_trat'] ?></td>			
                         <td><?php echo $row_RStrat['des'] ?></td>                        
                    </tr>
                    <?php } while ($row_RStrat = mysql_fetch_assoc($RStrat));?>
                    </tbody>
                    </table>
        <?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?> 
           <button type="submit" class="btn btn-primary btn-xs">Cerrar Terapia</button>   
        </fieldset>
        </div>                                                              
    </div>
</div>
</form>
</body>
</html>