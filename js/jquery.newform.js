(function($){

	//::: Variables Globales
	var arrLbExist = [];
	var lbExist = -1;

	$.formSettings = {
		wrap:'wrapForm',
		id:'form',
		name:'form',
		title: 'Form',
		fields: false,
		method: 'post',
		dataType: 'json',
		controls: false,
		url: false,
		module: false,
	};

	//::: TAG es un arreglo de metodos para detectar 
	//::: la etiqueta que se debe crear en el DOM y ademas
	//::: los valores que pueden llenar cada campo
	tag = {
		input: function(object){
			if(object=='createField'){
				switch (this.attr.type) {
					case 'text':
					case 'hidden':
					case 'password':
					case 'dates':
					case 'file':
						var input = document.createElement(this.tag);
						$.each(this.attr,function(at,value){
							input[at] = value;
						});
						break;
					/*case 'file':
						var div = document.createElement('div');
						div.className = 'wrapInput';
						var i = document.createElement(this.tag);
						$.each(this.attr,function(at,value){
							i[at] = value;
						});
						div.appendChild(i);
						var input = div;
						break;*/
					case 'checkbox':
					case 'radio':
						var field = this;
						var divSet = document.createElement('div');
						divSet.className = 'divSet';
						$.each(field.list,function(k,v){
							var divI = document.createElement('div');
							var lblI = document.createElement('label');
							lblI.htmlFor = field.attr.id+k;
							lblI.className = 'lblFMultiple';
							lblI.appendChild(document.createTextNode(v));
							var i = document.createElement('input');
							$.each(field.attr,function(at,value){
								i[at] = value;
							});
							i.id += k;
							divI.appendChild(i);
							divI.appendChild(lblI);
							divSet.appendChild(divI);
						});
						var input =  divSet;
						break;
				}
				return input;
			} else {
				switch (this[0].type) {
					case 'text':
					case 'hidden':
					case 'password':
					case 'dates':
						if(typeof object == 'string') this[0].value = object;
						else if (typeof object == 'object') {
							var div = document.getElementById(this[0].id).parentNode;
							var inputInicial = this[0];
							var idInput = inputInicial.id;
							var iFinal= -1;
							inputInicial.onchange = null;
							if(object!=null){
								$.each(object,function(i,o){ 
									if (i==0){
										inputInicial.id = idInput+i;
										inputInicial.value = o.value;
										iFinal = i;
									} else {
										var input = inputInicial.cloneNode(true);
										input.id = idInput+i;
										input.value = o.value;
										div.appendChild(input);
										iFinal = i;
									}
								});
								if(iFinal!=-1){
									var input = inputInicial.cloneNode(true);
									input.value = '';
									input.id = idInput+(iFinal+1);
									input.onchange = function(){
										$('#'+input.id).makeMultiple();
									}
									div.appendChild(input);
								}
							}
						}
						break;
					case 'checkbox':
					case 'radio':
						var input = this;
						if(typeof object == 'string')
							return false;
						$.each(object,function(i,v){
							input[i].checked = true;
						});
						break;
					case 'file':
						var divImgsLoaded = document.getElementById('listOfImgsLoaded');
						/*var btnDelAllIL = document.getElementById('aDelAllImgsLoaded');
						btnDelAllIL.style.display = 'inline';*/
						$.each(object.value,function(i,value){
							var btnDel = document.createElement('a');
							btnDel.className = 'btnDelIL';
							btnDel.rel = 'file-'+value.value;
							btnDel.style.cssFloat = 'left';
							btnDel.style.marginLeft = '0';
							btnDel.style.cursor = 'pointer';
							btnDel.appendChild(document.createTextNode(object.btnDel));

							var imgLoaded = document.createElement('div');
							imgLoaded.id = 'file-'+value.value;
							imgLoaded.className = 'imgLoaded';

							var spanImg = document.createElement('span');
							spanImg.id = value.key+','+value.value;
							spanImg.className = 'imgToDel';
							spanImg.appendChild(document.createTextNode(value.value));

							imgLoaded.appendChild(btnDel);
							imgLoaded.appendChild(spanImg);
							divImgsLoaded.appendChild(imgLoaded);

							btnDel.onclick = function(){
								var input = document.getElementById('delete-'+value.value);
								if(input == null){
									var input = document.createElement('input');
									input.id = 'delete-'+value.value;
									input.name = object.inputForDel;
									input.type = 'hidden';
									input.value = value.key;
									document.getElementById(btnDel.rel).appendChild(input);
									btnDel.className = 'btnAddIL';
									btnDel.innerHTML = object.btnAdd;
									spanImg.className = 'imgToAdd';
								} else {
									btnDel.className = 'btnDelIL';
									btnDel.innerHTML = object.btnDel;
									input.parentNode.removeChild(input);
									spanImg.className = 'imgToDel';
								}
								
							}

						});
						break;
				}
			}
		},
		select: function(object){
			if(object=='createField'){
				var div = document.createElement('div');
				div.className = 'select';
				div.style.width = 'auto';
				div.style.cssFloat = 'left';
				var field = this;
				s = document.createElement('select');
				$.each(field.attr,function(at,value){
					s[at] = value;
				});
				$.each(field.list,function(k,v){
					var op = document.createElement('option');
					op.id = s.id+'opt'+k;
					op.className = 'optionSelect';
					op.value = v.key;	
					op.appendChild(document.createTextNode(v.value));
					s.appendChild(op);
				});
				div.appendChild(s);
				//alert(field.label);
				return div;
			} else {
				var options = this[0].childNodes;
				$.each(options,function(i,opt){
					$.each(object,function(i,v){
						if(opt.value == v)
							opt.selected = true;
					});
				});
			}
		},
		textarea: function(object){
			if(object=='createField'){
				var textarea = document.createElement(this.tag);
				$.each(this.attr,function(at,value){
					textarea[at] = value;
				});
				return textarea;
			} else {
				this[0].value = object;
			}
		},
	};


	//::: METODOS PRIVADOS DEL PLUGIN

	function makeField(field){
		//::: DIV para colocar cada campo del formulario
		var df = document.createElement('div');
		df.id = 'div'+field.attr.id;
		df.className = 'formDivField';
		var iWrap = document.createElement('div');
		iWrap.className = 'wrapInput wI'+field.label;

		//::: LABEL de cada campo
		if (typeof field.label != 'undefined'){
			lbExist = arrLbExist.indexOf(field.label);
			if (lbExist==-1){
				var lb = document.createElement('label');
				lb.id = 'lb'+field.attr.id;
				lb.className = 'lblField';
				lb.htmlFor = field.attr.id;
				lb.appendChild(document.createTextNode(field.label));
				arrLbExist.push(field.label);
			}
		}

		//::: TAG HTML que se debe crear
		if(field.attr.type=='hidden') df.style.padding = '0';
		var f = tag[field.tag].apply(field,['createField']);
		if (lbExist!=-1){
			$('label').each(function(){
				if ($(this).html()==field.label){
					var df = document.getElementById($(this).attr('id')).parentNode.childNodes[1];
					df.appendChild(f);
					return 0;
				}
			});
		} else {
			if (typeof lb != 'undefined') df.appendChild(lb);
			iWrap.appendChild(f);
			df.appendChild(iWrap);

			return df;
		}
	}// FIN function makeField

	function prepareFilesToSend(){
		var filesToSend = new FormData();
		$('input:file').each(function(){
			var input = $(this)[0];
			for(var i=0; i<input.files.length;i++){
				filesToSend.append($(this).attr('name'),input.files[i]);
			}
		});
		return filesToSend;
	}// FIN function prepareFilesToSend


	//::: METODOS PUBLICOS DEL PLUGIN

	$.fsendMessage = function(tag,type,message,callback){
		var divMessage = document.createElement('div');
		divMessage.id = 'divMessage';
		divMessage.style.position = 'absolute';
		divMessage.style.zIndex = '1';
		divMessage.style.top = '10px';
		divMessage.style.left = '30%';
		divMessage.style.right = '30%';
		divMessage.style.display = 'none';
		divMessage.appendChild(document.createTextNode(message));

		var divToInclude = document.getElementById(tag);
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
	};// FIN function $.fsendMessage

	$.sendFormData = function(s){
		var r = false;
		var data = $('#'+s.idForm).serialize();
		if (data=='') return false;
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
	};// FIN function $.sendFormData

	$.fn.inputfiles = function(s){
		var settings = $.extend({
			btnLblAdd: '+',
			btnLblDel: '-',
			btnLblDelAll: '-',
			btnLblAddIL: '+',
			btnLblDelIL: '-',
			btnLblDelAllIL:'-',
			btnLblAddAllIL:'+',
			inputForDel:'imgtodelete[]',
		},s);
		//::: Buscamos o creamos el TAG ANCHOR para añadir
		//::: nuevos archivos.
		var btnAdd = document.getElementById('aNewFile');
		if(btnAdd == null){
			var btnAdd = document.createElement('a');
			btnAdd.id = 'aNewFile';
			btnAdd.className = 'inputFile btnAdd';
			btnAdd.style.cssFloat = 'left';
			btnAdd.style.position = 'absolute';
			btnAdd.style.marginLeft = '0';
			btnAdd.appendChild(document.createTextNode(settings.btnLblAdd));
		}
		//::: Buscamos o creamos el TAG ANCHOR para Eliminar
		//::: todos los archivos.
		var btnDelAll = document.getElementById('aDelFile');
		if(btnDelAll == null){
			var btnDelAll = document.createElement('a');
			btnDelAll.id = 'aDelFile';
			btnDelAll.className = 'inputFile btnDelAll';
			btnDelAll.style.cssFloat = 'left';
			btnDelAll.style.position = 'absolute';
			btnDelAll.style.marginLeft = '0';
			btnDelAll.style.cursor = 'pointer';
			btnDelAll.appendChild(document.createTextNode(settings.btnLblDelAll));
		}
		//::: Buscamos o creamos el TAG ANCHOR para Eliminar
		//::: todos los archivos cargados en BBDD.
		/*var btnDelAllIL = document.getElementById('aDelAllImgsLoaded');
		if(btnDelAllIL == null){
			var btnDelAllIL = document.createElement('a');
			btnDelAllIL.id = 'aDelAllImgsLoaded';
			btnDelAllIL.className = 'inputFile btnDelAllIL';
			btnDelAllIL.style.cssFloat = 'left';
			btnDelAllIL.style.position = 'absolute';
			btnDelAllIL.style.cursor = 'pointer';
			btnDelAllIL.style.display = 'none';
			btnDelAllIL.appendChild(document.createTextNode(settings.btnLblDelAllIL));
			btnDelAllIL.onclick = function(){
				if(btnDelAllIL.className=='inputFile btnDelAllIL'){
					btnDelAllIL.className = 'inputFile btnAddAllIL';
					btnDelAllIL.innerHTML = settings.btnLblDelAllIL;
				} else{
					btnDelAllIL.className = 'inputFile btnDelAllIL';
					btnDelAllIL.innerHTML = settings.btnLblAddAllIL;
				}
				var sw1 = false;
				$('.imgToDel').each(function(){
					$(this).addClass('imgToAdd').removeClass('imgToDel');
					var img = $(this).attr('id');
					var arrImg = img.split(',');
					var input = document.getElementById('delete-'+arrImg[1]);
					if(input==null){
						var input = document.createElement('input');
						input.id = 'delete-'+arrImg[1];
						input.name = settings.inputForDel;
						input.type = 'hidden';
						input.value = arrImg[0];
						document.getElementById(img).parentNode.appendChild(input);
					}
					sw1 = true;
				});
				if(sw1==false){
					$('.imgToAdd').each(function(){
						$(this).addClass('imgToDel').removeClass('imgToAdd');
						var img = $(this).attr('id');
						var arrImg = img.split(',');
						var input = document.getElementById('delete-'+arrImg[1]);
						document.getElementById(img).parentNode.removeChild(input);
						sw1 = true;
					});
				}

				var sw2 = false;
				$('.btnAddIL').each(function(){
					$(this).addClass('btnDelIL').removeClass('btnAddIL');
					$(this).html(settings.btnLblDelIL);
					sw2 = true;
				});
				if(sw2==false){
					$('.btnDelIL').each(function(){
						$(this).addClass('btnAddIL').removeClass('btnDelIL');
						$(this).html(settings.btnLblAddIL);
						sw2 = true;
					});
				}
			}
		}*/
		//::: Buscamos o creamos un DIV para almacenar algunos datos de cada 
		//::: Imagen que capture el Input:File. Tambien almacenara el Input:File
		//::: una vez se clone.
		var divImgs = document.getElementById('listOfImgs');
		if(divImgs == null){
			var divImgs = document.createElement('div');
			divImgs.id = 'listOfImgs';
			//divImgs.style.cssFloat = 'left';
		}
		//::: Buscamos o creamos un DIV para almacenar algunos datos de cada 
		//::: Imagen que este almacenada en BBDD. Tambien almacenara el Input:Hidden.
		var imgLoaded = document.getElementById('listOfImgsLoaded');
		if(imgLoaded == null){
			var imgLoaded = document.createElement('div');
			imgLoaded.id = 'listOfImgsLoaded';
			//imgLoaded.style.cssFloat = 'left';
		}
		//::: Se obtiene el DIV donde esta el Campo
		var divField = document.getElementById($(this).attr('id')).parentNode;
		divField.style.position = 'relative';
		//::: Se incorporan el Tag Anchor y el DIV Contenedor de Imagenes
		divField.appendChild(btnAdd);
		divField.appendChild(btnDelAll);
		//divField.appendChild(btnDelAllIL);
		divField.appendChild(divImgs);
		divField.appendChild(imgLoaded);
		//::: Se estiliza el Input:File
		var input = document.getElementById($(this).attr('id'));
		input.multiple = false;
		input.style.position = 'absolute';
		input.style.zIndex = '2';
		input.style.opacity = '0';
		input.style.marginLeft = '0';
		input.style.fontSize = '0px';
		input.style.width = $('.inputFile').outerWidth()+'px';
		input.style.height = $('.inputFile').outerHeight()+'px';

		divImgs.style.marginTop = $('#aNewFile').outerHeight()+'px';
		imgLoaded.style.marginTop = $('#aNewFile').outerHeight()+5+'px';
		btnDelAll.style.marginLeft = $('#aNewFile').outerWidth()+5+'px';
		//btnDelAllIL.style.marginLeft = $('#aNewFile').outerWidth()+$('#aDelFile').outerWidth()+10+'px';

		btnDelAll.onclick = function(){
			$('#listOfImgs .imgToUpload').remove();
		}

		input.onmouseover = function(){
			btnAdd.style.background = '#cdd';
		}
		input.onmouseout = function(){
			btnAdd.style.background = '#eff';
		}
		input.onchange = function(){
			var nInput = this.cloneNode(true);
			this.parentNode.insertBefore(nInput,this);
			this.removeAttribute('id');
			$('#'+nInput.id).inputfiles();

			for(var i=0; i<this.files.length;i++){
				this.style.display = 'none';

				var divImg = document.createElement('div');
				divImg.id = 'file-'+this.files[i].name;
				divImg.className = 'imgToUpload';

				var btnDel = document.createElement('a');
				btnDel.className = 'btnDel';
				btnDel.rel = 'file-'+this.files[i].name;
				btnDel.style.cssFloat = 'left';
				btnDel.style.marginLeft = '0';
				btnDel.style.cursor = 'pointer';
				btnDel.appendChild(document.createTextNode(settings.btnLblDel));

				var imgName = document.createElement('span');
				imgName.appendChild(document.createTextNode(this.files[i].name));

				divImg.appendChild(btnDel);
				divImg.appendChild(imgName);
				divImg.appendChild(this);
				divImgs.appendChild(divImg);

				btnDel.onclick = function(){
					$('[id="'+this.rel+'"]').remove();
				}
			}
		}
	};// FIN function $.inputfiles

	$.fn.makeMultiple = function(){
		var field = document.getElementById($(this).attr('id'));
		field.onchange = null;

		switch(field.tagName.toLowerCase()){
			case 'input':
			case 'textarea':
				var nField = field.cloneNode(true);
				nField.value = '';
				nField.onchange = function(){
					$('#'+this.id).makeMultiple();
				}
				
				field.parentNode.appendChild(nField);

				$('[name="'+field.name+'"]').each(function(i){
					$(this).attr('id',$(this).attr('id')+i);
				});
				break;
			case 'select':
				var nField = field.cloneNode(true);
				nField.onchange = function(){
					$('#'+this.id).makeMultiple();
				}
				
				field.parentNode.appendChild(nField);

				$('[name="'+field.name+'"]').each(function(i){
					$(this).attr('id',$(this).attr('id')+i);
				});
				break;
		}

	};// FIN function $.makeMultiple

	var methods = {
		init: function(object){ 
			//::: Declariación de Objetos
			if (typeof object == 'object'){
				var sf = $.extend($.formSettings, object);
				var gFC = this;
				var mTopWrap = 3;
				var fields = '';
				var dForm = document.getElementById($(this).attr('id'));
				var title = document.createElement('div');
				var btns = document.createElement('div');
				var wrap = document.createElement('div');
				var form = document.createElement('form');

				//::: Atributos del objeto TITLE
				title.id = 'titleForm';
				title.appendChild(document.createTextNode(sf.title));
				//::: Atributos del objeto de BTNS (Botones)
				btns.id = 'btnsForm';
				btns.className = 'btnsForm';
				//::: Atributos del objeto WRAP
				wrap.id = sf.wrap;
				wrap.style.marginTop = mTopWrap+'px';
				wrap.style.overflowX = 'hidden';
				wrap.style.overflowY = 'auto';
				//::: Atributos del objeto FORM
				form.id = sf.id;
				form.className= 'form';
				form.name = sf.name;
				form.style.width = '100%';
				//::: Integración de los Objetos al DOM
				dForm.appendChild(title);
				dForm.appendChild(btns);
				dForm.appendChild(wrap);
				wrap.appendChild(form);

				if(!typeof sf.ncol=='undefined' || sf.ncol>1){
					for(var i=1; i<=sf.ncol; i++){
						var divCol = document.createElement('div');
						divCol.id = 'idcol'+i;
						divCol.className = 'formCol';
						divCol.style.width = (($('#'+form.id).outerWidth()/sf.ncol)-10)+'px';
						form.appendChild(divCol);
					}
				}

				//::: Detectamos el ALTO del dForm para actualizar el ALTO 
				//::: de wrap.
				wrap.style.height = $('#'+dForm.id).outerHeight() - ($('#'+title.id).outerHeight() + $('#'+btns.id).outerHeight() + mTopWrap)+'px';

				//::: Llamada al Método makeFields
				//::: Si existen campos serán cargardos al formulario
				if (sf.fields){
					for(var i=0; i<sf.fields.length; i++){
						field = makeField(sf.fields[i]);
						if(typeof field!='undefined'){
							if(!typeof sf.ncol=='undefined' || sf.ncol>1){
								document.getElementById('idcol'+sf.fields[i].col).appendChild(field);
							}else{
								form.appendChild(field);
							}
						}
					}
					arrLbExist = [];
				}
				//::: Si existen botones serán cargardos
				if (sf.buttons){
					for(var i=0; i<sf.buttons.length; i++){
						var btn = document.createElement('a');
						btn.id = 'btn'+sf.buttons[i].label;
						btn.className = 'aButton';
						btn.appendChild(document.createTextNode(sf.buttons[i].label));

						if(sf.buttons[i].action=='send'){
							btn.onclick = function(){
								var success = $.sendFormData({
									idForm:form.id,
									method:'post',
									url: '_ajax.php',
									dataType: 'text',
								});
								if (success){
									$.fsendMessage($(gFC).attr('id'),'granted','El nuevo registro ha sido procesado!',function(){
										javascript:location.reload();
									});
								} else {
									$.fsendMessage($(gFC).attr('id'),'denied','Existe un error en los datos. Por favor verifiquelos!');
								}
							}
						}

						btns.appendChild(btn);
					}
				}
				//::: Buscamos todos los TYPE=FILE para colocarles 
				//::: el plugin de archivos si posee el SET, sino 
				//::: se busca en general algun input:file
				var setExist = false;
				$.each(sf.fields,function(i,f){
					if(typeof f.set == 'object'){
						$('#'+f.attr.id).inputfiles(f.set);
						setExist = true;
					}
				});
				if(!setExist){
					if ($('[type="file"]').attr('id')!=null){
						$('[type="file"]').inputfiles();
					}
				}
				//::: Buscamos todos los TYPE=DATES para colocarles 
				//::: el Datepicker de jQuery UI
				$('[type="dates"]').datepicker({
					dateFormat: 'yy-mm-dd',
				});
				
			} else if (typeof object == 'function'){
				//::: Ejecuta la funcion si existe
				object.call();
			}
		},
		fill: function(object){
			if (typeof object == 'object'){
				var toFill = object.fields;
				var obj = '';
				$.each(toFill,function(i,o){
					obj = document.getElementsByName(o.name);
					tagName = obj[0].tagName.toLowerCase();
					if(obj[0].type == 'file'){
						tag[tagName].apply(obj,[o]);
					} else {
						tag[tagName].apply(obj,[o.value]);
					}
				});
			} else if (typeof object == 'function'){
				//::: Ejecuta la funcion si existe
				object.call();
			}
		},
	};
	
	$.fn.nForm = function(method){

		if (methods[method]){
			return methods[method].apply(this,Array.prototype.slice.call(arguments,1));
		} else if (typeof method === 'object' || ! method) {
			return methods.init.apply(this,arguments);
		} else {
			$.error('Método '+method+' no existe en el plugin jQuery.newForm');
		}
	
	};// FIN $.fn.newForm
	
})(jQuery);