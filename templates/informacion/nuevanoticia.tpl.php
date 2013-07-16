<script type="text/javascript">
function nuevanoticia(){	
	$('#gridFormContent').nForm({
			id: 'formNuevaNoticia',
			title:'Nueva Noticia',
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
								name:'idusuario',
								type:'hidden',
								value:<?php print $_SESSION['session']['idusuario'];?>,
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
								type:'text',
								className:'inputField',
								value:<?php print "'".date('d-m-Y, H:i:s')."'"; ?>,
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
					value:'add',
				},
				{	name:'mod',
					value:'<?php print $fileNameModule; ?>',
				},
			],
		});

		//::: Buscamos todos los Objetos tipo Select para usar el Plugin Chosen
		$('#formNuevaNoticia select').chosen();				
}
</script>
