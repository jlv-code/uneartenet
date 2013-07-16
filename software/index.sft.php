<?php

	header('Content-Type: text/html; charset=UTF-8');

	require urlModules.'login.mod.php';
	require urlClass.'users.class.php';
	require urlClass.'db.class.php';
	require urlLibrary.'queries.lib.php';
	require urlLibrary.'functions.lib.php';
	

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

	$users = new users();
	$login = new login();
	$queries = new queries();
	$functions = new functions();
	

	session_set_cookie_params(82400);
	session_name('uneartenet');
	session_start();
	
	$paramGet = @$_GET;
	$paramPost = @$_POST;
	
	if (isset($_SESSION['closesession'])){
		$message = $functions->sendMessage($_SESSION['closesession']);
		session_destroy();
		session_set_cookie_params(82400);
		session_name('uneartenet');
		session_start();
	}
	
	if ($paramGet['v']!=''){
	}
	if ($paramGet['p']!=''){
		if ($paramGet['p']=='cerrar'){
			session_destroy();
			session_set_cookie_params(82400);
			session_name('uneartenet');
			session_start();
			$_SESSION['closesession'] = array(	'tipo'		=>	'granted',
												'mensaje'	=>	$term["login"]["cerrarsesionexitosa"]
											);
			header('location:index.php'); exit;
		}
		if ($paramGet['p']=='login'){
			if($paramPost['id']=='' || $paramPost['password']==''){
				$array = array(	'tipo'		=>	'denied',
								'mensaje'	=>	$term["login"]["errorusuariocontrasena"]
								);
				$message = $functions->sendMessage($array);
			} else {
				$bd->dbConection();
				$bdSice->dbConection();
				$user = $login->validarUsuario($paramPost);
				$bd->dbCloseConection();
				$bdSice->dbCloseConection();
				if ($user==0){
					$array = array(	'tipo'		=>	'denied',
									'mensaje'	=>	$term["login"]["errorusuariocontrasena"]
								);
					$message = $functions->sendMessage($array);
				} else {
					$logintype = array_pop($user);
					switch($logintype){
						case 'registro':
							$_SESSION['session']['register'] = md5($user['idusuario'].time());
							$_SESSION['session']['timesession'] = time();
							$fileNameModule = -1;
							$fileNameTemplate = urlTemplates.'register.tpl.php';
							break;
						case 'intranet':
							$bd->dbConection();
							$_SESSION['session'] = array (	'idpersona'		=>	$user['idpersona'],
															'idusuario'		=>	$user['idusuario'],
															'identificacion'=>	$user['identificacion'],
															'nombres'		=>	$user['nombres'],
															'apellidos'		=>	$user['apellidos'],
															'idcentro'		=>	$user['idcentro'],
															'nombrecentro'	=>	$user['nombre'],
															'idperfil'		=>	$login->extraerPerfiles($user),
															'timesession'	=>	time()
														);
							$_SESSION['session']['permissions'] = $login->generarPermisologia();
							$bd->dbCloseConection();
							header('location: index.php?p=inicio');
							exit;
							break;
					}
				}
			}
		}
	}
	
	if (!isset($_SESSION['session']) || !isset($paramGet['p'])){
		if (!isset($_SESSION['session'])) {
			session_destroy();
			session_set_cookie_params(82400);
			session_name('uneartenet');
			$fileNameModule = -1;
			$fileNameTemplate = urlTemplates.'login.tpl.php';
		} else {
			$fileNameModule = -1;
			$fileNameTemplate = urlTemplates.'inicio.tpl.php';
		}
	} else {
		if (time()-$_SESSION['session']['timesession']>=$config["timesession"]*60) {
			session_destroy();
			session_set_cookie_params(82400);
			session_name('uneartenet');
			session_start();
			$_SESSION['closesession'] = array(	'tipo'		=>	'denied',
												'mensaje'	=>	$term["login"]["sessionclosed"]
											);
			header('location:index.php'); exit;
		}
		
		$_SESSION['session']['timesession'] = time();

		//print_r($_SESSION['session']);
		for($i=0;$i<count($_SESSION['session']['permissions']);$i++){
			if ($_SESSION['session']['permissions'][$i]['nombre_plantilla']==$paramGet['p']){
				if ($_SESSION['session']['permissions'][$i]['idmodulo']!=0){
					$module = $_SESSION['session']['permissions'][$i]['nombre_modulo']; 
				} else {
					$module = -1;
				}
				$template = $_SESSION['session']['permissions'][$i]['nombre_plantilla'];
				$access = 1;
				break;
			} else {
				$access = 0;
			}
		}
		
		if ($access==0){
			$array = array(	'tipo'		=>	'denied',
							'mensaje'	=>	$term["files"]["accessdenied"]
							);
			$message = $functions->sendMessage($array);
			$fileNameModule = urlModules.$_SESSION['session']['permissions'][0]['nombre_modulo'].'.mod.php';
			$fileNameTemplate = urlTemplates.$_SESSION['session']['permissions'][0]['nombre_plantilla'].'.tpl.php';
		} else {
			if ($module=='' || $template==''){
				$array = array(	'tipo'		=>	'denied',
								'mensaje'	=>	$term["files"]["noexistemodulo"]
								);
				$message = $functions->sendMessage($array);
			} else {
				$fileNameModule = ($modulo != -1)? urlModules.$module.'.mod.php' : '';
				$fileNameTemplate = urlTemplates.$template.'.tpl.php';
			}
		}
		
		if (!file_exists($fileNameModule) && $module!=-1){
			$array = array(	'tipo'		=>	'denied',
							'mensaje'	=>	$term["files"]["noexistemodulo"]
							);
			$message = $functions->sendMessage($array);
		} else {
			if (!file_exists($fileNameTemplate)){
				$array = array(	'tipo'		=>	'denied',
								'mensaje'	=>	$term["files"]["noexisteplantilla"]
								);
				$message = $functions->sendMessage($array);
			}
		}
	}
	
?>
