<?php
	
	$unidadesOrg = $plantafisica->unidadesOrg();
	$personasResponsables = $plantafisica->personasResponsables();
	$tipificacion = $plantafisica->tipificacion();
	$statusSolicitudes = $plantafisica->statusSolicitudes();
	$actividades = $plantafisica->actividades();

?>
<script type="text/javascript">
	function nuevasolicitudinfraestructura(){
		$('#gridFormContent').nForm({
			id:'formulario',
			title: 'Generar una Solicitud',
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
				{	label:'Solicitante',
					tag:'input',
					attr: {
						id:'solicitante',
						name:'solicitante',
						type:'text',
						className:'inputField',
						readOnly:true,
					},
				},
				{	label:'Descripción',
					tag:'input',
					attr: {
						id:'descripcion',
						name:'descripcion',
						type:'text',
						className:'inputField',
					},
				},
				{	label:'Fecha de Detección',
					tag:'input',
					attr: {
						id:'fechadet',
						name:'fechadet',
						type:'text',
						readOnly:true,
						className:'inputField',
					},
				},
				{	label:'Fecha de Compromiso',
					tag:'input',
					attr: {
						id:'fechacom',
						name:'fechacom',
						type:'dates',
						className:'inputField',
					},
				},
				{	label:'Fecha de Ejecución',
					tag:'input',
					attr: {
						id:'fechaeje',
						name:'fechaeje',
						type:'dates',
						className:'inputField',
					},
				},
				{	label:'Unidad Organizativa',
					tag:'select',
					attr: {
						id:'unidadorganizativa',
						name:'unidadorganizativa',
						className:'inputField',
					},
					list:<?php print json_encode($unidadesOrg); ?>,
				},
				{	label:'Responsable de obra',
					tag:'select',
					attr: {
						id:'responsableobra',
						name:'responsableobra',
						className:'inputField',
					},
					list:<?php print json_encode($personasResponsables); ?>,
				},
				{	label:'Tipificacion de Solicitud',
					tag:'select',
					attr: {
						id:'tipificacion',
						name:'tipificacion',
						className:'inputField',
					},
					list:<?php print json_encode($tipificacion); ?>,
				},
				{	label:'Status de Solicitud',
					tag:'select',
					attr: {
						id:'status',
						name:'status',
						className:'inputField',
					},
					list:<?php print json_encode($statusSolicitudes); ?>,
				},
				{	label:'Observación',
					tag:'textarea',
					attr: {
						id:'observacion',
						name:'observacion',
						className:'inputField',
					},
				},
				{	label:'Actividades',
					tag:'select',
					attr: {
						id:'actividades',
						name:'actividades[]',
						className:'inputField',
						multiple:true,
					},
					list:<?php print json_encode($actividades); ?>,
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
				{	name:'solicitante',
					value:"<?php print $_SESSION['session']['apellidos'].', '.$_SESSION['session']['nombres']; ?>",
				},
				{	name:'fechadet',
					value:'<?php print date("Y-m-d"); ?>',
				},
			],
		});

		//::: Buscamos todos los Objetos tipo Select para usar el Plugin Chosen
		$('#formulario select').chosen();
	}
</script>
