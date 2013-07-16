<script type="text/javascript">
function editarperfil(rcd,links,listaLinks){
	var linksData = new Array();
	var idrcd = parseInt(rcd.id.slice(5,rcd.id.length));
	var idPerfil = document.getElementById('ididperfil'+idrcd);
	var nombrePerfil = document.getElementById('idnombre'+idrcd);

	idP = idPerfil.innerHTML;
	$.each(links,function(k,v){
		if (idP==links[k].id) linksData = eval(links[k].l);
	});

	var grid = document.getElementById('grid');

	var linksxPerfil = document.getElementById('linksxPerfil');
	linksxPerfil.style.cssFloat = 'left';
	linksxPerfil.style.width = '59.8%';
	linksxPerfil.style.height = grid.style.height;
	linksxPerfil.style.borderRight = '1px solid #fff';
	linksxPerfil.style.display = 'block';

	var divControls = document.getElementById('divControls');
	divControls.style.cssFloat = 'left';
	divControls.style.width = '100%';
	divControls.style.height = '30px';
	divControls.style.borderBottom = '1px solid #fff';
	divControls.style.background = '#dddddd';
	divControls.style.background = '-moz-linear-gradient(top,  #dddddd 0%, #cccccc 100%)';
	divControls.style.background = '-webkit-gradient(linear, left top, left bottom, color-stop(0%,#dddddd), color-stop(100%,#cccccc))';
	divControls.style.background = '-webkit-linear-gradient(top,  #dddddd 0%,#cccccc 100%)';
	divControls.style.background = '-o-linear-gradient(top,  #dddddd 0%,#cccccc 100%)';
	divControls.style.background = '-ms-linear-gradient(top,  #dddddd 0%,#cccccc 100%)';
	divControls.style.background = 'linear-gradient(to bottom,  #dddddd 0%,#cccccc 100%)';

	var btnDelete = document.getElementById('btnDelete');
	if (btnDelete!=null) divControls.removeChild(btnDelete);

	var btnSave = document.getElementById('btnSave');
	if (btnSave!=null) divControls.removeChild(btnSave);

	var btnSelections = document.getElementById('btnSelections');
	if (btnSelections!=null) divControls.removeChild(btnSelections);

	var btnDelete = document.createElement('a');
	btnDelete.id = 'btnDelete';
	btnDelete.className = 'aButton';
	btnDelete.href = '#';
	btnDelete.style.cssFloat = 'right';
	btnDelete.style.margin = '1px 2px';
	btnDelete.style.paddingTop = '4px';
	btnDelete.appendChild(document.createTextNode('Eliminar'));

	var btnSave = document.createElement('a');
	btnSave.id = 'btnSave';
	btnSave.className = 'aButton';
	btnSave.href = '#';
	btnSave.style.cssFloat = 'right';
	btnSave.style.margin = '1px 2px';
	btnSave.style.paddingTop = '4px';
	btnSave.appendChild(document.createTextNode('Guardar'));

	var btnSelections = document.createElement('a');
	btnSelections.id = 'btnSelections';
	btnSelections.className = 'aButton';
	btnSelections.href = '#';
	btnSelections.style.cssFloat = 'right';
	btnSelections.style.margin = '1px 2px';
	btnSelections.style.paddingTop = '4px';
	btnSelections.style.width = 'auto';
	btnSelections.appendChild(document.createTextNode('Seleccionar Todos'));

	divControls.appendChild(btnDelete);
	divControls.appendChild(btnSave);
	divControls.appendChild(btnSelections);

	var divLinks = document.getElementById('divLinks');
	divLinks.style.cssFloat = 'left';
	divLinks.style.width = '100%';
	divLinks.style.height = ($('#'+grid.id).outerHeight()-30)+'px';
	divLinks.style.overflowY = 'scroll';

	var formLinks = document.getElementById('formLinks');
	if (formLinks!=null) divLinks.removeChild(formLinks);

	var formLinks = document.createElement('form');
	formLinks.id = 'formLinks';
	formLinks.name = 'formLinks';
	formLinks.style.cssFloat = 'left';
	formLinks.style.width = '100%';

	var inputIdPerfil = document.createElement('input');
	inputIdPerfil.name = 'idperfil';
	inputIdPerfil.type = 'hidden';
	inputIdPerfil.value = idPerfil.innerHTML;
	formLinks.appendChild(inputIdPerfil);

	var module = document.createElement('input');
	module.name = 'mod';
	module.type = 'hidden';
	module.value = '<?php print $fileNameModule; ?>';
	formLinks.appendChild(module);

	var action = document.createElement('input');
	action.name = 'action';
	action.type = 'hidden';
	action.value = 'update';
	formLinks.appendChild(action);

	divLinks.appendChild(formLinks);

	var divNPerfil = document.createElement('div');
	divNPerfil.id = 'nombrePerfil';
	divNPerfil.style.padding = '10px 5px';
	divNPerfil.style.borderTop = '1px solid #ddd';
	divNPerfil.style.borderBottom = '1px solid #fff';

	var lblNPerfil = document.createElement('label');
	lblNPerfil.htmlFor = 'nPerfil';
	lblNPerfil.appendChild(document.createTextNode('Nombre del Perfil'));
	lblNPerfil.style.fontWeight = 'bold';

	var inputNPerfil = document.createElement('input');
	inputNPerfil.id = 'nPerfil';
	inputNPerfil.name = 'nombreperfil';
	inputNPerfil.size = 30;
	inputNPerfil.value = nombrePerfil.innerHTML;
	inputNPerfil.style.marginLeft = '10px';
	inputNPerfil.style.padding = '5px';
	inputNPerfil.style.border = '1px solid #ccc';

	divNPerfil.appendChild(lblNPerfil);
	divNPerfil.appendChild(inputNPerfil);

	formLinks.appendChild(divNPerfil);

	$.each(listaLinks,function(k,v){
		var link = document.createElement('div');
		link.id = 'link'+k;
		link.style.borderBottom = '1px solid #777';

		switch(v.orden.length){
			case 1:
				link.style.padding = '5px';
				link.style.background = '#bbb';
				break;
			case 2:
				link.style.padding = '5px 5px 5px 15px';
				link.style.background = '#ccc';
				break;
			case 3:
				link.style.padding = '5px 5px 5px 25px';
				link.style.background = '#ddd';
				break;
			case 4:
				link.style.padding = '5px 5px 5px 35px';
				link.style.background = '#eee';
				break;
		}

		var lblLink = document.createElement('label');
		lblLink.htmlFor = 'lblLink'+k;
		var lblLinkDes = document.createElement('span');
		lblLinkDes.appendChild(document.createTextNode(v.descripcion));
		lblLinkDes.style.color = '#777';
		lblLink.appendChild(document.createTextNode(v.nombre));
		lblLink.appendChild(document.createTextNode(' - '));
		lblLink.appendChild(lblLinkDes);

		var chkLink = document.createElement('input');
		chkLink.id = 'link'+k;
		chkLink.type = 'checkbox';
		chkLink.value = v.idlink;
		chkLink.style.cssFloat = 'right';
		chkLink.name = 'links[]';
		
		for(var i=0;i<linksData.length;i++)
			if (linksData[i].idlink==v.idlink) chkLink.checked = true;

		link.appendChild(lblLink);
		link.appendChild(chkLink);

		formLinks.appendChild(link);

		inputNPerfil.autofocus = 'on';
	});
	
	//--
	//Este metodo se encarga de enviar los datos del formulario
	btnSave.onclick = function(){
		var success = $.sendFormData({
			idForm:'formLinks',
			method:'post',
			url: '_ajax.php',
			dataType: 'text',
		});
		if (success){
			sendMessage('granted','Los datos del perfil han sido enviados correctamente!');
			//setInterval(function(){javascript:location.reload();},2000);
		} else {
			sendMessage('denied','Debe seleccionar al menos una opción para guardar los datos. Todos los perfiles deben tener al menos un registro seleccionado.');
		}
	};

	btnSelections.onclick = function(){
		var makeCheck = true;
		if($(this).html()=='Seleccionar Todos'){
			makeCheck = true;
			$(this).html('Quitar Selección');
		} else {
			makeCheck = false;
			$(this).html('Seleccionar Todos');
		}

		$('[name="links[]"]').each(function(){
			$(this).attr("checked",makeCheck);
		});
	};

}
</script>