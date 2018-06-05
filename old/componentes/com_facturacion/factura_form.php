<?php
include('../_config.php');
require_once(RAIZ.'Connections/conn.php');

if (!isset($_SESSION)) session_start();

if($_SESSION['stat_proc']=="SAVED") echo '<script type="text/javascript">parent.Shadowbox.close();</script>';
else{
	if($_POST['id_cons']==null) $_POST['id_cons']=$_GET['id_cons'];
	if($_POST['action_cons']==null) $_POST['action_cons']=$_GET['action_cons'];
	$LOG = $_GET['LOG'];

$idPACses = "-1";
if (isset($_SESSION['id_pac'])) $idPACses = $_SESSION['id_pac'];
$detCLI=detCliPer($idPACses);
$status_cons="[ Nueva Factura ]";
$action_btn="GRABAR";
?>
<?php include(RAIZ.'frames/_head.php'); ?>
<script type="text/javascript" src="js/js_carga_list-cons-pac.js"></script>
<script type="text/javascript" src="js/jquery.tablesorter.js"></script>
<body>
<div id="head_sec">
<a href="#" class="link">FACTURACION</a>&nbsp;<span class="statuscons"><?php echo $status_cons; ?></span></div>
<div id="cont_head">
<form id="form_factura_cab" name="form_factura_cab" method="post" action="factura_agregar.php">
<table class="main">
	<tr>
    	<td><table>
        	<tr>
           	  	<td class="txt_name">ID Cliente:</td>
			    <td class="txt_values-sec"><?php echo $_SESSION['id_pac']; ?></td>
          </tr>
      </table></td>
      <td></td>
      <td bgcolor="#999999" width="1"></td>
   	  <td><table>
        	<tr>
           	  	<td class="txt_name">Fecha:</td>
			    <td class="txt_values"><?php echo date("Y-m-d"); ?></td>
            </tr>
      </table></td>
      <td bgcolor="#999999" width="1"></td>
   	  <td><table>
        	<tr>
           	  	<td class="txt_name">Pago:</td>
				<td class="txt_values"><span id="sprysel_pag">
				<select name="tip_pag" id="tip_pag">
				  <option value="-1"></option>
				  <option value="1">Contado</option>
				  <option value="2">Cheque</option>
				  <option value="3">Credito</option>
				</select><br />
		        <span class="selectInvalidMsg">Seleccione Tipo Pago válido.</span>
                <span class="selectRequiredMsg">Seleccione Tipo Pago.</span></span></td>
            </tr>
      </table></td>
      <td bgcolor="#999999" width="1"></td>
   	  <td><table>
		  <tr>
       	    <td class="txt_name">Empleado:</td>
		      <td class="txt_values-sec"><?php echo $row_RS_emp_sel['emp_nom']; ?> <?php echo $row_RS_emp_sel['emp_ape']; ?>
              </td>
          </tr>
      </table></td>
		<td bgcolor="#999999" width="1"></td>
    	<td><?php if (count($_SESSION[$ses_id]['compra'])>0) { ?>
          &nbsp;&nbsp;&nbsp;
          <input type="submit" name="btn_action" id="btn_action" value="Grabar" onClick="return confirm('Desea Grabar?');"/>
		  <?php } ?>
          </td>
    </tr>
</table>
</form>
<table width="100%">
	<tr>
   	  <td width="50%">
          <table class="main" width="100%">
          <tr>
          	<td class="txt_name" width="70">Cliente:</td>
            <td class="txt_values-big" align="left"><?php echo $detCLI['cli_nom']; ?> <?php echo $detCLI['cli_ape']; ?></td>
          </tr>
          <tr>
          	<td colspan="2">
            	<table>
                	<tr>
<td>
                        	<table>
		  <tr>
                                	<td class="tit_sec_gray">RUC:</td>
                          <td class="txt_name"><strong>
						<?php echo $detCLI['cli_ruc']; ?></strong></td>
                            </tr>
                                <tr>
                                	<td class="tit_sec_gray">Dirección:</td>
                                  <td class="txt_name"><?php echo $detCLI['cli_dir']; ?></td>
                              </tr>
                                <tr>
                                	<td class="tit_sec_gray">Teléfono:</td>
                                  <td class="txt_name"><?php echo $detCLI['cli_tel']; ?> - <?php echo $detCLI['cli_cel']; ?></td>
                              </tr>
                            </table>
                      </td>
                    </tr>
                </table>
            </td>
          </tr>
        </table>
      </td>
		<td align="center" valign="top" >
          <?php include(RAIZ.'componentes/com_commons/productos_find.php'); ?>
      </td>
    </tr>
</table>
</div>
<table class="bord_gray_4cornes" align="center" width="100%" bgcolor="#DDDDDD">
    <tr>
    	<td width="90%" bgcolor="#FFFFFF">
        <table width="100%">
            <tr>
            	<td>
            		<?php 
						$detalle = $_SESSION[$ses_id]['compra'];
						if($detalle){ ?>
                        	<table class="tablesorter" id="mytable">
                        	<thead>
                            <tr>
                           		<th width="60">COD</th>
                            	<th>Nombre</th>
                            	<th width="60">Cantidad</th>
                                <th width="85">Precio</th>
                                <th width="95">Subtotal</th>
                                <th width="30"></th>
							</tr>
                            </thead>
                            <tbody>
                        	<?php foreach ($_SESSION[$ses_id]['compra'] as $v) { ?>
                        	<tr>
                        		<td><?php echo $v["id"]; ?></td>
                                <td>
								<strong>
                                <a href="producto_detail.php?prod_sel_find=<?php echo $v['id']; ?>&prod_sel_can=<?php echo $v["can"]; ?>&prod_sel_pre=<?php echo $v["pre"]; ?>" rel="shadowbox;width=500;options={relOnClose:true}">
								<?php echo $v["nom"];?>
                                </a></strong>
                                </td>
                                <td><?php echo $v["can"] ;?></td>
                                <td><?php echo $v["pre"] ;?></td>
                                <td><?php echo $v["sub"] ;?></td>
                                <td align="center"><form action="prod_detail_eliminar.php" method="post">
                                <input name="btn_quitar" type="image" value="Quitar" src="img_est/png/publish_x.png"/>
                                <!--<input type="submit" name=	 "btn_quitar" value="Quitar"/> -->
                                <input type="hidden" value="<?php echo $v["id"]; ?>" name="id_prod" /></form>
                                </td>
							</tr>
                            <?php
                            $sumsubtot+= $v["sub"];
							 } ?>
                            </tbody>
                        </table>
						<?php }else{ ?>
                            <table align="center" width="100%">
                                <tr>
                                    <td class="log" align="center">
                                    	<br /><br />
                                    	<strong>aNo Hay Productos a Facturar</strong><br />
                                    	<br /><br />                                    </td>
                                </tr>
                            </table>
                        <?php }	?>
              </td>
            </tr>
        </table>
        </td>
    </tr>
</table>

<table height="40" align="center" class="bord_gray_4cornes">
<tr>
    	<td class="log"><?php echo $_GET['LOG']; ?></td>
    </tr>
</table>

<?php include(RAIZ.'modulos/taskbar/_taskbar_facturacion.php'); ?>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("sprysel_pag", {invalidValue:"-1", validateOn:["blur", "change"]});
//-->
</script>
</body>
</html>
<?php } ?>