<?php

	header('Content-Type: text/html; charset=UTF-8');
	if (isset($_SESSION['session'])):
		$header = '<div id="logo"><a href="index.php?p=inicio" style="text-decoration:none;"><img class="logo" src="'.urlImages.$config["logo"].'" alt="" /></a></div>';
	else:
		$header = '<div id="logo"><a href="index.php" style="text-decoration:none;"><img class="logo" src="'.urlImages.$config["logo"].'" alt="" /></a></div>';
	endif;
?>
