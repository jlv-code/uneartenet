<?php
	
	if (isset($_SESSION['session']['permissions'])){
		for ($i=0; $i<count($_SESSION['session']['permissions']); $i++){
			if ($paramGet['p']==$_SESSION['session']['permissions'][$i]['nombre_plantilla']) {
				$appDescription = $_SESSION['session']['permissions'][$i]['descripcion_link'];
				$showSB = ($_SESSION['session']['permissions'][$i]['idmodulo']==0)? 0 : 1;
				if ($_SESSION['session']['permissions'][$i]['nombre_menu']=='Navegación'){
					$idLinkPadre = $_SESSION['session']['permissions'][$i]['idlink'];
					$appTitle = $_SESSION['session']['permissions'][$i]['nombre_link'];
					$appTdC = 'Inicio';
					$inicioURLTemplate = $_SESSION['session']['permissions'][$i]['nombre_plantilla'];
					$inicioDESTemplate = $_SESSION['session']['permissions'][$i]['descripcion_link'];
				} else {
					if ($_SESSION['session']['permissions'][$i]['nombre_menu']=='SoftwareBar'){
						$idLinkPadre = $_SESSION['session']['permissions'][$i]['padre'];
						for ($k=0; $k<count($_SESSION['session']['permissions']); $k++) {
							if ($idLinkPadre==$_SESSION['session']['permissions'][$k]['idlink']){
								$appTitle = $_SESSION['session']['permissions'][$k]['nombre_link'];
								$appTdC = $_SESSION['session']['permissions'][$i]['nombre_link'];
								$inicioURLTemplate = $_SESSION['session']['permissions'][$k]['nombre_plantilla'];
								$inicioDESTemplate = $_SESSION['session']['permissions'][$k]['descripcion_link'];
							}
						}
					}
				}
				$tdcMenu = '<ul class="mmul">';
				$tdcMenu.= '<li class="mmli">';
				$tdcMenu.= '<a class="mma" href="index.php?p='.$inicioURLTemplate.'">';
				$tdcMenu.= '<span class="mmaTitle">'.$appTitle.'</span>';
				$tdcMenu.= '<span class="mmaDescr">'.$inicioDESTemplate.'</span>';
				$tdcMenu.= '</a>';
				$tdcMenu.= '</li>';
				
				for ($j=0; $j<count($_SESSION['session']['permissions']); $j++){
					if ($idLinkPadre==$_SESSION['session']['permissions'][$j]['padre'] && $_SESSION['session']['permissions'][$j]['nombre_menu']!='Navegación') {
						$showSB = ($_SESSION['session']['permissions'][$j]['idmodulo']==0 && $showSB==1)? 0 : 1;
						$tdcMenu.= '<li class="mmli">';
						$tdcMenu.= '<a class="mma" href="index.php?p='.$_SESSION['session']['permissions'][$j]['nombre_plantilla'].'">';
						$tdcMenu.= '<span class="mmaTitle">'.$_SESSION['session']['permissions'][$j]['nombre_link'].'</span>';
						$tdcMenu.= '<span class="mmaDescr">'.$_SESSION['session']['permissions'][$j]['descripcion_link'].'</span>';
						$tdcMenu.= '</a>';
						$tdcMenu.= '</li>';
					}
				}
				$tdcMenu.= '</ul>';
			}
		}
		
		if ($showSB == 1){
			$softwareBar = '<div id="softwareBar">'; 
			
			$softwareBar.= '<div id="wrapSoftwareBarRight">';
			$softwareBar.= '<div id="titleSoftwareBarRight">'.$appDescription.'</div>';
			$softwareBar.= '<div id="ctrlSoftwareBarRight">';
			$softwareBar.= '<div id="actionsSoftwareBarRight">';
			$softwareBar.= '</div>'; //FIN DE ACTIONS SOFTWARE BAR
			$softwareBar.= '</div>'; //FIN DE CTRL SOFTWARE BAR RIGHT
			$softwareBar.= '</div>'; //FIN WRAP SOFTWARE BAR RIGHT
			
			$softwareBar.= '<div id="wrapSoftwareBarLeft">';
			$softwareBar.= '<a id="aWrapSoftwareBarLeft" href="#" onClick="javascript:toogleLayers('."'aWrapSoftwareBarLeft'".');">';
			$softwareBar.= '<div id="softwareBarLogo"></div>';
			$softwareBar.= '<div id="titleSoftwareBarLeft">'.$appTitle.'</div>';
			$softwareBar.= '<div id="separadorSoftwareBarLeft"></div>';
			$softwareBar.= '<div id="moduloSoftwareBarLeft">'.$appTdC.'</div>';
			$softwareBar.= '<div id="subSoftwareBarLeft"></div>';
			$softwareBar.= '</a>'; //FIN ANCHOR WRAP SOFTWARE BAR LEFT
			$softwareBar.= '</div>'; //FIN WRAP SOFTWARE BAR LEFT
			
			$softwareBar.= '<div id="layeraWrapSoftwareBarLeft">';
			$softwareBar.= $tdcMenu;
			$softwareBar.= '</div>'; //FIN ANCHOR WRAP SOFTWARE BAR LEFT LAYER
			
			$softwareBar.= '</div>'; //FIN DE SOFTWARE BAR
		} else {
			$softwareBar = '';
		}

	} else {
		$softwareBar = '';
	}

	
?>
