<div id="grid">
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<script type="text/javascript">
$(document).ready(function(){
	$('#grid').grid({
		fields: [
				{display:'id',name:'id',width:'5%',novisible:true},
				{display:'Tipificación',name:'tipificacion',width:'30%'},
				{display:'Descripción',name:'descripcion',width:'40%'},
				{display:'Fecha Detección',name:'fecha_deteccion',width:'25%'}
				],
		data: [
				{'id':'0','tipificacion':'Traslado diario','descripcion':'SAR-PLM 10:00-11:00','fecha_deteccion':'00-00-0000'},
				{'id':'1','tipificacion':'Traslado diario','descripcion':'PLM-SAR 11:00-12:00','fecha_deteccion':'00-00-0000'},
				{'id':'2','tipificacion':'Traslado solicitado','descripcion':'Proyecto de Infraestructura','fecha_deteccion':'00-00-0000'},
				{'id':'3','tipificacion':'Traslado diario','descripcion':'Proyecto','fecha_deteccion':'00-00-0040'},
				{'id':'4','tipificacion':'Traslado solicitado','descripcion':'Proyecto de Infraestructura','fecha_deteccion':'00-00-0000'},
				{'id':'5','tipificacion':'Traslado solicitado','descripcion':'Proyecto de Infraestructura6','fecha_deteccion':'00-00-0000'}
				],
		widthG: '100%',
		heightG: '100%',
		rcdpp: 3,
		events: [{action:'onclick', fn:'alert("tipificacion");', field:'tipificacion'}],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'}
	});
});
</script>