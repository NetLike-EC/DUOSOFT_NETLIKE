<?php require_once('../../init.php');
    $selr=vParam('selr',$_GET['selr'],$_POST['selr'],FALSE);
	$FI=vParam('FI',$_GET['FI'],$_POST['FI'],FALSE);
	$FF=vParam('FF',$_GET['FF'],$_POST['FF'],FALSE);
	// GET HTML
	ob_start();
    if($selr=="1"){
		include('rep_pacProc_print01.php');	
		$nomFile='ReporteSourcesContact-'.$sdate.'.pdf';
	}else if($selr=="2"){
		include('rep_pacProc_print02.php');
		$nomFile='ReporteListContact-'.$sdate.'.pdf';	
	}else{
		echo '<h2>No se ha seleccionado un reporte</h2>';
	}
	
    $content = ob_get_clean();
    // convert in PDF
    try{
        $html2pdf = new HTML2PDF('P', 'A4', 'fr');
        $html2pdf->writeHTML($content);
        $html2pdf->Output();
    }catch(HTML2PDF_exception $e) { echo $e; exit; }
	ob_end_flush();
?>