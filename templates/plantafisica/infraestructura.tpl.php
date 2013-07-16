<div id="grid">
	<div id="gridForm"></div>
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<?php
	
	$data = $plantafisica->listInfraestructura();
	$actions = $functions->actions($_SESSION['session']['permissions'],'Infraestructura');
	
	foreach($actions as $key => $value){
		include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
		if ($value['nombre_plantilla']!='plantafisica/editarsolicitudinfraestructura'){
			list($app,$template) = explode('/', $value['nombre_plantilla']);
			$templates[$key]['id'] = $value['idplantilla'];
			$templates[$key]['icon'] = $value['icono'];
			$templates[$key]['href'] = $template;
			$templates[$key]['label'] = $value['nombre_link'];
		}
	};

?>
<script type="text/javascript">
$(document).ready(function(){
	var data = <?php print json_encode($data); ?>;
	$('#grid').grid({
		menu: <?php print json_encode($templates); ?>,
		fields: [
				{display:'Nº Solicitud',name:'idsolicitud',width:'7%'},
				{display:'Descripción',name:'descripcion',width:'33%'},
				{display:'Tipificación',name:'nombre_tipificacion',width:'20%'},
				{display:'Unidad Organizativa',name:'unidadorganizativa',width:'30%'},
				{display:'Status',name:'statussolicitudes',width:'10%'},
				],
		data: data,
		widthG: '100%',
		heightG: '100%',
		rcdpp: 20,
		ignoreDivs: ['system-message'],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'},
		onclickrcd:function(rcd){
			var setup = {
				idGrid:'grid',
				idGForm:'gridForm',
				idGController:'gridController',
			};
			$.gridShowForm(setup);
			$('#'+setup.idGForm).slideDown('slow');
			$('#divModal').fadeIn('slow');
			editarsolicitudinfraestructura(data,rcd);
		},
	});
});
</script>
