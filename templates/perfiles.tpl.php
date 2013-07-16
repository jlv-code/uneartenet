<div id="grid">
	<div id="gridForm"></div>
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<div id="linksxPerfil" style="display:none;">
	<div id="divControls"></div>
	<div id="divLinks"></div>
</div>

<?php

	$data = $perfiles->listaPerfiles();
	$listaLinks = $perfiles->listaLinks();
	$actions = $functions->actions($_SESSION['session']['permissions'],'Perfiles');
	//print_r($_SESSION['session']['permissions']);
	
	foreach($actions as $key => $value){
		include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
		if ($value['nombre_plantilla']!='editarperfil'){
			list($app,$template) = explode('/', $value['nombre_plantilla']);
			$templates[$key]['id'] = $value['idplantilla'];
			$templates[$key]['icon'] = $value['icono'];
			$templates[$key]['href'] = ($template!=null)?$template:$value['nombre_plantilla'];
			$templates[$key]['label'] = $value['nombre_link'];
		}
	};

	for($i=0;$i<count($data);$i++){
		$links[$i]['id'] = $data[$i]['idperfil'];
		$links[$i]['l'] = "[".str_replace('"', "'", $data[$i]['links'])."]";
	}

?>
<script type="text/javascript">
$(document).ready(function(){
	var data = <?php print json_encode($data); ?>;
	var links = <?php print json_encode($links); ?>;
	var listaLinks = <?php print json_encode($listaLinks); ?>;
	var menu = <?php print json_encode($templates); ?>;
	$('#grid').grid({
		menu: menu,
		fields: [
				{display:'Nº Perfil',name:'idperfil',width:'29%'},
				{display:'Descripción del Perfil',name:'nombre',width:'70%'},
				],
		data: data,
		widthG: '40%',
		heightG: '100%',
		rcdpp: 20,
		ignoreDivs: ['system-message','linksxPerfil'],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'},
		onloadgrid:function(){
			var rcd = document.getElementById('idrcd0');
			editarperfil(rcd,links,listaLinks);
		},
		onclickrcd:function(rcd){
			editarperfil(rcd,links,listaLinks);
		}
	});
	
});
</script>