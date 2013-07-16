<?php
	
	header('Content-Type: text/html; charset=UTF-8');
	
	DEFINE ('urlSoftware'	,'software/');
	DEFINE ('urlModules'	,'modules/');
	DEFINE ('urlTemplates'	,'templates/');
	DEFINE ('urlEstilos'	,'css/');
	DEFINE ('urlScripts'	,'js/');
	DEFINE ('urlLibrary'	,'library/');
	DEFINE ('urlClass'		,'class/');
	DEFINE ('urlMedia'		,'media/');
	DEFINE ('urlImages'		,'media/images/');
	DEFINE ('urlIcons'		,'media/icons/');
	DEFINE ('urlVideo'		,'media/video/');
	DEFINE ('urlAudio'		,'media/audio/');
	DEFINE ('urlFotos'		,'media/fotos/');
	DEFINE ('urlAjaxM'      ,'_ajax.php');
	DEFINE ('FPDF_FONTPATH'	,'../media/fonts/');
	
	
	DEFINE ('urlInfoBiblioteca'		,'software/biblioteca/info/');
	
	$config["version"] = '2.0-beta';
	$config["timesession"] = 60; //Expresado en minutos
	$config["logo"] = 'logo-intranet.png';
	$config["clavegeneral"] = 'unearte'; //Clave para registrar usuarios en intranet
	$config["registroActivo"] = 1;
	$config["numitemsxpantalla"] = 10;
	$config["db_servidorPublico"] = 'xxx.xxx.xxx.xxx';
	
?>
