<link href="../../styles/taskbar.css" rel="stylesheet" type="text/css" />
<div id="taskbar">
	<div id="container">
   		<div class="block-left">
    		<a href="../../componentes/com_pacientes/pacientes_gest.php" class="btns">Consultas</a>
		</div>
    <div class="block-center">
    	<table align="center">
        	<tr>
            	<td>
                	<table class="btns" border="0" cellpadding="0" cellspacing="0" height="100%">
                        <tr>
                          <td valign="middle"><img src="../../images/struct/img_taskbar/book_addresses.png" /><a href="../../componentes/com_consultas/consultas_reserva_list.php" rel="shadowbox" title="<strong>Consultas Reservadas</strong>">&nbsp;Consultas Reservadas</a></td>
                        </tr>
                    </table>
                </td>
                <td width="10">&nbsp;</td>
                <td>
                	<table class="btns" border="0" cellpadding="0" cellspacing="0" height="100%">
                        <tr>
                          <td valign="middle"><img src="../../images/struct/img_taskbar/application.png" /><a href="../../componentes/com_consultas/consultas_list.php" rel="shadowbox;options={relOnClose:true}" title="<strong>Consultas</strong>">&nbsp;Lista Consultas</a></td>
                            
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>
    <div class="block-right"><?php include('../../frames/_user_session_start.php'); ?></div>
  </div>
</div>