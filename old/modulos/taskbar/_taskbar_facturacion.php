<link href="styles/taskbar.css" rel="stylesheet" type="text/css" />
<div id="taskbar">
	<div id="container">
   		<div class="block-left">
        <table height="100%" width="100%"><tr><td align="center"><a class="btns">Facturaci&oacute;n</a>
        </td></tr></table>
        </div>
        <div class="block-center" align="center">
        <table width="100%" height="100%">
            <tr>
                <td align="center">
                <?php include('_detail_doc.php') ?>
                </td>
            </tr>
        </table>
        </div>
		<div class="block-right"><?php include(RAIZ.'frames/_user_session_start.php'); ?></div>
	</div>
</div>