<div class="container-fluid">
    <ul class="breadcrumb">
							<li>
								<i class="icon-print"></i>
								<a onclick="printID()">Imprimir</a>
								<i class="icon-angle-right"></i>
							</li>
							<li class="pull-right no-text-shadow">
								<div id="dashboard-report-range" class="dashboard-date-range tooltips no-tooltip-on-touch-device responsive" data-tablet="" data-desktop="tooltips" data-placement="top" data-original-title="Change dashboard date range">
									<i class="icon-calendar"></i>
									<span></span>
									<i class="icon-angle-down"></i>
								</div>
							</li>
						</ul>
	<div id="contPrintID">
    <input type="hidden" id="refRep" value="repVen">
    <div id="contRepo">
		<div class="alert alert-warning"><h4>Seleccione la Fecha(s) para Generar el Reporte</h4></div>
    </div>
    </div>
</div>
<script type="text/javascript">

function verifica_reporte(start,end){
	var repSel=$("#refRep").val();
	//alert(repSel+start+end);
	$( "#contRepo" ).load( "_fra_ventas.php?fStart="+start+"&fEnd="+end, function() {
	logGritter("Reporte Generado","Se ha visualizado su reporte");
});
}

function printID(){
  togleClassPrint('add');
  var objeto=document.getElementById('contPrintID');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write(objeto.outerHTML);  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento
  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
  togleClassPrint('rem');
}
</script>