<?php
	
   /* @autor Kimberly Álvarez
 	* @version 2.0 2012
  	* CLASE INFO
 	* Clase para manipulación de datos de la información generada desde la INTRANET (Noticias, Boletines, Comunicados)
 	*/

	class informacion {

   		private $perfil = array();
		
		public function setIdPerfil($perfil) {
			$this->perfil = $perfil;
			//print_r($this->perfil);			
	 	}
	 

    /* FUNCIONES QUERIES */
		
		public function qNoticias($sw){
			$filterStatus = "";
			if ($sw==0){
				$filterStatus = " and i.idstatusinformacion = 1 ";
			}
			$sql = "select 
				        i.idinformacion as id,
				        i.titulo as titulo,
				        i.descripcion,
				        i.idstatusinformacion,
				        si.nombre,
				        to_char(fechapublicacion,'DD/MM/YYYY') as fecha,
				        
						array_to_string(array(select
				        m.idmultimedia || ';' || m.url as url
				        from multimedia as m
				        where m.idinformacion = i.idinformacion),',') as url,

						array_to_string(array(select
				        ca.nombre as nombre
				        from categoria as ca
				        join noticiasxcategoria as c on (c.idinformacion = i.idinformacion)
				        where ca.idcategoria = c.idcategoria),', ') as categoria,

						array_to_string(array(select
				        ca.idcategoria as idcategoria
				        from noticiasxcategoria as ca
						where ca.idinformacion = i.idinformacion),',') as idcategoria
					
				        from informacion as i	
				        join statusinformacion as si on (si.idstatusinformacion = i.idstatusinformacion) 
				        where idtipoinformacion = 3 ".$filterStatus."
				        order by idinformacion DESC";
			return $sql;
		}
		
		public function noticias($sw){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qNoticias($sw));
			$bd->dbCloseConection();

			return $data;
		
		}

		/*FIN QUERY NOTICIAS*/

		public function qBoletines($sw){	
			
			$filterStatus = "";
			if ($sw==0){
				$filterStatus = " and i.idstatusinformacion = 1 ";
			}

			$sql = "select 
					i.idinformacion as id,
					i.idstatusinformacion,
					si.nombre,
					titulo as titulo,
					to_char(fechapublicacion,'DD/MM/YYYY') as fecha,
					array_to_string(array(select
				        m.idmultimedia || ';' || m.url as url
				        from multimedia as m
				        where m.idinformacion = i.idinformacion),',') as url
					from informacion as i
					join statusinformacion as si on (si.idstatusinformacion = i.idstatusinformacion)
					where idtipoinformacion = 2 ".$filterStatus."
					order by idinformacion DESC";
			return $sql;		  		
		}
		
		public function boletines($sw){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qBoletines($sw));
			$bd->dbCloseConection();

			return $data;
		}

		/*FIN QUERY BOLETINES*/	
			
		public function qComunicados($sw){	

			$filterStatus = "";
			if ($sw==0){
				$filterStatus = " and i.idstatusinformacion = 1 ";
			}

			$sql = "select 
					i.idinformacion as id,
					i.idstatusinformacion,
					si.nombre,
					titulo as titulo,
					to_char(fechapublicacion,'DD/MM/YYYY') as fecha,
					array_to_string(array(select
				        m.idmultimedia || ';' || m.url as url
				        from multimedia as m
				        where m.idinformacion = i.idinformacion),',') as url
					from informacion as i
					join statusinformacion as si on (si.idstatusinformacion = i.idstatusinformacion)
					where idtipoinformacion = 1 ".$filterStatus."
					order by i.idinformacion DESC";
			return $sql;		  		
		}
		
		public function comunicados($sw){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentASSOC($this->qComunicados($sw));
			$bd->dbCloseConection();

			return $data;
		}

		/*FIN QUERY COMUNICADOS*/	

		public function qCategorias(){	
			$sql = "select *
		            from categoria 
		            order by 2 ASC";
			return $sql;		  		
		}
		
		public function categorias(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qCategorias());
			$bd->dbCloseConection();

			return $data;
		}

		/*FIN QUERY CATEGORIA*/

		public function qEstado(){	
			$sql = "select *
		            from statusinformacion 
		            order by 2 ASC";
			return $sql;		  		
		}

		public function estado(){
			global $bd;

			$bd->dbConection();
			$data = $bd->getContentKEYVALUE($this->qEstado());
			$bd->dbCloseConection();

			return $data;
		}
		
		/*FIN QUERY ESTADO*/

	 /* FIN QUERIES */
		
	/* FUNCIONES DE ACCIONES */
		
		public function GuardarInformacion($fields = '', $xfiles=''){
			
				global $bd;

				$sql= "INSERT INTO INFORMACION (
						idtipoinformacion, 
						idusuario, 
						autor, 
						titulo, 
						descripcion, 
						fechapublicacion,
						idstatusinformacion
						) VALUES ( 
							'".$fields['tipoinformacion']."',
							'".$fields['idusuario']."',
							'".'NOTICIAS UNEARTE'."',
							'".$fields['titulo']."',
							'".$fields['descripcion']."',
							'".$fields['fecha']."',
							'".$fields['estado'][0]."'
						  ) returning idinformacion;";
		
			$bd->dbConection();
			$idInformacion = $bd->getContentASSOC($sql);
			$bd->dbCloseConection();

			if($xfiles['media']!= ''){

				$canMultimedia = count($xfiles['media']['name']);

				for ($i=0;$i<$canMultimedia;$i++){

					if($fields['tipomultimedia'] == 2){			
						$ext = explode(".", $xfiles['media']['name'][$i]);	
						$extension = $ext [count ($ext)-1];	
						$xfiles['media']['name'] = str_replace($extension, "png", $xfiles['media']['name']);
					}		
	            	
					$sql2 = "INSERT INTO MULTIMEDIA(
							idtipomultimedia,
							idinformacion,
							url
							) VALUES (
								'".$fields['tipomultimedia']."',
								'".$idInformacion[0]['idinformacion']."',
								'".$xfiles['media']['name'][$i]."'
							   );";

					$bd->dbConection();
					$idMultimedia = $bd->getContentASSOC($sql2);
					$bd->dbCloseConection();
	
				}

			}
			
			if($fields['tipoinformacion'] == 3){

			$canCategorias = count($fields['categoria']);	
            
				for ($i=0;$i<$canCategorias;$i++){

					$sql3 = "INSERT INTO NOTICIASXCATEGORIA(
							 idinformacion,
							 idcategoria
							 ) VALUES(
								 '".$idInformacion[0]['idinformacion']."',
								 '".$fields['categoria'][$i]."' 
								);";	
					
					$bd->dbConection();
					$idCategoria = $bd->getContentASSOC($sql3);
					$bd->dbCloseConection();						
		    	
		    	}
		    }
			
	        return true;
	    } 

	    /*FIN FUNCION GUARDAR INFORMACION*/

	    public function EditarInformacion($fields = '', $xfiles=''){

  			global $bd;

	    	$sql = "UPDATE INFORMACION SET 
					 titulo = '".$fields['titulo']."', 
					 descripcion = '".$fields['descripcion']."', 
					 fechapublicacion = '".$fields['fecha']."',
					 idstatusinformacion = '".$fields['estado'][0]."' 
					 WHERE idinformacion = ".$fields['idinformacion']."
					 returning idinformacion;";   
	            	
			$bd->dbConection();
			$idInformacion = $bd->getContentASSOC($sql);
			$bd->dbCloseConection();
		
			if($xfiles['media'] != ''){

				$canMultimedia = count($xfiles['media']['name']);

				if($idInformacion[0]!=''){
					$selMultimedia = "select
									  idmultimedia,
									  idinformacion,
									  url
									  from multimedia
									  where
									  idinformacion = ".$idInformacion[0]['idinformacion'];

					$bd->dbConection();
			    	$selmulti = $bd->getContentASSOC($selMultimedia);
				    $bd->dbCloseConection();
				}

        		$bd->dbConection();
        		$inMultimedia = '';
				
					for ($i=0;$i<$canMultimedia;$i++){
						
						if($fields['tipomultimedia'] == 2){			
							$ext = explode(".", $xfiles['media']['name'][$i]);
							$extension = $ext [count ($ext)-1];	
							$xfiles['media']['name'] = str_replace($extension, "png", $xfiles['media']['name']);
						}
					
						print_r($xfiles['media']['name']);
						$inMultimedia = "INSERT INTO MULTIMEDIA(
										 idinformacion,
										 idtipomultimedia,
										 url
										) VALUES(
										 '".$idInformacion[0]['idinformacion']."',
										 '".$fields['tipomultimedia']."',
										 '".$xfiles['media']['name'][$i]."' 
										);";	
						
						$insMultimedia = $bd->getContentASSOC($inMultimedia);						
					}	
				}

			if ($fields['imgtodelete']!=''){						
				for($i=0;$i<count($fields['imgtodelete']);$i++){	
					$del.= "delete from multimedia where idmultimedia = ".$fields['imgtodelete'][$i].";\n";
				} 
			$bd->dbConection();
			$delmulti = $bd->getContentASSOC($del);
			$bd->dbCloseConection();
			}
				

			if($fields['tipoinformacion'] == 3){				
				
				$canCategorias = count($fields['categoria']);

				if($idInformacion[0]!=''){
					$selCategorias = "select
									  idnoticiasxcategoria,
									  idinformacion,
									  idcategoria
									  from noticiasxcategoria
									  where
									  idinformacion = ".$idInformacion[0]['idinformacion'];

					$bd->dbConection();
			    	$selnotxcat = $bd->getContentASSOC($selCategorias);
				    $bd->dbCloseConection();	

					if($canCategorias == 0){	
						if($selnotxcat[0]!=''){
							$delCategorias = "DELETE FROM noticiasxcategoria
									 		  WHERE idinformacion = '".$idInformacion[0]['idinformacion']."';";	
							$bd->dbConection();
							$dCategorias = $bd->getContentASSOC($delCategorias);
							$bd->dbCloseConection();		
							return true;
						}	
					}
					else {

            		$bd->dbConection();
            		$inCategoria = '';
						for ($i=0;$i<$canCategorias;$i++){	
							$sel = "SELECT * FROM noticiasxcategoria 
									WHERE idinformacion = '".$idInformacion[0]['idinformacion']."' and idcategoria = '".$fields['categoria'][$i]."'";

							$idnotixcat = $bd->getContentASSOC($sel);
							if($idnotixcat==''){
								$inCategoria = "INSERT INTO NOTICIASXCATEGORIA(
												 idinformacion,
												 idcategoria
												) VALUES(
												 '".$idInformacion[0]['idinformacion']."',
												 '".$fields['categoria'][$i]."' 
												);";	
								
								$insCategoria = $bd->getContentASSOC($inCategoria);
							}
						}

						$del = '';
						for($i=0;$i<count($selnotxcat);$i++){
							$key = array_search($selnotxcat[$i]['idcategoria'], $fields['categoria']);
			
							if ($selnotxcat[$i]['idcategoria']==$fields['categoria'][$key]){
								continue;
							} else {
								$del.= "delete from noticiasxcategoria where idnoticiasxcategoria = ".$selnotxcat[$i]['idnoticiasxcategoria'].";\n";
							}
						}
						$selnotxcat = $bd->getContentASSOC($del);
						$bd->dbCloseConection();	
						return true;
						
					}
				}		
			}
			return true;
	    }     
		
		/*FIN FUNCION EDITAR INFORMACION*/	

	/*FIN FUNCIONES DE ACCIONES*/	
	
}
	$informacion = new informacion();
	
	switch($xget['action']){
		case 'add':
			   print json_encode($informacion->GuardarInformacion($xget,$xfiles));
			break;
		case 'update':
			   print json_encode($informacion->EditarInformacion($xget,$xfiles));
			break;
		case 'delete':
			echo json_encode($_POST);
			break;
	}
?>
