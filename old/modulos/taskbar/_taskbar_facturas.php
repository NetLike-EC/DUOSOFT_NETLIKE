<link href="styles/taskbar.css" rel="stylesheet" type="text/css" />
<div id="taskbar">
	<div id="container">
   		<div class="block-left">
    		<a href="clientes_gest.php" class="btns">FACTURACION</a>		</div>
<div class="block-center">
    	<table border="0" cellpadding="0" cellspacing="0" height="100%" align="center">
                    	<tr>
                        	<td><img src="img_est/img_taskbar/calculator.png" /></td><td><a class="btns" rel="shadowbox" href="rep_facturas_list.php">Lista Facturas</a></td>
                        </tr>
        </table>
    </div>
    <div class="block-right">Caja Actual: 
      <?php 
	$valor_actual_caja= valor_actual_caja_chica();
	echo $valor_actual_caja['caj_chi_val_act'];
	?></div>
  </div>
</div>