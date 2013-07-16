<script type="text/javascript">
	function editarsolicitudinfraestructura(data,rcd){
		var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
		var idSolicitud = document.getElementById('ididsolicitud'+idrcd);
		var indexRecord = 0;

		$.each(data,function(i,r){
			if(r.idsolicitud == idSolicitud.innerHTML){
				indexRecord = i;
			}
		});

		var record = data[indexRecord];
		var actividades = new Array();
		actividades = record.actividades.split(',');

		$('#gridFormContent').nForm({
			id:'formulario',
			title: 'Editar una Solicitud',
			ncol: 1,
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
				{	label:'Solicitante',
					tag:'input',
					col:1,
					attr: {
						id:'solicitante',
						name:'solicitante',
						type:'text',
						className:'inputField',
						readOnly:true,
					},
				},
				{	label:'Número de Solicitud',
					tag:'input',
					col:1,
					attr: {
						id:'idsolicitud',
						name:'idsolicitud',
						type:'text',
						className:'inputField',
					},
				},
				{	label:'Descripción',
					tag:'input',
					col:1,
					attr: {
						id:'descripcion',
						name:'descripcion',
						type:'text',
						className:'inputField',
					},
				},
				{	label:'Fecha de Detección',
					tag:'input',
					col:1,
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
					col:1,
					attr: {
						id:'fechacom',
						name:'fechacom',
						type:'dates',
						className:'inputField',
					},
				},
				{	label:'Fecha de Ejecución',
					tag:'input',
					col:1,
					attr: {
						id:'fechaeje',
						name:'fechaeje',
						type:'dates',
						className:'inputField',
					},
				},
				{	label:'Unidad Organizativa',
					tag:'select',
					col:1,
					attr: {
						id:'unidadorganizativa',
						name:'unidadorganizativa',
						className:'inputField',
					},
					list:<?php print json_encode($unidadesOrg); ?>,
				},
				{	label:'Responsable de obra',
					tag:'select',
					col:1,
					attr: {
						id:'responsableobra',
						name:'responsableobra',
						className:'inputField',
					},
					list:<?php print json_encode($personasResponsables); ?>,
				},
				{	label:'Tipificacion de Solicitud',
					tag:'select',
					col:1,
					attr: {
						id:'tipificacion',
						name:'tipificacion',
						className:'inputField',
					},
					list:<?php print json_encode($tipificacion); ?>,
				},
				{	label:'Status de Solicitud',
					tag:'select',
					col:1,
					attr: {
						id:'status',
						name:'status',
						className:'inputField',
					},
					list:<?php print json_encode($statusSolicitudes); ?>,
				},
				{	label:'Observación',
					tag:'textarea',
					col:1,
					attr: {
						id:'observacion',
						name:'observacion',
						className:'inputField',
					},
				},
				{	label:'Actividades',
					tag:'select',
					col:1,
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
					value:'update',
				},
				{	name:'mod',
					value:'<?php print $fileNameModule; ?>',
				},
				{	name:'solicitante',
					value:"<?php print $_SESSION['session']['apellidos'].', '.$_SESSION['session']['nombres']; ?>",
				},
				{	name:'idsolicitud',
					value:record.idsolicitud,
				},
				{	name:'descripcion',
					value:record.descripcion,
				},
				{	name:'fechadet',
					value:record.fecha_deteccion,
				},
				{	name:'fechacom',
					value:record.fecha_compromiso,
				},
				{	name:'fechaeje',
					value:record.fecha_ejecucion,
				},
				{	name:'unidadorganizativa',
					value:[record.idunidadorganizativa],
				},
				{	name:'responsableobra',
					value:[record.idresponsable],
				},
				{	name:'tipificacion',
					value:record.idtipificacion,
				},
				{	name:'status',
					value:[record.idstatus_solicitud],
				},
				{	name:'observacion',
					value:record.observacion,
				},
				{	name:'actividades[]',
					value:actividades,
				},
			],
		});

		//::: Buscamos todos los Objetos tipo Select para usar el Plugin Chosen
		$('#formulario select').chosen();
	}
</script>
