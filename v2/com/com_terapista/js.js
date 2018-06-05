// JavaScript Document
function cargardatos(id,est,obs)
{		
	if(est==1)
	{			
		$("#est0").prop('checked', true);
		$("#est1").prop('checked', false);
		document.getElementById('estado').value='1';		
	}
	if(est==2)
	{
		document.getElementById('estado').value='2';
		$("#est1").prop('checked', true);
		$("#est0").prop('checked', false);				
	}
	if(obs!=undefined)
	{	
	document.getElementById('id_ses').value=id;
	document.getElementById('num_sesion').innerHTML = id;
	document.getElementById('obs').innerHTML = obs;	
	
	}else{
		document.getElementById('id_ses').value=id;
		document.getElementById('num_sesion').innerHTML = id;	
		document.getElementById('obs').innerHTML = "";
	}
}

$("#est0").click( function(){
   document.getElementById('estado').value='1';
   $("#est1").prop('checked', false);
});

$("#est1").click( function(){
   document.getElementById('estado').value='2';
   $("#est0").prop('checked', false);
});