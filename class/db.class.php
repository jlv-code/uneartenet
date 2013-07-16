<?php

header('Content-Type: text/html; charset=UTF-8');
class database {//INICIO DE LA CLASE PARA CONECTAR CON LA BASE DE DATOS

	private $conexion;

    
	//METODO CONSTRUCTOR
	public function db(){		
		$this->arrCnx = array (	
								"db_nombre"		=>	'',
								"db_usuario"    => 	'',
								"db_contrasena" => 	'',
								"db_servidor"   => 	''
								);
	}

	//METODO DE CONEXION
	public function dbConection(){
    	$this->conexion = pg_pconnect	(
											"host="			.$this->arrCnx['db_servidor'].
											" dbname="		.$this->arrCnx['db_nombre'].
											" user="		.$this->arrCnx['db_usuario'].
											" password="	.$this->arrCnx['db_contrasena']
										)
										or die 
										(
											"No hay Conexión con el Servidor!"
										); 
	}
	
	//METODO QUE CIERRA LA CONEXION A LA BASE DE DATOS
	public function dbCloseConection() {
		pg_close($this->conexion);
	}
	
	public function getConexion(){
		return $this->conexion;
	}
	
	/* METODO GETTITLE
	 * Metodo encargado de devolver una matriz como resultado del 
	 * Fetch_Field_Name
	 */
	public function getTitle($sqlCompleto) {
		$result = @pg_query($this->conexion,$sqlCompleto);
		$num = pg_num_fields($result);
		if ($result) {
			for ($i=0;$i<$num;$i++) { 
				$arrResult[$i] = @pg_field_name($result,$i);
			}
		}
		return $arrResult;
	}//Fin FUNCTION
	
	/* METODO GETCONTENTASSOC
	 * Metodo encargado de devolver una matriz como resultado del 
	 * Fetch_Array_Assoc (Modo Asociativo)
	 */
	public function getContentASSOC($sql) {
		$result = @pg_query($this->conexion,$sql);
		$rows = pg_num_rows($result);
		if ($result):
			for ($j=0;$j<$rows;$j++):
				$arrResult[] = @pg_fetch_assoc($result,$j);
			endfor;
		endif;
		return $arrResult;
	}
	//Fin FUNCTION
	
	/* METODO GETCONTENTNUM
	 * Metodo encargado de devolver una matriz como resultado del 
	 * Fetch_Array (Modo Númerico)
	 */
	public function getContentNUM($sql) {
		$result = @pg_query($this->conexion,$sql);
		$rows = pg_num_rows($result);
		if ($result):
			for ($j=0;$j<$rows;$j++):
			 $arrResult[] = @pg_fetch_row($result,$j);
			endfor;
		endif;
		return $arrResult;
	}//Fin FUNCTION
	
	/* METODO GETCONTENTOBJECT
	 * Metodo encargado de devolver una matriz como resultado del 
	 * Fetch_Array_Object (Modo Objeto)
	 */
	public function getContentOBJECT($sql) {
		$result = @pg_query($this->conexion,$sql);
		$rows = pg_num_rows($result);
		if ($result):
			for ($j=0;$j<$rows;$j++):
			 $arrResult[] = @pg_fetch_object($result,$j);
			endfor;
		endif;
		return $arrResult;
	}//Fin FUNCTION
	
	/* METODO GETCONTENTKEYVALUE
	 * Metodo encargado de devolver una matriz como resultado en 
	 * formato KEY:VALUE
	 */
	public function getContentKEYVALUE($sql) {
		$res=pg_query($this->conexion, $sql);
		$filas=pg_num_rows($res);
		for ($i=0;$i<$filas;$i++) {
			$arr[] = array ('key'=>pg_result($res,$i,0),'value'=>pg_result($res,$i,1));
		}
		return $arr;
	}//Fin FUNCTION

	//METODO DE CONSULTA DIRECTA
	public function dbQuery ($sqlCompleto) {
		$res=pg_query($this->conexion, $sqlCompleto);
		$filas=pg_num_rows($res);
		$columnas=pg_num_fields($res);
		for ($i=0;$i<$filas;$i++) {
			for ($j=0;$j<$columnas;$j++) {
				$arr[$i][$j]=pg_result($res,$i,$j);
			}
		}
		return $arr;
	}
	
	/* METODO GETMETA
	 * Metodo encargado de devolver una matriz como resultado del 
	 * Fetch_Array
	 */
	public function getMeta($sqlCompleto) {
		$result = pg_meta_data($this->conexion,$sqlCompleto);
		return $result;
	}//Fin FUNCTION
	
	function searchAutocomplete ($sqlCompleto) {		
		$res=pg_query($this->conexion, $sqlCompleto);		
		while ($row = pg_fetch_array($res)) {
		$resultArray[] = array("value"=>$row[0]);
		}
		return $resultArray;
	}
	
}//FIN DE LA CLASE DE BASE DE DATOS
?>
