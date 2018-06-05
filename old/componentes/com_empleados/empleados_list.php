<?php include('../_config.php');?>
<?php
	session_start();
	if (($_GET['id_emp']==null)&&($_GET["action_form"]!="INSERT"))
		$_GET['id_emp']=$_SESSION['id_emp'];
	$accion =$_GET["action_form"];	
?>
<?php require_once(RAIZ.'/Connections/conn.php'); ?>
<?php include(RAIZ.'frames/_head.php'); ?>
<?php 
$query_empleados ='SELECT * FROM tbl_empleados';
if (mysql_query($query_empleados))
{
$RS_empleados_list = mysql_query($query_empleados);
$row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list);
 	?>
    <table class="tablesorter" id="mytable" >
    <thead>
    			<tr>
                	<th></th>	
                	<th>Codigo Empleado</th>
                    <th>Nombres</th>
                    <th>Apellidos</th>
                    <th>Direccion</th>
                    <th>Telefono 1</th>
                    <th>Telefono 2</th>
                    <th>Tipo</th>
                </tr>
                </thead>
                <tbody>
	<?php do { ?> 
            	<tr>
              	  <td align="center">
                    <a onClick="show_det_emp_list(<?php echo $row_RS_empleados_list['emp_cod']; ?>)" title="Ver Detalle"><img src="../../images/struct/img_taskbar/zoom.png" /></a>
    	            <a href="empleados_form.php?id_emp=<?php echo $row_RS_empleados_list['emp_cod']; ?>&amp;action_form=UPDATE" rel="shadowbox;options={relOnClose:true};width=700px;height=300px;" title="Modificar Empleado"><img src="../../images/struct/img_taskbar/add_user.png" border="0" alt="Reserva"/></a>
                  </td>
                  <td><?php echo $row_RS_empleados_list['emp_cod']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_nom']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_ape']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_dir']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_tel1']; ?></td>
                  <td><?php echo $row_RS_empleados_list['emp_tel2']; ?></td>
                  <td><?php echo $row_RS_empleados_list['typ_cod']; ?></td>
                </tr>  
         <?php } while ($row_RS_empleados_list = mysql_fetch_assoc($RS_empleados_list)); 
}else echo mysql_error();?> 
            </tbody>
            </table>