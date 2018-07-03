<?php session_start();
include('../_config.php');
include(RAIZf.'head.php');
include('_libs.php');?>
<?php
if (count($_SESSION['b'])==0){echo "NO TIENE DETALLE";}
else{
//GRABAR CABECERA////////////////////////////
	$fac_num = $_POST["fac_num"];
	$fac_tip_pag = $_POST["fac_tip_pag"];
	$fac_fec = $_POST["fac_fec"];
	echo 'paciente'.$fac_pac = $_POST["fac_pac"];
	echo 'empleado'.$fac_emp = $_POST["fac_emp"];
	$fac_sal = 0;
	$fac_total = $_SESSION['total'];
	$inser_cab = "INSERT INTO tbl_factura(fac_num,fac_fech,cli_id,emp_cod,tip_pag,total,saldo) VALUES('$fac_num','$fac_fec', '$fac_pac', '$fac_emp', '$fac_tip_pag', '$fac_total', '$fac_sal');";
	@mysql_query($inser_cab)or($LOG=mysql_error());
//////////////////////////////////////////////	
	if ($LOG == '')
	{	
//GRABAR DETALLE//////////////////////////////
		if(count($_SESSION['b'])>0)
		{	foreach($_SESSION['b'] as $l)
			{	
					$cuenta = $l["ind"];
					$detalle = $l["det"];
					$valor = $l["val_fac"];
					$fecha = $l["fec"];
					$inser_det = "INSERT INTO tbl_det_factura(fac_num,num_cta,detalle,valor) VALUES ('$fac_num', '$cuenta', '$detalle', '$valor') ";
			//echo $inser_det;
				 @mysql_query($inser_det)or($LOG=mysql_error());
				 echo $LOG;
//////////////////////////////////////////////				
//ACTUALIZAR CUENTAS//////////////////////////
					$upda_cta ="UPDATE tbl_cta_por_cobrar SET cta_est = 'F' WHERE tbl_cta_por_cobrar.num_cta = '$cuenta'";
				
					@mysql_query($upda_cta)or($LOG=mysql_error());			
/////////////////////////////////////////////				
			};
		};
  	}
	else
	{
		
		echo $LOG." SE PRODUJO UN ERROR EN LA CABECERA FACTURA";
	}
?>
<html>
	<?php include('../../system/base/__styles.php'); ?>
	<body>
			<table width="50%" class="tablesorter">
            	<tr>
                	<td>Nº</td>
                    <td><?php echo $fac_num;?></td>
                    <td>Fecha</td>
                    <td><?php echo $fac_fec;?></td>                
                    <td>Paciente</td>
                    <td><?php echo $fac_pac;?></td>
                </tr>
            </table>
            <table width="50%" class="tablesorter">
            <tr>
            	<td>Detalle</td>
                <td>Valor</td>
            </tr>
        	<?php
                if(count($_SESSION['b'])>0)
				  {	?>
				  	<?php 
					foreach($_SESSION['b'] as $l)
					{
            		?>
                    <tr>
							<td><?php echo $l["det"];?></td>
                            <td><?php echo $l["val_fac"];?></td>
                    </tr>
					<?php
			        }
                  }	    
			?>
            </table>
            <input type="submit" value="IMPRIMIR"/>
	</body>
</html>
<?php };?>