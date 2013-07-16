<?php

	/*	USUARIOS
 	 *	Todos los queries y métodos relacionados con la
 	 *	aplicación de Usuarios
 	 * 	@autor: José V.
 	 * 	@date: 2012-10-30 : 1230
 	 */ 
	
	class usuarios {

		private function qListaUsuarios(){
			$sql = "select
					ti.idtipoidentificacion,
					ti.nombre as tipoidentificacion,
					pe.idpersona,
					pe.identificacion,
					pe.apellidos,
					pe.nombres,
					pe.direccionhabitacion,
					pe.fechanacimiento,
					ge.idgenero,
					ge.nombre as genero,
					us.idusuario,
					us.fecharegistro,
					su.idstatususuario,
					su.nombre as statususuario,
					ca.idcargo,
					ca.nombre as cargo,
					ce.idcentro,
					ce.nombre as centro,
					ce.nom as nomenclatura,
					array_to_string(array(
					select
					'{key:' || te.idtelefono || ',value:\"' || te.nombre || '\"}'
					from telefono as te
					where te.idpersona = pe.idpersona),',') as telefonos,
					array_to_string(array(
					select
					'{key:' || co.idcorreo || ',value:\"' || co.nombre || '\"}'
					from correo as co
					where co.idpersona = pe.idpersona),',') as correos,
					array_to_string(array(
					select
					pu.idperfil
					from perfilxusuario as pu
					where pu.idusuario = us.idusuario),',') as perfiles
					from persona as pe
					join usuario as us on (us.idpersona = pe.idpersona)
					join tipoidentificacion as ti on (ti.idtipoidentificacion = pe.tipoidentificacion)
					join genero as ge on (ge.idgenero = pe.idgenero)
					join centro as ce on (ce.idcentro = us.idcentro)
					join cargo as ca on (ca.idcargo = us.idcargo)
					join statususuario as su on (su.idstatususuario = us.idstatususuario)
					where
					pe.idpersona != 1
					order by
					pe.idpersona DESC;";
			return $sql;
		}

		public function listaUsuarios(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qListaUsuarios());
			$bd->dbCloseConection();

			return $data;
		}// FIN listaUsuarios

		public function tipoidentificacion(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select * from tipoidentificacion order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function tipoidentificacion

		public function genero(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select * from genero order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function genero

		public function centro(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select idcentro,nombre from centro order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function centro

		public function cargo(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select idcargo,nombre from cargo order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function cargo

		public function statususuario(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select idstatususuario,nombre from statususuario order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function statususuario

		public function perfiles(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE("select * from perfil where idperfil!=1 order by 1");
			$bd->dbCloseConection();

			return $data;
		}// FIN function perfiles

		public function insTelefonos($idP,$telfs){
			global $bd;

			if (is_array($telfs)){
				for($i=0;$i<count($telfs);$i++){
					if ($telfs[$i]!='') {
						$ins = "insert into telefono (
								idpersona,
								nombre
								) values (
								".$idP.",
								'".$telfs[$i]."'
								);";
						$bd->getContentASSOC($ins);
					}
				}
			}
		}// FIN function insTelefonos

		public function insCorreos($idP,$correos){
			global $bd;

			if (is_array($correos)){
				for($i=0;$i<count($correos);$i++){
					if ($correos[$i]!='') {
						$ins = "insert into correo (
								idpersona,
								nombre
								) values (
								".$idP.",
								'".$correos[$i]."'
								);";
						$bd->getContentASSOC($ins);
					}
				}
				return true;
			} else {
				return true;
			}
		}// FIN function insCorreos

		public function insPerfiles($idU,$perfiles){
			global $bd;

			if (is_array($perfiles)){
				for($i=0;$i<count($perfiles);$i++){
					if ($perfiles[$i]!='') {
						$ins = "insert into perfilxusuario (
								idusuario,
								idperfil
								) values (
								".$idU.",
								".$perfiles[$i]."
								);";
						$bd->getContentASSOC($ins);
					}
				}
				return true;
			} else {
				return true;
			}
		}// FIN function insPerfiles

		public function nuevoUsuario ($fields=''){
			global $bd;

			if ($fields=='') return false;
			$bd->dbConection();
			$sql = "select identificacion from persona where identificacion = '".$fields['identificacion']."';";
			$id = $bd->getContentASSOC($sql);
			if ($id[0]!=''){
				return false;
			} else {
				$ins = "insert into persona (
							tipoidentificacion,
							identificacion,
							apellidos,
							nombres,
							direccionhabitacion,
							idgenero,
							fechanacimiento
						) values (
							".$fields['tipoidentificacion'].",
							'".$fields['identificacion']."',
							'".$fields['apellidos']."',
							'".$fields['nombres']."',
							'".$fields['direccion']."',
							".$fields['genero'].",
							'".$fields['fechanac']."'
						) returning idpersona;";
				$idP = $bd->getContentASSOC($ins);
				$this->insTelefonos($idP[0]['idpersona'],$fields['telefonos']);
				$this->insCorreos($idP[0]['idpersona'],$fields['correos']);
				if($idP[0]!=''){
					$fecha = $fields['fechaing'].' '.date('H:i:s');
					$ins = "insert into usuario (
								idpersona,
								idcentro,
								idcargo,
								idstatususuario,
								contrasena,
								fecharegistro
							) values (
								".$idP[0]['idpersona'].",
								".$fields['centro'].",
								".$fields['cargo'].",
								".$fields['statususuario'].",
								MD5('".$fields['contrasena']."'),
								'".$fecha."'
							) returning idusuario;";
					$idU = $bd->getContentASSOC($ins);
					if ($idU[0]!=''){
						$this->insPerfiles($idU[0]['idusuario'],$fields['perfiles']);
						$bd->dbCloseConection();
						return true;
					} else {
						$bd->getContentASSOC('delete from persona where idpersona = '.$idP[0]['idpersona']);
						$bd->dbCloseConection();
						return false;
					}
				} else {
					$bd->getContentASSOC('delete from persona where idpersona = '.$idP[0]['idpersona']);
					$bd->dbCloseConection();
					return false;
				}
			}
		}// FIN function nuevoUsuario

		public function editarUsuario ($fields=''){
			global $bd;

			if ($fields=='') return false;
			$bd->dbConection();
			$upd = "update persona set
					apellidos = '".$fields['apellidos']."',
					nombres = '".$fields['nombres']."',
					direccionhabitacion = '".$fields['direccion']."',
					idgenero = ".$fields['genero'].",
					fechanacimiento = '".$fields['fechanac']."' 
					where
					idpersona = ".$fields['idpersona']." returning idpersona;";
			$idP = $bd->getContentASSOC($upd);
			if ($idP[0]!=''){
				$upd = "update usuario set
						idcentro = ".$fields['centro'].",
						idcargo = ".$fields['cargo'].",
						idstatususuario = ".$fields['statususuario']."
						where
						idpersona = ".$fields['idpersona']." and idusuario = ".$fields['idusuario'].";";
				$bd->getContentASSOC($upd);
				$bd->getContentASSOC('delete from telefono where idpersona = '.$fields['idpersona'].';');
				$bd->getContentASSOC('delete from correo where idpersona = '.$fields['idpersona'].';');
				$bd->getContentASSOC('delete from perfilxusuario where idusuario = '.$fields['idusuario'].';');
				$this->insTelefonos($fields['idpersona'],$fields['telefonos']);
				$this->insCorreos($fields['idpersona'],$fields['correos']);
				$this->insPerfiles($fields['idusuario'],$fields['perfiles']);
				return true;
			} else {
				$bd->dbCloseConection();
				return false;
			}
		}// FIN function editarUsuario

	}// FIN class usuarios

	$usuarios = new usuarios();
	switch($xget['action']){
		case 'add':
			print $usuarios->nuevoUsuario($xget);
			break;
		case 'update':
			print $usuarios->editarUsuario($xget);
			break;
		case 'delete':
			break;
	}//Fin switch

?>
