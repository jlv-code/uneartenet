<?php
	
	header('Content-Type: text/html; charset=utf-8');
	$profileSoft = '';
	if (isset($_SESSION['session'])){
		$bd->dbConection();
		$arrContenido = $bd->dbQuery($queries->qUsuarioDetalle($_SESSION['session']['idusuario']));
		
		$profileSoft = '<div id="profileSoft">';
		$profileSoft.= '<a id="aprofilesoft" href="#" onClick="javascript: toogleLayers('."'aprofilesoft'".');">';
		$profileSoft.= '<div id="profilesub"></div>';
		$profileSoft.= '<div id="username">'.$arrContenido[0][3].', '.substr($arrContenido[0][4],0,1).'.</div>';
		$profileSoft.= '<div id="sedeuser">'.$termprofile["sede"].': '.$arrContenido[0][8].'</div>';
		$profileSoft.= '<div id="imgprofilemini">';
		$profileSoft.= (file_exists(urlFotos.$arrContenido[0][1].'.png'))?'<img class="userphoto" src="'.urlFotos.$_SESSION['session']['identificacion'].'.png">':'';
		$profileSoft.= '</div>';
		$profileSoft.= '</a>';
		$profileSoft.= '</div>';
		
		$profileSoft.= '<div id="layeraprofilesoft">';
		$profileSoft.= '<div id="profile-photo">';
		$profileSoft.= (file_exists(urlFotos.$arrContenido[0][1].'.png')) ? '<img class="userphoto" src="'.urlFotos.$arrContenido[0][1].'.png" />':'';
		$profileSoft.= '</div>'; //FIN DIV PROFILE-PHOTO
		$profileSoft.= '<div id="profile-data">';
		$profileSoft.= '<div class="profile-data-name" >'.$arrContenido[0][3].', '.substr($arrContenido[0][4],0,1).'.</div>';
		$profileSoft.= '<div class="profile-data-field" >'.$termprofile["sede"].': '.$arrContenido[0][8].'</div>';
		$profileSoft.= '<div class="profile-data-field" >'.$termprofile["cargo"].': '.$arrContenido[0][2].'</div>';
		$profileSoft.= '</div>'; //FIN DIV PROFILE-DATA
		$profileSoft.= '<div id="profile-buttons">';
		$profileSoft.= '<a class="lnkText" href="index.php?p=cerrar">'.$termprofile["cerrarsesion"].'</a>';
		$profileSoft.= '<a class="btnText" href="index.php?p=userprofile">'.$termprofile["configuracion"].'</a>';
		$profileSoft.= '</div>'; //FIN DIV PROFILE-BUTTONS
		$profileSoft.= '</div>'; //FIN DIV PROFILE-LAYER
		$bd->dbCloseConection();
	}
	
?>
