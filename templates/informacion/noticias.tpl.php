<div id="grid">
	<div id="gridForm"></div>
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>
<div style="width:50%;" id="panelRight">
	<div id="noticia_titulo"></div>
	<div id="noticia_img"></div>
	<div id="noticia_descripcion"></div>
	<div id="noticia_categoria"></div>
	<div id="noticia_fecha"></div>
	<div id="noticia_autor">NOTICIAS UNEARTE</div>
</div>
<?php
	$actions = $functions->actions($_SESSION['session']['permissions'],'Noticias');
	$sw = 0;
	if($actions!=''){
		foreach($actions as $key => $value){
			include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
			list($app,$template) = explode('/', $value['nombre_plantilla']);
			if ($template!='editarnoticia') {
				$templates[$key]['id'] = $value['idplantilla'];
				$templates[$key]['icon'] = $value['icono'];
				$templates[$key]['href'] = $template;
				$templates[$key]['label'] = $value['nombre_link'];
			}
			if ($template == 'editarnoticia' || $template == 'nuevanoticia'){
				$sw = 1;
			}
		}
	}

?>
<script type="text/javascript">
$(document).ready(function(){
	var sw = <?php print $sw; ?>;
	var d = <?php print json_encode($informacion->noticias($sw));?>;

	if (sw==1){
		var arrFields = [{display:'Nº',name:'id',width:'5%'},{display:'Titulo',name:'titulo',width:'40%'},{display:'Categoria',name:'categoria',width:'25%'},{display:'Publicación',name:'fecha',width:'15%'},{display:'Estado',name:'nombre',width:'12%'}]; 
	} else {
		var arrFields = [{display:'Nº',name:'id',width:'5%'},{display:'Titulo',name:'titulo',width:'40%'},{display:'Categoria',name:'categoria',width:'25%'},{display:'Publicación',name:'fecha',width:'15%'}]; 
	}

	$('#grid').grid({
		menu: <?php print json_encode($templates); ?>,
		fields: arrFields,
		data: d, 
		widthG: '50%',
		heightG: '100%',
		rcdpp: 25,
		ignoreDivs: ['system-message','panelRight'],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'},
		onloadgrid:function(){
			var idNoticia = document.getElementById('idid0');
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.id == idNoticia.innerHTML){
					indexRecord = i;
				}
			});

			viewdetails(d[indexRecord]);
		},
		onclickrcd: function(rcd){
			var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
			var idNoticia = document.getElementById('idid'+idrcd);
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.id == idNoticia.innerHTML){
					indexRecord = i;
				}
			});

			viewdetails(d[indexRecord]);
		},
		ondblclickrcd: function(rcd){
		if (sw==1){	
				var setup = {
					idGrid:'grid',
					idGForm:'gridForm',
					idGController:'gridController',
				};
				$.gridShowForm(setup);
				$('#'+setup.idGForm).slideDown('slow');
				$('#divModal').fadeIn('slow');
				editarnoticia(d,rcd);
			}
		}
	});

	function viewdetails(data){
		var tff = new typeForFields();
		var nTitulo = document.getElementById('noticia_titulo');
		var nImg = document.getElementById('noticia_img');
		var nDescripcion = document.getElementById('noticia_descripcion');
		var nCategoria = document.getElementById('noticia_categoria');
		var nFecha = document.getElementById('noticia_fecha');
		
		nTitulo.innerHTML = data.titulo;

		if (document.getElementById('divImg')) nImg.removeChild(document.getElementById('divImg'));
		var arrImg = data.url.split(',');
		var strImg = '';
		for(var i=0;i<arrImg.length;i++){
			var rcdImg = arrImg[i].split(';');
			if (i==arrImg.length-1)
				strImg += rcdImg[1];
			else
				strImg += rcdImg[1]+',';
		}
		nImg.appendChild(tff.image(strImg,'media/informacion/fotos/'));

		nDescripcion.innerHTML = tff.nl2br(data.descripcion,false);

		nCategoria.innerHTML = data.categoria;

		nFecha.innerHTML = data.fecha;
	}
	
});
</script>
