$(document).ready (function(){
	adaptWindowHeight();
});

$(window).resize(function(){
	adaptWindowHeight();
});

function adaptWindowHeight(){
	$(document).ready (function(){
		var heightWindow = $(window).height();
		var heightHeader = $('header').height();
		var heightFooter = $('footer').height();
		var heightContent = heightWindow - (heightHeader + heightFooter);
		$('#container').css({'height':heightContent});
		$('#panelLeft').css({'height':parseInt(heightContent)-57});
		$('#panelRight').css({'height':parseInt(heightContent)-57});
	});
}

function toogleLayers(id) {
	$(document).ready (function(){
		$("[id^=layer]").each(function(){
			if ($(this).attr('id') != "layer"+id) {
				$("#"+$(this).attr('id')).slideUp("fast");
			}
		});
		idClicked = $(".clicked").attr("id");
		$(".clicked").animate({opacity:1},"fast").removeClass("clicked");
		if (idClicked != id){
			$("#"+id).addClass("clicked");
		}
		$(".clicked").animate({opacity:.65},"fast");
		$("#layer"+id).slideToggle("fast");
	});
}

/*	FUNCTION SENDMESSAGE
 * 	Permite enviar mensaje al DOM usando Jquery
 */ 
function sendMessage(tipo_mensaje,texto_mensaje) {
	$(document).ready (function(){
		var mensaje = $("#system-message");
		
		switch(tipo_mensaje){
			case 'granted' : 
				mensaje.css({
					"color":"#040",
					"background":"#afa",
					"border-left":"1px solid #8d8",
					"border-right":"1px solid #8d8",
					"border-bottom":"1px solid #8d8"
					});
				break;
			case 'denied' : 
				mensaje.css({
					"color":"#a00",
					"background":"#eaa",
					"border-left":"1px solid #e55",
					"border-right":"1px solid #e55",
					"border-bottom":"1px solid #e55"
					}); 
				break;
		}
		mensaje.css({
			"-webkit-border-bottom-right-radius": "5px",
			"-webkit-border-bottom-left-radius": "5px",
			"-moz-border-radius-bottomright": "5px",
			"-moz-border-radius-bottomleft": "5px",
			"border-bottom-right-radius": "5px",
			"border-bottom-left-radius": "5px",
			"z-index":"1000"
			});
		mensaje.html(texto_mensaje);
		mensaje.slideDown("slow").delay(5000).slideUp("slow");
	});
}

/*	CLASE BROWSER
 * 	Te permite detectar las propiedades de los
 *	navegadores.
 */
