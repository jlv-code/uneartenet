<?php

	/*	CLASE USERS
 	 *	Clase para manipulación de datos de los usuarios que se logean
 	 * 	@autor: José V.
 	 * 	@date: 2012-10-30 : 1230
 	 *	@version 2.0
 	 */

class users {
	
	private $id = '';
	private $password = '';
	private $idtype = '';
	private $idcentro = '';
	private $conection = '';
	private $res = '';
	
	public function setConexion ($conexion) {
		$this->conection = $conexion;
	}

	public function validarUsuario($sql) {
		if($sql!=''){
			$this->res=pg_query($this->conection, $sql);
			if ($this->res){
				$arrRes = pg_fetch_array($this->res,0,PGSQL_ASSOC);
				return $arrRes;
			} else {
				return 0;
			}
		} else {
			return -1;
		}
		pg_close($this->conexion);
	}
	
	public function perfilesEnCadena($sql) {
		if($sql!=''){
			$this->res=pg_query($this->conection, $sql);
			if ($this->res){
				$filas=pg_num_rows($this->res);
				for ($j=0;$j<$filas;$j++):
					$arrRes[] = pg_fetch_array($this->res,$j,PGSQL_NUM);
				endfor;
				$cadPerfiles = $arrRes[0][0];
				for($j=1;$j<count($arrRes);$j++):
					$cadPerfiles.= ','.$arrRes[$j][0];
				endfor;
				return $cadPerfiles;
			} else {
				return 0;
			}
		} else {
			return -1;
		}
		pg_close($this->conexion);
	}
}
