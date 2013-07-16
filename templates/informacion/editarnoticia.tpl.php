<script type="text/javascript">
function editarnoticia(d,rcd){	
	var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
	var idNoticia = document.getElementById('idid'+idrcd);
	var indexRecord = 0;

	$.each(d,function(i,rcd){
		if(rcd.id == idNoticia.innerHTML){
			indexRecord = i;
		}
	});
	var record = d[indexRecord];
	var media = new Array();
	if (record.url != ''){
		
		media = record.url.split(',');
		
		var nmedia = '[';
		for(var i=0;i<media.length;i++){
			if (i==media.length-1)
				nmedia += '{key:'+(media[i].replace(';',",value:'")+"'}");
			else
				nmedia += '{key:'+(media[i].replace(';',",value:'")+"'},");
		}
		nmedia += ']';
		media = eval(nmedia);
	}	
	$('#gridFormContent').nForm({
			id: 'formEditarNoticia',
			title:'Editar Noticia',
			fields: [
						{	tag:'input',
							attr: {
								id:'action',
								name:'action',
								type:'hidden',

							},
						},
						{	tag:'input',
							attr: {
								id:'module',
								name:'mod',
								type:'hidden',
							},
						},
						{	tag:'input',
							attr:{
								name:'tipoinformacion',
								type:'hidden',
								value:3,
							},
						},
						{	tag:'input',
							attr:{
								name:'idinformacion',
								type:'hidden',
							},
						},	
						
						{	label:'Título',
							tag:'input',
							attr:{
								 name:'titulo',
								 type:'text',
								 className:'inputField',
								},
						},
								
						{	label:'Descripción',
							tag:'textarea',
							attr:{
								id:'descripcion',
								name:'descripcion',
								col:20,
								row:10,
								className:'inputField',
							},
						},
							
						{	label:'Categoría',
							tag:'select',
							attr:{
								id:'categoria',
								name:'categoria[]',
								multiple:true,
							},
							list:<?php print json_encode($informacion->categorias());?>,
						},	

						{	label:'Fecha',
							tag:'input',
							attr:{	
								name:'fecha',
								type:'dates', 
								className:'inputField',
							},
						},
							
						{	label:'Imagenes',
							tag:'input',
							col:1,
							attr: {
								id:'imagenes',
								name:'media[]',
								type:'file',
							},
							set: {
								btnLblAdd: '+ Agregar',
								btnLblDel: '-',
								btnLblDelAll: '- Eliminar Todo',
							},	
						},
							
						{	tag:'input',
							attr:{
								name:'tipomultimedia',
								type:'hidden',
								value:2,
							},
						},
							
						{	label:'Estado',
							tag:'select',
							attr:{
								id:'estado',
								name:'estado',
							},	
							list:<?php print json_encode($informacion->estado());?>,
						},
	
					],

			buttons: [
					{
						label:'Guardar',
						action:'send',
					}
			],
		});

		$('#gridFormContent').nForm('fill',{
		
			fields:[
				{	name:'action',
					value:'update',
				},
				{	name:'mod',
					value:'<?php print $fileNameModule; ?>',
				},
				{
					name:'idinformacion',
					value: record.id,
				},
				{
					name:'titulo',
					value: record.titulo,
				},
				{
					name:'descripcion',
					value: record.descripcion,
				},
				{
					name:'categoria[]',
					value: record.idcategoria,
				},
				{
					name:'fecha',
					value: record.fecha,
				},
				{
					name:'media[]',
					value: media,
					inputForDel:'imgtodelete[]',
					btnAdd:'+',
					btnDel:'-',
				},				
				{
					name:'estado',
					value: record.idstatusinformacion,
				},
			],
		});

		//::: Buscamos todos los Objetos tipo Select para usar el Plugin Chosen
		$('#formEditarNoticia select').chosen();	
					
}
</script>
