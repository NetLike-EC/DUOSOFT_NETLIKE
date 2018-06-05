<div class="container-fluid">
	<a onclick="printID()" class="btn"><i class="icon-print"></i></a>
	<div id="contPrintID">
	<?php include('_fra_existencias.php'); ?>
    </div>
</div>
<script type="text/javascript">
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