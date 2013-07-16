<div id="grid">
	<div id="gridForm"></div>
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<?php
	
	$data = $usuarios->listaUsuarios();

	$actions = $functions->actions($_SESSION['session']['permissions'],'Usuarios');
	foreach($actions as $key => $value){
		include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
		if ($value['nombre_plantilla']!='editarusuario'){
			list($app,$template) = explode('/', $value['nombre_plantilla']);
			$templates[$key]['id'] = $value['idplantilla'];
			$templates[$key]['icon'] = $value['icono'];
			$templates[$key]['href'] = ($template!=null)?$template:$value['nombre_plantilla'];
			$templates[$key]['label'] = $value['nombre_link'];
		}
	};

?>
<script type="text/javascript">
$(document).ready(function(){
	var menu = <?php print json_encode($templates); ?>;
	var data = <?php print json_encode($data); ?>;
	$('#grid').grid({
		menu: menu,
		fields: [
				{name:'idpersona',width:'0'},
				{name:'idusuario',width:'0'},
				{display:'Nº ',name:'tipoidentificacion',width:'2%'},
				{display:'de Cédula',name:'identificacion',width:'10%'},
				{display:'Apellidos',name:'apellidos',width:'15%'},
				{display:'Nombres',name:'nombres',width:'15%'},
				{display:'Cargo',name:'cargo',width:'15%'},
				{display:'Sede',name:'centro',width:'15%'},
				{display:'Fecha de Registro',name:'fecharegistro',width:'18%'},
				{display:'Status',name:'statususuario',width:'10%'},
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
			editarusuario(data,rcd);
		},
	});
});
</script>