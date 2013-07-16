(function($){
	
	/*	INICIALIZACIÓN DEL PLUGIN DE GRID
	 *	Pulign desarrollado para mostrar un grid
	 *	de datos.
	 */
	$.fn.grid = function(setup){

		var settings = $.extend($.gridsettings, setup);

		var typeOf = {
				embed: function(fileEmbed,srcEmbed,typeEmbed,width,height){
					var file = document.createElement('embed');
					file.src = srcEmbed+fileEmbed;
					file.type = typeEmbed;
					file.width = width;
					file.height = height;
					return file;
				},

				image:  function(images,src,ext){
					var arrImages = images.split(',');
					var divImg = document.createElement('div');
					divImg.id = 'divImg';
					divImg.className = 'divImg';
					for(i=0;i<arrImages.length;i++){
						var img = document.createElement('img');
						if (typeof(src)=='undefined') src = 'images/';
						if (typeof(ext)=='undefined') ext = '';
						img.src = src+arrImages[i]+ext;
						img.alt = arrImages[i];
						divImg.appendChild(img);
					}
					return divImg;
				},

				nl2br: function(str,is_xhtml) {
					var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '' : '<br>';
					return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
				},
        };
		
		var fnc = {
				gridShowController: function(){
					if (settings.menu!=false) fnc.gridMenu();
					var divControllerInfo = document.createElement('div');
					divControllerInfo.id = 'gridControllerInfo';
					divControllerInfo.style.width = '200px';
					divControllerInfo.style.cssFloat = 'left';
					divControllerInfo.style.paddingTop = '7px';
					divControllerInfo.style.paddingLeft = parseInt($('#gridMenu').outerWidth())+10+'px';
					divControllerInfo.style.color = '#555';
					divControllerInfo.style.fontSize = '11px';
					divControllerInfo.innerHTML = settings.controls.info+settings.data.length;

					var divWrapController = document.createElement('div');
					divWrapController.id = 'gridWrapController';
					
					var aFirst = document.createElement('a');
					aFirst.className = 'gridControllerFirst';
					aFirst.innerHTML = settings.controls.first;
					
					var aPrev = document.createElement('a');
					aPrev.className = 'gridControllerPrev';
					aPrev.innerHTML = settings.controls.prev;
					
					var aLast = document.createElement('a');
					aLast.className = 'gridControllerLast';
					aLast.innerHTML = settings.controls.last;
					
					var aNext = document.createElement('a');
					aNext.className = 'gridControllerNext';
					aNext.innerHTML = settings.controls.next;
					
					var inputPage = document.createElement('input');
					inputPage.name = 'gridControllerInput';
					inputPage.className = 'gridControllerInput';
					inputPage.value = '1';
					inputPage.type = 'text';
					inputPage.size = 3;
					
					var divTotal = document.createElement('div');
					divTotal.className = 'gridControllerTotal';
					if (typeof(settings.rcdpp)=='number'){
						divTotal.innerHTML = settings.controls.of+Math.ceil(settings.data.length/settings.rcdpp);
					} else if (typeof(settings.rcdpp)=='string'){
						if (settings.rcdpp.toUpperCase()=='ALL'){
							divTotal.innerHTML = settings.controls.of+settings.controls.all;
						} else {
							alert('Error con el Número de registros por páginas');
						}
					}
					
					$('#'+settings.idGController).append(divControllerInfo);
					$('#'+settings.idGController).append(divWrapController);
					
					$('#'+divWrapController.id).append(aFirst);
					$('#'+divWrapController.id).append(aPrev);
					$('#'+divWrapController.id).append(inputPage);
					$('#'+divWrapController.id).append(divTotal);
					$('#'+divWrapController.id).append(aNext);
					$('#'+divWrapController.id).append(aLast);
				},

				gridMenu: function(){
					if (settings.menu==null) return false;
					var gridC = document.getElementById(settings.idGController);
					var divSideBar = document.createElement('div');
					divSideBar.id = 'gridMenu';
					divSideBar.className = 'gridMenu';
					divSideBar.style.position = 'absolute';
					divSideBar.style.zIndex = 0;
					divSideBar.style.top = 0;
					divSideBar.style.left = 0;
					divSideBar.style.cssFloat = 'left';
					divSideBar.style.width = 'auto';
					divSideBar.style.cursor = 'pointer';
					divSideBar.style.fontSize = '11px';
					var imgIco = document.createElement('img');
					imgIco.className = 'gridMenuIco';
					imgIco.style.marginRight = '5px';
					imgIco.style.cssFloat = 'left';
					imgIco.style.width = '16px';
					imgIco.style.height = '16px';
					imgIco.style.background = '#eee';
					imgIco.src = 'templates/plantafisica/images/024.png';
					divSideBar.appendChild(imgIco);
					divSideBar.appendChild(document.createTextNode('Menú'));
					gridC.appendChild(divSideBar);

					var menuSB = document.createElement('div');
					menuSB.id = 'menuSB';
					menuSB.className = 'menuSB';
					menuSB.style.position = 'absolute';
					menuSB.style.zIndex = 0;
					menuSB.style.top = parseInt($('#'+divSideBar.id).outerHeight())+'px';
					menuSB.style.left = 0;
					menuSB.style.width = 'auto';
					menuSB.style.padding = '10px 5px';
					menuSB.style.color = '#fff';
					menuSB.style.background = '#333';
					menuSB.style.display = 'none';
					gridC.appendChild(menuSB);

					$.each(settings.menu,function(i,v){
						var divOpt = document.createElement('div');
						divOpt.className = 'gridMenuOpt';
						divOpt.style.cssFloat = 'left';
						divOpt.style.padding = '0 10px';

						var imgOptIco = document.createElement('img');
						imgOptIco.className = 'gridMenuOptIco';
						imgOptIco.style.marginRight = '5px';
						imgOptIco.style.cssFloat = 'left';
						imgOptIco.style.width = '32px';
						imgOptIco.style.height = '32px';
						imgOptIco.style.background = '#eee';
						imgOptIco.src = (v.icon!=''||v.icon==null)?v.icon:'';

						var aOpt = document.createElement('a');
						aOpt.id = 'id'+v.id;
						aOpt.className = 'gridMenuA';
						aOpt.style.margin = 0;
						aOpt.style.padding = '0 5px 0 0';
						aOpt.style.cssFloat = 'left';
						aOpt.style.color = '#fff';
						aOpt.style.maxWidth = '150px';
						aOpt.style.textDecoration = 'none';
						aOpt.style.fontSize = '11px';
						aOpt.href = 'javascript: '+v.href+'();';
						aOpt.rel = v.href;

						aOpt.onmouseover = function(){
							aOpt.style.background = '#555';
						};
						aOpt.onmouseout = function(){
							aOpt.style.background = '#333';
						};
						aOpt.onclick = function(){
							$.gridShowForm(settings);
							$('#divModal').fadeIn('slow');
							$('#'+settings.idGForm).slideDown('slow');
						};
						
						aOpt.appendChild(imgOptIco);
						aOpt.appendChild(document.createTextNode(v.label));
						divOpt.appendChild(aOpt);
						menuSB.appendChild(divOpt);

					});

					$('#'+divSideBar.id).bind('click',function(){
						if ($('#'+menuSB.id).css('display')=='block') 
							$('#'+menuSB.id).slideUp('normal');
						else
							$('#'+menuSB.id).slideDown('normal');
					});
					$('#'+menuSB.id).bind('mouseleave',function(){
						$(this).slideUp('fast');
					});
				},
				
				gridChangePage: function(type){
					switch(type){
						case 'first':
							settings.currentPage = 1;
						break;
						case 'prev':
							if (settings.currentPage>1) settings.currentPage = parseInt(settings.currentPage)-1;
						break;
						case 'last':
							settings.currentPage = Math.ceil(settings.data.length/settings.rcdpp);
						break;
						case 'next':
							if (settings.currentPage<Math.ceil(settings.data.length/settings.rcdpp)) settings.currentPage = parseInt(settings.currentPage)+1;
						break;
						case 'input':
							var pageCalled = $('.gridControllerInput').val();
							var totalPages = Math.ceil(settings.data.length/settings.rcdpp);
							if (pageCalled >= 1 && pageCalled <= totalPages) 
								settings.currentPage = pageCalled 
							else 
								alert ('Coloque un valor entre 1 y '+totalPages)
							break;
					}
					fnc.gridLoadContent();
					fnc.gridResize();
					fnc.gridHoverRcds();
					$('.gridControllerInput').attr('value',settings.currentPage);
				},
				
				gridLoadTitles: function(){
					if (settings.fields){
						$.each(settings.fields,function(index,field){
							var divTitle = document.createElement('div');
							divTitle.id = 'id'+field.name;
							divTitle.className = 'gridTitleField';
							if (field.width==0){
								divTitle.style.width = field.width;
								divTitle.style.margin = '0';
								divTitle.style.padding = '0';
							} else {
								divTitle.style.width = field.width;
							}

							divTitle.innerHTML = field.display;
							$('#'+settings.idGTitles).append(divTitle);
						});
					}
				},
				
				gridLoadContent: function(){
					if (typeof(settings.rcdpp)=='string'){
						if (settings.rcdpp.toUpperCase()=='ALL')
							settings.rcdpp = settings.data.length;
					}
					
					var totalRcd = settings.data.length;
					var inicio = (settings.currentPage-1)*settings.rcdpp;
					var fin = inicio + settings.rcdpp;
					
					if(fin > totalRcd) fin = totalRcd;
						
					data = settings.data.slice(inicio,fin);
					
					if (data){
						$('#'+settings.idGContent).html('');
						var bool=true;
						$.each(data,function(indexD,fieldD){
							var nRcd = indexD;
							var record = (document.getElementById('idrcd'+indexD)==null) ? document.createElement('div') : document.getElementById('idrcd'+indexD);
							record.id = 'idrcd'+nRcd;
							record.className = 'gridContRcd';
							record.style.width = settings.widthG;
							record.style.cursor = 'pointer';
							record.onselectstart = function(){
								return false;
							}
							if (bool){
								record.style.background = settings.rcdColor.firstC;
								bool = false;
							}else{
								record.style.background = settings.rcdColor.secondC;
								bool = true;
							}
							$('#'+settings.idGContent).append(record);
							
							$.each(settings.fields,function(indexT,fieldT){
								var fieldRcd = (document.getElementById('id'+fieldT.name+nRcd)==null) ? document.createElement('div') : document.getElementById('id'+fieldT.name+nRcd);
								fieldRcd.id = 'id'+fieldT.name+nRcd;
								fieldRcd.className = 'gridContRcdField '+fieldT.name;
								fieldRcd.style.whiteSpace = (typeof(fieldT.nowrap)=='undefined' || fieldT.nowrap==false)? 'normal': 'nowrap';
								if (fieldT.width==0){
									fieldRcd.style.width = fieldT.width;
									fieldRcd.style.margin = '0';
									fieldRcd.style.padding = '0';
								} else {
									fieldRcd.style.width = fieldT.width;
								}
								
								if (typeof(fieldT.type)=='undefined'){
									fieldRcd.innerHTML = fieldD[fieldT.name];
								} else {
									switch (fieldT.type){
										case 'img':
											imgw = (typeof(fieldT.imgw)!='undefined')? fieldT.imgw:'16px';
											imgh = (typeof(fieldT.imgh)!='undefined')? fieldT.imgh:'16px';
											src =  fieldT.src+"/"+fieldD[fieldT.name]+fieldT.ext;
											fieldRcd.innerHTML = "<img style=\"width:"+imgw+"; height:"+imgh+"\"; src='"+src+"' />";
											break;
										default:
											fieldRcd.innerHTML = fieldD[fieldT.name];
											break;
									}
								}
								$('#idrcd'+nRcd).append(fieldRcd);
							});
						});
					
						$("[id^='idrcd']").bind({
							click:function(){
								settings.onclickrcd(this);
							},
							dblclick:function(){
								settings.ondblclickrcd(this);
							},
							onmouseenter:function(){
								settings.onmouseenterrcd(this);
							},
							onmouseout:function(){
								settings.onmouseoutrcd(this);
							}
						});

					} else {
						alert("No hay Data para mostrar");
					}
				},
				
				gridOuterWidth: function(selector){
					$(selector).each(function(){
						$(this).css('width',$(this).width()-($(this).outerWidth(true)-$(this).width()));
					});
				},
				
				gridElementsForResize: function(){
					fnc.gridOuterWidth('#'+settings.idGrid);
					fnc.gridOuterWidth('#'+settings.idGController);
					fnc.gridOuterWidth('#'+settings.idGTitles);
					fnc.gridOuterWidth('.gridTitleField');

					var grid = document.getElementById(settings.idGrid);
					var pHeightGrid = grid.parentNode.style.height;
					var parent = grid.parentNode.id;
					var deathHeight = 0;
					var ignoredDiv = 0;
					$("#"+parent+" > div").each(function(){
						if ($(this).attr('id')!=settings.idGrid){
							if (settings.ignoreDivs){
								ignoredDiv = settings.ignoreDivs.indexOf($(this).attr('id'));
								if (ignoredDiv==(-1)){
									deathHeight += $(this).outerHeight(true);
								}
							} else {
								deathHeight += $(this).outerHeight(true);
							}
						}
					});

					heightGrid = pHeightGrid.substr(0,pHeightGrid.indexOf('px')) - deathHeight;

					var gHeightController = $('#'+settings.idGController).outerHeight();
					var gHeightTitles = $('#'+settings.idGTitles).outerHeight();
					var heightGContent = heightGrid - (gHeightController + gHeightTitles);

					$('#'+settings.idGrid).css({'height':heightGrid});
					$('#'+settings.idGContent).css({'height':heightGContent});

					fnc.gridOuterWidth('#'+settings.idGContent);
					fnc.gridOuterWidth('.gridContRcd');
					fnc.gridOuterWidth('.gridContRcdField');
				},
				
				gridResize: function(){
					$('#'+settings.idGrid).css({'width':settings.widthG});
					$('#'+settings.idGController).css('width','100%');
					if ($('#'+settings.idGContent).css('overflow-y')=='scroll'){
						$('#'+settings.idGTitles).css('padding-right','16px');
					}
					$('#'+settings.idGTitles).css('width','100%');
					$('#'+settings.idGContent).css('width','100%');
					$('.gridContRcd').css('width','100%');
					$.each(settings.fields,function(index,field){
						$("[id^='id"+field.name+"']").css('width',field.width);
					});
					fnc.gridElementsForResize();
				},

				gridHoverRcds: function(){
					$("[id^='idrcd']").hover(
						function(){
							lastC = $(this).css('background-color');
							$(this).css({'background-color':settings.rcdColor.overC});
						},
						function(){
							$(this).css({'background-color':lastC});
						}
					);
				},		
		};
		
		/* Desde aqui, el codigo prosigue llamando las funciones
		 * antes creadas
		 */ 
		
		if (settings.data!=null){
			$(document).ready(function(){

				var lastC = '';
				
				fnc.gridShowController();
				fnc.gridLoadTitles();
				fnc.gridLoadContent();
				fnc.gridResize();
				fnc.gridHoverRcds();

				$('.gridControllerFirst').click(function(){fnc.gridChangePage('first')});
				$('.gridControllerPrev').click(function(){fnc.gridChangePage('prev')});
				$('.gridControllerLast').click(function(){fnc.gridChangePage('last')});
				$('.gridControllerNext').click(function(){fnc.gridChangePage('next')});
				$('.gridControllerInput').keydown(function(k){if (k.keyCode==13) fnc.gridChangePage('input')});

				settings.onloadgrid();
			});
			
			$(window).resize(function(){
				fnc.gridResize();
			});
		} else {
			sendMessage('denied','No existen datos para mostrar!');
		}
	};

	/*	ARREGLO SETTINGS
	 *	Prepara las opciones predefinidas del plugin
	 */
	$.gridsettings = {
	 	fields: false, 
		data: false, 
		currentPage: 1, 
		rcdpp: 1, 
		idGrid: 'grid',
		idGForm: 'gridForm',
		idGController: 'gridController',
		idGTitles: 'gridTitles',
		idGContent: 'gridContent',
		widthG: '100%',
		heightG: '100%',
		showForm: false,
		ignoreDivs: false,
		rcdColor: {firstC:'#eff',secondC:'#fff',overC:'#fee'},
		menu: false,
		controls: {
					first:'<img src="media/icons/first16.png" alt=""/>',
					prev:'<img src="media/icons/previous16.png" alt=""/>',
					next:'<img src="media/icons/next16.png" alt=""/>',
					last:'<img src="media/icons/last16.png" alt=""/>',
					of: 'de ',
					all:'Todos',
					info:'Total de registros: ',
					},
		onloadgrid:function(){},
		onclickrcd: function(){},
		ondblclickrcd: function(){},
		onmouseenterrcd: function(){},
		onmouseoutrcd: function(){},
	};
	

	$.gridShowForm = function(settings){
		if (document.getElementById(settings.idGForm)!=null){
			document.getElementById(settings.idGrid).removeChild(document.getElementById(settings.idGForm));
		}
		if (document.getElementById('divModal')!=null){
			document.getElementById(settings.idGrid).removeChild(document.getElementById('divModal'));
		}
		var divModal = document.createElement('div');
		divModal.id = 'divModal';
		divModal.style.position = 'absolute';
		divModal.style.zIndex = 0;
		divModal.style.top = '0';
		divModal.style.left = '0';
		divModal.style.width = '100%';
		divModal.style.height = '100%';
		divModal.style.background = '#333';
		divModal.style.opacity = '0.7';
		divModal.style.display = 'none';

		var gridForm = document.createElement('div');
		gridForm.id = settings.idGForm;
		gridForm.style.position = 'absolute';
		gridForm.style.zIndex = 0;
		gridForm.style.top = '0';//$('#'+settings.idGController).outerHeight()+'px';
		gridForm.style.left = '2%';
		gridForm.style.padding = '0 2% 2% 2%';
		gridForm.style.width = '92%';
		heightGForm = parseInt($('#'+settings.idGrid).outerHeight())-parseInt($('#'+settings.idGController).outerHeight())-22;
		gridForm.style.height = heightGForm+'px';
		gridForm.style.background = '#fff';
		gridForm.style.borderLeft = '1px solid #ccc';
		gridForm.style.borderRight = '1px solid #ccc';
		gridForm.style.borderBottom = '1px solid #ccc';
		gridForm.style.display = 'none';

		var divClose = document.createElement('div');
		divClose.id = 'gridFormClose';
		divClose.style.margin = '5px 0 0 0';
		divClose.style.cssFloat = 'right';
		divClose.style.width = '100%';
		gridForm.appendChild(divClose);

		var aClose = document.createElement('a');
		aClose.id = 'aClose';
		aClose.style.margin = 0;
		aClose.style.padding = '5px';
		aClose.style.cssFloat = 'right';
		aClose.style.color = '#500';
		aClose.style.cursor = 'pointer';
		aClose.style.textDecoration = 'none';
		aClose.appendChild(document.createTextNode('CERRAR'));
		aClose.onclick = function(){
			$('#'+gridForm.id).slideUp('slow');
			$('#divModal').fadeOut('slow');
		};
		divClose.appendChild(aClose);

		var divContent = document.createElement('div');
		divContent.id = 'gridFormContent';
		divContent.style.cssFloat = 'left';
		divContent.style.width = '100%';
		divContent.style.height = heightGForm-26+'px';
		//divContent.style.overflowY = 'auto';
		//divContent.style.overflowX = 'hidden';
		gridForm.appendChild(divContent);

		document.getElementById(settings.idGrid).appendChild(divModal);
		document.getElementById(settings.idGrid).appendChild(gridForm);
	}

})(jQuery);
