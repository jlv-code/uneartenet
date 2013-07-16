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
	$('#gridForm').newForm({
		titleForm: 'Editar Comunicado',
		idDivInclude: 'gridFormContent',
		useStyle: 'chosen',
		idForm: 'formEditarComunicado',
		method: 'post',
		url: '<?php print urlAjaxM; ?>',
		module: '<?php print $fileNameModule; ?>',
		dataType: 'text',
		fields: [
				{name:'idinformacion',typeOf:'hidden',value:record.id},
				{label:'Título',name:'titulo',typeOf:'text', value:record.titulo},
				{label:'Fecha',name:'fecha', typeOf:'text', value:record.fecha},
				{label:'Archivo',name:'media',typeOf:'file',width:'150px',multiple:true},
				{name:'tipomultimedia',typeOf:'hidden',value:5},
				{name:'tipoinformacion',typeOf:'hidden',value:1},		
				{label:'Estado',name:'estado',typeOf:'select',value:record.idstatusinformacion,list:<?php print json_encode($informacion->estado());?>},
				],
		controls: [
				{label:'Guardar',action:'update'},
				],
		onSuccess: function(response){
			if (response) {
				$.fsendMessage('granted','¡Se ha actualizado satisfactoriamente el registro!',function(){
					javascript:location.reload();
				});
			} else {
				$.fsendMessage('denied','Existe un error en los datos. Por favor verifiquelos');
			}
		},		
	});
}
</script>