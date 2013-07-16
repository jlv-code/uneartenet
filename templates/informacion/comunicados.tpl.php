<div id="grid">
	<div id="gridForm"></div>
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<div style="width:60%; overflow:hidden;" id="panelRight">
	<div id="comunicados_url"></div>
</div>
<?php
	$actions = $functions->actions($_SESSION['session']['permissions'],'Comunicados');

	$sw = 0;
	if($actions!=''){
		foreach($actions as $key => $value){
			include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
			list($app,$template) = explode('/', $value['nombre_plantilla']);
			if ($template!='editarcomunicado'){	
				$templates[$key]['id'] = $value['idplantilla'];
				$templates[$key]['icon'] = $value['icono'];
				$templates[$key]['href'] = $template;
				$templates[$key]['label'] = $value['nombre_link'];
		    }
		    if ($template == 'editarcomunicado' || $template == 'nuevocomunicado'){
				$sw = 1;
			}
		};
	}	
?>
<script type="text/javascript">
$(document).ready(function(){

    var sw = <?php print $sw; ?>;
	var d = <?php print json_encode($informacion->comunicados($sw)); ?>;
	
	if (sw==1){
		var arrFields = [{display:'Nº',name:'id',width:'8%'},{display:'Titulo',name:'titulo',width:'45%'},{display:'Publicación',name:'fecha',width:'20%'},{display:'Estado',name:'nombre',width:'15%'}]; 
	} else {
		var arrFields = [{display:'Nº',name:'id',width:'8%'},{display:'Titulo',name:'titulo',width:'70%'},{display:'Publicación',name:'fecha',width:'20%'}]; 
	}
	
	$('#grid').grid({
		menu: <?php print json_encode($templates); ?>,
		fields: arrFields,
		data: d,
		widthG: '40%',
		heightG: '100%',
		rcdpp: 25,
		ignoreDivs: ['system-message','panelRight'],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'},

		onloadgrid:function(){
			var idComunicado = document.getElementById('idid0');
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.id == idComunicado.innerHTML){
					indexRecord = i;
				}
			});

			viewdetails(d[indexRecord]);
		},
		onclickrcd: function(rcd){
			var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
			var idComunicado = document.getElementById('idid'+idrcd);
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.id == idComunicado.innerHTML){
					indexRecord = i;
				}
			});

			viewdetails(d[indexRecord]);
		},
		ondblclickrcd: function(rcd){
		if(sw == 1){	
				var setup = {
					idGrid:'grid',
					idGForm:'gridForm',
					idGController:'gridController',
				};
				$.gridShowForm(setup);
				$('#'+setup.idGForm).slideDown('slow');
				$('#divModal').fadeIn('slow');
				editarcomunicado(d,rcd);
			}
		},
	});
	
	function viewdetails(data){
		var tff = new typeForFields();
		var nArchivo = document.getElementById('comunicados_url');

		$('#comunicados_url embed').remove();
		var arrPdf = data.url.split(',');
		var strPdf = '';
		for(var i=0;i<arrPdf.length;i++){
			var rcdPdf = arrPdf[i].split(';');
			strPdf += rcdPdf[1];
		}
		nArchivo.appendChild(tff.embed(strPdf,'media/informacion/pdf/','application/pdf','100%','100%'));
	}
	
});
</script>
