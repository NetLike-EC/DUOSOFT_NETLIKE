<?php include('../../init.php');
$idt=vParam('idt',$_GET['idt'],$_POST['idt']);
$idp=vParam('idp',$_GET['idp'],$_POST['idp']);
$acc='UPD';
$btnAcc='<button class="btn btn-success navbar-btn">ACTUALIZAR SESIÓN</button>';
$detP=detRow('db_clientes','pac_cod',$idp);
$qryConLst=sprintf('SELECT * FROM clinic_freimo.db_fullcalendar_sesiones
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
$css['body']='cero';
include(RAIZf.'head.php'); ?>
<?php sLOG('g') ?>
<form action="actions.php" method="post">
<fieldset>   
	<input name="id_ses" type="hidden" id="id_ses" value="">
    <input name="estado" type="hidden" id="estado" value="">
    <input name="id_tera" type="hidden" id="id_tera" value="<?php echo $idt?>">    
</fieldset>

<nav class="navbar navbar-default">
  <div class="container-fluid">
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">FISIO TERAPIAS <span class="label label-default"><?php echo $idt?></span></a>
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
    	                       
        <div class="col-sm-4">
        	<div class="panel panel-primary">
				<div class="panel-heading">Sesiones Generadas para esta Terapia</div>
               <?php if ($tr_RSt>0){?>
                <table class="table table-hover">
                <thead>
                <tr>
                    <th>Fecha Sesión</th>		
                    <th>Hora</th>
                    <th>Estado</th>                                       
                    <th></th>
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
                        <td class="text-center">                                                                       
                        <?php                         
                        if ($row_RSt['est']==1){									
							$btnAcc='<button type="button" class="btn btn-primary btn-xs" onClick="cargardatos('.$row_RSt['id'].','.$row_RSt['est'].')">Atender Sesión</button>';
						}else{									
							$btnAcc='<button type="button" class="btn btn-primary btn-xs" onClick="cargardatos('.$row_RSt['id'].','.$row_RSt['est'].','."'".$row_RSt['obs']."'".')">Modificar</button>';
						}                                                
                        ?> 
                        <?php echo $btnAcc?>                                                    								
                        </td>
                    </tr>
                    <?php } while ($row_RSt = mysql_fetch_assoc($RSt));?>
                    </tbody>
                    </table>
        <?php }else echo '<div class="alert alert-warning"><h4>Sin Registros</h4></div>';?>        
            </div>                                                          
        </div> 
        
        <div class="col-sm-4">
        <div class="panel panel-default">
        	<div class="panel-heading">Datos de Sesion en Atencion</div>
            <div class="panel-body">
            	<fieldset class="form-horizontal">
                <div class="form-group">
                	<label class="control-label col-sm-4">Sesión N.</label>
                    <div class="col-sm-8">
                        <span class="btn btn-default disabled" id="num_sesion" name="num_sesion" style="width:100%"></span>
                    </div>
                </div>
                <div class="form-group">
                	<label class="control-label col-sm-4">Estado</label>
                    <div class="col-sm-8">
                        
                        <div class="radio">
                            <label>
                            <input type="radio" name="est0" value="" id="est0">
                            Pendiente
                            </label>
                        </div>
                        <div class="radio">
                            <label>
                            <input type="radio" name="est1" value="" id="est1">
                            Atendido
                            </label>
                        </div>
                        
                        
                    </div>
                </div>
                <div class="form-group">
                	<label class="control-label col-sm-4">Observaciones del Terapista</label>
                    <div class="col-sm-8">
                    <textarea rows="4" cols="45" id="obs" name="obs" value="" class="form-control"></textarea>
                    </div>
                </div>
                	
                
                </fieldset>
            
            </div>
        </div>
        </div>
        
        <div class="col-sm-4">
        <div class="panel panel-info">
        	<div class="panel-heading">Tratamientos Designados</div>
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
                            
        </div>
        </div>
                                                
    </div>
</div>
</form>
<script type="text/javascript" src="js.js"></script>
<?php include(RAIZf.'footer.php'); ?>