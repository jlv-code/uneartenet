<?php
    
    header('Content-Type: text/html; charset=iso-8859-1');
    
    unset($styles);
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'style.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'jquery.newform.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'ui-lightness/jquery-ui.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'informacion.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'biblioteca.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'chosen.css" />';
    $styles.= '<link rel="stylesheet" type="text/css" href="'.urlEstilos.'uniform.aristo.css" />';
    $styles.= '<style type="text/css">
				/*demo styles*/
				
				/*fieldset { border:0;  margin-bottom: 40px;}*/
				/*label,select,.ui-select-menu { float: left; margin-right: 10px; }*/
				/*select { width: 200px; }*/
				
				/*select with custom icons*/
				body a.customicons { height: 2.8em;}
				body .customicons li a, body a.customicons span.ui-selectmenu-status { line-height: 2em; padding-left: 30px !important; }
				body .video .ui-selectmenu-item-icon, body .podcast .ui-selectmenu-item-icon, body .rss .ui-selectmenu-item-icon { height: 24px; width: 24px; }
				body .video .ui-selectmenu-item-icon { background: url(sample_icons/24-video-square.png) 0 0 no-repeat; }
				body .podcast .ui-selectmenu-item-icon { background: url(sample_icons/24-podcast-square.png) 0 0 no-repeat; }
				body .rss .ui-selectmenu-item-icon { background: url(sample_icons/24-rss-square.png) 0 0 no-repeat; }
				</style>';
    
?>
