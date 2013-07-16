<?php

	require 'config/db.config.php';
	require 'class/db.class.php';
	require 'library/queries.lib.php';
	require 'library/functions.lib.php';	

	$bd = new database();
	$bd->dbCloseConection();
	$bd->arrCnx["db_nombre"]		= $dbintranet['db_nombre'];
	$bd->arrCnx["db_usuario"]		= $dbintranet['db_usuario'];
	$bd->arrCnx["db_contrasena"]	= $dbintranet['db_contrasena'];
	$bd->arrCnx["db_servidor"]		= $dbintranet['db_servidor'];

	$bdSice = new database();
	$bdSice->dbCloseConection();
	$bdSice->arrCnx["db_nombre"]		= $dbsice['db_nombre'];
	$bdSice->arrCnx["db_usuario"]		= $dbsice['db_usuario'];
	$bdSice->arrCnx["db_contrasena"]    = $dbsice['db_contrasena'];
	$bdSice->arrCnx["db_servidor"]		= $dbsice['db_servidor'];

	$queries = new queries();
	$functions = new functions();

	if ($_GET) $xget = $_GET;
	if ($_POST) $xpost = $_POST;
	if ($_FILES) $xfiles = $_FILES;

	if ($xget['mod']) require $xget['mod'];

?>
