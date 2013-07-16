<?php
	
	header('Content-Type: text/html; charset=UTF-8');
	DEFINE ('urlConfig','config/');
	
	require urlConfig.'config.php';
	require urlConfig.'db.config.php';
	require urlConfig.'term.php';
	require urlSoftware.'index.sft.php';
	require urlSoftware.'header.sft.php';
	require urlSoftware.'nav.sft.php';
	require urlSoftware.'softwarebar.sft.php';
	require urlSoftware.'profile.sft.php';
	require urlSoftware.'footer.sft.php';
	
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="UTF-8" />
<?php require urlLibrary.'styles.lib.php'; print $styles; //Enlaza todas la Hojas de Estilo ?>
<?php require urlLibrary.'scripts.lib.php'; print $scripts; //Enlaza todos los Scripts con extension javascript ?>
<?php require urlSoftware.'titlepage.sft.php'; print $app_title; //Crea el Titulo de la Pagina ?>
</head>
<body>
	<!-- Inicio del WRAP -->
	<div id="wrap">
	<header>
	<?php print $header; ?>
	<nav>
	<?php print $nav; ?>
	</nav>
	<?php print $profileSoft; ?>
	</header>
	<!-- Inicio del CONTAINER -->
	<div id="container">
	<?php 
		if ($message!=''): print $message; endif;
	?>
	<div id="system-message"></div>
	<?php 
		print $softwareBar;
		include $fileNameModule;
		include $fileNameTemplate;
	?>
	</div>
	<!-- Fin del CONTAINER -->
	<footer>
	<?php print $footer; ?>
	</footer>
	</div>
	<!-- Fin del WRAP -->
</body>
</html>
