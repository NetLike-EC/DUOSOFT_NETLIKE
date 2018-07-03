<link href="../../styles/taskbar.css" rel="stylesheet" type="text/css" />
<link href="../../styles/style_v002.css" rel="stylesheet" type="text/css" />
<div id="taskbar">
	<div id="container">
   		<div class="block-left">
    		<a class="btns">Consultas</a>
		</div>
    <div class="block-center">
    	<table class="btns" border="0" cellpadding="0" cellspacing="0">
        	<tr>
           	  <td valign="middle">
                <?php 
				if(($stat_act=='NUEVA')||($stat_act=='Pendiente'))
				{
				}else{
				if (($_POST['action_cons']=="update")||($_GET['action_cons']=="update"))
				{
				?>
                <form action="../../componentes/com_terapias/terapias_form.php" method="post">
					<?php
					//Verificamos Si Existe Una Terapia Relacionada con la Consulta
                    if (@mysql_result(mysql_query($query_RS_ter_cons),'con_num'))
                    {
						$_SESSION['id_ter']=$row_RS_ter_cons['ter_num'];
                    ?>
                    <input type="submit" name="btn_nueva_ter" value="Ver Terapia" />
                    <input name="id_ter" type="hidden" id="id_ter" value="<?php echo $row_RS_ter_cons['ter_num']; ?>" />
                    <input name="id_cons" type="hidden" id="id_cons" value="<?php echo $row_RS_ter_cons['con_num']; ?>" />
              <input name="id_pac"  type="hidden" id="id_pac" value="<?php echo $row_RS_ter_cons['cli_id']; ?>" />
                    <input name="action_form" type="hidden" id="action_form" value="Actualizar" />
                </form>
                <form action="../../componentes/com_terapias/terapias_form.php" method="post">
                  <?php }else{ ?>
                    <input type="submit" name="btn_nueva_ter" value="Crear Terapia" />
                    <input name="id_cons" type="hidden" id="id_cons" value="<?php echo $row_RS_cons_detail['con_num']; ?>" />
                    <input name="id_pac"  type="hidden" id="id_pac" value="<?php echo $row_RS_cons_detail['cli_id']; ?>" />
                  <input name="action_form"  type="hidden" id="action2" value="Grabar Nuevo" />
                  <?php } ?>
                </form>
                  <?php } ?>
                <?php } ?>
              </td>
                    
            </tr>
</table>
    </div>
    <div class="block-right"></div>
  </div>
</div>