<div class="panel panel-default">
    <div class="panel-heading">Resumen</div>
    <?php
        $TR_Con=totRowsTab('db_consultas','1','1');
        $TR_RepObs=totRowsTab('db_rep_obs','1','1');
        $TR_RepEco=totRowsTab('db_rep_eco','1','1');
        $TR_Trat=totRowsTab('db_tratamientos','1','1');
        $TR_Exa=totRowsTab('db_examenes','1','1');
        $TR_Cir=totRowsTab('db_cirugias','1','1');
        $TR_Pac=totRowsTab('db_clientes','1','1');
        $TR_PacN=totRowsTab('db_clientes','isnew','1');
        $TR_Doc=totRowsTab('db_documentos','1','1');
        $TR_Tinf=totRowsTab('db_tratamiento_infertilidad','status','1');
        $TR_Tinff=totRowsTab('db_tratamiento_infertilidad','status','0');
    ?>
    <ul class="list-group">
        <li class="list-group-item">
            <a href="#">Pacientes</a>
            <span class="badge"><?php echo $TR_Pac ?></span> 
        </li>
        <li class="list-group-item">
            <a href="#">Pacientes Nuevos</a>
            <span class="badge"><?php echo $TR_PacN ?></span> 
        </li>
        <li class="list-group-item">
            <a href="#">Consultas</a>
            <span class="badge"><?php echo $TR_Con ?></span> 
        </li>
        <li class="list-group-item">
            <a href="#">Tratamientos ACtivos</a>
            <span class="badge"><?php echo $TR_Trat ?></span> 
        </li>
        
        <li class="list-group-item">
            <a href="#">Tratamientos Finalizados</a>
            <span class="badge"><?php echo $TR_Trat ?></span> 
        </li>
        
        <li class="list-group-item">
            <a href="#">Terapias</a>
            <span class="badge"><?php echo $TR_Doc ?></span> 
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_examen/">Examenes</a>
            <span class="badge"><?php echo $TR_Exa ?></span> 
        </li>
        <li class="list-group-item">
            <a href="<?php echo $RAIZc ?>com_cirugia/">Cirugias</a>
            <span class="badge"><?php echo $TR_Cir ?></span> 
        </li>
    </ul>
</div>