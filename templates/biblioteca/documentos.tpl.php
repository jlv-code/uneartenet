<div id="panelLeft">
	<div id="biblio_title">DATOS DEL DOCUMENTO</div>
	<div id="contenidoForm">
		<div id="parteAlta">
			<div id="parteAltaIzqVerLibro">
				<div id="biblio_cota_imagen" class="fotoEdicionLibro"></div>
			</div>
			<div id="parteAltaDerVerLibro">
				<div class="datosLibro" id="biblio_nombre_documento"></div>
				<div class="datosLibro" id="biblio_titulo"></div>
				<div class="datosLibro" id="biblio_autores" style="text-transform:capitalize;"></div>				
				<div class="datosLibro" id="tituloCeca">Publicado en <b style="font-size: 11px;" id="biblio_ano"></b> por, <b style="font-size: 11px;" id="biblio_editoriales"></b></b></div>
				<div class="datosLibro" id="tituloCeca"><b style="font-size: 10px; text-transform:capitalize;" id="biblio_ciudad"></b> - <b style="font-size: 10px; text-transform:capitalize;" id="biblio_pais"></b> en <b style="font-size: 11px; text-transform:capitalize;" id="biblio_idioma"></b></b></div>
			    <div class="datosLibro" id="tituloCeca">ISBN: <b style="font-size: 10px;" id="biblio_isbn"></b></div>
			</div>
		</div>
		
		<div id="parteBajaVerLibro">
			<div id="biblio_materias"></div>
			<div class="datosLibro" id="tituloCeca">Impreso en <b style="font-size: 10px;" id="biblio_impreso"></b>, <b style="font-size: 10px;" id="biblio_medida"></b> cm. y <b style="font-size: 10px;" id="biblio_paginas"></b> p. </b></div>
			<div class="datosLibro" id="tituloCeca">Disponible <b style="font-size: 11px;" id="biblio_ejemplares"></b> ejemplares en <b style="font-size: 11px;" id="biblio_centros"></b></b></div>
			<div class="datosLibro" id="tituloCeca">Solicite el material por la cota <b style="font-size: 11px;" id="biblio_cota"></b> y/o referencia(s) <b style="font-size: 11px;" id="biblio_referencia"></b> </div>
		</div>
		
		<div class="titleHead">TITULOS <div id="biblio_titulos"></div> </div>
		<div class="titleHead2">RESUMEN <div id="biblio_resumen"></div> </div>

	</div>	
</div>
<div id="grid">
	<div id="gridController"></div>
	<div id="gridTitles"></div>
	<div id="gridContent"></div>
</div>

<?php
	$actions = $functions->actions($_SESSION['session']['permissions'],'Documentos');
	
	foreach($actions as $key => $value){
		include 'templates/'.$value['nombre_plantilla'].'.tpl.php';
		list($app,$template) = explode('/', $value['nombre_plantilla']);
		//if ($template!='editarnoticias') {
			$templates[$key]['id'] = $value['idplantilla'];
			$templates[$key]['icon'] = $value['icono'];
			$templates[$key]['href'] = $template;
			$templates[$key]['label'] = $value['nombre_link'];
		//}
	};
?>

<script type="text/javascript">
$(document).ready(function(){
	var d = <?php print json_encode($biblioteca->consultaGeneral()); ?>;
	$('#grid').grid	({
		menu: <?php print json_encode($templates); ?>,
		fields: [
				{display:' ',name:'cota',type:'img',width:'5%',imgw:'100%',imgh:'auto',src:'media/biblioteca/fotos',ext:".png"},
				{display:'TIPO',name:'nombre_documento',width:'8%'},
				{display:'COTA',name:'cota_imagen',width:'15%'},
				{display:'Titulo del Documento',name:'titulo',width:'34%'},
				{display:'Autor(es)',name:'autores',width:'25%'},
				{display:'#',name:'ejemplares',width:'2%'},
				{display:'C.E.C.A.',name:'centros',width:'10%'},
				],
		data: d,
		widthG: '70%',
		heightG: '100%',
		rcdpp: 40,
		ignoreDivs: ['system-message','panelLeft'],
		rcdColor: {firstC:'#fff',secondC:'#efefef',overC:'#def'},
		onloadgrid:function(){
			var idDocumento = document.getElementById('idcota0');
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.id == idDocumento.innerHTML){
					indexRecord = i;
				}
			});

			viewdetails(d[indexRecord]);
		},
		onclickrcd: function(rcd){
			var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
			var idDocumento = document.getElementById('idcota_imagen'+idrcd);
			var indexRecord = 0;
			
			$.each(d,function(i,rcd){
				if(rcd.cota == idDocumento.innerHTML){
					indexRecord = i;
				}
			});
			viewdetails(d[indexRecord]);
		},
		ondblclickrcd: function(rcd){
			var setup = {
				idGrid:'grid',
				idGForm:'gridForm',
				idGController:'gridController',
			};
			$.gridShowForm(setup);
			$('#'+setup.idGForm).slideDown('slow');
			$('#divModal').fadeIn('slow');			
			editardocumento(d,rcd);
		}
	});
	
	function viewdetails(data){
		var tff = new typeForFields();
		var nTitulo = document.getElementById('biblio_titulo');
		var nCota = document.getElementById('biblio_cota');
		var nImg = document.getElementById('biblio_cota_imagen');
		var nEditoriales = document.getElementById('biblio_editoriales');
		var nAutores = document.getElementById('biblio_autores');
		var nResumen = document.getElementById('biblio_resumen');
		var nAno = document.getElementById('biblio_ano');
		var nCiudad = document.getElementById('biblio_ciudad');
		var nPais = document.getElementById('biblio_pais');
		var nIdioma = document.getElementById('biblio_idioma');
		var nIsbn = document.getElementById('biblio_isbn');
		var nMaterias = document.getElementById('biblio_materias');
		var nTitulos = document.getElementById('biblio_titulos');
		var nTipoDocumento = document.getElementById('biblio_nombre_documento');
		var nReferencia = document.getElementById('biblio_referencia');
		var nImpreso = document.getElementById('biblio_impreso');
		var nMedida = document.getElementById('biblio_medida');
		var nPaginas = document.getElementById('biblio_paginas');
		var nEjemplares = document.getElementById('biblio_ejemplares');
		var nCentros = document.getElementById('biblio_centros');
		
		nTitulo.innerHTML=data.titulo;
		nCota.innerHTML=data.cota;
		nAutores.innerHTML=data.autores;
		nEditoriales.innerHTML=data.editoriales;
		nAno.innerHTML=data.ano;
		nCiudad.innerHTML=data.ciudad;
		nPais.innerHTML=data.pais;
		nIdioma.innerHTML=data.idioma;
		nIsbn.innerHTML=data.isbn;
		nMaterias.innerHTML=data.materias;
		nTitulos.innerHTML=data.titulos;
		nTipoDocumento.innerHTML=data.nombre_documento;
		nReferencia.innerHTML=data.referencia;
		nImpreso.innerHTML=data.impreso;
		nMedida.innerHTML=data.medida;
		nPaginas.innerHTML=data.paginas;
		nEjemplares.innerHTML=data.ejemplares;
		nCentros.innerHTML=data.centros;
		nResumen.innerHTML=data.resumen;

		if (document.getElementById('divImg')) nImg.removeChild(document.getElementById('divImg'));
		nImg.appendChild(tff.image(data.cota+'.png','media/biblioteca/fotos/'));

	}
});
</script>
