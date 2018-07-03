
    	<fieldset class="form-horizontal">
        <div class="form-group">
        	<label class="control-label col-sm-4">Email to send test (include)</label>
        	<div class="col-sm-8"><input id="stMail" type="email" class="form-control"/></div>
        </div>
        
        <div class="form-group">
        	<div class="col-sm-offset-4 col-sm-8"><button type="button" id="btnSendTest" class="btn btn-info" data-toggle="button"><i class="fa fa-envelope fa-lg"></i> Send Test</button></div>
        </div>
        <div class="form-group">
        	<label class="control-label col-sm-4">Status Send</label>
        	<div class="col-sm-8">
            	<div id="statSend"></div>
            </div>
        </div>
        </fieldset>
<script type="text/javascript">
$(document).ready(function(){
    $("#btnSendTest").click(function(){
		var $btn = $(this).button('loading');
		var parametros = {
            subject: $('#stSub').val(),
            mail: $('#stMail').val(),
			reply:$("#stRep").val(),
			msg:$("#stCon").val()
    	};
		
		$.post("jsonSendTest.php", parametros, siRespuesta, 'json');
		$btn.button('reset');
    });
});
function siRespuesta(r){
	$("#statSend").removeClass();
    $("#statSend").html(r.res);
	if(r.est=="TRUE") $("#statSend").addClass( "alert alert-success");
	else $("#statSend").addClass( "alert alert-danger");
	// Crear HTML con las respuestas del servidor
        /*var rHtml = 'El resultado de la suma es: ' + r.suma + '<br/>';
            rHtml += 'El resultado del producto es: ' + r.producto;
 
        $('#respuesta').html(rHtml);   // Mostrar la respuesta del servidor en el div con el id "respuesta"
		*/
    }
// Convert divs to queue widgets when the DOM is ready
function sendTest(mSub,mTo,mCon){
	
	//jQuery.ajax( url ,POST[] )
}
</script>