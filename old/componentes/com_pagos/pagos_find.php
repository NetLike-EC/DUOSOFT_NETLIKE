<script src="../../SpryAssets/SpryValidationSelect.js" type="text/javascript"></script>
<link href="../../SpryAssets/SpryValidationSelect.css" rel="stylesheet" type="text/css" />

<table align="center">
                	<tr>
                   	  <td class="tit_sec_gray">Tipo Pago:</td>
                      	<td class="sec_values"><span id="spryselect1">
                          <label>
                          <select name="lis_tip_pag" class="txt_name" id="lis_tip_pag">
                            <option value="-1" selected="selected">Seleccione Tipo Pago:</option>
                            <option value="1">Contado</option>
                          </select>
                          </label><br />
                        <span class="selectInvalidMsg">Tipo Seleccionado No Válido.</span>
                        <span class="selectRequiredMsg">Seleccione Tipo Pago.</span></span></td>
                        <td width="1" bgcolor="#DDDDDD">&nbsp;</td>
                      <td><label>
                        <input type="submit" name="btn_cobrar" id="btn_cobrar" value="Cobrar" />
                          <input name="deuda" type="hidden" id="deuda" value="<?php echo $row_RS_cta_deuda['Deuda'] ?>" />
                          <input name="pac_sel_pag" type="hidden" id="pac_sel_pag" value="<?php echo $row_RS_pac_sel['pac_cod']; ?>" />
                          <input name="textfield" type="text" id="textfield" value="<?php echo $row_RS_cta_pend['Deuda']; ?>" />
                      </label></td>
                    </tr>
              </table>
<script type="text/javascript">
<!--
var spryselect1 = new Spry.Widget.ValidationSelect("spryselect1", {validateOn:["blur", "change"], invalidValue:"-1"});
//-->
</script>
