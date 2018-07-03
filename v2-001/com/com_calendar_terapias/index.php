<?php include('../../init.php');
$_SESSION['MODSEL']="CAL";
include(RAIZf.'head.php'); 
$_SESSION['idp'] = $_GET['idp'];
$_SESSION['idc'] = $_GET['idc'];
?>
<style>
	#loading {
		display: none;
		position: absolute;
		top: 10px;
		right: 10px;
	}
</style>
<script>
$(document).ready(function() {
$('#calendar').fullCalendar('today');
$('#calendar').fullCalendar({
	header: {
		left: 'prev,next today',
		center: 'title',
		right: 'month,agendaWeek,agendaDay'
	},
	defaultView: "agendaWeek",
	lang: "es",
	agenda: 'h:mm', // 5:00
	editable: true,
	weekends: true,
	/*
	dayClick: function(date, jsEvent, view) {
		var urlAge='form.php?datefc='+date.format();
		alert(urlAge);
		alert(view.name);
		loadFancyBoxEvent(urlAge);
		alert("day Click");
		var Hola="Holavar";
	},*/
	selectable: true,
	selectHelper: true,
	select: function(start, end, jsEvent, view) {
		var urlAge='form.php?';
		
		if(view.name=='month'){
			urlAge=urlAge+'datefc='+start.format();			
		}else{
			urlAge=urlAge+'datefc='+start.format()+'&datefe='+end.format();
		}		
		pasar_fecha(start.format());		
		$('#calendar').fullCalendar('unselect');
		parent.$.fancybox.close();
	},
	eventClick: function(calEvent, jsEvent, view) {
		//var urlAge='form.php?id='+calEvent.id;
		//loadFancyBoxEvent(urlAge);
		
	},
	eventDrop: function(calEvent, jsEvent, view) {
		setDB(calEvent.id,calEvent.start.format(),calEvent.end.format())
	},
	eventResize: function(calEvent, jsEvent, view) {
		setDB(calEvent.id,calEvent.start.format(),calEvent.end.format())
	},
	events: {		
		url: 'jsonEvents.php',
		error: function() {
			$("#logF").slideDown(200).text("Error Carga json").delay(3800).slideUp(200);
		}
	},
	loading: function(bool) {
		$('#loading').toggle(bool);
	}
});

function loadFancyBoxEvent(urlAge){
	alert("OK");
	$.fancybox({
		type: 'iframe',
		href: urlAge,
		title: 'Reserva',
		preload  : true,
		autoSize : false,
		width    : "90%",
		height   : "90%",
		beforeClose: function() {
			$('#calendar').fullCalendar('refetchEvents');
   		}
	});
};

function pasar_fecha(fecha)
    {    	
	//alert(fecha);
           $.ajax({
            type: "POST",
            url: "temp.php",
            async: false,
        data: {
			
      	fecha: fecha		
        },
        success:  function(resultado) 
        {            
         //alert(fecha);        
        }		
      });	 
    }

function setDB(id, start, end){
	//alert(id);
	$.get( "actionsJS.php", { id: id, start: start, end: end}, function( data ) {
		showLoading();
		hideLoading();
		$("#logF").slideDown(200).text(data.inf).delay(3800).slideUp(200);
	}, "json" );
	$('#calendar').fullCalendar('refetchEvents');
}	

});
</script>
<body style="background:#999;">
<?php sLOG('g') ?>
	<div class="container-fluid">
		<div id='loading'>loading...</div>
		<div class="well" style="background:#fff">
    		<div id='calendar'></div>            
    	</div>
    </div>
<?php include(RAIZf."footer.php");?>