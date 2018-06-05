<link href="../../styles/taskbar.css" rel="stylesheet" type="text/css" />
<div id="taskbar">
	<div id="container">
   		<div class="block-left">
    		<a href="../../componentes/com_clientes/clientes_gest.php" class="btns">Usuarios Sistema</a>
		</div>
    <div class="block-center">
    	<table class="btns" border="0" cellpadding="0" cellspacing="0" height="100%">
        	<tr>
            	<td valign="middle"><img src="../../images/struct/img_taskbar/add_user.png" /></td>
              <td valign="middle"><a href="../../componentes/com_usersystem/users_form.php?action_form=INSERT" rel="shadowbox;options={relOnClose:true};width=500;height=500">&nbsp;Nuevo Usuario</a></td>
                
            </tr>
        </table>
    </div>
    <div class="block-right">
    <?php include('../../frames/_user_session_start.php'); ?>
    </div>
  </div>
</div>