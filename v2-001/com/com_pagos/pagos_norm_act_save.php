<?php require_once('../../init.php');
$valor=$_GET['valor'];
$idp=$_GET['idp'];
$id_emp=$_SESSION['MM_UserID'];

$SQL_bus_pen="SELECT tbl_cta_por_cobrar.num_cta, tbl_cta_por_cobrar.cta_detalle, tbl_cta_por_cobrar.con_num, tbl_cta_por_cobrar.pac_cod,
(tbl_cta_por_cobrar.cta_valor-tbl_cta_por_cobrar.cta_abono) AS Saldo FROM tbl_cta_por_cobrar
WHERE tbl_cta_por_cobrar.cta_abono<tbl_cta_por_cobrar.cta_valor AND tbl_cta_por_cobrar.pac_cod=".$idp." 
ORDER BY tbl_cta_por_cobrar.num_cta ASC";
$RES_bus_pen = mysql_query($SQL_bus_pen);

$val_cal=$valor;
$cont_regs=0;
$array_det_pag=null;
while($row1 = mysql_fetch_array($RES_bus_pen)) 
{
	$num_cta_sel=$row1["num_cta"];
	$con_num=$row1["con_num"];
	$cta_det=$row1["cta_detalle"];
	$saldo_sel=$row1["Saldo"];
	
	if($val_cal>=$saldo_sel){
		$pagado_cta=$saldo_sel;
		$val_cal=$val_cal-$pagado_cta;
	}else{
		$pagado_cta=$val_cal;
		$val_cal=$val_cal-$pagado_cta;
	}	

	$array_det_pag[$cont_regs][0]=$num_cta_sel;
	$array_det_pag[$cont_regs][1]=$con_num;
	$array_det_pag[$cont_regs][2]=$cta_det;
	$array_det_pag[$cont_regs][3]=$pagado_cta;
	$cont_regs++;

	if($val_cal<=0)
		break;
}

$fec_system=date("Y-m-d H:i:s");

	@mysql_query("INSERT INTO tbl_pagopac_cab(
	pag_fech,pag_val,emp_cod,pac_cod,pag_tip)
	VALUES ('$fec_system', '$valor', '$id_emp', '$idp', '1')")or($LOG=mysql_error());
	$id_pago_cab=@mysql_insert_id();
		
	$cont_update=0;
	while($cont_update<$cont_regs)
	{
		$upd_num_cta=$array_det_pag[$cont_update][0];
		$upd_con_num=$array_det_pag[$cont_update][1];
		$upd_cta_det=$array_det_pag[$cont_update][2];
		$upd_pagado_cta=$array_det_pag[$cont_update][3];
		
		if(@mysql_query("INSERT INTO tbl_pagopac_det (pag_num, con_num, pac_cod, num_cta, abono, detalle)
		VALUES('$id_pago_cab', '$upd_con_num', '$idp', '$upd_num_cta', '$upd_pagado_cta', '$upd_cta_det')"))
		{
			$id_pagdet=@mysql_insert_id();
			$LOG.="Grabado Pago Det ".$id_pagdet." OK<br />";
		}
		else
			$LOG.="Error Grabado Pago Det<br />";
		
		if(@mysql_query("UPDATE tbl_cta_por_cobrar SET cta_abono=cta_abono+'$upd_pagado_cta'
		WHERE num_cta='$upd_num_cta'"))
			$LOG.="Actualizada Cuenta ".$upd_num_cta." x cobrar OK";
		else
			$LOG.="Error Actualizacion Cuenta x Cobrar";
	$cont_update++;
	}
$_SESSION['refresh']='ok';
$insertGoTo = 'pagos_detail.php?LOG='.$LOG.'&id_pag='.$id_pago_cab;//REDIRECCION A LA PAGINA SIGUIENTE
header(sprintf("Location: %s", $insertGoTo));
?>