function Browser() {   
    // ---- public properties -----
    this.fullName = 'unknow'; // getName(false);
    this.name = 'unknow'; // getName(true);
    this.code = 'unknow'; // getCodeName(this.name);
    this.fullVersion = 'unknow'; // getVersion(this.name);
    this.version = 'unknow'; // getBasicVersion(this.fullVersion);
    this.mobile = false; // isMobile(navigator.userAgent);
    this.width = screen.width;
    this.height = screen.height;
    this.platform =  'unknow'; //getPlatform(navigator.userAgent);
    
    // ------- init -------    
    this.init = function() { //operative system, is an auxiliary var, for special-cases
        //the first var is the string that will be found in userAgent. the Second var is the common name
        // IMPORTANT NOTE: define new navigators BEFORE firefox, chrome and safari
        var navs = [
            { name:'Opera Mobi', fullName:'Opera Mobile', pre:'Version/' },
            { name:'Opera Mini', fullName:'Opera Mini', pre:'Version/' },
            { name:'Opera', fullName:'Opera', pre:'Version/' },
            { name:'MSIE', fullName:'Microsoft Internet Explorer', pre:'MSIE ' },  
            { name:'BlackBerry', fullName:'BlackBerry Navigator', pre:'/' }, 
            { name:'BrowserNG', fullName:'Nokia Navigator', pre:'BrowserNG/' }, 
            { name:'Midori', fullName:'Midori', pre:'Midori/' }, 
            { name:'Kazehakase', fullName:'Kazehakase', pre:'Kazehakase/' }, 
            { name:'Chromium', fullName:'Chromium', pre:'Chromium/' }, 
            { name:'Flock', fullName:'Flock', pre:'Flock/' }, 
            { name:'Galeon', fullName:'Galeon', pre:'Galeon/' }, 
            { name:'RockMelt', fullName:'RockMelt', pre:'RockMelt/' }, 
            { name:'Fennec', fullName:'Fennec', pre:'Fennec/' }, 
            { name:'Konqueror', fullName:'Konqueror', pre:'Konqueror/' }, 
            { name:'Arora', fullName:'Arora', pre:'Arora/' }, 
            { name:'Swiftfox', fullName:'Swiftfox', pre:'Firefox/' }, 
            { name:'Maxthon', fullName:'Maxthon', pre:'Maxthon/' },
            // { name:'', fullName:'', pre:'' } //add new broswers
            // { name:'', fullName:'', pre:'' }
            { name:'Firefox',fullName:'Mozilla Firefox', pre:'Firefox/' },
            { name:'Chrome', fullName:'Google Chrome', pre:'Chrome/' },
            { name:'Safari', fullName:'Apple Safari', pre:'Version/' }
        ];
    
        var agent = navigator.userAgent, pre;
        //set names
        for (i in navs) {
           if (agent.indexOf(navs[i].name)>-1) {
               pre = navs[i].pre;
               this.name = navs[i].name.toLowerCase(); //the code name is always lowercase
               this.fullName = navs[i].fullName; 
                if (this.name=='msie') this.name = 'iexplorer';
                if (this.name=='opera mobi') this.name = 'opera';
                if (this.name=='opera mini') this.name = 'opera';
                break; //when found it, stops reading
            }
        }//for
        
      //set version
        if ((idx=agent.indexOf(pre))>-1) {
            this.fullVersion = '';
            this.version = '';
            var nDots = 0;
            var len = agent.length;
            var indexVersion = idx + pre.length;
            for (j=indexVersion; j<len; j++) {
                var n = agent.charCodeAt(j); 
                if ((n>=48 && n<=57) || n==46) { //looking for numbers and dots
                    if (n==46) nDots++;
                    if (nDots<2) this.version += agent.charAt(j);
                    this.fullVersion += agent.charAt(j);
                }else j=len; //finish sub-cycle
            }//for
            this.version = parseInt(this.version);
        }
        
        // set Mobile
        var mobiles = ['mobi', 'mobile', 'mini', 'iphone', 'ipod', 'ipad', 'android', 'blackberry'];
        for (var i in mobiles) {
            if (agent.indexOf(mobiles[i])>-1) this.mobile = true;
        }
        if (this.width<700 || this.height<600) this.mobile = true;
        
        // set Platform        
        var plat = navigator.platform;
        if (plat=='Win32' || plat=='Win64') this.platform = 'Windows';
        if (agent.indexOf('NT 5.1') !=-1) this.platform = 'Windows XP';        
        if (agent.indexOf('NT 6') !=-1)  this.platform = 'Windows Vista';
        if (agent.indexOf('NT 6.1') !=-1) this.platform = 'Windows 7';
        if (agent.indexOf('Mac') !=-1) this.platform = 'Macintosh';
        if (agent.indexOf('Linux') !=-1) this.platform = 'Linux';
        if (agent.indexOf('iPhone') !=-1) this.platform = 'iOS iPhone';
        if (agent.indexOf('iPod') !=-1) this.platform = 'iOS iPod';
        if (agent.indexOf('iPad') !=-1) this.platform = 'iOS iPad';
        if (agent.indexOf('Android') !=-1) this.platform = 'Android';
        
        if (this.name!='unknow') {
            this.code = this.name+'';
            if (this.name=='opera') this.code = 'op';
            if (this.name=='firefox') this.code = 'ff';
            if (this.name=='chrome') this.code = 'ch';
            if (this.name=='safari') this.code = 'sf';
            if (this.name=='iexplorer') this.code = 'ie';
            if (this.name=='maxthon') this.code = 'mx';
        }
        
        //manual filter, when is so hard to define the navigator type
        if (this.name=='safari' && this.platform=='Linux') {
            this.name = 'unknow';
            this.fullName = 'unknow';
            this.code = 'unknow';
        }
        
    };//function
    
    this.init();

}//Browser class

/*  CLASE TYPEFORFIELDS
 *  Permite crear un objeto que segun el metodo llamado
 *  devuelve el tipo de campo que debe mostrar una vista
 *  de detalles
 */

 function typeForFields(){
    this.embed = function(fileEmbed,srcEmbed,typeEmbed,width,height){
        var file = document.createElement('embed');
        file.src = srcEmbed+fileEmbed;
        file.type = typeEmbed;
        file.width = width;
        file.height = height;
        return file;
    };

    this.image = function(images,src,ext){
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
    };

    this.nl2br = function(str,is_xhtml) {
        var breakTag = (is_xhtml || typeof is_xhtml === 'undefined') ? '' : '<br>';
        return (str + '').replace(/([^>\r\n]?)(\r\n|\n\r|\r|\n)/g, '$1' + breakTag + '$2');
    };
 }