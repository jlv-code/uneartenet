<?php

	$tipoidentificacion = $usuarios->tipoidentificacion();
	$genero = $usuarios->genero();
	$centro = $usuarios->centro();
	$cargo = $usuarios->cargo();
	$statususuario = $usuarios->statususuario();
	$perfiles = $usuarios->perfiles();

?>
<script type="text/javascript">
	function nuevousuario(){
		$('#gridFormContent').nForm({
			id:'formulario',
			title: 'Agregar Nuevo Usuario',
			ncol:2,
			fields: [
				{	tag:'input',
					col:1,
					attr: {
						id:'action',
						name:'action',
						type:'hidden',
					},
				},
				{	tag:'input',
					col:1,
					attr: {
						id:'module',
						name:'mod',
						type:'hidden',
					},
				},
				{	label:'Identificación',
					tag:'select',
					col:1,
					attr:{
						id:'tipoidentificacion',
						name:'tipoidentificacion',
						className:'inputField',
					},
					list:<?php print json_encode($tipoidentificacion); ?>,
				},
				{	label:'Identificación',
					tag:'input',
					col:1,
					attr:{
						id:'identificacion',
						name:'identificacion',
						className:'inputField',
						type:'text',
					},
				},
				{	label:'Apellidos',
					tag:'input',
					col:1,
					attr:{
						id:'apellidos',
						name:'apellidos',
						className:'inputField',
						type:'text',
					},
				},
				{	label:'Nombres',
					tag:'input',
					col:1,
					attr:{
						id:'nombres',
						name:'nombres',
						className:'inputField',
						type:'text',
					},
				},
				{	label:'Género',
					tag:'select',
					col:1,
					attr:{
						id:'genero',
						name:'genero',
						className:'inputField',
					},
					list:<?php print json_encode($genero); ?>,
				},
				{	label:'Fecha de Nacimiento',
					tag:'input',
					col:1,
					attr:{
						id:'fechanac',
						name:'fechanac',
						className:'inputField',
						type:'dates',
					},
				},
				{	label:'Teléfono',
					tag:'input',
					col:1,
					attr:{
						id:'telefonos',
						name:'telefonos[]',
						className:'inputField',
						type:'text',
						onchange:function(){$('#'+this.id).makeMultiple()}
					},
				},
				{	label:'Correo Electrónico',
					tag:'input',
					col:1,
					attr:{
						id:'correos',
						name:'correos[]',
						className:'inputField',
						type:'text',
						onchange:function(){$('#'+this.id).makeMultiple()}
					},
				},
				{	label:'Dirección de Habitación',
					tag:'textarea',
					col:1,
					attr:{
						id:'direccion',
						name:'direccion',
						className:'inputField',
					},
				},
				{	label:'Centro donde Trabaja',
					tag:'select',
					col:2,
					attr:{
						id:'centro',
						name:'centro',
						className:'inputField',
					},
					list:<?php print json_encode($centro); ?>,
				},
				{	label:'Cargo',
					tag:'select',
					col:2,
					attr:{
						id:'cargo',
						name:'cargo',
						className:'inputField',
					},
					list:<?php print json_encode($cargo); ?>,
				},
				{	label:'Status de Usuario',
					tag:'select',
					col:2,
					attr:{
						id:'statususuario',
						name:'statususuario',
						className:'inputField',
					},
					list:<?php print json_encode($statususuario); ?>,
				},
				{	label:'Fecha de Ingreso',
					tag:'input',
					col:2,
					attr:{
						id:'fechaing',
						name:'fechaing',
						type:'text',
						readOnly: true,
						className:'inputField',
					},
				},
				{	label:'Contraseña',
					tag:'input',
					col:2,
					attr:{
						id:'contrasena',
						name:'contrasena',
						type:'password',
						className:'inputField',
					},
				},
				{	label:'Repetir Contraseña',
					tag:'input',
					col:2,
					attr:{
						id:'repetircontrasena',
						name:'repetircontrasena',
						type:'password',
						className:'inputField',
					},
				},
				{	label:'Perfiles',
					tag:'select',
					col:2,
					attr:{
						id:'perfiles',
						name:'perfiles[]',
						className:'inputField',
						multiple:true,
					},
					list:<?php print json_encode($perfiles); ?>,
				},
			],
			buttons: [
				{
					label:'Guardar',
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
				{	name:'fechaing',
					value:'<?php print date("Y-m-d"); ?>',
				},
				{	name:'perfiles[]',
					value:[16],
				},
			],
		});

		$('#tipoidentificacion').css('width','80px');
		$('#genero, #statususuario').css('width','120px');

		$('#formulario select').chosen();
	}
</script>
