<script type="text/javascript">
	function editarusuario(data,rcd){
		var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
		var idPersona = document.getElementById('ididpersona'+idrcd);
		var indexRecord = 0;

		$.each(data,function(i,r){
			if(r.idpersona == idPersona.innerHTML){
				indexRecord = i;
			}
		});

		var record = data[indexRecord];
		var telefonos = eval("["+record.telefonos+"]");
		var correos = eval("["+record.correos+"]");
		var perfiles = record.perfiles.split(',');

		$('#gridFormContent').nForm({
			id:'formulario',
			title: 'Actualizar Usuario',
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
				{	tag:'input',
					col:1,
					attr: {
						id:'idpersona',
						name:'idpersona',
						type:'hidden',
					},
				},
				{	tag:'input',
					col:1,
					attr: {
						id:'idusuario',
						name:'idusuario',
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
						disabled: true,
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
						readOnly: true,
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
					list:<?php print json_encode($genero); ?>,
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
					value:'update',
				},
				{	name:'mod',
					value:'<?php print $fileNameModule; ?>',
				},
				{	name:'idpersona',
					value:record.idpersona,
				},
				{	name:'idusuario',
					value:record.idusuario,
				},
				{	name:'tipoidentificacion',
					value:[record.idtipoidentificacion],
				},
				{	name:'identificacion',
					value:record.identificacion,
				},
				{	name:'apellidos',
					value:record.apellidos,
				},
				{	name:'nombres',
					value:record.nombres,
				},
				{	name:'genero',
					value:[record.idgenero],
				},
				{	name:'fechanac',
					value:record.fechanacimiento,
				},
				{	name:'telefonos[]',
					value:telefonos,
				},
				{	name:'correos[]',
					value:correos,
				},
				{	name:'direccion',
					value:record.direccionhabitacion,
				},
				{	name:'centro',
					value:[record.idcentro],
				},
				{	name:'cargo',
					value:[record.idcargo],
				},
				{	name:'statususuario',
					value:[record.idstatususuario],
				},
				{	name:'fechaing',
					value:record.fecharegistro,
				},
				{	name:'perfiles[]',
					value:perfiles,
				},
			],
		});

		$('#tipoidentificacion').css('width','80px');
		$('#genero, #statususuario').css('width','120px');

		$('#formulario select').chosen();
	}
</script>
