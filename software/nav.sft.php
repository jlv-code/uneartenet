<?php
	
	if (isset($_SESSION['session']['permissions'])) {
		for ($i=0;$i<count($_SESSION['session']['permissions']);$i++){
			
			if ($_SESSION['session']['permissions'][$i]['nombre_menu']=='Navegación' && $_SESSION['session']['permissions'][$i]['padre']==0) {
				$withoutSubClass = (strtolower($_SESSION['session']['permissions'][$i]['nombre_link'])=='inicio')? ' a-without-sub' : '';
				$nav.= '<div class="nav-link">';
				if ($_SESSION['session']['permissions'][$i]['url']==''){
					$url = 'index.php?p='.$_SESSION['session']['permissions'][$i]['nombre_plantilla'];
				} else {
					$url = $_SESSION['session']['permissions'][$i]['url'];
				}
				$nav.= '<a class="nav-link-a'.$withoutSubClass.'" href="'.$url.'">'.$_SESSION['session']['permissions'][$i]['nombre_link'].'</a>';
				
				if ($withoutSubClass==''){
					$id = 'id'.$i;
					$nav.= '<div class="nav-link-sub">';
					$nav.= '<a id="'.$id.'" class="nav-link-sub-a" onclick="javascript: toogleLayers('."'".$id."'".');"><img src="'.urlIcons.'sub-blanco.png" /></a>';
					$nav.= '<div id="layer'.$id.'" class="subnav-link">';
					$nav.= '<div class="wrap-subnav-link">';
					for ($j=0;$j<count($_SESSION['session']['permissions']);$j++){
						if ($_SESSION['session']['permissions'][$i]['idlink']==$_SESSION['session']['permissions'][$j]['padre']){
							if ($_SESSION['session']['permissions'][$j]['url']==''){
								$url = 'index.php?p='.$_SESSION['session']['permissions'][$j]['nombre_plantilla'];
								$target = '_self';
							} else {
								$url = $_SESSION['session']['permissions'][$j]['url'];
								$target = '_blank';
							}
							$nav.= '<a class="subnav-link-a" href="'.$url.'" target="'.$target.'">';
							$nav.= '<span class="subnav-link-title">'.$_SESSION['session']['permissions'][$j]['nombre_link'].'</span><br />';
							$nav.= '<span class="subnav-link-descr">'.$_SESSION['session']['permissions'][$j]['descripcion_plantilla'].'</span>';
							$nav.= '</a>';
						}
					}
					$nav.= '</div>';
					$nav.= '</div>';
					$nav.= '</div>';
				}
				
				$nav.= '</div>';
			}
		}
	}
	
?>
