<script type="text/javascript">
function editarcomunicado(d,rcd){	
	var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
	var idComunicado = document.getElementById('idid'+idrcd);
	var indexRecord = 0;

	$.each(d,function(i,rcd){
		if(rcd.id == idComunicado.innerHTML){
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
		id:'formEditarComunicado',
		title:'Editar Comunicado',
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
								name:'idinformacion',
								type:'hidden',
						},
					},
					{	tag:'input',
						attr:{
							name:'tipoinformacion',
							id:'tipoinformacion',
							type:'hidden',
							value:1,
						},
				    },		
					{	label:'Título',
						tag:'input',
						attr:{
							 name:'titulo',
							 id:'titulo',
							 type:'text',
							 className:'inputField',
						},
					},
					{	label:'Fecha',
						tag:'input',
						attr:{	
							name:'fecha',
							id:'fecha',
							type:'dates', 
							className:'inputField',
						},
					},			
					{	label:'Archivo',
						tag:'input',
						col:1,
						attr: {
							id:'archivo',
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
							id:'tipomultimedia',
							type:'hidden',
							value:5,
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
					},
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
		$('#formEditarComunicado select').chosen();			
}
</script>