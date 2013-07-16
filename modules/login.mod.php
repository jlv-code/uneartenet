<?php
	
	class login {
		
		private $idPerfiles;
		
		public function validarUsuario($paramPost){
			global $config, $bd, $bdSice, $users, $functions, $queries;
			
			$users->setConexion($bd->getConexion());
			$user = $users->validarUsuario($queries->qValidarUsuario($paramPost));
			if ($user==0){
				$user = $users->validarUsuario($queries->qValidarUsuarioTrabajador($paramPost));
				if ($user==0){
					$users->setConexion($bdSice->getConexion());
					$user = $users->validarUsuario($queries->qValidarUsuarioEstudiante($paramPost));
					if ($user==0){
						$user = $users->validarUsuario($queries->qValidarUsuarioDocente($paramPost));
						if ($user==0) {
							return $user;
						} else {
							if ($paramPost['password']==$config["clavegeneral"]):
								$logintype = array('logintype' => 'registro');
								$user = array_merge($user,$logintype);
								return $user;
							else:
								return 0;
							endif;
						}
					} else {
						if ($paramPost['password']==$config["clavegeneral"]):
							$logintype = array('logintype' => 'registro');
							$user = array_merge($user,$logintype);
							return $user;
						else:
							return 0;
						endif;
					}
				} else {
					if ($paramPost['password']==$config["clavegeneral"]):
						$logintype = array('logintype' => 'registro');
						$user = array_merge($user,$logintype);
						return $user;
					else:
						return 0;
					endif;
				}
			} else {
				$logintype = array('logintype' => 'intranet');
				$user = array_merge($user,$logintype);
				return $user;
			}
		}
		
		public function extraerPerfiles($user){
			global $bd, $users, $queries;
			$users->setConexion($bd->getConexion());
			return $this->idPerfiles = $users->perfilesEnCadena($queries->qPerfilesUsuario($user['idusuario']));
		}
		
		public function generarPermisologia(){
			global $bd, $queries;
			return $bd->getContentASSOC($queries->qPermisologia($this->idPerfiles));
		}
		
	}
	
?>
