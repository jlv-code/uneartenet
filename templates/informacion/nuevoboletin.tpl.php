<script type="text/javascript">
function nuevoboletin(){
		$('#gridFormContent').nForm({
			id:'formNuevoBoletin',
			title:'Nuevo Boletín',
			fields:[
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
								id:'tipoinformacion',
								type:'hidden',
								value:1,
							},
						},	
						{	tag:'input',
							attr:{
								name:'idusuario',
								id:'idusuario',
								type:'hidden',
								value:<?php print $_SESSION['session']['idusuario'];?>,
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
								type:'text',
								className:'inputField',
								value:<?php print "'".date('d-m-Y, H:i:s')."'"; ?>,
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
