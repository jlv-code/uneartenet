(function($){
	
	$.fn.newForm = function(setup){
		var settings = $.extend($.newFormSettings, setup);

		var typeOf = {
			inputField: function(f){
				if(f.typeOf=='text' || f.typeOf=='number' || f.typeOf=='hidden' || f.typeOf=='dates'){
					var input = document.createElement('input');
					input.id = 'id'+f.name;
					input.name = f.name;
					input.className = 'inputField';
					input.type = f.typeOf;
					input.placeholder = f.label;
					//input.type = (f.typeOf=='dates')?'text':f.typeOf;
					if (typeof(f.value)!='undefined') input.value = f.value;
					if (typeof(f.size)!='undefined') input.size = f.size;
					if (typeof(f.disabled)!='undefined') input.disabled = 'true';
					if (typeof(f.readOnly)!='undefined') input.readOnly = 'true';
					return input;
				} else {
					if (typeof(f.list)=='undefined'){
						alert('Debe haber una Lista para el campo: '+f.label+'. Por tanto, no se mostrará.');
					} else {
						var divSet = document.createElement('div');
						divSet.id = 'divSet'+f.name;
						divSet.className = 'divSet';

						$.each(f.list,function(i,o){
							var divInputFMultiple = document.createElement('div');
							var input = document.createElement('input');
							input.id = 'id'+f.name+i;
							input.name = f.name+'[]';
							input.className = 'inputField inputFMultiple';
							input.type = f.typeOf;
							input.value = o.key;
							if(typeof(f.value)!='undefined'){
								switch(f.typeOf){
									case 'checkbox':
										for(var i=0; i<f.value.length;i++){
											if(f.value[i]==o.key) input.checked = true;
										}
										break;
									case 'radio':
										if(f.value==o.key) input.checked = true;
										break;
								}
							}
							divInputFMultiple.appendChild(input);
							var lblI =  document.createElement('label');
							lblI.htmlFor = input.id;
							lblI.className = 'lblFMultiple';
							var textI = document.createTextNode(o.value);
							lblI.appendChild(textI);
							divInputFMultiple.appendChild(lblI);
							divSet.appendChild(divInputFMultiple);
							
						});
						return divSet;
					}
				}
			},
			textAreaField: function(f){
				var textArea = document.createElement('textarea');
				textArea.id = 'id'+f.name;
				textArea.name = f.name;
				textArea.type = f.typeOf;
				textArea.cols = f.col;
				textArea.rows = f.row;
				textArea.className = 'inputField';
				if (typeof(f.value)!='undefined') textArea.appendChild(document.createTextNode(f.value));
				return textArea;
			},
			selectField: function(f){
				var select = document.createElement('select');
				select.id = 'id'+f.name;
				select.name = (f.multiple==false || typeof(f.multiple)!='undefined')?f.name:f.name+'[]';
				select.className = 'selectField';
				if (typeof(f.w)!='undefined') select.style.width = f.w;
				if (typeof(f.size)!='undefined') select.size = f.size;
				if (f.multiple==true) select.multiple = true;

				$.each(f.list,function(i,o){
					var option = document.createElement('option');
					option.className = 'optionSelect';
					option.value = o.key;
					option.text = o.value;
					if (typeof(f.value)!='undefined'){
						//if (f.name=='actividades[]') alert(f.value[i]);
						for(var i=0;i<f.value.length;i++){
							if(f.value[i]==o.key) option.selected = true;
						}
					}
					select.appendChild(option);
				});

				return select;
			},
			fileField: function(f){
				var fileInput = document.createElement('input');
				fileInput.id = 'id'+f.name;
				fileInput.name = (f.multiple==true)?f.name+'[]':f.name;
				fileInput.multiple = (f.multiple==true)?true:false;
				fileInput.type = f.typeOf;
				fileInput.className = 'inputField';
				fileInput.style.width = (typeof(f.width)=='undefined')?'100px':f.width;
				return fileInput;
			},
		};
		
		var fnc = {

			formShowFields: function(){
				var divToInclude = document.getElementById(settings.idDivInclude);
				var divTitleForm = document.createElement('div');
				divTitleForm.id = 'divTitleForm';
				divTitleForm.style.padding = '5px';
				divTitleForm.style.color = '#500';
				divTitleForm.style.fontWeight = 'bold';
				divTitleForm.style.textTransform = 'uppercase';
				divTitleForm.appendChild(document.createTextNode(settings.titleForm));
				divToInclude.appendChild(divTitleForm);
				var divForm = document.createElement('div');
				divForm.id = settings.idDivForm;
				var nform = document.createElement('form');
				nform.id = settings.idForm;
				nform.className = 'form';
				nform.style.width = (settings.w!='')?settings.w:'';
				nform.method = settings.method;
				nform.enctype = 'multipart/form-data';
				divForm.appendChild(nform);
				divToInclude.appendChild(divForm);

				$.each(settings.fields, function(i,f){
					var divField = document.createElement('div');
					divField.className = 'formDivField class'+i+' type-'+f.typeOf;
					if(f.typeOf=='hidden') divField.style.display = 'none';

					if(f.label!='' && typeof(f.label)!='undefined'){
						var lblFieldText = document.createTextNode(f.label);
						var lblField = document.createElement('label');
						lblField.htmlFor = 'id'+f.name;
						lblField.className = 'lblField';
						lblField.appendChild(lblFieldText);
					}

					switch(f.typeOf){
						case 'hidden':
						case 'text':
						case 'checkbox':
						case 'radio':
						case 'number':
						case 'dates':
							newField = typeOf.inputField(f);
							break;
						case 'select':
							newField = typeOf.selectField(f);
							break;
						case 'file':
							newField = typeOf.fileField(f);
							break;
						case 'textarea':
							newField = typeOf.textAreaField(f);
							break;
					}

					$('#'+nform.id).append(divField);
					if (typeof(lblField)!='undefined') {
						$('.class'+i).append(lblField);
					}
					$('.class'+i).append(newField);
				});
			},
			
			formShowControls: function(){
				var divControls = document.createElement('div');
				divControls.id = 'divControls';
				divControls.className = 'divControls';
				document.getElementById(settings.idForm).appendChild(divControls);
				$.each(settings.controls,function(i,v){
					var btn = document.createElement('a');
					btn.appendChild(document.createTextNode(v.label));
					btn.id = 'submit';
					btn.name = 'submit';
					btn.className = 'aButton';
					document.getElementById(divControls.id).appendChild(btn);
					switch(v.action){
						case 'add': 
							btn.onclick = function(){
								$.sendFormData(v.action,settings);
							};
							break;
						case 'update':
							btn.onclick = function(){
								$.sendFormData(v.action,settings);
							};
							break;
					}
				});
			}
		};

		$.fsendMessage = function(type,message,callback){
			//ESTE METODO HAY QUE PULIRLO
			var divMessage = document.createElement('div');
			divMessage.id = 'divMessage';
			divMessage.style.position = 'absolute';
			divMessage.style.zIndex = '1';
			divMessage.style.top = '10px';
			divMessage.style.left = '30%';
			divMessage.style.right = '30%';
			divMessage.style.display = 'none';
			divMessage.appendChild(document.createTextNode(message));

			var divToInclude = document.getElementById(settings.idDivInclude).parentNode;
			divToInclude.appendChild(divMessage);

			switch(type){
				case 'granted' :
					divMessage.style.padding = '5px';
					divMessage.style.border = '1px solid #8d8';
					divMessage.style.color = '#040';
					divMessage.style.background = '#afa';
					break;
				case 'denied' :
					divMessage.style.padding = '5px';
					divMessage.style.border = '1px solid #e55';
					divMessage.style.color = '#a00';
					divMessage.style.background = '#eaa';
					break;
			}

			$('#'+divMessage.id).slideDown().delay(2000).slideUp('slow',function(){
				$(this).remove();
				if (typeof(callback)=='function') callback.call();
			});
		};
		
		/* Desde aqui, el codigo prosigue llamando las funciones
		 * antes creadas
		 */ 
		
		$(document).ready(function(){
			fnc.formShowFields();
			fnc.formShowControls();
			//var brw = new Browser();
			//if (brw.name == 'firefox') $('[type="date"]').datepicker();
			$('[type="dates"]').datepicker({
				dateFormat: 'yy-mm-dd',
			});
			switch(settings.useStyle){
				case 'jqueryui':
					$('#'+settings.idForm+' div').each(function(){
						var divSet = this.id.slice(0,6);
						if (divSet == 'divSet'){
							$('#'+this.id).buttonset();
						}
					});
					$('#'+settings.idForm+' select').selectmenu();
					break;
				case 'chosen':
					$('#'+settings.idForm+' select').chosen();
					break;
				case 'uniform':
					$("select, input:checkbox, input:radio, input:file").uniform();
					break;
			}
		});// FIN $(document).ready
			
	};// FIN $.fn.newForm

	$.newFormSettings = {
		titleForm: 'Form',
		useStyle: false,
		fields: false,
		idDivInclude: 'divForm',
		idDivForm: 'wrapForm',
		idForm:'form_new',
		nameForm: 'form_new',
		actionForm: '#',
		method: 'post',
		dataType: 'json',
		controls: false,
		url: false,
		module: false,
		onSuccess: function(){
			javascript:location.reload();
		},
	};

	//METODOS PRIVADOS DEL PLUGIN
	function prepareFilesToSend(){
		var filesToSend = new FormData();
		$('input:file').each(function(){
			var elementWithfiles = document.getElementById($(this).attr('id'));
			for(var i=0; i<elementWithfiles.files.length;i++){
				filesToSend.append($(this).attr('name'),elementWithfiles.files[i]);
			}
		});
		return filesToSend;
	}

	//METODOS PUBLICOS DEL PLUGIN
	$.sendFormData = function(action,s){
		var r = false;
		var data = $('#'+s.idForm).serialize();
		if (data=='') return false;
		data = data + '&action='+action+'&mod='+s.module;
		if($('[type="file"]').val()!='undefined') 
			var filesToSend = prepareFilesToSend();
		$.ajax({
			type: s.method,
			url: s.url+'?'+data,
			data: filesToSend,
			async:false,
			contentType: false,
			processData: false,
			cache: false,
			dataType: s.dataType,
			success: function(response){
				if(s.onSuccess) s.onSuccess(response);
				r = response;
			},
		});
		return r;
	};
	
})(jQuery);
