
<?php
define('IN_CB', true);
include('include/header.php');

$default_value['checksum'] = '';
$checksum = isset($_POST['checksum']) ? $_POST['checksum'] : $default_value['checksum'];
registerImageKey('checksum', $checksum);
registerImageKey('code', 'BCGcode39');

$characters = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9', 'A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z', '-', '.', '&nbsp;', '$', '/', '+', '%');
?>
<button onclick="imprimir();"> IMPRIMIR </button>    
<button onclick="imprimirA(2);"> IMPRIMIR jquery</button>    
<ul id="specificOptions">
    <li class="option">
        <div class="title">
            <label for="checksum">Checksum</label>
        </div>
        <div class="value">
            <?php echo getCheckboxHtml('checksum', $checksum, array('value' => 1)); ?>
        </div>
    </li>
</ul>

<div id="validCharacters">
    <h3>Valid Characters</h3>
    <?php foreach ($characters as $character) { echo getButton($character); } ?>
</div>

<div id="explanation">
    <h3>Explanation</h3>
    <ul>
        <li>Known also as USS Code 39, 3 of 9.</li>
        <li>Code 39 can encode alphanumeric characters.</li>
        <li>The symbology is used in non-retail environment.</li>
        <li>Code 39 is designed to encode 26 upper case letters, 10 digits and 7 special characters.</li>
        <li>Code 39 has a checksum but it's rarely used.</li>
    </ul>
</div>

<?php
include('include/footer.php');
?>
<script type="text/javascript" src="../../../js/jquery-1.10.2.min.js"></script>
<script>

var valorVal = $("#imageOutput").val();
var valorTex = $("#imageOutput").text();
var valorHtm = $("#imageOutput").html();

$("#imageOutput").html(function(){
   valorHtm = "Elementos hijos: " + $(this).children('*').length;
});

function imprimirA(id)
{
        var imp;
        imp = window.open(" ","Formato de Impresion"); 
        imp.document.open(); 
        imp.document.append($('#'+id).html());
        imp.document.close();
        imp.print();   
        imp.close(); 
}

function imprimir(){
  var objeto=document.getElementById('imageOutput');  //obtenemos el objeto a imprimir
  var ventana=window.open('','_blank');  //abrimos una ventana vacía nueva
  ventana.document.write('*');  //imprimimos el HTML del objeto en la nueva ventana
  ventana.document.close();  //cerramos el documento
  ventana.print();  //imprimimos la ventana
  ventana.close();  //cerramos la ventana
}
</script>