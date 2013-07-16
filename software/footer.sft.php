<?php
	
	header('Content-Type: text/html; charset=UTF-8');
	
	unset ($footer);
	$footer = '<div  id="desarrollado"><p>'.$termfooter["desarrollado"].'</p></div>';
	$footer .= '<div  id="dgtit"><p>Direcci&oacute;n General de Tecnolog&iacute;a, Informaci&oacute;n y Telecomunicaciones</p></div>';
	$footer .= '<div  id="version"><p>'.$termfooter["version"].': '.$config["version"].'</p></div>';
	
?>
