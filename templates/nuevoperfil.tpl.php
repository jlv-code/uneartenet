<script type="text/javascript">
	function nuevoperfil(){
		$('#gridFormContent').nForm({
			id:'formulario',
			title: 'Agregar Nuevo Perfil',
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
				{	label:'Nombre del Perfil',
					tag:'input',
					attr:{
						id:'perfil',
						name:'perfil',
						type:'text',
						className:'inputField',
					},
				},
			],
			buttons: [
				{
					label:'Guardar Solicitud',
					action: 'send',
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
	}
</script>
